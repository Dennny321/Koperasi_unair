<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tukar Hadiah — Koperasi Pegawai UNAIR</title>
    <link href="https://fonts.bunny.net/css?family=Plus+Jakarta+Sans:300,400,500,600,700,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --primary: #2f3291; --primary-dark: #1e2061; --accent: #ffca0a;
            --white: #ffffff; --bg-body: #f4f7fe; --text-main: #2d3748;
            --text-secondary: #718096; --border-color: #e2e8f0;
            --success: #10b981; --danger: #ef4444; --warning: #f59e0b; --info: #3b82f6;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--bg-body); color: var(--text-main); min-height: 100vh; }

        /* TOPBAR */
        .topbar {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            padding: 0 32px; height: 68px; display: flex; align-items: center;
            justify-content: space-between; position: sticky; top: 0; z-index: 100;
            box-shadow: 0 2px 16px rgba(47,50,145,.25);
        }
        .topbar-brand { display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .topbar-brand span { font-weight: 800; font-size: 18px; color: white; }
        .topbar-right { display: flex; align-items: center; gap: 16px; }
        .poin-badge {
            background: rgba(255,202,10,.15); border: 1px solid rgba(255,202,10,.4);
            border-radius: 30px; padding: 8px 18px; display: flex; align-items: center; gap: 8px;
            color: var(--accent); font-weight: 700; font-size: 15px;
        }
        .btn-back { display: flex; align-items: center; gap: 6px; padding: 8px 16px; background: rgba(255,255,255,.12);
            border: 1px solid rgba(255,255,255,.2); border-radius: 8px; color: white; text-decoration: none;
            font-size: 13px; font-weight: 600; transition: var(--transition); }
        .btn-back:hover { background: rgba(255,255,255,.2); }

        /* MAIN */
        .main { max-width: 1200px; margin: 0 auto; padding: 32px 24px; }
        .page-title { font-size: 26px; font-weight: 800; color: var(--text-main); margin-bottom: 4px; }
        .page-sub { color: var(--text-secondary); font-size: 14px; margin-bottom: 28px; }

        /* POIN CARD */
        .poin-card {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border-radius: 16px; padding: 24px 28px; color: white; margin-bottom: 28px;
            display: flex; align-items: center; justify-content: space-between;
            box-shadow: 0 8px 32px rgba(47,50,145,.25);
        }
        .poin-card-left h3 { font-size: 14px; opacity: .8; margin-bottom: 4px; }
        .poin-card-left .poin-num { font-size: 42px; font-weight: 800; color: var(--accent); }
        .poin-card-right { font-size: 60px; opacity: .15; }

        /* ALERT */
        .alert { border-radius: 10px; padding: 14px 18px; margin-bottom: 20px; display: flex; align-items: flex-start; gap: 10px; }
        .alert-success { background: #d1fae5; border: 1px solid #6ee7b7; color: #065f46; }
        .alert-danger  { background: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; }

        /* HADIAH GRID */
        .section-title { font-size: 18px; font-weight: 700; color: var(--text-main); margin-bottom: 16px; display: flex; align-items: center; gap: 8px; }
        .hadiah-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 16px; margin-bottom: 36px; }
        .hadiah-card {
            background: white; border: 1px solid var(--border-color); border-radius: 14px;
            padding: 20px; transition: var(--transition); position: relative; overflow: hidden;
        }
        .hadiah-card:hover { border-color: var(--primary); box-shadow: 0 8px 24px rgba(47,50,145,.12); transform: translateY(-2px); }
        .hadiah-icon { width: 56px; height: 56px; border-radius: 14px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex; align-items: center; justify-content: center; font-size: 26px; margin-bottom: 12px; }
        .hadiah-nama { font-weight: 700; font-size: 15px; color: var(--text-main); margin-bottom: 8px; }
        .hadiah-poin { display: flex; align-items: center; gap: 6px; color: var(--warning); font-weight: 700; font-size: 14px; margin-bottom: 6px; }
        .hadiah-stok { font-size: 12px; color: var(--text-secondary); margin-bottom: 14px; }
        .btn-tukar {
            width: 100%; padding: 10px; border-radius: 8px; font-weight: 700; font-size: 13px;
            border: none; cursor: pointer; transition: var(--transition); display: flex; align-items: center; justify-content: center; gap: 6px;
        }
        .btn-tukar-active { background: var(--primary); color: white; }
        .btn-tukar-active:hover { background: var(--primary-dark); }
        .btn-tukar-disabled { background: #e2e8f0; color: var(--text-secondary); cursor: not-allowed; }
        .badge-kurang { position: absolute; top: 10px; right: 10px; background: var(--danger);
            color: white; font-size: 10px; font-weight: 700; padding: 3px 8px; border-radius: 6px; }
        .badge-cukup { position: absolute; top: 10px; right: 10px; background: #d1fae5;
            color: #065f46; font-size: 10px; font-weight: 700; padding: 3px 8px; border-radius: 6px; border: 1px solid #6ee7b7; }

        /* RIWAYAT */
        .card { background: white; border: 1px solid var(--border-color); border-radius: 14px; overflow: hidden; }
        .card-header { padding: 16px 20px; border-bottom: 1px solid var(--border-color); display: flex; align-items: center; justify-content: space-between; }
        .card-title { font-weight: 700; font-size: 15px; color: var(--text-main); }
        table { width: 100%; border-collapse: collapse; }
        th { padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 700; text-transform: uppercase;
            letter-spacing: .5px; color: var(--text-secondary); background: var(--bg-body); border-bottom: 1px solid var(--border-color); }
        td { padding: 12px 16px; font-size: 13px; border-bottom: 1px solid var(--border-color); }
        tr:last-child td { border-bottom: none; }
        .badge { display: inline-flex; align-items: center; gap: 4px; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; }
        .badge-menunggu { background: #fef3c7; color: #92400e; }
        .badge-diklaim  { background: #d1fae5; color: #065f46; }
        .badge-batal    { background: #fee2e2; color: #991b1b; }
        .btn-batal {
            padding: 5px 12px; border-radius: 6px; font-size: 12px; font-weight: 600;
            background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5;
            cursor: pointer; transition: var(--transition); text-decoration: none; display: inline-block;
        }
        .btn-batal:hover { background: #fca5a5; }
        .empty-state { text-align: center; padding: 48px 24px; color: var(--text-secondary); }
        .empty-state i { font-size: 48px; margin-bottom: 12px; display: block; opacity: .3; }
        .pagination-wrap { padding: 16px; display: flex; justify-content: flex-end; }

        /* MODAL KONFIRMASI */
        .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.55); z-index: 999; justify-content: center; align-items: center; }
        .modal-overlay.active { display: flex; }
        .modal-box { background: white; border-radius: 16px; padding: 28px; max-width: 420px; width: 90%; box-shadow: 0 24px 60px rgba(0,0,0,.2); animation: modalIn .2s ease; }
        @keyframes modalIn { from { opacity:0; transform: scale(.95); } to { opacity:1; transform: scale(1); } }
        .modal-icon { width: 64px; height: 64px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; font-size: 28px; margin: 0 auto 16px; }
        .modal-title { text-align: center; font-size: 18px; font-weight: 700; margin-bottom: 8px; }
        .modal-sub { text-align: center; font-size: 13px; color: var(--text-secondary); margin-bottom: 20px; }
        .modal-info { background: var(--bg-body); border-radius: 10px; padding: 14px; margin-bottom: 20px; }
        .modal-info-row { display: flex; justify-content: space-between; align-items: center; padding: 4px 0; font-size: 13px; }
        .modal-info-row strong { color: var(--text-main); }
        .modal-actions { display: flex; gap: 10px; }
        .modal-actions button, .modal-actions .btn-modal { flex: 1; padding: 12px; border-radius: 8px; font-weight: 700; font-size: 14px; cursor: pointer; border: none; transition: var(--transition); }
        .btn-modal-cancel { background: var(--bg-body); color: var(--text-secondary); }
        .btn-modal-cancel:hover { background: var(--border-color); }
        .btn-modal-confirm { background: var(--primary); color: white; }
        .btn-modal-confirm:hover { background: var(--primary-dark); }
    </style>
</head>
<body>
    <!-- TOPBAR -->
    <nav class="topbar">
        <a href="{{ route('member.dashboard') }}" class="topbar-brand">
            <span>🎁 Tukar Hadiah</span>
        </a>
        <div class="topbar-right">
            <div class="poin-badge">
                <i class="fas fa-coins"></i>
                <span id="poinDisplay">{{ number_format($user->saldo_poin, 0, ',', '.') }} Poin</span>
            </div>
            <a href="{{ route('member.dashboard') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Dashboard
            </a>
        </div>
    </nav>

    <main class="main">
        <h1 class="page-title">🎁 Tukar Hadiah dengan Poin</h1>
        <p class="page-sub">Gunakan poin Anda untuk mendapatkan hadiah menarik dari Koperasi</p>

        <!-- ALERT -->
        @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle" style="font-size:18px; flex-shrink:0;"></i>
            <div>{{ session('success') }}</div>
        </div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle" style="font-size:18px; flex-shrink:0;"></i>
            <div>{{ session('error') }}</div>
        </div>
        @endif

        <!-- POIN CARD -->
        <div class="poin-card">
            <div class="poin-card-left">
                <h3><i class="fas fa-wallet"></i> Saldo Poin Anda</h3>
                <div class="poin-num">{{ number_format($user->saldo_poin, 0, ',', '.') }}</div>
                <div style="font-size:13px; opacity:.8; margin-top:4px;">{{ $user->name }}</div>
            </div>
            <div class="poin-card-right">
                <i class="fas fa-star"></i>
            </div>
        </div>

        <!-- KATALOG HADIAH -->
        <div class="section-title">
            <i class="fas fa-gift" style="color: var(--primary);"></i>
            Hadiah Tersedia ({{ $hadiahTersedia->count() }})
        </div>

        @if($hadiahTersedia->isEmpty())
        <div class="card" style="margin-bottom: 32px;">
            <div class="empty-state">
                <i class="fas fa-box-open"></i>
                <p style="font-weight:600; font-size:15px;">Belum ada hadiah tersedia</p>
                <p style="font-size:13px; margin-top:4px;">Pantau terus untuk hadiah menarik!</p>
            </div>
        </div>
        @else
        <div class="hadiah-grid">
            @foreach($hadiahTersedia as $hadiah)
            @php $bisa = $user->saldo_poin >= $hadiah->biaya_poin; @endphp
            <div class="hadiah-card">
                @if($bisa)
                    <span class="badge-cukup"><i class="fas fa-check"></i> Poin Cukup</span>
                @else
                    <span class="badge-kurang">Poin Kurang</span>
                @endif

                <div class="hadiah-icon">🎁</div>
                <div class="hadiah-nama">{{ $hadiah->nama }}</div>
                <div class="hadiah-poin">
                    <i class="fas fa-coins"></i>
                    {{ number_format($hadiah->biaya_poin, 0, ',', '.') }} Poin
                </div>
                <div class="hadiah-stok">
                    <i class="fas fa-box"></i> Stok: {{ $hadiah->stok }} tersisa
                </div>

                @if($bisa)
                <button class="btn-tukar btn-tukar-active"
                        onclick="konfirmasiTukar({{ $hadiah->id }}, '{{ $hadiah->nama }}', {{ $hadiah->biaya_poin }})">
                    <i class="fas fa-exchange-alt"></i> Tukar Sekarang
                </button>
                @else
                <button class="btn-tukar btn-tukar-disabled" disabled>
                    <i class="fas fa-lock"></i>
                    Butuh {{ number_format($hadiah->biaya_poin - $user->saldo_poin, 0, ',', '.') }} poin lagi
                </button>
                @endif
            </div>
            @endforeach
        </div>
        @endif

        <!-- RIWAYAT PENUKARAN -->
        <div class="section-title">
            <i class="fas fa-history" style="color: var(--primary);"></i>
            Riwayat Penukaran Saya
        </div>

        <div class="card">
            @if($riwayatPenukaran->isEmpty())
            <div class="empty-state">
                <i class="fas fa-receipt"></i>
                <p style="font-weight:600;">Belum ada riwayat penukaran</p>
            </div>
            @else
            <div style="overflow-x:auto;">
                <table>
                    <thead>
                        <tr>
                            <th>Kode Unik</th>
                            <th>Hadiah</th>
                            <th>Poin Digunakan</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($riwayatPenukaran as $p)
                        <tr>
                            <td>
                                <code style="background:#f1f5f9; padding:3px 8px; border-radius:5px; font-size:12px; font-weight:700;">
                                    {{ $p->kode_unik }}
                                </code>
                            </td>
                            <td style="font-weight:600;">{{ $p->hadiah?->nama ?? '-' }}</td>
                            <td>
                                <span style="color:var(--danger); font-weight:700;">
                                    <i class="fas fa-coins"></i> -{{ number_format($p->poin_digunakan, 0, ',', '.') }}
                                </span>
                            </td>
                            <td style="color:var(--text-secondary);">
                                {{ $p->dibuat_pada?->format('d M Y, H:i') ?? '-' }}
                            </td>
                            <td>
                                @if($p->isMenunggu())
                                    <span class="badge badge-menunggu"><i class="fas fa-clock"></i> Menunggu</span>
                                @elseif($p->isDiklaim())
                                    <span class="badge badge-diklaim"><i class="fas fa-check"></i> Diklaim</span>
                                @else
                                    <span class="badge badge-batal"><i class="fas fa-times"></i> Dibatalkan</span>
                                @endif
                            </td>
                            <td>
                                @if($p->isMenunggu())
                                <form action="{{ route('member.penukaran.destroy', $p->id) }}" method="POST"
                                      onsubmit="return confirm('Batalkan penukaran ini? Poin akan dikembalikan.')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-batal">
                                        <i class="fas fa-times"></i> Batalkan
                                    </button>
                                </form>
                                @else
                                <span style="color:var(--text-secondary); font-size:12px;">—</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($riwayatPenukaran->hasPages())
            <div class="pagination-wrap">{{ $riwayatPenukaran->links() }}</div>
            @endif
            @endif
        </div>
    </main>

    <!-- MODAL KONFIRMASI TUKAR -->
    <div class="modal-overlay" id="modalTukar">
        <div class="modal-box">
            <div class="modal-icon">🎁</div>
            <div class="modal-title">Konfirmasi Penukaran</div>
            <div class="modal-sub">Pastikan Anda yakin menukar hadiah ini</div>

            <div class="modal-info">
                <div class="modal-info-row">
                    <span style="color:var(--text-secondary);">Hadiah</span>
                    <strong id="modalNamaHadiah">-</strong>
                </div>
                <div class="modal-info-row">
                    <span style="color:var(--text-secondary);">Poin Diperlukan</span>
                    <strong style="color:var(--warning);" id="modalBiayaPoin">-</strong>
                </div>
                <div class="modal-info-row">
                    <span style="color:var(--text-secondary);">Saldo Poin Anda</span>
                    <strong style="color:var(--success);">{{ number_format($user->saldo_poin, 0, ',', '.') }} poin</strong>
                </div>
                <div class="modal-info-row" style="border-top:1px solid var(--border-color); margin-top:8px; padding-top:8px;">
                    <span style="color:var(--text-secondary);">Sisa Poin Setelah</span>
                    <strong style="color:var(--primary);" id="modalSisaPoin">-</strong>
                </div>
            </div>

            <form id="formTukar" action="" method="POST">
                @csrf
                <div class="modal-actions">
                    <button type="button" class="btn-modal-cancel" onclick="tutupModal()">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <button type="submit" class="btn-modal-confirm">
                        <i class="fas fa-exchange-alt"></i> Ya, Tukar!
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const saldoPoin = {{ $user->saldo_poin }};

        function konfirmasiTukar(idHadiah, namaHadiah, biayaPoin) {
            document.getElementById('modalNamaHadiah').textContent = namaHadiah;
            document.getElementById('modalBiayaPoin').textContent  = biayaPoin.toLocaleString('id-ID') + ' poin';
            document.getElementById('modalSisaPoin').textContent   = (saldoPoin - biayaPoin).toLocaleString('id-ID') + ' poin';
            document.getElementById('formTukar').action = `/member/penukaran`;

            // Add hidden id_hadiah
            let input = document.getElementById('inputIdHadiah');
            if (!input) {
                input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'id_hadiah';
                input.id   = 'inputIdHadiah';
                document.getElementById('formTukar').appendChild(input);
            }
            input.value = idHadiah;

            document.getElementById('modalTukar').classList.add('active');
        }

        function tutupModal() {
            document.getElementById('modalTukar').classList.remove('active');
        }

        document.getElementById('modalTukar').addEventListener('click', function(e) {
            if (e.target === this) tutupModal();
        });
    </script>
</body>
</html>
