<?php

namespace App\Exports;

use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Events\AfterSheet;

class TransaksiExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles, WithEvents
{
    /**
     * Get the data collection for export
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Transaksi::where('nama_pegawai', auth()->user()->nama)->get();
    }

    /**
     * Set the headings for the Excel file
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Nama Pelanggan',
            'Nama Menu',
            'Jumlah',
            'Total Harga',
            'Nama Pegawai',
            'Tanggal Transaksi',
            'Tanggal Edit Transaksi'
        ];
    }

    /**
     * Apply styles to the Excel sheet
     *
     * @param Worksheet $sheet
     */
    public function styles(Worksheet $sheet)
    {
        // Header row styles
        $sheet->getStyle('A1:H1')->getFont()->setBold(true);
        $sheet->getStyle('A1:H1')->getFont()->setSize(13);
        $sheet->getStyle('A1:H1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1:H1')->getFont()->getColor()->setRGB('FFFFFF');
        $sheet->getStyle('A1:H1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A1:H1')->getFill()->getStartColor()->setRGB('5A3300'); // Dark brown header color

        // Apply borders to all cells
        $sheet->getStyle('A1:H' . (Transaksi::count() + 1))->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);
    }

    /**
     * Register events for the Excel export
     *
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet;

                $cellRange = 'A1:H' . (Transaksi::count() + 1);
                $sheet->getStyle($cellRange)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);

                // Add auto filter
                $sheet->setAutoFilter($sheet->calculateWorksheetDimension());

                // Alternating row colors for better readability
                $lastRow = Transaksi::count() + 1;
                for ($row = 2; $row <= $lastRow; $row++) {
                    if ($row % 2 == 0) {
                        // Apply background color for even rows
                        $sheet->getStyle("A$row:H$row")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()->setRGB('F2E4D5'); // Light background color for even rows
                    }
                }

                // Set column widths
                $sheet->getColumnDimension('A')->setWidth(5);  // ID column
                $sheet->getColumnDimension('B')->setWidth(20); // Nama Pelanggan column
                $sheet->getColumnDimension('C')->setWidth(20); // Nama Menu column
                $sheet->getColumnDimension('D')->setWidth(15); // Jumlah column
                $sheet->getColumnDimension('E')->setWidth(20); // Total Harga column
                $sheet->getColumnDimension('F')->setWidth(20); // Nama Pegawai column
                $sheet->getColumnDimension('G')->setWidth(20); // Tanggal Transaksi column
                $sheet->getColumnDimension('H')->setWidth(20); // Tanggal Edit Transaksi column

                // Format date columns (Tanggal Transaksi & Tanggal Edit Transaksi)
                $sheet->getStyle("G2:G$lastRow")->getNumberFormat()->setFormatCode('yyyy-mm-dd');
                $sheet->getStyle("H2:H$lastRow")->getNumberFormat()->setFormatCode('yyyy-mm-dd');
            },
        ];
    }
}
