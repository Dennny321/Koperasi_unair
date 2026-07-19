<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PrintJob;
use App\Models\Data\Transaksi;
use App\Services\NotaPrinterService;
use Illuminate\Http\Request;

class PrintJobController extends Controller
{
    public function __construct(protected NotaPrinterService $printerService) {}

    /**
     * ── ENDPOINT 1: Push job cetak ke antrian ──────────────────────
     *
     * Dipanggil dari tombol "Cetak Nota" di browser kasir.
     * Menggantikan printQz() yang lama.
     *
     * POST /api/print-jobs
     * Body: { transaksi_id, printer_target? }
     */
    public function push(Request $request)
    {
        $request->validate([
            'transaksi_id'   => 'required|exists:02_transaksi,id',
            'printer_target' => 'nullable|string|max:100',
        ]);

        $transaksi = Transaksi::with(['kasir', 'member', 'detail.produk', 'riwayatPoin'])
            ->findOrFail($request->transaksi_id);

        // Cek apakah sudah ada job pending untuk transaksi ini
        // (hindari double print kalau tombol diklik 2x)
        $existing = PrintJob::where('id_transaksi', $transaksi->id)
            ->where('status', 'pending')
            ->first();

        if ($existing) {
            return response()->json([
                'success' => true,
                'job_id'  => $existing->id,
                'message' => 'Job cetak sudah ada di antrian.',
            ]);
        }

        // Generate ESC/POS bytes
        try {
            $base64 = $this->printerService->generateBase64($transaksi);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal generate nota: ' . $e->getMessage(),
            ], 500);
        }

        $job = PrintJob::create([
            'id_transaksi'   => $transaksi->id,
            'no_nota'        => $transaksi->no_nota,
            'kasir_id'       => auth()->id(),
            'status'         => 'pending',
            'escpos_base64'  => $base64,
            'printer_target' => $request->printer_target ?? null,
        ]);

        return response()->json([
            'success' => true,
            'job_id'  => $job->id,
            'message' => 'Job cetak berhasil ditambahkan ke antrian.',
        ]);
    }

    /**
     * ── ENDPOINT 2: Polling dari Python di PC kasir ────────────────
     *
     * Python memanggil ini setiap N detik.
     * Mengembalikan 1 job pending (FIFO), lalu langsung tandai
     * sebagai 'processing' agar tidak diambil 2x.
     *
     * GET /api/print-jobs/poll?token=SECRET&printer=POS58
     */
    public function poll(Request $request)
    {
        // Validasi token sederhana (isi di .env: PRINT_AGENT_TOKEN=...)
        $token = $request->query('token');
        if ($token !== config('printer.agent_token')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $printerTarget = $request->query('printer');

        // Ambil 1 job pending, FIFO, atomic (pakai lockForUpdate)
        $job = PrintJob::pending()
            ->forPrinter($printerTarget)
            ->orderBy('id')
            ->lockForUpdate()
            ->first();

        if (! $job) {
            return response()->json(['job' => null]);
        }

        // Tandai processing agar tidak diambil agent lain
        $job->update(['status' => 'processing']);

        return response()->json([
            'job' => [
                'id'            => $job->id,
                'no_nota'       => $job->no_nota,
                'escpos_base64' => $job->escpos_base64,
            ],
        ]);
    }

    /**
     * ── ENDPOINT 3: Python lapor hasil cetak ──────────────────────
     *
     * POST /api/print-jobs/{id}/result
     * Body: { token, success, error_message? }
     */
    public function result(Request $request, $id)
    {
        $token = $request->input('token');
        if ($token !== config('printer.agent_token')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $job = PrintJob::findOrFail($id);

        if ($request->boolean('success')) {
            $job->update([
                'status'     => 'done',
                'printed_at' => now(),
            ]);
        } else {
            $job->update([
                'status'        => 'failed',
                'error_message' => $request->input('error_message', 'Unknown error'),
            ]);
        }

        return response()->json(['ok' => true]);
    }

    /**
     * ── ENDPOINT 4: Cek status job (opsional, untuk feedback di browser) ──
     *
     * GET /api/print-jobs/{id}/status
     */
    public function status($id)
    {
        $job = PrintJob::select('id', 'status', 'printed_at', 'error_message')
            ->findOrFail($id);

        return response()->json(['job' => $job]);
    }
}