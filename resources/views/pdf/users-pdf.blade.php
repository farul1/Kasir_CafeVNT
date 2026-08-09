<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Events\AfterSheet;

class UsersExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::all(['id', 'nama', 'username', 'role', 'created_at', 'updated_at']);
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama',
            'Username',
            'Role',
            'Tanggal Dibuat',
            'Tanggal Edit'
        ];
    }

    /**
     * Apply styles to the header
     */
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:F1')->getFont()->setBold(true);
        $sheet->getStyle('A1:F1')->getFont()->setSize(13);
        $sheet->getStyle('A1:F1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1:F1')->getFont()->getColor()->setRGB('FFFFFF');
        $sheet->getStyle('A1:F1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A1:F1')->getFill()->getStartColor()->setRGB('5A3300'); // Warna latar belakang
    }

    /**
     * Apply additional styles and borders
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet;

                $cellRange = 'A1:F' . (User::count() + 1);
                $sheet->getStyle($cellRange)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);

                $sheet->setAutoFilter($sheet->calculateWorksheetDimension());

                $lastRow = User::count() + 1;
                for ($row = 2; $row <= $lastRow; $row++) {
                    if ($row % 2 == 0) { // Baris genap
                        $sheet->getStyle("A$row:F$row")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()->setRGB('F2E4D5'); // Warna latar belakang untuk baris genap
                    }
                }

                $sheet->getColumnDimension('A')->setWidth(5);  // Lebar kolom ID
                $sheet->getColumnDimension('B')->setWidth(20); // Lebar kolom Nama
                $sheet->getColumnDimension('C')->setWidth(20); // Lebar kolom Username
                $sheet->getColumnDimension('D')->setWidth(15); // Lebar kolom Role
                $sheet->getColumnDimension('E')->setWidth(20); // Lebar kolom Tanggal Dibuat
                $sheet->getColumnDimension('F')->setWidth(20); // Lebar kolom Tanggal Edit
            },
        ];
    }
}
