<?php

namespace App\Exports\Template;

use Maatwebsite\Excel\Concerns\{
    FromCollection, 
    Exportable,
    WithHeadings,
    ShouldAutoSize, 
    WithStyles
};
use PhpOffice\PhpSpreadsheet\{
    Worksheet\Worksheet,
    Style\Alignment,
};

class PesertaExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    use Exportable;

    public function collection()
    {
        return collect([]);
    }

    public function headings(): array
    {
        return [
            'No Reg',
            'Name',
            'Origin',
            'Event Title',
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
