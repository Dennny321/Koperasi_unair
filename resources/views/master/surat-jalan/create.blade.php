@extends('layouts.app')

@section('title', 'Buat Surat Jalan')
@section('breadcrumb', 'Data / Surat Jalan / Buat')
@section('page-title', 'Buat Surat Jalan')

@push('styles')
    {{-- Select2 — hanya untuk halaman ini --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
    <style>
        .select2-container--default .select2-selection--single {
            height: 31px;
            border: 1px solid #ced4da;
            border-radius: 6px;
            font-size: 14px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 29px;
            color: var(--text-primary);
            padding-left: 10px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 29px;
        }

        .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(var(--primary-rgb, 13, 110, 253), 0.15);
        }

        .select2-container {
            width: 100% !important;
        }

        .select2-dropdown {
            border: 1px solid #ced4da;
            border-radius: 6px;
            font-size: 14px;
        }

        .select2-search--dropdown .select2-search__field {
            border: 1px solid #ced4da;
            border-radius: 4px;
            padding: 4px 8px;
            font-size: 13px;
        }

        .select2-results__option--highlighted {
            background-color: var(--primary) !important;
        }

        .select2-results__option {
            padding: 6px 10px;
        }

        .stok-badge {
            font-size: 11px;
            padding: 1px 7px;
            border-radius: 4px;
            float: right;
            font-weight: 600;
        }

        .stok-ok {
            background: #dcfce7;
            color: #166534;
        }

        .stok-low {
            background: #fef9c3;
            color: #854d0e;
        }

        .stok-nil {
            background: #fee2e2;
            color: #991b1b;
        }
    </style>
@endpush

@section('content')
    @php $rp = auth()->user()->role === 'admin' ? 'admin' : 'kasir'; @endphp
    <div class="content-header">
        <div>
            <h2 style="color: var(--primary); font-size: 28px; margin-bottom: 4px;">Buat Surat Jalan</h2>
            <p style="color: var(--text-secondary);">Buat surat jalan & invoice pengiriman barang baru</p>
        </div>
        <a href="{{ route($rp . '.surat-jalan.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    @if ($errors->any())
        <div
            style="background:#fee2e2; border:1px solid #fca5a5; border-radius:10px; padding:14px 18px; margin-bottom:16px; color:#991b1b;">
            <i class="fas fa-exclamation-circle me-2"></i>
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('stok_errors'))
        <div class="alert alert-danger">
            <strong><i class="fas fa-exclamation-triangle me-1"></i>Stok tidak mencukupi:</strong>
            <ul class="mb-0 mt-1">
                @foreach (session('stok_errors') as $err)
                    <li>{!! $err !!}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route($rp . '.surat-jalan.store') }}" method="POST" id="formSuratJalan">
        @csrf
        <div class="row g-4">
            {{-- INFO SURAT --}}
            <div class="col-lg-5">
                <div class="table-container" style="padding:24px;">
                    <h5 style="font-weight:800; color:var(--primary); margin-bottom:20px;">
                        <i class="fas fa-info-circle me-2"></i>Informasi Surat Jalan
                    </h5>
                    {{-- No. Surat Jalan --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">No. Surat Jalan <span class="text-danger">*</span></label>
                        <div class="d-flex align-items-center" style="gap: 12px;">
                            <input type="text" name="no_surat" id="no_surat"
                                class="form-control @error('no_surat') is-invalid @enderror" value="{{ old('no_surat') }}"
                                placeholder="Contoh: SRT-20260706-0001" style="flex: 1;" required>
                            <button type="button" class="btn btn-outline-secondary flex-shrink-0"
                                onclick="generateNomor('no_surat', 'SRT')"
                                style="margin-left: 12px; padding: 8px 18px; white-space: nowrap;">
                                <i class="fas fa-magic me-1"></i> Generate
                            </button>
                        </div>
                        @error('no_surat')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- No. Transaksi --}}
                    <div class="mb-3" style="margin-top: 10px">
                        <label class="form-label fw-semibold">No. Transaksi <span class="text-danger">*</span></label>
                        <div class="d-flex align-items-center" style="gap: 12px;">
                            <input type="text" name="no_transaksi" id="no_transaksi"
                                class="form-control @error('no_transaksi') is-invalid @enderror"
                                value="{{ old('no_transaksi') }}" placeholder="Contoh: SJ-20260706-0001" style="flex: 1;"
                                required>
                            <button type="button" class="btn btn-outline-secondary flex-shrink-0"
                                onclick="generateNomor('no_transaksi', 'SJ')"
                                style="margin-left: 12px; padding: 8px 18px; white-space: nowrap;">
                                <i class="fas fa-magic me-1"></i> Generate
                            </button>
                        </div>
                        @error('no_transaksi')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3" style="margin-top: 10px">
                        <label class="form-label fw-semibold">Tujuan Pengiriman <span class="text-danger">*</span></label>
                        <input type="text" name="tujuan" class="form-control @error('tujuan') is-invalid @enderror"
                            value="{{ old('tujuan') }}" placeholder="Nama instansi / alamat tujuan" required>
                        @error('tujuan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3" style="margin-top: 10px">
                        <label class="form-label fw-semibold">Keterangan</label>
                        <textarea name="keterangan" class="form-control" rows="3" placeholder="Catatan tambahan (opsional)">{{ old('keterangan') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- DAFTAR PRODUK --}}
            <div class="col-lg-7">
                <div class="table-container" style="padding:24px;">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
                        <h5 style="font-weight:800; color:var(--primary); margin-bottom:0;">
                            <i class="fas fa-boxes me-2"></i>Daftar Barang
                        </h5>
                        <button type="button" class="btn btn-success btn-sm" onclick="tambahBaris()">
                            <i class="fas fa-plus me-1"></i> Tambah Barang
                        </button>
                    </div>

                    <div class="table-responsive mb-3">
                        <table class="table table-bordered" id="tabelProduk">
                            <thead style="background: var(--bg-body);">
                                <tr>
                                    <th style="min-width:100px;">Produk</th>
                                    <th style="width:150px;">Jumlah</th>
                                    <th style="width:130px;">Harga Satuan</th>
                                    <th style="width:130px;">Subtotal</th>
                                    <th style="width:50px;"></th>
                                </tr>
                            </thead>
                            <tbody id="bodyProduk">
                                {{-- baris awal --}}
                            </tbody>
                            <tfoot>
                                <tr style="background:var(--bg-body); font-weight:800;">
                                    <td colspan="3" class="text-end pe-3">TOTAL</td>
                                    <td id="totalHarga" style="color:var(--primary); font-size:16px;">Rp 0</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <button type="submit" class="btn btn-primary w-100" id="btnSimpan">
                        <i class="fas fa-save me-2"></i>Simpan Surat Jalan
                    </button>
                </div>
            </div>
        </div>
    </form>

    {{-- TEMPLATE BARIS (hidden) --}}
    <template id="templateBaris">
        <tr class="baris-produk">
            <td>
                <select name="produk[__IDX__][id_produk]" class="form-control form-control-sm select-produk" required>
                    <option value="">-- Pilih Produk --</option>
                    @foreach ($produk as $p)
                        <option value="{{ $p->id }}" data-harga="{{ $p->harga }}"
                            data-satuan="{{ $p->satuan }}" data-stok="{{ $p->stok }}">
                            [{{ $p->kode_produk }}] {{ $p->nama }} (Rp {{ number_format($p->harga, 0, ',', '.') }})
                        </option>
                    @endforeach
                </select>
            </td>
            <td>
                <input type="number" name="produk[__IDX__][jumlah]" class="form-control form-control-sm inp-jumlah"
                    value="1" min="1" required>
            </td>
            <td>
                <input type="number" name="produk[__IDX__][harga_satuan]" class="form-control form-control-sm inp-harga"
                    value="0" min="0" step="0.01" required>
            </td>
            <td class="td-subtotal fw-bold" style="color:var(--primary);">Rp 0</td>
            <td>
                <button type="button" class="btn btn-danger btn-sm btn-hapus-baris" title="Hapus">
                    <i class="fas fa-times"></i>
                </button>
            </td>
        </tr>
    </template>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        let idx = 0;

        function generateNomor(fieldId, prefix) {
            const now = new Date();
            const tgl = now.getFullYear().toString() +
                String(now.getMonth() + 1).padStart(2, '0') +
                String(now.getDate()).padStart(2, '0');
            const random = String(Math.floor(Math.random() * 9000) + 1000); // 4 digit random
            document.getElementById(fieldId).value = prefix + '-' + tgl + '-' + random;
        }

        // Saat produk dipilih dari autocomplete / select
        function pilihProduk(row, id, nama, harga, stok, satuan) {
            row.querySelector('[name$="[id_produk]"]').value = id;
            row.querySelector('[name$="[harga_satuan]"]').value = harga;
            row.querySelector('.nama-produk').textContent = nama;
            row.querySelector('.input-jumlah').dataset.stok = stok; // ← simpan stok
            row.querySelector('.input-jumlah').dataset.satuan = satuan; // ← simpan satuan
            hitungSubtotal(row);
        }

        function tambahBaris() {
            const tmpl = document.getElementById('templateBaris').innerHTML.replaceAll('__IDX__', idx++);
            const tbody = document.getElementById('bodyProduk');
            const tr = document.createElement('tr');
            tr.innerHTML = tmpl;
            // Extract actual TR from the template (template contains a TR)
            const actual = new DOMParser().parseFromString('<table><tbody>' + tmpl + '</tbody></table>', 'text/html')
                .querySelector('tr.baris-produk');
            tbody.appendChild(actual);
            bindBaris(actual);
            hitungTotal();
        }

        function bindBaris(tr) {
            const selProduk = tr.querySelector('.select-produk');
            const inpJumlah = tr.querySelector('.inp-jumlah');
            const inpHarga = tr.querySelector('.inp-harga');
            const tdSub = tr.querySelector('.td-subtotal');
            const btnHapus = tr.querySelector('.btn-hapus-baris');

            // ── Init Select2 pada select ini saja ──
            $(selProduk).select2({
                placeholder: '-- Cari / Pilih Produk --',
                allowClear: true,
                width: '100%',
                language: {
                    noResults: () => 'Produk tidak ditemukan',
                    searching: () => 'Mencari...',
                },
                templateResult: formatProdukOption,
                templateSelection: formatProdukSelected,
                dropdownParent: $(tr).closest('.table-responsive'),
            });

            // Gunakan event Select2, bukan native 'change'
            $(selProduk).on('select2:select', function() {
                const opt = this.options[this.selectedIndex];
                inpHarga.value = opt.dataset.harga || 0;
                inpJumlah.dataset.stok = opt.dataset.stok || 0;
                inpJumlah.dataset.satuan = opt.dataset.satuan || '';
                validasiJumlah(inpJumlah, tr);
                updateSubtotal(inpJumlah, inpHarga, tdSub);
            });

            $(selProduk).on('select2:clear', function() {
                inpHarga.value = 0;
                inpJumlah.dataset.stok = 0;
                inpJumlah.dataset.satuan = '';
                validasiJumlah(inpJumlah, tr);
                updateSubtotal(inpJumlah, inpHarga, tdSub);
            });

            inpJumlah.addEventListener('input', () => {
                validasiJumlah(inpJumlah, tr);
                updateSubtotal(inpJumlah, inpHarga, tdSub);
            });
            inpHarga.addEventListener('input', () => updateSubtotal(inpJumlah, inpHarga, tdSub));

            btnHapus.addEventListener('click', function() {
                $(selProduk).select2('destroy'); // bersihkan instance Select2
                tr.remove();
                hitungTotal();
            });
        }

        function formatProdukOption(option) {
            if (!option.id) return option.text;
            const el = option.element;
            const stok = parseInt(el.dataset.stok ?? 0);
            const sat = el.dataset.satuan ?? '';
            const harga = parseInt(el.dataset.harga ?? 0);

            let cls = stok > 5 ? 'stok-ok' : stok > 0 ? 'stok-low' : 'stok-nil';
            let lab = stok > 0 ? `Stok: ${stok} ${sat}` : 'Habis';

            const $el = $(
                `<span style="display:flex;justify-content:space-between;align-items:center;gap:8px;">
            <span>${option.text}</span>
            <span class="stok-badge ${cls}">${lab}</span>
         </span>`
            );
            return $el;
        }

        function formatProdukSelected(option) {
            return option.text || option.id;
        }

        function updateSubtotal(inpJumlah, inpHarga, td) {
            const sub = parseFloat(inpJumlah.value || 0) * parseFloat(inpHarga.value || 0);
            td.textContent = 'Rp ' + sub.toLocaleString('id-ID', {
                minimumFractionDigits: 0
            });
            hitungTotal();
        }

        function hitungTotal() {
            let total = 0;
            document.querySelectorAll('.td-subtotal').forEach(td => {
                const val = td.textContent.replace(/[^0-9]/g, '');
                total += parseInt(val || 0);
            });
            document.getElementById('totalHarga').textContent = 'Rp ' + total.toLocaleString('id-ID');
        }

        function validasiJumlah(input, tr) {
            const stok = parseInt(input.dataset.stok ?? 0);
            const satuan = input.dataset.satuan ?? '';
            const jumlah = parseInt(input.value) || 0;

            let alertEl = tr.querySelector('.alert-stok');
            if (alertEl) alertEl.remove();

            if (stok === 0) {
                input.classList.remove('is-invalid');
                cekSemuaJumlah();
                return;
            }

            if (jumlah > stok) {
                alertEl = document.createElement('div');
                alertEl.className = 'alert-stok';
                alertEl.style.cssText = 'color:#dc3545; font-size:12px; margin-top:4px;';
                alertEl.innerHTML =
                    `<i class="fas fa-exclamation-circle me-1"></i>Stok tidak cukup. Tersedia: <strong>${stok} ${satuan}</strong>`;
                input.after(alertEl);
                input.classList.add('is-invalid');
            } else {
                input.classList.remove('is-invalid');
            }
            cekSemuaJumlah();
        }

        function cekSemuaJumlah() {
            const inputs = document.querySelectorAll('.inp-jumlah');
            let adaError = false;

            inputs.forEach(input => {
                const stok = parseInt(input.dataset.stok ?? 0);
                const jumlah = parseInt(input.value) || 0;
                if (stok > 0 && jumlah > stok) adaError = true;
            });

            document.getElementById('btnSimpan').disabled = adaError;
        }

        // Validasi: minimal 1 baris sebelum submit
        document.getElementById('formSuratJalan').addEventListener('submit', function(e) {
            const rows = document.querySelectorAll('.baris-produk');
            if (rows.length === 0) {
                e.preventDefault();
                alert('Tambahkan minimal 1 barang!');
            }
        });

        // Tambah 1 baris awal otomatis
        tambahBaris();
    </script>
@endsection
