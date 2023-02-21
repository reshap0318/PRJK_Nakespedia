<?php

namespace App\Http\Controllers;

use App\Exports\PesertaExport as ExportsPesertaExport;
use App\Exports\Template\PesertaExport;
use App\Http\Requests\PesertaRequest;
use App\Imports\PesertaImport;
use App\Models\PesertaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PesertaController extends Controller
{
    public function index(Request $request)
    {
        if($request->tag == 'export') {
            return (new ExportsPesertaExport())
                ->forIds($request->ids)
                ->setRange($request->range)
                ->download('data peserta '.date('Y-m-d').".xlsx");
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
            $data = PesertaModel::create($request->all());
        } catch (\Throwable $th) {
            return redirect()->route('peserta.index')->with('error', 'gagal menambahkan data');    
        }

        return redirect()->route('peserta.index')->with('success', 'berhasil menambahkan data');    
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
            $data = $request->all();
            $peserta->update($data);
            return redirect()->route('peserta.index')->with('success', 'berhasil mengubah data');   
        } catch (\Throwable $th) {
            return redirect()->route('peserta.index')->with('error', 'gagal mengubah data');   
        }
    }

    public function destroy(PesertaModel $peserta)
    {
        $peserta->delete();
        return redirect()->route('peserta.index')->with('success', 'berhasil menghapus data'); 
    }

    public function batchDestroy(Request $request)
    {
        $ids = is_array($request->ids) ? $request->ids : explode(",", str_replace(" ", "", $request->ids));
        $ids = array_filter($ids);
        PesertaModel::whereIn('id', $ids)->delete();
        return redirect()->route('peserta.index')->with('success', 'berhasil menghapus data'); 
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
            if($request->has('is_preview') && $isPreview == 1) return response()->json(['code' => 'xls', 'error' => $errors], 500);
            return redirect()->back()->with('error', 'error menambahkan data');
            
        } 
        catch (\Throwable $th) {
            if($request->has('is_preview') && $isPreview == 1) return response()->json(['code' => 'err', 'error' => $th->getMessage()], 500);
            return redirect()->back()->with('error', 'error menambahkan data');
        }

        if($request->has('is_preview') && $isPreview == 1) return response()->json(['code' => 200, 'msg' => 'oke'], 200);
        return redirect()->route('peserta.index')->with('success', 'berhasil menambahkan data');
    }

    public function homepage()
    {
        return view('pages.homepage.index');
    }

    public function homepageData(Request $request)
    {
        $request->validate(['no_reg' => 'required']);
        $data = PesertaModel::where('no_reg', $request->no_reg)->first();
        if(!$data) return response()->json(['code' => 404, 'error' => "data not found"], 404);
        return response()->json(['code' => 200, 'data' => $data], 200);
    }
}
