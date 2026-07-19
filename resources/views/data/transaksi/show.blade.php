@extends('layouts.app')

@section('title', 'Detail Transaksi #' . $transaksi->no_nota)
@section('breadcrumb', 'Transaksi / Detail')
@section('page-title', 'Detail Transaksi')

@push('styles')
<style>
    .detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        margin-bottom: 24px;
    }

    .info-card {
        background: var(--white);
        border-radius: 12px;
        box-shadow: var(--shadow-card);
        overflow: hidden;
    }

    .info-card-header {
        padding: 14px 20px;
        background: var(--bg-body);
        border-bottom: 2px solid var(--border-color);
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 700;
        font-size: 14px;
        color: var(--primary);
    }

    .info-card-body {
        padding: 20px;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid var(--border-color);
        font-size: 14px;
        gap: 12px;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-row-label {
        color: var(--text-secondary);
        font-weight: 600;
        flex-shrink: 0;
    }

    .info-row-value {
        color: var(--text-primary);
        text-align: right;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
    }

    .status-badge.selesai {
        background: #d1fae5;
        color: #065f46;
    }

    .status-badge.batal {
        background: #fee2e2;
        color: #991b1b;
    }

    .metode-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        background: rgba(47, 50, 145, .08);
        color: var(--primary);
    }

    .produk-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }

    .produk-table thead tr {
        background: var(--bg-body);
    }

    .produk-table th {
        padding: 12px 16px;
        font-weight: 700;
        color: var(--text-secondary);
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: .5px;
    }

    .produk-table td {
        padding: 14px 16px;
        border-bottom: 1px solid var(--border-color);
        vertical-align: middle;
    }

    .produk-table tbody tr:last-child td {
        border-bottom: none;
    }

    .produk-table tbody tr:hover {
        background: rgba(47, 50, 145, .03);
    }

    .summary-box {
        background: var(--white);
        border-radius: 12px;
        box-shadow: var(--shadow-card);
        overflow: hidden;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 13px 24px;
        border-bottom: 1px solid var(--border-color);
        font-size: 14px;
    }

    .summary-row:last-child {
        border-bottom: none;
    }

    .summary-row.grand-total {
        background: var(--primary);
        color: white;
        font-size: 18px;
        font-weight: 700;
        padding: 18px 24px;
    }

    .poin-row {
        background: #fffbeb;
        border-left: 4px solid #f59e0b;
    }

    /* ── Print Log Panel ── */
    #printLogPanel {
        display: none;
        background: #0f1117;
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 24px;
        box-shadow: 0 4px 24px rgba(0, 0, 0, .3);
    }

    #printLogPanel.visible {
        display: block;
    }

    .log-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 18px;
        background: #1a1d27;
        border-bottom: 1px solid #2d3148;
    }

    .log-header-left {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .log-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #6b7280;
        transition: background .3s;
    }

    .log-dot.active {
        background: #22c55e;
        animation: pulse-dot 1s ease-in-out infinite;
    }

    .log-dot.error {
        background: #ef4444;
        animation: none;
    }

    .log-title {
        color: #e5e7eb;
        font-size: 13px;
        font-weight: 600;
        font-family: monospace;
    }

    .log-close {
        background: none;
        border: none;
        color: #6b7280;
        font-size: 18px;
        cursor: pointer;
        padding: 0 4px;
        line-height: 1;
    }

    .log-close:hover {
        color: #e5e7eb;
    }

    #logBody {
        padding: 14px 18px;
        font-family: 'Courier New', monospace;
        font-size: 12.5px;
        line-height: 1.9;
        max-height: 300px;
        overflow-y: auto;
        color: #9ca3af;
    }

    .log-line {
        display: flex;
        gap: 10px;
    }

    .log-time {
        color: #4b5563;
        flex-shrink: 0;
    }

    .log-icon {
        flex-shrink: 0;
    }

    .log-msg {
        color: #d1d5db;
    }

    .log-ok .log-msg   { color: #4ade80; }
    .log-err .log-msg  { color: #f87171; }
    .log-warn .log-msg { color: #fbbf24; }
    .log-info .log-msg { color: #60a5fa; }
    .log-dim .log-msg  { color: #6b7280; }
    .log-step .log-msg { color: #a78bfa; font-weight: 600; }

    .log-progress {
        height: 3px;
        background: #1e2030;
        position: relative;
        overflow: hidden;
    }

    .log-progress-bar {
        height: 100%;
        background: linear-gradient(90deg, #6366f1, #818cf8);
        transition: width .4s ease;
        width: 0%;
    }

    @keyframes pulse-dot {
        0%, 100% { opacity: 1; }
        50%       { opacity: .4; }
    }

    @media (max-width: 768px) {
        .detail-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
@php $rp = auth()->user()->role === 'admin' ? 'admin' : 'kasir'; @endphp

{{-- ── HEADER ── --}}
<div class="content-header">
    <div>
        <h2 style="color:var(--primary); font-size:28px; margin-bottom:4px;">Detail Transaksi</h2>
        <p style="color:var(--text-secondary);">
            No. Nota <strong>{{ $transaksi->no_nota }}</strong>
            &nbsp;·&nbsp;
            <span class="status-badge {{ $transaksi->status }}">
                <i class="fas fa-{{ $transaksi->status === 'selesai' ? 'check-circle' : 'ban' }}"></i>
                {{ strtoupper($transaksi->status) }}
            </span>
        </p>
    </div>
    <div style="display:flex; gap:10px; flex-wrap:wrap;">
        <button type="button" class="btn btn-primary" onclick="cetakPolling()" id="btnCetak">
            <i class="fas fa-print"></i> Cetak Nota
        </button>

        {{-- Tombol log, muncul setelah tombol cetak diklik --}}
        <button type="button" class="btn btn-secondary" onclick="toggleLog()" id="btnLog" style="display:none;">
            <i class="fas fa-terminal"></i> Lihat Log
        </button>

        @if ($transaksi->status === 'selesai' && auth()->user()->role === 'admin')
        <form action="{{ route($rp . '.transaksi.destroy', $transaksi->id) }}" method="POST"
            onsubmit="return confirm('Yakin ingin membatalkan transaksi ini?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-danger">
                <i class="fas fa-ban"></i> Batalkan
            </button>
        </form>
        @endif
        <a href="{{ route($rp . '.transaksi.index') }}" class="btn btn-warning">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

{{-- ── PRINT LOG PANEL ── --}}
<div id="printLogPanel">
    <div class="log-header">
        <div class="log-header-left">
            <div class="log-dot" id="logDot"></div>
            <span class="log-title">Print Log — Polling Agent</span>
        </div>
        <button class="log-close" onclick="toggleLog()" title="Tutup log">×</button>
    </div>
    <div class="log-progress">
        <div class="log-progress-bar" id="logBar"></div>
    </div>
    <div id="logBody"></div>
</div>

{{-- ── GRID INFO ── --}}
<div class="detail-grid">
    <div class="info-card">
        <div class="info-card-header"><i class="fas fa-receipt"></i> Informasi Transaksi</div>
        <div class="info-card-body">
            <div class="info-row">
                <span class="info-row-label">No. Transaksi</span>
                <span class="info-row-value">{{ $transaksi->no_transaksi }}</span>
            </div>
            <div class="info-row">
                <span class="info-row-label">No. Nota</span>
                <span class="info-row-value"><strong>{{ $transaksi->no_nota }}</strong></span>
            </div>
            <div class="info-row">
                <span class="info-row-label">Tanggal</span>
                <span class="info-row-value">{{ $transaksi->dibuat_pada->translatedFormat('d F Y, H:i') }}</span>
            </div>
            <div class="info-row">
                <span class="info-row-label">Status</span>
                <span class="info-row-value">
                    <span class="status-badge {{ $transaksi->status }}">
                        <i class="fas fa-{{ $transaksi->status === 'selesai' ? 'check-circle' : 'ban' }}"></i>
                        {{ strtoupper($transaksi->status) }}
                    </span>
                </span>
            </div>
            <div class="info-row">
                <span class="info-row-label">Metode Bayar</span>
                <span class="info-row-value">
                    <span class="metode-badge">
                        <i class="fas fa-{{ $transaksi->metode_bayar === 'tunai' ? 'money-bill-wave' : 'credit-card' }}"></i>
                        {{ strtoupper($transaksi->metode_bayar) }}
                    </span>
                </span>
            </div>
        </div>
    </div>

    <div class="info-card">
        <div class="info-card-header"><i class="fas fa-users"></i> Kasir & Member</div>
        <div class="info-card-body">
            <div class="info-row">
                <span class="info-row-label">Kasir</span>
                <span class="info-row-value">
                    <i class="fas fa-user-tie" style="color:var(--primary);"></i>
                    {{ $transaksi->kasir->name }}
                </span>
            </div>
            @if ($transaksi->member)
            <div class="info-row">
                <span class="info-row-label">Member</span>
                <span class="info-row-value">
                    <i class="fas fa-id-card" style="color:#28a745;"></i>
                    {{ $transaksi->member->name }}
                </span>
            </div>
            <div class="info-row">
                <span class="info-row-label">Telepon</span>
                <span class="info-row-value">{{ $transaksi->member->no_telepon ?? '—' }}</span>
            </div>
            <div class="info-row">
                <span class="info-row-label">Saldo Poin</span>
                <span class="info-row-value" style="font-weight:700; color:var(--primary);">
                    {{ number_format($transaksi->member->saldo_poin ?? 0) }} poin
                </span>
            </div>
            @else
            <div class="info-row">
                <span class="info-row-label">Member</span>
                <span class="info-row-value" style="color:var(--text-secondary);">
                    <i class="fas fa-user-slash"></i> Tanpa Member
                </span>
            </div>
            @endif
        </div>
    </div>
</div>

{{-- ── TABEL PRODUK ── --}}
<div class="info-card" style="margin-bottom:24px;">
    <div class="info-card-header">
        <i class="fas fa-box"></i> Daftar Produk
        <span style="margin-left:auto; font-size:13px; font-weight:400; color:var(--text-secondary);">
            {{ $transaksi->detail->count() }} item
        </span>
    </div>
    <div style="overflow-x:auto;">
        <table class="produk-table">
            <thead>
                <tr>
                    <th style="width:40px;">#</th>
                    <th>Produk</th>
                    <th style="text-align:center;">Qty</th>
                    <th style="text-align:right;">Harga Satuan</th>
                    <th style="text-align:right;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaksi->detail as $i => $detail)
                <tr>
                    <td style="color:var(--text-secondary); font-weight:600;">{{ $i + 1 }}</td>
                    <td>
                        <div style="font-weight:600;">{{ $detail->produk->nama }}</div>
                        <div style="font-size:12px; color:var(--text-secondary); margin-top:2px;">
                            {{ $detail->produk->kode_produk }}
                        </div>
                    </td>
                    <td style="text-align:center;">
                        <span style="font-weight:700;">{{ $detail->jumlah }}</span>
                        <span style="font-size:12px; color:var(--text-secondary);">{{ $detail->produk->satuan }}</span>
                    </td>
                    <td style="text-align:right;">Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                    <td style="text-align:right; font-weight:700;">
                        Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- ── SUMMARY TOTAL ── --}}
<div style="display:flex; justify-content:flex-end; margin-bottom:24px;">
    <div class="summary-box" style="min-width:360px;">
        <div class="summary-row">
            <span style="color:var(--text-secondary); font-weight:600;">Total Harga</span>
            <span style="font-weight:700;">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
        </div>
        <div class="summary-row">
            <span style="color:var(--text-secondary); font-weight:600;">Total Bayar</span>
            <span style="font-weight:700;">Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</span>
        </div>
        @if ($transaksi->metode_bayar === 'tunai')
        <div class="summary-row">
            <span style="color:var(--text-secondary); font-weight:600;">Kembalian</span>
            <span style="font-weight:700; color:#28a745;">
                Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}
            </span>
        </div>
        @endif
        @if ($transaksi->riwayatPoin && $transaksi->riwayatPoin->jenis === 'masuk')
        <div class="summary-row poin-row">
            <span style="font-weight:600; color:#92400e;">
                <i class="fas fa-star" style="color:#f59e0b;"></i> Poin Didapat
            </span>
            <span style="font-weight:700; color:#92400e;">
                +{{ number_format($transaksi->riwayatPoin->poin, 0, ',', '.') }} poin
            </span>
        </div>
        @endif
        <div class="summary-row grand-total">
            <span>GRAND TOTAL</span>
            <span>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
const PUSH_URL     = "{{ url('/api/print-jobs') }}";
const CSRF_TOKEN   = @json(csrf_token());
const TRANSAKSI_ID = @json($transaksi->id);

function getEl(id) { return document.getElementById(id); }

/* ── LOG PANEL ───────────────────────────────────────────────── */
function openLog() {
    const body = getEl('logBody');
    const bar  = getEl('logBar');
    if (body) body.innerHTML = '';
    if (bar)  bar.style.width = '0%';

    // Sembunyikan panel, reset tombol log
    const panel  = getEl('printLogPanel');
    const btnLog = getEl('btnLog');
    if (panel)  panel.classList.remove('visible');
    if (btnLog) {
        btnLog.style.display = '';
        btnLog.innerHTML = '<i class="fas fa-terminal"></i> Lihat Log';
    }
}

function toggleLog() {
    const panel  = getEl('printLogPanel');
    const btnLog = getEl('btnLog');
    if (!panel) return;
    const isVisible = panel.classList.contains('visible');
    panel.classList.toggle('visible');
    if (btnLog) {
        btnLog.innerHTML = isVisible
            ? '<i class="fas fa-terminal"></i> Lihat Log'
            : '<i class="fas fa-terminal"></i> Sembunyikan Log';
    }
}

function showLogOnError() {
    const panel  = getEl('printLogPanel');
    const btnLog = getEl('btnLog');
    if (panel && !panel.classList.contains('visible')) {
        panel.classList.add('visible');
    }
    if (btnLog) {
        btnLog.innerHTML = '<i class="fas fa-terminal"></i> Sembunyikan Log';
    }
}

function setProgress(pct) {
    const bar = getEl('logBar');
    if (bar) bar.style.width = pct + '%';
}

function setDot(state) {
    const dot = getEl('logDot');
    if (!dot) return;
    dot.className = 'log-dot' + (state !== 'idle' ? ' ' + state : '');
}

function log(msg, type = 'info') {
    const body = getEl('logBody');
    if (!body) return;
    const icons = { step:'▶', ok:'✔', err:'✘', warn:'⚠', info:'·', dim:' ' };
    const now   = new Date().toLocaleTimeString('id-ID', { hour12: false });
    const line  = document.createElement('div');
    line.className = `log-line log-${type}`;
    line.innerHTML =
        `<span class="log-time">${now}</span>` +
        `<span class="log-icon">${icons[type] ?? '·'}</span>` +
        `<span class="log-msg">${String(msg).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;')}</span>`;
    body.appendChild(line);
    body.scrollTop = body.scrollHeight;
}

/* ── CETAK POLLING ───────────────────────────────────────────── */
async function cetakPolling() {
    const btn = getEl('btnCetak');
    if (btn) btn.disabled = true;

    openLog();
    setDot('active');
    setProgress(20);
    log('Mengirim job cetak ke antrian server...', 'step');

    let jobId;
    try {
        const res  = await fetch(PUSH_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'Accept':       'application/json',
            },
            body: JSON.stringify({ transaksi_id: TRANSAKSI_ID }),
        });
        const data = await res.json();
        if (!data.success) throw new Error(data.message ?? 'Gagal push job');
        jobId = data.job_id;
        log(`Job #${jobId} berhasil masuk antrian ✔`, 'ok');
        setProgress(40);
    } catch (err) {
        log('Gagal kirim ke server: ' + err.message, 'err');
        log('Pastikan route /api/print-jobs sudah ditambahkan di routes/api.php', 'dim');
        showLogOnError();
        finishLog(false, btn);
        return;
    }

    // STEP 2 — Tunggu Python agent cetak
    log('Menunggu printer agent mencetak...', 'step');
    log('(Python di PC kasir akan ambil job ini tiap 2 detik)', 'dim');
    setProgress(60);

    const maxWait  = 30;
    const interval = 2000;
    let elapsed    = 0;
    let printed    = false;

    while (elapsed < maxWait * 1000) {
        await new Promise(r => setTimeout(r, interval));
        elapsed += interval;

        try {
            const res  = await fetch(`/api/print-jobs/${jobId}/status`, {
                headers: { 'Accept': 'application/json' }
            });
            const data = await res.json();
            const status = data.job?.status;

            if (status === 'done') {
                printed = true;
                break;
            } else if (status === 'failed') {
                log('Agent gagal cetak: ' + (data.job?.error_message ?? '-'), 'err');
                showLogOnError();
                break;
            } else {
                log(`Status: ${status} (${elapsed / 1000}s)...`, 'dim');
            }
        } catch { /* lanjut */ }
    }

    setProgress(100);

    if (printed) {
        log('Nota berhasil dicetak oleh printer agent ✔', 'ok');
    } else if (elapsed >= maxWait * 1000) {
        log(`Timeout ${maxWait}s — pastikan print_agent.py jalan di PC kasir.`, 'warn');
        showLogOnError();
    }

    finishLog(printed, btn);
}

/* ── FINISH ──────────────────────────────────────────────────── */
function finishLog(success, btn) {
    if (btn) btn.disabled = false;
    setDot(success ? 'idle' : 'error');
    log('─────────────────────────────────────', 'dim');
    showToast(
        success ? '✔ Nota berhasil dicetak!' : '✘ Cetak gagal — lihat log di atas',
        success ? 'success' : 'error'
    );
}

function showToast(msg, type = 'success') {
    getEl('toastNotif')?.remove();
    const t = document.createElement('div');
    t.id = 'toastNotif';
    t.style.cssText = `
        position:fixed; bottom:24px; right:24px; z-index:99999;
        background:${type === 'success' ? '#065f46' : '#991b1b'};
        color:white; padding:16px 24px; border-radius:10px;
        font-size:15px; font-weight:600; box-shadow:0 8px 24px rgba(0,0,0,.3);
        max-width:400px; line-height:1.5;
    `;
    t.textContent = msg;
    document.body.appendChild(t);
    setTimeout(() => t?.remove(), 6000);
}

/* ── AUTO PRINT ──────────────────────────────────────────────── */
@if(session('auto_print'))
window.addEventListener('DOMContentLoaded', () => {
    setTimeout(() => cetakPolling(), 800);
});
@endif
</script>
@endpush