<?php

namespace App\Exports;

use App\Models\Menu;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class MenuExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles, WithEvents
{
    /**
     * Get the data collection for export
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Menu::all();
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
            'Nama Menu',
            'Harga',
            'Deskripsi',
            'Ketersediaan',
            'Tanggal Ditambahkan',
            'Tanggal Edit',
            'Gambar Menu'  // Menambahkan kolom untuk gambar menu
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
        $sheet->getStyle('A1:H1')->getFont()->setSize(14);
        $sheet->getStyle('A1:H1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1:H1')->getFont()->getColor()->setRGB('FFFFFF');
        $sheet->getStyle('A1:H1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A1:H1')->getFill()->getStartColor()->setRGB('3A4E57'); // Darker shade

        // Apply borders to all cells
        $sheet->getStyle('A1:H' . (Menu::count() + 1))->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'B0B0B0'],
                ],
            ],
        ]);

        // Apply text alignment for better readability
        $sheet->getStyle('A1:H' . (Menu::count() + 1))->getAlignment()->setVertical('center');
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
                $sheet = $event->sheet->getDelegate(); // Mendapatkan objek PhpSpreadsheet\Worksheet\Worksheet
                $lastRow = Menu::count() + 1;

                // Apply alternating row colors
                for ($row = 2; $row <= $lastRow; $row++) {
                    if ($row % 2 == 0) {
                        $sheet->getStyle("A$row:H$row")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()->setRGB('F4F4F4'); // Light gray background for even rows
                    }
                }

                // Add auto filter
                $sheet->setAutoFilter($sheet->calculateWorksheetDimension());

                // Set column widths
                $sheet->getColumnDimension('A')->setWidth(5);  // ID column
                $sheet->getColumnDimension('B')->setWidth(20); // Nama Menu column
                $sheet->getColumnDimension('C')->setWidth(15); // Harga column
                $sheet->getColumnDimension('D')->setWidth(30); // Deskripsi column
                $sheet->getColumnDimension('E')->setWidth(15); // Ketersediaan column
                $sheet->getColumnDimension('F')->setWidth(20); // Tanggal Ditambahkan column
                $sheet->getColumnDimension('G')->setWidth(20); // Tanggal Edit column
                $sheet->getColumnDimension('H')->setWidth(15); // Gambar Menu column

                // Format date columns (Tanggal Ditambahkan & Tanggal Edit)
                $sheet->getStyle("F2:F$lastRow")->getNumberFormat()->setFormatCode('yyyy-mm-dd');
                $sheet->getStyle("G2:G$lastRow")->getNumberFormat()->setFormatCode('yyyy-mm-dd');

                // Menambahkan gambar untuk setiap menu
                for ($row = 2; $row <= $lastRow; $row++) {
                    $menu = Menu::find($row - 1);  // Ambil menu berdasarkan ID
                    $gambarMenu = $menu->gambar_menu;

                    if ($gambarMenu) {
                        $imagePath = storage_path('app/public/' . $gambarMenu);
                        if (file_exists($imagePath)) {
                            // Menyesuaikan tinggi baris untuk gambar
                            $sheet->getRowDimension($row)->setRowHeight(40); // Adjust row height for images (smaller size)

                            // Menghapus nilai pada sel gambar
                            $sheet->setCellValue('H' . $row, ''); // Hapus tulisan apa pun di kolom Gambar Menu

                            // Gambar hanya akan ditambahkan tanpa teks
                            $drawing = new Drawing();
                            $drawing->setPath($imagePath);
                            $drawing->setWidth(40); // Ukuran gambar yang lebih kecil (width)
                            $drawing->setHeight(40); // Ukuran gambar yang lebih kecil (height)
                            $drawing->setCoordinates('H' . $row);  // Set the image in column H
                            $drawing->setWorksheet($sheet); // Assign to the worksheet
                        }
                    }
                }
            },
        ];
    }
}
