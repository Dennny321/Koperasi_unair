<?php

namespace App\Exports;

use App\Models\Master\Restock;
use App\Models\Master\Supplier;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class RestockExport
{
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function download(): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $restocks    = $this->getData();
        $spreadsheet = $this->buildSpreadsheet($restocks);
        $filename    = 'laporan-restock-' . now()->format('Ymd-His') . '.xlsx';
        $writer      = new Xlsx($spreadsheet);

        return response()->streamDownload(function () use ($writer) {
            $writer->save('php://output');
        }, $filename, [
            'Content-Type'        => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control'       => 'max-age=0',
        ]);
    }

    protected function getData()
    {
        // Eager-load details beserta produk & kategori sekaligus
        $query = Restock::with(['supplier', 'user', 'details.produk.kategori']);

        if ($this->request->filled('status')) {
            $query->byStatus($this->request->status);
        }
        if ($this->request->filled('supplier')) {
            $query->where('id_supplier', $this->request->supplier);
        }
        if ($this->request->filled('start_date') && $this->request->filled('end_date')) {
            $query->byPeriode($this->request->start_date, $this->request->end_date);
        }
        if ($this->request->filled('search')) {
            $search = $this->request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode_restock', 'like', "%{$search}%")
                  ->orWhere('keterangan', 'like', "%{$search}%");
            });
        }

        return $query->latest('tanggal_restock')->get();
    }

    protected function buildSpreadsheet($restocks): Spreadsheet
    {
        $spreadsheet = new Spreadsheet();

        // ── Sheet 1: Ringkasan Restock ─────────────────────────────
        $this->buildSummarySheet($spreadsheet->getActiveSheet(), $restocks);

        // ── Sheet 2: Detail Produk ─────────────────────────────────
        $detailSheet = $spreadsheet->createSheet();
        $this->buildDetailSheet($detailSheet, $restocks);

        // Aktifkan sheet pertama saat file dibuka
        $spreadsheet->setActiveSheetIndex(0);

        return $spreadsheet;
    }

    // ──────────────────────────────────────────────────────────────
    //  SHEET 1 – RINGKASAN RESTOCK
    // ──────────────────────────────────────────────────────────────
    protected function buildSummarySheet(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet, $restocks): void
    {
        $sheet->setTitle('Ringkasan Restock');

        /* Judul */
        $sheet->mergeCells('A1:H1');
        $sheet->setCellValue('A1', 'LAPORAN DATA RESTOCK – RINGKASAN');
        $sheet->getStyle('A1')->applyFromArray([
            'font'      => ['bold' => true, 'size' => 14, 'color' => ['rgb' => 'FFFFFF']],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '2E5EA8']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(30);

        /* Sub Judul */
        $sheet->mergeCells('A2:H2');
        $periodeLabel = ($this->request->filled('start_date') && $this->request->filled('end_date'))
            ? 'Periode: ' . \Carbon\Carbon::parse($this->request->start_date)->format('d/m/Y')
              . ' s/d '   . \Carbon\Carbon::parse($this->request->end_date)->format('d/m/Y')
            : 'Semua Periode';
        $sheet->setCellValue('A2', 'Dicetak: ' . now()->format('d/m/Y H:i') . '   |   ' . $periodeLabel);
        $sheet->getStyle('A2')->applyFromArray([
            'font'      => ['italic' => true, 'size' => 10, 'color' => ['rgb' => '555555']],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'EBF3FB']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);
        $sheet->getRowDimension(2)->setRowHeight(18);

        /* Header Kolom */
        $headers = ['No', 'Kode Restock', 'Tanggal', 'Supplier', 'Total Biaya (Rp)', 'Status', 'Dibuat Oleh', 'Keterangan'];
        $cols    = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
        foreach ($headers as $i => $header) {
            $sheet->setCellValue($cols[$i] . '3', $header);
        }
        $sheet->getStyle('A3:H3')->applyFromArray([
            'font'      => ['bold' => true, 'size' => 11, 'color' => ['rgb' => 'FFFFFF']],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4F81BD']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'FFFFFF']]],
        ]);
        $sheet->getRowDimension(3)->setRowHeight(22);

        /* Data */
        $row = 4;
        foreach ($restocks as $no => $item) {
            $sheet->setCellValue("A{$row}", $no + 1);
            $sheet->setCellValue("B{$row}", $item->kode_restock);
            $sheet->setCellValue("C{$row}", $item->tanggal_restock->format('d/m/Y'));
            $sheet->setCellValue("D{$row}", $item->supplier ? $item->supplier->nama : 'Tanpa Supplier');
            $sheet->setCellValue("E{$row}", (float) $item->total_biaya);
            $sheet->setCellValue("F{$row}", ucfirst($item->status));
            $sheet->setCellValue("G{$row}", $item->user->name ?? '-');
            $sheet->setCellValue("H{$row}", $item->keterangan ?? '-');

            $bgColor = ($row % 2 === 0) ? 'EBF3FB' : 'FFFFFF';
            $sheet->getStyle("A{$row}:H{$row}")->applyFromArray([
                'fill'    => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $bgColor]],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'D3D3D3']]],
                'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
            ]);
            $sheet->getStyle("E{$row}")->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle("A{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("C{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("F{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

            $statusColor = match ($item->status) {
                'selesai'    => '155724',
                'draft'      => '856404',
                'dibatalkan' => '721C24',
                default      => '333333',
            };
            $sheet->getStyle("F{$row}")->getFont()->getColor()->setRGB($statusColor);
            $sheet->getStyle("F{$row}")->getFont()->setBold(true);
            $sheet->getRowDimension($row)->setRowHeight(18);
            $row++;
        }

        /* Total */
        if ($restocks->count() > 0) {
            $sheet->setCellValue("D{$row}", 'TOTAL');
            $sheet->setCellValue("E{$row}", (float) $restocks->sum('total_biaya'));
            $sheet->getStyle("A{$row}:H{$row}")->applyFromArray([
                'font'    => ['bold' => true, 'size' => 11, 'color' => ['rgb' => 'FFFFFF']],
                'fill'    => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '2E5EA8']],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '1E4A8A']]],
            ]);
            $sheet->getStyle("D{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("E{$row}")->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getRowDimension($row)->setRowHeight(22);
        }

        /* Lebar Kolom */
        $sheet->getColumnDimension('A')->setWidth(6);
        $sheet->getColumnDimension('B')->setWidth(22);
        $sheet->getColumnDimension('C')->setWidth(14);
        $sheet->getColumnDimension('D')->setWidth(22);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(14);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setWidth(30);
        $sheet->freezePane('A4');
    }

    // ──────────────────────────────────────────────────────────────
    //  SHEET 2 – DETAIL PRODUK
    // ──────────────────────────────────────────────────────────────
    protected function buildDetailSheet(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet, $restocks): void
    {
        $sheet->setTitle('Detail Produk');

        /* Judul */
        $sheet->mergeCells('A1:J1');
        $sheet->setCellValue('A1', 'LAPORAN DATA RESTOCK – DETAIL PRODUK');
        $sheet->getStyle('A1')->applyFromArray([
            'font'      => ['bold' => true, 'size' => 14, 'color' => ['rgb' => 'FFFFFF']],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '2E5EA8']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(30);

        /* Sub Judul */
        $sheet->mergeCells('A2:J2');
        $periodeLabel = ($this->request->filled('start_date') && $this->request->filled('end_date'))
            ? 'Periode: ' . \Carbon\Carbon::parse($this->request->start_date)->format('d/m/Y')
              . ' s/d '   . \Carbon\Carbon::parse($this->request->end_date)->format('d/m/Y')
            : 'Semua Periode';
        $sheet->setCellValue('A2', 'Dicetak: ' . now()->format('d/m/Y H:i') . '   |   ' . $periodeLabel);
        $sheet->getStyle('A2')->applyFromArray([
            'font'      => ['italic' => true, 'size' => 10, 'color' => ['rgb' => '555555']],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'EBF3FB']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);
        $sheet->getRowDimension(2)->setRowHeight(18);

        /* Header Kolom */
        $headers = [
            'A' => 'No',
            'B' => 'Kode Restock',
            'C' => 'Tanggal Restock',
            'D' => 'Supplier',
            'E' => 'Status Restock',
            'F' => 'Kode Produk',
            'G' => 'Nama Produk',
            'H' => 'Kategori',
            'I' => 'Jumlah',
            'J' => 'Satuan',
            'K' => 'Harga Beli (Rp)',
            'L' => 'Subtotal (Rp)',
            'M' => 'Catatan',
        ];
        foreach ($headers as $col => $header) {
            $sheet->setCellValue("{$col}3", $header);
        }
        $sheet->getStyle('A3:M3')->applyFromArray([
            'font'      => ['bold' => true, 'size' => 11, 'color' => ['rgb' => 'FFFFFF']],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4F81BD']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'FFFFFF']]],
        ]);
        $sheet->getRowDimension(3)->setRowHeight(22);

        /* Data */
        $row   = 4;
        $seqNo = 1;

        foreach ($restocks as $item) {
            // Jika tidak ada detail, tetap tampilkan satu baris kosong
            if ($item->details->isEmpty()) {
                $sheet->setCellValue("A{$row}", $seqNo++);
                $sheet->setCellValue("B{$row}", $item->kode_restock);
                $sheet->setCellValue("C{$row}", $item->tanggal_restock->format('d/m/Y'));
                $sheet->setCellValue("D{$row}", $item->supplier ? $item->supplier->nama : 'Tanpa Supplier');
                $sheet->setCellValue("E{$row}", ucfirst($item->status));
                $sheet->setCellValue("F{$row}", '-');
                $sheet->setCellValue("G{$row}", 'Tidak ada detail produk');
                $sheet->setCellValue("H{$row}", '-');
                $sheet->setCellValue("I{$row}", '-');
                $sheet->setCellValue("J{$row}", '-');
                $sheet->setCellValue("K{$row}", '-');
                $sheet->setCellValue("L{$row}", '-');
                $sheet->setCellValue("M{$row}", '-');

                $this->applyDetailRowStyle($sheet, $row, 'FFF9C4'); // kuning muda tanda kosong
                $sheet->getStyle("G{$row}")->getFont()->setItalic(true)->getColor()->setRGB('AAAAAA');
                $row++;
                continue;
            }

            $firstRow     = $row;
            $detailCount  = $item->details->count();

            foreach ($item->details as $di => $detail) {
                // Kolom restock header hanya diisi di baris pertama,
                // baris sisanya di-merge agar lebih rapi.
                $sheet->setCellValue("A{$row}", $seqNo);
                $sheet->setCellValue("B{$row}", $item->kode_restock);
                $sheet->setCellValue("C{$row}", $item->tanggal_restock->format('d/m/Y'));
                $sheet->setCellValue("D{$row}", $item->supplier ? $item->supplier->nama : 'Tanpa Supplier');
                $sheet->setCellValue("E{$row}", ucfirst($item->status));

                // Kolom detail produk
                $sheet->setCellValue("F{$row}", $detail->produk->kode_produk ?? '-');
                $sheet->setCellValue("G{$row}", $detail->produk->nama ?? 'Produk dihapus');
                $sheet->setCellValue("H{$row}", $detail->produk->kategori->nama ?? '-');
                $sheet->setCellValue("I{$row}", (int) $detail->jumlah);
                $sheet->setCellValue("J{$row}", $detail->produk->satuan ?? '-');
                $sheet->setCellValue("K{$row}", (float) $detail->harga_beli);
                $sheet->setCellValue("L{$row}", (float) $detail->subtotal);
                $sheet->setCellValue("M{$row}", $detail->catatan ?? '-');

                // Warna baris bergantian per restock (bukan per baris global)
                $bgColor = ($seqNo % 2 === 0) ? 'EBF3FB' : 'FFFFFF';
                $this->applyDetailRowStyle($sheet, $row, $bgColor);

                // Format angka
                $sheet->getStyle("K{$row}")->getNumberFormat()->setFormatCode('#,##0');
                $sheet->getStyle("L{$row}")->getNumberFormat()->setFormatCode('#,##0');
                $sheet->getStyle("I{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Warna teks status
                $statusColor = match ($item->status) {
                    'selesai'    => '155724',
                    'draft'      => '856404',
                    'dibatalkan' => '721C24',
                    default      => '333333',
                };
                $sheet->getStyle("E{$row}")->getFont()->getColor()->setRGB($statusColor);
                $sheet->getStyle("E{$row}")->getFont()->setBold(true);
                $sheet->getStyle("E{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->getRowDimension($row)->setRowHeight(18);
                $row++;
            }

            // Merge kolom header restock (A–E) jika lebih dari 1 detail
            if ($detailCount > 1) {
                $lastRow = $row - 1;
                foreach (['A', 'B', 'C', 'D', 'E'] as $col) {
                    $sheet->mergeCells("{$col}{$firstRow}:{$col}{$lastRow}");
                    $sheet->getStyle("{$col}{$firstRow}")->getAlignment()
                          ->setVertical(Alignment::VERTICAL_TOP)
                          ->setHorizontal(
                              in_array($col, ['A', 'C', 'E'])
                                  ? Alignment::HORIZONTAL_CENTER
                                  : Alignment::HORIZONTAL_LEFT
                          );
                }
            }

            // Baris subtotal per restock
            $subtotalRow = $row;
            $sheet->setCellValue("K{$subtotalRow}", 'Subtotal:');
            $sheet->setCellValue("L{$subtotalRow}", (float) $item->details->sum('subtotal'));
            $sheet->getStyle("A{$subtotalRow}:M{$subtotalRow}")->applyFromArray([
                'font'    => ['bold' => true, 'size' => 10, 'color' => ['rgb' => '1a3f6f']],
                'fill'    => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'D6E4F3']],
                'borders' => [
                    'top'    => ['borderStyle' => Border::BORDER_THIN,   'color' => ['rgb' => '4F81BD']],
                    'bottom' => ['borderStyle' => Border::BORDER_MEDIUM, 'color' => ['rgb' => '2E5EA8']],
                ],
            ]);
            $sheet->getStyle("K{$subtotalRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("L{$subtotalRow}")->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getRowDimension($subtotalRow)->setRowHeight(18);
            $row++;

            $seqNo++;
        }

        /* Grand Total */
        if ($restocks->count() > 0) {
            $grandTotal = $restocks->flatMap->details->sum('subtotal');

            $sheet->mergeCells("A{$row}:K{$row}");
            $sheet->setCellValue("A{$row}", 'GRAND TOTAL SELURUH RESTOCK');
            $sheet->setCellValue("L{$row}", (float) $grandTotal);
            $sheet->getStyle("A{$row}:M{$row}")->applyFromArray([
                'font'    => ['bold' => true, 'size' => 12, 'color' => ['rgb' => 'FFFFFF']],
                'fill'    => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '2E5EA8']],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_MEDIUM, 'color' => ['rgb' => '1E4A8A']]],
            ]);
            $sheet->getStyle("A{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("L{$row}")->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getRowDimension($row)->setRowHeight(24);
        }

        /* Lebar Kolom */
        $sheet->getColumnDimension('A')->setWidth(6);
        $sheet->getColumnDimension('B')->setWidth(22);
        $sheet->getColumnDimension('C')->setWidth(16);
        $sheet->getColumnDimension('D')->setWidth(22);
        $sheet->getColumnDimension('E')->setWidth(14);
        $sheet->getColumnDimension('F')->setWidth(16);
        $sheet->getColumnDimension('G')->setWidth(28);
        $sheet->getColumnDimension('H')->setWidth(18);
        $sheet->getColumnDimension('I')->setWidth(10);
        $sheet->getColumnDimension('J')->setWidth(10);
        $sheet->getColumnDimension('K')->setWidth(18);
        $sheet->getColumnDimension('L')->setWidth(18);
        $sheet->getColumnDimension('M')->setWidth(24);
        $sheet->freezePane('A4');
    }

    // ──────────────────────────────────────────────────────────────
    //  HELPER: apply style baris detail
    // ──────────────────────────────────────────────────────────────
    private function applyDetailRowStyle(
        \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet,
        int $row,
        string $bgColor
    ): void {
        $sheet->getStyle("A{$row}:M{$row}")->applyFromArray([
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $bgColor]],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'D3D3D3']]],
            'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
        ]);
    }
}