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

class AllTransaksiExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles, WithEvents
{
    /**
     * Get the data collection for export
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Transaksi::all();
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
            'Tanggal Edit Transaksi',
            'Gambar Menu'
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
        $sheet->getStyle('A1:I1')->getFont()->setBold(true);
        $sheet->getStyle('A1:I1')->getFont()->setSize(13);
        $sheet->getStyle('A1:I1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1:I1')->getFont()->getColor()->setRGB('FFFFFF');
        $sheet->getStyle('A1:I1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A1:I1')->getFill()->getStartColor()->setRGB('5A3300'); // Dark brown header color

        // Apply borders to all cells
        $lastRow = Transaksi::count();
        $sheet->getStyle('A1:I' . ($lastRow + 1))->applyFromArray([
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
                $lastRow = Transaksi::count();

                // Apply alternating row colors
                for ($row = 2; $row <= $lastRow + 1; $row++) {
                    if ($row % 2 == 0) {
                        $sheet->getStyle("A$row:I$row")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()->setRGB('F2E4D5'); // Light background color for even rows
                    }
                }

                // Add auto filter
                $sheet->setAutoFilter($sheet->calculateWorksheetDimension());

                // Set column widths
                $sheet->getColumnDimension('A')->setWidth(5);  // ID column
                $sheet->getColumnDimension('B')->setWidth(20); // Nama Pelanggan column
                $sheet->getColumnDimension('C')->setWidth(20); // Nama Menu column
                $sheet->getColumnDimension('D')->setWidth(10); // Jumlah column
                $sheet->getColumnDimension('E')->setWidth(15); // Total Harga column
                $sheet->getColumnDimension('F')->setWidth(20); // Nama Pegawai column
                $sheet->getColumnDimension('G')->setWidth(20); // Tanggal Transaksi column
                $sheet->getColumnDimension('H')->setWidth(20); // Tanggal Edit Transaksi column
                $sheet->getColumnDimension('I')->setWidth(20); // Gambar Menu column

                // Format number columns (Jumlah and Total Harga)
                $sheet->getStyle("D2:D$lastRow")->getNumberFormat()->setFormatCode('#,##0');  // Format for Jumlah
                $sheet->getStyle("E2:E$lastRow")->getNumberFormat()->setFormatCode('#,##0');  // Format for Total Harga

                // Format date columns (Tanggal Transaksi & Tanggal Edit Transaksi)
                $sheet->getStyle("G2:G$lastRow")->getNumberFormat()->setFormatCode('yyyy-mm-dd');
                $sheet->getStyle("H2:H$lastRow")->getNumberFormat()->setFormatCode('yyyy-mm-dd');

                // Menambahkan gambar untuk setiap transaksi
                for ($row = 2; $row <= $lastRow + 1; $row++) {
                    $gambarMenu = Transaksi::find($row - 1)->menu->gambar_menu;  // Menyisipkan gambar dari relasi menu
                    if ($gambarMenu) {
                        $imagePath = storage_path('app/public/' . $gambarMenu);
                        if (file_exists($imagePath)) {
                            $sheet->getRowDimension($row)->setRowHeight(80); // Menyesuaikan tinggi baris untuk gambar
                            $sheet->getCell('I' . $row)->setValue('Gambar Menu');
                            $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                            $drawing->setPath($imagePath);
                            $drawing->setWidth(50); // Ukuran gambar
                            $drawing->setHeight(50);
                            $drawing->setCoordinates('I' . $row);
                            $drawing->setWorksheet($sheet);
                        }
                    }
                }
            },
        ];
    }
}
