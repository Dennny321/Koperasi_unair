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
        background: rgba(47,50,145,.08);
        color: var(--primary);
    }

    /* Tabel produk */
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
        background: rgba(47,50,145,.03);
    }

    /* Summary total */
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
            <h2 style="color:var(--primary); font-size:28px; margin-bottom:4px;">
                Detail Transaksi
            </h2>
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
            <button type="button" class="btn btn-primary" onclick="cetakEscpos()" id="btnCetakEscpos">
                <i class="fas fa-print"></i> Cetak Nota
            </button>
            @if ($transaksi->status === 'selesai' && auth()->user()->role === 'admin')
                <form action="{{ route($rp . '.transaksi.destroy', $transaksi->id) }}" method="POST"
                      onsubmit="return confirm('Yakin ingin membatalkan transaksi ini? Stok akan dikembalikan.')">
                    @csrf
                    @method('DELETE')
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

    {{-- ── GRID INFO ATAS ── --}}
    <div class="detail-grid">

        {{-- Info Transaksi --}}
        <div class="info-card">
            <div class="info-card-header">
                <i class="fas fa-receipt"></i> Informasi Transaksi
            </div>
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

        {{-- Info Kasir & Member --}}
        <div class="info-card">
            <div class="info-card-header">
                <i class="fas fa-users"></i> Kasir & Member
            </div>
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

    {{-- Loading Overlay --}}
    <div class="print-loading" id="printLoading"
         style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
                background:rgba(0,0,0,.7); z-index:9999; justify-content:center; align-items:center;">
        <div style="background:white; padding:30px 40px; border-radius:12px; text-align:center;">
            <div style="border:4px solid #f3f4f6; border-top:4px solid var(--primary); border-radius:50%;
                        width:40px; height:40px; animation:spin 1s linear infinite; margin:0 auto 16px;"></div>
            <h4 style="margin:0;">Mencetak Nota...</h4>
            <p style="margin:8px 0 0; color:var(--text-secondary);">Mohon tunggu sebentar</p>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    @if (session('auto_print'))
        window.addEventListener('DOMContentLoaded', function () {
            setTimeout(() => { if (confirm('Cetak nota sekarang?')) cetakEscpos(); }, 500);
        });
    @endif

    async function cetakEscpos() {
        const btn     = document.getElementById('btnCetakEscpos');
        const loading = document.getElementById('printLoading');

        loading.style.display = 'flex';
        btn.disabled = true;

        try {
            const response = await fetch('{{ route($rp . '.transaksi.print-escpos', $transaksi->id) }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            });

            const data = await response.json();
            loading.style.display = 'none';
            btn.disabled = false;

            showToast(data.success ? '✅ ' + data.message : '❌ ' + data.message, data.success ? 'success' : 'error');

        } catch (error) {
            loading.style.display = 'none';
            btn.disabled = false;
            showToast('❌ Gagal terhubung ke printer: ' + error.message, 'error');
        }
    }

    function showToast(msg, type = 'success') {
        const existing = document.getElementById('toastNotif');
        if (existing) existing.remove();

        const toast = document.createElement('div');
        toast.id = 'toastNotif';
        toast.style.cssText = `
            position:fixed; bottom:24px; right:24px; z-index:99999;
            background:${type === 'success' ? '#065f46' : '#991b1b'};
            color:white; padding:16px 24px; border-radius:10px;
            font-size:15px; font-weight:600; box-shadow:0 8px 24px rgba(0,0,0,.3);
            animation:slideIn .3s ease; max-width:400px;
        `;
        toast.textContent = msg;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 4000);
    }
</script>
<style>
    @keyframes spin { from { transform:rotate(0deg); } to { transform:rotate(360deg); } }
    @keyframes slideIn { from { opacity:0; transform:translateY(20px); } to { opacity:1; transform:translateY(0); } }
</style>
@endpush