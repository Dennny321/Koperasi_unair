<?php

namespace App\Services;

use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\PrintConnectors\DummyPrintConnector;

class NotaPrinterService
{
    protected int $lebar = 32; // 58mm = 32 char | 80mm = 42 char

    /**
     * Cetak langsung ke printer (untuk server lokal / USB)
     */
    public function cetak($transaksi): void
    {
        $connector = $this->resolveConnector();
        $printer   = new Printer($connector);

        try {
            $this->doPrint($printer, $transaksi);
        } finally {
            $printer->close();
        }
    }

    /**
     * Generate raw ESC/POS bytes → dikembalikan sebagai Base64
     * Dipakai jika server adalah cloud/VPS (tidak bisa akses USB langsung)
     */
    public function generateBase64($transaksi): string
{
    ob_start();
    
    $connector = new FilePrintConnector('php://output');
    $printer   = new Printer($connector);
    $this->doPrint($printer, $transaksi);
    $printer->close();
    
    $data = ob_get_clean();
    
    return base64_encode($data);
}

    // ─────────────────────────────────────────────────────────────
    // PRIVATE
    // ─────────────────────────────────────────────────────────────

    private function resolveConnector()
    {
        $mode = config('printer.mode', 'file');

        return match ($mode) {
            'file'    => new FilePrintConnector(config('printer.device', 'COM5:')),
            'windows' => new WindowsPrintConnector(config('printer.name', 'RPP02N')),
            'network' => new NetworkPrintConnector(
                            config('printer.host', '192.168.1.200'),
                            config('printer.port', 9100)
                         ),
            default   => new FilePrintConnector(config('printer.device', 'COM5:')),
        };
    }

    private function doPrint(Printer $printer, $transaksi): void
    {
        $lebar = $this->lebar;

        // ── INIT ────────────────────────────────────────────────────
        $printer->initialize();

        // ── HEADER ──────────────────────────────────────────────────
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->setEmphasis(true);
        $printer->setTextSize(2, 1);
        $printer->text("KOPERASI UNAIR\n");
        $printer->setTextSize(1, 1);
        $printer->setEmphasis(false);
        $printer->text("Koperasi Pegawai Univ. Airlangga\n");
        $printer->text("Kampus B Unair, Surabaya\n");
        $printer->text(str_repeat('-', $lebar) . "\n");

        // ── NOMOR NOTA ──────────────────────────────────────────────
        $printer->text("No. Nota / Surat Jalan\n");
        $printer->setEmphasis(true);
        $printer->setTextSize(1, 2);
        $noNota = $transaksi->no_nota ?? $transaksi->no_transaksi;
        $printer->text($noNota . "\n");
        $printer->setTextSize(1, 1);
        $printer->setEmphasis(false);
        $printer->text(str_repeat('-', $lebar) . "\n");

        // ── INFO TRANSAKSI ──────────────────────────────────────────
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->text($this->row('No. Transaksi', $transaksi->no_transaksi, $lebar));
        $printer->text($this->row('Tanggal', $transaksi->dibuat_pada->format('d/m/Y H:i'), $lebar));
        $printer->text($this->row('Kasir', $transaksi->kasir?->name ?? '-', $lebar));
        $printer->text(str_repeat('-', $lebar) . "\n");

        // ── ITEM BELANJA ─────────────────────────────────────────────
        foreach ($transaksi->detail as $item) {
            $nama = $item->produk?->nama ?? 'Produk';

            // Wrap nama produk jika panjang
            foreach ($this->wordWrap($nama, $lebar) as $i => $line) {
                if ($i === 0) {
                    $printer->setEmphasis(true);
                }
                $printer->text($line . "\n");
                $printer->setEmphasis(false);
            }

            $qty = $item->jumlah . ' x Rp ' . number_format($item->harga_satuan, 0, ',', '.');
            $sub = 'Rp ' . number_format($item->subtotal, 0, ',', '.');
            $printer->text($this->row($qty, $sub, $lebar));
        }

        $printer->text(str_repeat('-', $lebar) . "\n");

        // ── TOTAL ────────────────────────────────────────────────────
        $printer->text($this->row(
            'Subtotal',
            'Rp ' . number_format($transaksi->total_harga, 0, ',', '.'),
            $lebar
        ));

        $printer->setEmphasis(true);
        $printer->text(str_repeat('=', $lebar) . "\n");
        $printer->text($this->row(
            'TOTAL',
            'Rp ' . number_format($transaksi->total_harga, 0, ',', '.'),
            $lebar
        ));
        $printer->text(str_repeat('=', $lebar) . "\n");
        $printer->setEmphasis(false);

        $printer->text($this->row(
            'Dibayar',
            'Rp ' . number_format($transaksi->total_bayar, 0, ',', '.'),
            $lebar
        ));
        $printer->text($this->row(
            'Kembalian',
            'Rp ' . number_format($transaksi->kembalian, 0, ',', '.'),
            $lebar
        ));
        $printer->text(str_repeat('-', $lebar) . "\n");

        // ── METODE BAYAR ─────────────────────────────────────────────
        $metodeLbl = ['tunai' => 'TUNAI', 'transfer' => 'TRANSFER', 'qris' => 'QRIS'];
        $metode    = $metodeLbl[$transaksi->metode_bayar] ?? strtoupper($transaksi->metode_bayar);

        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->setEmphasis(true);
        $printer->text("*** $metode ***\n");
        $printer->setEmphasis(false);

        // ── MEMBER + POIN (jika ada) ─────────────────────────────────
        if ($transaksi->member) {
            $printer->text(str_repeat('-', $lebar) . "\n");
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text("MEMBER\n");
            $printer->setEmphasis(true);
            $printer->text($transaksi->member->name . "\n");
            $printer->setEmphasis(false);
            $printer->text(($transaksi->member->no_telepon ?? '-') . "\n");

            if ($transaksi->riwayatPoin) {
                $poin = number_format($transaksi->riwayatPoin->poin, 0, ',', '.');
                $printer->text("* +{$poin} poin diberikan\n");
            }
        }

        // ── FOOTER ───────────────────────────────────────────────────
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text(str_repeat('-', $lebar) . "\n");
        $printer->text("Terima kasih atas kunjungan Anda!\n");
        $printer->text("Barang yang sudah dibeli\n");
        $printer->text("tidak dapat dikembalikan.\n");
        $printer->feed(1);
        $printer->text("Dicetak: " . now()->format('d/m/Y H:i:s') . "\n");

        // ── CUT ──────────────────────────────────────────────────────
        $printer->feed(3);
        $printer->cut();
    }

    /**
     * Format 2 kolom rata kiri-kanan
     * Contoh: "Subtotal            Rp 50.000"
     */
    private function row(string $kiri, string $kanan, int $lebar): string
    {
        $maxKiri = $lebar - strlen($kanan);

        if ($maxKiri < 1) {
            // Jika kanan sudah memenuhi lebar, print 2 baris
            return $kiri . "\n" . str_pad($kanan, $lebar, ' ', STR_PAD_LEFT) . "\n";
        }

        if (strlen($kiri) >= $maxKiri) {
            $kiri = substr($kiri, 0, $maxKiri - 2) . '..';
        }

        return str_pad($kiri, $maxKiri) . $kanan . "\n";
    }

    /**
     * Word wrap sederhana untuk nama produk panjang
     */
    private function wordWrap(string $text, int $lebar): array
    {
        return explode("\n", wordwrap($text, $lebar, "\n", true));
    }
}
