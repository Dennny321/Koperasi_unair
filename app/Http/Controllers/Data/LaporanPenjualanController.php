<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use App\Models\Data\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanPenjualanController extends Controller
{
    /**
     * Ambil query transaksi berdasarkan filter dari request.
     */
    private function buildQuery(Request $request)
    {
        $query = Transaksi::with(['kasir', 'member', 'detail.produk'])
            ->where('status', 'selesai');

        if ($request->filled('tanggal_dari')) {
            $query->whereDate('dibuat_pada', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('dibuat_pada', '<=', $request->tanggal_sampai);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('no_transaksi', 'like', "%{$search}%")
                  ->orWhere('no_nota', 'like', "%{$search}%")
                  ->orWhereHas('member', fn($q2) =>
                        $q2->where('name', 'like', "%{$search}%"))
                  ->orWhereHas('detail.produk', fn($q2) =>
                        $q2->where('nama', 'like', "%{$search}%")
                           ->orWhere('kode_produk', 'like', "%{$search}%"));
            });
        }
        if ($request->filled('metode_bayar')) {
            $query->where('metode_bayar', $request->metode_bayar);
        }

        return $query->orderBy('dibuat_pada', 'desc');
    }

    /**
     * Query ringkasan (tanpa ORDER BY agar tidak konflik dengan aggregate).
     */
    private function getSummary(Request $request): object
    {
        $query = Transaksi::where('status', 'selesai');

        if ($request->filled('tanggal_dari')) {
            $query->whereDate('dibuat_pada', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('dibuat_pada', '<=', $request->tanggal_sampai);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('no_transaksi', 'like', "%{$search}%")
                  ->orWhere('no_nota', 'like', "%{$search}%")
                  ->orWhereHas('member', fn($q2) =>
                        $q2->where('name', 'like', "%{$search}%"))
                  ->orWhereHas('detail.produk', fn($q2) =>
                        $q2->where('nama', 'like', "%{$search}%")
                           ->orWhere('kode_produk', 'like', "%{$search}%"));
            });
        }
        if ($request->filled('metode_bayar')) {
            $query->where('metode_bayar', $request->metode_bayar);
        }

        return $query->selectRaw(
            'COUNT(*) as total_transaksi,
             COALESCE(SUM(total_harga), 0) as total_pendapatan,
             COALESCE(AVG(total_harga), 0) as rata_rata'
        )->first();
    }

    /**
     * Halaman utama laporan penjualan.
     */
    public function index(Request $request)
    {
        $perPage = in_array((int) $request->get('per_page', 5), [5, 10, 25, 50, 100])
            ? (int) $request->get('per_page', 5)
            : 5;

        $summary   = $this->getSummary($request);
        $transaksi = $this->buildQuery($request)->paginate($perPage)->withQueryString();

        return view('data.laporan-penjualan.index', compact('transaksi', 'summary'));
    }

    /**
     * Export ke Excel (CSV dengan BOM agar Excel baca UTF-8).
     */
    public function exportExcel(Request $request)
{
    $transaksi = $this->buildQuery($request)->get();
    $summary   = $this->getSummary($request);
    $namaFile  = 'laporan-penjualan-' . now()->format('Ymd-His') . '.xlsx';

    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setTitle('Laporan Penjualan');

    // ── Styling helpers ──
    $boldStyle = ['font' => ['bold' => true]];
    $headerStyle = [
        'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 11],
        'fill'      => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '2F3291']],
        'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                        'wrapText'   => true],
        'borders'   => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                         'color' => ['rgb' => 'FFFFFF']]],
    ];
    $totalStyle = [
        'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
        'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                   'startColor' => ['rgb' => '1e2061']],
    ];
    $borderThin = [
        'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                       'color' => ['rgb' => 'D1D5DB']]],
    ];

    // ── Baris 1: Judul ──
    $sheet->mergeCells('A1:K1');
    $sheet->setCellValue('A1', 'LAPORAN PENJUALAN KOPERASI PEGAWAI UNAIR');
    $sheet->getStyle('A1')->applyFromArray([
        'font'      => ['bold' => true, 'size' => 14, 'color' => ['rgb' => 'FFFFFF']],
        'fill'      => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '2F3291']],
        'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER],
    ]);
    $sheet->getRowDimension(1)->setRowHeight(30);

    // ── Baris 2: Tanggal cetak ──
    $sheet->mergeCells('A2:K2');
    $sheet->setCellValue('A2', 'Dicetak pada: ' . now()->format('d/m/Y H:i') . '  |  Oleh: ' . (auth()->user()->name ?? 'Admin'));
    $sheet->getStyle('A2')->applyFromArray([
        'font' => ['italic' => true, 'color' => ['rgb' => '4A5568']],
        'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                   'startColor' => ['rgb' => 'F0F4FF']],
    ]);

    // ── Baris 3: Filter ──
    $sheet->mergeCells('A3:K3');
    $sheet->setCellValue('A3', 'Filter: ' . $this->buildFilterLabel($request));
    $sheet->getStyle('A3')->applyFromArray([
        'font' => ['bold' => true, 'color' => ['rgb' => '2F3291']],
        'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                   'startColor' => ['rgb' => 'E8EAFF']],
    ]);

    // ── Baris 4: Kosong ──
    $sheet->getRowDimension(4)->setRowHeight(8);

    // ── Baris 5: Summary ──
    $sheet->setCellValue('A5', 'Total Transaksi');
    $sheet->setCellValue('B5', (int) $summary->total_transaksi);
    $sheet->setCellValue('D5', 'Total Pendapatan');
    $sheet->setCellValue('E5', 'Rp ' . number_format((int) $summary->total_pendapatan, 0, ',', '.'));
    $sheet->setCellValue('G5', 'Rata-rata / Transaksi');
    $sheet->setCellValue('H5', 'Rp ' . number_format((int) $summary->rata_rata, 0, ',', '.'));
    $sheet->getStyle('A5:H5')->applyFromArray($boldStyle);
    $sheet->getStyle('A5:H5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
          ->getStartColor()->setRGB('EEF0FF');

    // ── Baris 6: Kosong ──
    $sheet->getRowDimension(6)->setRowHeight(8);

    // ── Baris 7: Header Kolom ──
    $headers = ['No', 'No. Transaksi', 'No. Nota', 'Tanggal', 'Jam',
                'Kasir', 'Member', 'Produk Dibeli', 'Metode Bayar',
                'Total Harga', 'Kembalian'];
    $col = 'A';
    foreach ($headers as $h) {
        $sheet->setCellValue($col . '7', $h);
        $col++;
    }
    $sheet->getStyle('A7:K7')->applyFromArray($headerStyle);
    $sheet->getRowDimension(7)->setRowHeight(22);

    // ── Baris 8+: Data ──
    $row = 8;
    $no  = 1;
    foreach ($transaksi as $t) {
        $produkList = $t->detail->map(fn($d) =>
            ($d->produk->nama ?? '-') . ' x' . $d->jumlah
        )->implode("\n");

        $sheet->setCellValue('A' . $row, $no++);
        $sheet->setCellValue('B' . $row, $t->no_transaksi);
        $sheet->setCellValue('C' . $row, $t->no_nota ?? '-');
        $sheet->setCellValue('D' . $row, $t->dibuat_pada?->format('d/m/Y') ?? '-');
        $sheet->setCellValue('E' . $row, $t->dibuat_pada?->format('H:i') ?? '-');
        $sheet->setCellValue('F' . $row, $t->kasir->name ?? '-');
        $sheet->setCellValue('G' . $row, $t->member->name ?? 'Umum');
        $sheet->setCellValue('H' . $row, $produkList);
        $sheet->setCellValue('I' . $row, ucfirst($t->metode_bayar));
        $sheet->setCellValue('J' . $row, (int) $t->total_harga);
        $sheet->setCellValue('K' . $row, (int) $t->kembalian);

        // Zebra stripe
        if ($no % 2 === 0) {
            $sheet->getStyle('A'.$row.':K'.$row)->getFill()
                  ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                  ->getStartColor()->setRGB('F7F8FF');
        }

        $sheet->getStyle('A'.$row.':K'.$row)->applyFromArray($borderThin);
        $sheet->getStyle('A'.$row)->getAlignment()->setHorizontal(
            \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('J'.$row.':K'.$row)->getNumberFormat()
              ->setFormatCode('#,##0');
        $sheet->getStyle('H'.$row)->getAlignment()->setWrapText(true);

        $row++;
    }

    // ── Baris Total ──
    $sheet->mergeCells('A'.$row.':I'.$row);
    $sheet->setCellValue('A'.$row, 'TOTAL PENDAPATAN');
    $sheet->setCellValue('J'.$row, (int) $summary->total_pendapatan);
    $sheet->getStyle('A'.$row.':K'.$row)->applyFromArray($totalStyle);
    $sheet->getStyle('J'.$row)->getNumberFormat()->setFormatCode('#,##0');
    $sheet->getStyle('A'.$row)->getAlignment()
          ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

    // ── Lebar Kolom ──
    $widths = ['A'=>6,'B'=>22,'C'=>18,'D'=>12,'E'=>8,'F'=>18,'G'=>18,'H'=>35,'I'=>14,'J'=>16,'K'=>14];
    foreach ($widths as $c => $w) {
        $sheet->getColumnDimension($c)->setWidth($w);
    }

    // ── Format angka kolom J & K ──
    $sheet->getStyle('J8:J'.$row)->getNumberFormat()->setFormatCode('#,##0');
    $sheet->getStyle('K8:K'.($row-1))->getNumberFormat()->setFormatCode('#,##0');

    // ── Freeze pane di baris header ──
    $sheet->freezePane('A8');

    // ── Output ──
    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    $tempFile = tempnam(sys_get_temp_dir(), 'laporan_');
    $writer->save($tempFile);

    return response()->download($tempFile, $namaFile, [
        'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    ])->deleteFileAfterSend(true);
}

    /**
     * Halaman cetak PDF (print dari browser).
     */
    public function cetakPdf(Request $request)
    {
        $transaksi = $this->buildQuery($request)->get();
        $raw       = $this->getSummary($request);

        $summary = [
            'total_transaksi'  => (int) $raw->total_transaksi,
            'total_pendapatan' => (float) $raw->total_pendapatan,
            'total_bayar'      => $transaksi->sum('total_bayar'),
            'rata_rata'        => (float) $raw->rata_rata,
        ];

        $filterLabel = $this->buildFilterLabel($request);

        return view('data.laporan-penjualan.cetak-pdf',
            compact('transaksi', 'summary', 'filterLabel'));
    }

    private function buildFilterLabel(Request $request): string
    {
        $parts = [];
        if ($request->filled('tanggal_dari'))
            $parts[] = 'Dari: ' . \Carbon\Carbon::parse($request->tanggal_dari)->format('d/m/Y');
        if ($request->filled('tanggal_sampai'))
            $parts[] = 'Sampai: ' . \Carbon\Carbon::parse($request->tanggal_sampai)->format('d/m/Y');
        if ($request->filled('search'))
            $parts[] = 'Pencarian: "' . $request->search . '"';
        if ($request->filled('metode_bayar'))
            $parts[] = 'Metode: ' . ucfirst($request->metode_bayar);

        return count($parts) ? implode('  |  ', $parts) : 'Semua Data';
    }
}
