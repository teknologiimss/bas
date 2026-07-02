<?php

namespace App\Exports;

use App\Models\DailyActivity;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class WeeklyActivityExport implements FromCollection, WithHeadings, WithEvents
{
    protected $start;
    protected $end;

    public function __construct($start, $end)
    {
        $this->start = $start;
        $this->end = $end;
    }

    public function collection()
    {
        return DailyActivity::with('monitoring')
            ->whereBetween('tanggal', [$this->start, $this->end])
            ->get()
            ->map(function ($item) {
                $keterangan = $item->keterangan ?? '-';

                $lines = preg_split('/\r\n|\r|\n/', trim($keterangan));

                $formattedKeterangan = collect($lines)
                    ->filter(fn($v) => trim($v) !== '')
                    ->map(fn($v) => trim($v))
                    ->implode("\n");

                return [
                    'Tanggal' => $item->tanggal,
                    'Proyek' => optional($item->monitoring)->nama_pekerjaan,
                    'Kegiatan' => $item->kegiatan,
                    'Status' => $item->status,
                    'Keterangan' => $formattedKeterangan,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Proyek',
            'Kegiatan',
            'Status',
            'Keterangan',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestRow = $sheet->getHighestRow();
                $range = "A1:E{$highestRow}";

                // =========================
                // HEADER STYLE
                // =========================
                $sheet->getStyle('A1:E1')->applyFromArray([
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'D9D9D9'],
                    ],
                    'font' => [
                        'bold' => true,
                    ],
                    'alignment' => [
                        'vertical' => Alignment::VERTICAL_CENTER,
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                    ],
                ]);

                // =========================
                // BORDER + MIDDLE ALIGN
                // =========================
                $sheet->getStyle($range)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                    'alignment' => [
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // =========================
                // WRAP TEXT (KETERANGAN)
                // =========================
                $sheet
                    ->getStyle("E2:E{$highestRow}")
                    ->getAlignment()
                    ->setWrapText(true);

                // =========================
                // AUTO ROW HEIGHT
                // =========================
                for ($row = 2; $row <= $highestRow; $row++) {
                    $sheet->getRowDimension($row)->setRowHeight(-1);
                }

                // =========================
                // STATUS COLOR
                // =========================
                for ($row = 2; $row <= $highestRow; $row++) {
                    $status = strtoupper($sheet->getCell("D{$row}")->getValue());

                    if ($status === 'OPEN') {
                        $sheet->getStyle("D{$row}")->applyFromArray([
                            'fill' => [
                                'fillType' => Fill::FILL_SOLID,
                                'startColor' => ['rgb' => 'FF4D4D'],
                            ],
                        ]);
                    }

                    if ($status === 'CLOSED') {
                        $sheet->getStyle("D{$row}")->applyFromArray([
                            'fill' => [
                                'fillType' => Fill::FILL_SOLID,
                                'startColor' => ['rgb' => '4CAF50'],
                            ],
                        ]);
                    }
                }
            },
        ];
    }
}
