<?php

namespace App\Exports;

use App\Models\PesertaModel;
use Maatwebsite\Excel\Concerns\{
    FromQuery,
    Exportable,
    WithHeadings, 
    WithMapping,
    ShouldAutoSize,
    WithStyles
};
use PhpOffice\PhpSpreadsheet\{
    Worksheet\Worksheet,
    Style\Alignment,
};

class PesertaExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    use Exportable;

    protected $ids, $skip, $limit;

    public function forIds($ids)
    {
        $ids = is_array($ids) ? $ids : explode(",", str_replace(" ", "", $ids));
        $ids = array_filter($ids);
        $this->ids = $ids;
        return $this;
    }

    public function setRange($range)
    {
        $split = is_array($range) ? $range : array_filter(explode("-",str_replace(" ", "", $range)));
        $this->skip  = (int) ($split[0] ?? 0);
        $this->limit = (int) ($split[1] ?? 0);
        return $this;
    }

    public function query()
    {
        return PesertaModel::with([
            'userUpload' => function($q)
            {
                return $q->select(['id', 'name']);
            }
        ])
        ->when($this->ids,function($q)
        {
            return $q->whereIn('id', $this->ids);
        })
        ->when($this->limit > 0,function($q)
        {
            return $q->skip($this->skip)->limit($this->limit);
        });
    }

    public function map($data): array
    {
        return [
            $data->no_reg,
            $data->name,
            $data->origin,
            $data->event_title,
            $data->userUpload->name,
            $data->created_at
        ];
    }

    public function headings(): array
    {
        return [
            'No Reg',
            'Name',
            'Origin',
            'Event Title',
            'Created By',
            'Created At'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'fill' => [
                    'fillType' => 'solid',
                    'rotation' => 0, 
                    'color' => ['rgb' => '0a3b73']
                ],
                'font' => [
                    'bold' => true,
                    'color' => ['argb' => 'ffffff']
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ],
            ]
        ];
    }
}
