<?php

namespace App\Imports;

use App\Models\PesertaModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\{
    ToModel,
    Importable,
    WithValidation,
    WithHeadingRow,
    WithBatchInserts,
    SkipsEmptyRows,
    WithChunkReading
};

class PesertaImport implements ToModel, WithValidation, WithHeadingRow, WithBatchInserts, WithChunkReading, SkipsEmptyRows
{
    use Importable;

    private $isPreview = 0, $result = [];

    public function __construct($isPreview = 1) {
        $this->isPreview = $isPreview;
    }

    public function model(array $row)
    {
        if($this->isPreview) return;
        
        $noReg = $row['no_reg'];
        generateQrCode($noReg);
        
        return new PesertaModel([
            'no_reg'        => $row['no_reg'],
            'name'          => $row['name'],
            'origin'        => $row['origin'],
            'event_title'   => $row['event_title'],
            'user_id'       => Auth::id()
        ]);
    }

    public function batchSize(): int
    {
        if($this->isPreview) return 10000;
        return 500;
    }

    public function chunkSize(): int
    {
        if($this->isPreview) return 10000;
        return 500;
    }

    public function rules(): array
    {
        $model = new PesertaModel();
        if($this->isPreview) return [
            'no_reg'        =>  [
                                'required',
                                'alpha_num',
                                'max:6',
                                'min:6',
                                'required',
                                Rule::unique($model->getConnectionName().".".$model->getTable(), "no_reg")
                            ],
            'name'          => 'required',
            'origin'        => 'required',
            'event_title'   => 'required'
        ];
        return [];
    }

    public function customValidationAttributes()
    {
        return [
            'no_reg' => 'no reg',
            'event_title' => 'event title'
        ];
    }

    public function prepareForValidation($data, $index)
    {
        $data['no_reg'] = trim($data['no_reg'] ?? null);
        
        return $data;
    }
}
