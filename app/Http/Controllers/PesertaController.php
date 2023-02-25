<?php

namespace App\Http\Controllers;

use App\Exports\PesertaExport as ExportsPesertaExport;
use App\Exports\Template\PesertaExport;
use App\Http\Requests\PesertaRequest;
use App\Imports\PesertaImport;
use App\Models\PesertaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use ZipArchive;

class PesertaController extends Controller
{
    public function index(Request $request)
    {
        if($request->tag == 'export') {
            return $this->download($request->ids, $request->range);
        }
        return view('pages.peserta.index');
    }

    public function datatable()
    {
        $query = PesertaModel::query();
        return DataTables::eloquent($query)
            ->editColumn('created_at', function ($d) {
                return $d->created_at ? $d->created_at->format('Y-m-d H:i') : "-";
            })
            ->addColumn('action', function ($d)
            {
                return [
                    'edit' => [
                        'isCan' => Auth::user()->is_admin,
                        'link'  => route('peserta.edit', ['peserta' => $d])
                    ],
                    'delete' => [
                        'isCan' => Auth::user()->is_admin,
                        'link'  => route('peserta.destroy', ['peserta' => $d])
                    ]
                ];
            })
            ->make(true);
    }

    public function create()
    {
        return view('pages.peserta.create');
    }

    public function store(PesertaRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = PesertaModel::create($request->all());
            generateQrCode($data->no_reg);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('peserta.index')->with('error', 'failed added data');    
        }

        return redirect()->route('peserta.index')->with('success', 'successfully added data');    
    }

    public function edit(PesertaModel $peserta)
    {
        return view('pages.peserta.edit', [
            'peserta' => $peserta
        ]);
    }

    public function update(PesertaRequest $request, PesertaModel $peserta)
    {
        try {
            DB::beginTransaction();
            $data = $request->all();
            $peserta->update($data);
            generateQrCode($peserta->no_reg);
            DB::commit();
            return redirect()->route('peserta.index')->with('success', 'successfully changed data');   
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('peserta.index')->with('error', 'failed changed data');   
        }
    }

    public function destroy(PesertaModel $peserta)
    {
        $peserta->delete();
        $qrName = 'qrcode/'.$peserta->no_reg.".png";
        if(Storage::exists($qrName)) Storage::delete($qrName);
        return redirect()->route('peserta.index')->with('success', 'successfully deleted data'); 
    }

    public function batchDestroy(Request $request)
    {
        $ids = is_array($request->ids) ? $request->ids : explode(",", str_replace(" ", "", $request->ids));
        $ids = array_filter($ids);
        PesertaModel::whereIn('id', $ids)->delete();
        foreach (PesertaModel::whereIn('id', $ids)->get() as $peserta) {
            $qrName = 'qrcode/'.$peserta->no_reg.".png";
            if(Storage::exists($qrName)) Storage::delete($qrName);
        }
        return redirect()->route('peserta.index')->with('success', 'successfully deleted data'); 
    }

    public function import(Request $request)
    {
        if($request->tag=='template') return (new PesertaExport())->download("template batch peserta ".date('Y-m-d').".xlsx");
        return view('pages.peserta.import');
    }

    public function importStore(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);
        ini_set('max_execution_time', '1800'); //30mnt
        ini_set('memory_limit', -1);

        
        $isPreview = $request->is_preview ?? 1;
        try {
            $import = new PesertaImport($isPreview);
            $import->import($request->file);
        }
        catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $errors = [];
            $failures = $e->failures();
            foreach ($failures as $idx => $failure) {
                $row = $failure->row();
                $err = $failure->errors();
                $attr= $failure->attribute();
                $key = array_search($row, array_column($errors, 'row'));
                if($key > -1) {
                    $errors[$key]['errors'] = array_merge($errors[$key]['errors'], $err);
                }
                else {
                    $merge = array_merge($failure->values(), ['row' => $row, 'errors' => $err, 'attr' => $attr]);
                    array_push($errors, $merge);
                }
            }
            if($request->has('is_preview') && $isPreview == 1) return response()->json(['code' => 'xls', 'message' => $errors, 'failures' => $failures], 500);
            return redirect()->back()->with('error', 'error added data');
            
        } 
        catch (\Throwable $th) {
            if($request->has('is_preview') && $isPreview == 1) return response()->json(['code' => 'err', 'message' => $th->getMessage()], 500);
            return redirect()->back()->with('error', 'error added data');
        }

        if($request->has('is_preview') && $isPreview == 1) return response()->json(['code' => 200, 'msg' => 'oke'], 200);
        return redirect()->route('peserta.index')->with('success', 'successfully added data');
    }

    public function homepage()
    {
        return view('pages.homepage.index', ['data' => null]);
    }

    public function homepageData($no_reg)
    {
        $data = PesertaModel::where('no_reg', $no_reg)->first();
        if(!$data) return redirect(route('homepage.index'))->with('error', 'data not foud');

        return view('pages.homepage.index', ['data' => $data]);
    }

    public function download($ids = null, $range = null)
    {
        ini_set('max_execution_time', '1800'); //30mnt
        ini_set('memory_limit', -1);

        $path = "extract";
        Storage::deleteDirectory($path);
        if(!Storage::directoryExists($path)) Storage::makeDirectory($path);

        $zip = new ZipArchive;
        $fileName = $path.'/data peserta '.date('Y-m-d').($range ? " range ".$range : "").".zip";

        if ($zip->open(Storage::path($fileName), ZIPARCHIVE::CREATE )!==TRUE) {
            return redirect()->back()->with('error', "can't download $fileName");
        }

        if ($zip->open(Storage::path($fileName), ZipArchive::CREATE) === TRUE)
        {
            $excelDown = (new ExportsPesertaExport())->forIds($ids)->setRange($range);

            $zip->addFile(
                $excelDown
                    ->download('000-data-peserta.xlsx')
                    ->getFile(),
                '000-data-peserta.xlsx'
            );

            foreach ($excelDown->getCollection() as $item) {
                $qrName = generateQrCode($item->no_reg);
                $zip->addFile(
                    Storage::path($qrName)
                );
            }

            $zip->close();
        }
        return response()->download(Storage::path($fileName));       
    }
}
