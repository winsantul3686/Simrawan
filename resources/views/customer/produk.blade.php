@extends('layouts.app')

@section('title', 'Katalog Produk - SiMrawan')

@section('no-sidebar')
@endsection

@section('styles')
<style>
    .page-header {
        background: linear-gradient(135deg, #f0fffe 0%, #f3f0ff 100%);
        padding: 36px 0 32px;
        border-bottom: 1px solid var(--border);
    }
    .page-header h2 {
        font-size: 1.6rem; font-weight: 800; color: var(--dark);
        margin-bottom: 4px; letter-spacing: -0.5px;
    }
    .page-header p {
        font-size: 0.85rem; color: var(--text-muted);
    }
    .produk-container {
        padding: 36px 48px;
        max-width: 100%;
    }
    .produk-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 24px;
    }
    .cust-produk-card {
        cursor: pointer;
    }
    @media (max-width: 768px) {
        .page-header { padding: 24px 20px; }
        .produk-container { padding: 24px 20px; }
    }
</style>
@endsection

@section('content')
@include('components.navbar-customer')

<div class="page-header">
    <div style="max-width: 100%; padding: 0 48px;">
        <h2>🐟 Katalog Produk</h2>
        <p>Pilih ikan segar berkualitas langsung dari Mrawan Fish Farm</p>
    </div>
</div>

<div class="produk-container">

    @if(session('success'))
        <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
    @endif

    <div class="produk-grid">
        @forelse($produkList as $produk)
        @php
            $sizesForThisFish = $allStok->get($produk->stokIkan->jenis_ikan) ?? collect();
            $sizesArr = $sizesForThisFish->map(function($stok) {
                return [
                    'id' => $stok->id,
                    'ukuran' => $stok->ukuran_sortasi,
                    'stok' => $stok->jumlah_stok,
                    'status' => $stok->status,
                    'harga' => $stok->harga_jual,
                    'min_order' => $stok->min_order ?? 0
                ];
            })->values()->toArray();
        @endphp
        <div class="cust-produk-card" data-catalog-id="{{ $produk->id }}">
            {{-- Gambar --}}
            <div class="cust-produk-img">
                @if($produk->gambar)
                    <img src="{{ asset('uploads/' . $produk->gambar) }}" alt="{{ $produk->stokIkan->jenis_ikan }}">
                @else
                    <div class="cust-produk-img-placeholder">🐟</div>
                @endif
            </div>

            {{-- Info --}}
            <div class="cust-produk-body">
                <div style="display:flex;align-items:start;justify-content:space-between;margin-bottom:6px;">
                    <div>
                        <div style="font-size:1.05rem;font-weight:800;color:var(--dark);">{{ $produk->stokIkan->jenis_ikan }}</div>
                        <div style="font-size:0.75rem;color:var(--text-muted);margin-top:2px;">{{ $produk->stokIkan->ukuran_sortasi }}</div>
                    </div>
                    @if($produk->stokIkan->jumlah_stok > 0)
                        <span class="badge-tersedia">✓ Tersedia</span>
                    @else
                        <span style="background:#fce4ec;color:#c62828;padding:3px 10px;border-radius:20px;font-size:0.68rem;font-weight:700;white-space:nowrap;">⚠ Stok Habis</span>
                    @endif
                </div>

                <div style="background:var(--gray);border-radius:10px;padding:12px;margin:12px 0;">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px;">
                        <span style="font-size:0.72rem;color:var(--text-muted);font-weight:600;">HARGA / KG</span>
                        <span style="font-size:1.05rem;font-weight:800;color:var(--primary);">
                            Rp {{ number_format($produk->stokIkan->harga_jual,0,',','.') }}
                        </span>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                        <span style="font-size:0.72rem;color:var(--text-muted);font-weight:600;">STOK</span>
                        <span style="font-size:0.82rem;font-weight:700;color:var(--text);">{{ number_format($produk->stokIkan->jumlah_stok, 0) }} Kg</span>
                    </div>
                    @if($produk->stokIkan->min_order ?? false)
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-top:6px;">
                        <span style="font-size:0.72rem;color:var(--text-muted);font-weight:600;">MIN. ORDER</span>
                        <span style="font-size:0.82rem;font-weight:700;">{{ $produk->stokIkan->min_order }} Kg</span>
                    </div>
                    @endif
                </div>

                @if($produk->deskripsi)
                <p style="font-size:0.76rem;color:var(--text-muted);margin-bottom:14px;line-height:1.6;">{{ Str::limit($produk->deskripsi, 80) }}</p>
                @endif

                <div>
                    @if($produk->stokIkan->jumlah_stok > 0)
                    <button type="button" class="btn-pesan-trigger cust-btn-pesan" style="width:100%;" data-catalog-id="{{ $produk->id }}">
                        <i class="fas fa-shopping-cart"></i> Pesan
                    </button>
                    @else
                    <button type="button" class="btn-wishlist-trigger"
                        style="width:100%;padding:11px;border:1.5px solid #f9a8d4;border-radius:10px;background:#fff;color:#db2777;font-family:inherit;font-size:0.88rem;font-weight:700;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;transition:all 0.2s;"
                        onmouseover="this.style.background='#fdf2f8'"
                        onmouseout="this.style.background='#fff'"
                        data-catalog-id="{{ $produk->id }}">
                        <i class="fas fa-heart"></i> Tambah ke Wishlist
                    </button>
                    @endif
                </div>
            </div>
        </div>

        {{-- Data produk untuk JS --}}
        <script>
        window.produkData = window.produkData || {};
        window.produkData[{{ $produk->id }}] = {
            id: {{ $produk->id }},
            nama: @json($produk->stokIkan->jenis_ikan),
            ukuran: @json($produk->stokIkan->ukuran_sortasi),
            harga: {{ $produk->stokIkan->harga_jual }},
            stok: {{ $produk->stokIkan->jumlah_stok }},
            minOrder: {{ $produk->stokIkan->min_order ?? 0 }},
            deskripsi: @json($produk->deskripsi ?? ''),
            gambar: @json($produk->gambar ?? ''),
            stokId: {{ $produk->stokIkan->id }},
            sizes: @json($sizesArr)
        };
        </script>

        @empty
        <div style="grid-column:1/-1;text-align:center;padding:80px 0;">
            <div style="font-size:4rem;margin-bottom:16px;">🐟</div>
            <div style="font-size:1.1rem;font-weight:700;color:var(--dark);margin-bottom:8px;">Belum ada produk tersedia</div>
            <p style="font-size:0.85rem;color:var(--text-muted);">Produk akan segera hadir. Pantau terus halaman ini.</p>
        </div>
        @endforelse
    </div>
</div>

{{-- Modal Form Pemesanan --}}

<div class="modal-overlay" id="modalPesan">
    <div class="modal-box" style="max-width:540px;">
        <div class="modal-header">
            <h3><i class="fas fa-shopping-cart" style="color:var(--primary);"></i> Form Pemesanan</h3>
            <button class="modal-close" onclick="closeModal('modalPesan')">&times;</button>
        </div>
        <form action="{{ route('customer.pesanan.store') }}" method="POST">
            @csrf
            <input type="hidden" name="stok_ikan_id" id="pesan_stok_id">

            <div style="background:var(--gray);border-radius:12px;padding:16px;margin-bottom:18px;">
                <div style="font-size:0.75rem;color:var(--text-muted);font-weight:600;margin-bottom:4px;">PRODUK DIPILIH</div>
                <div id="pesan_nama_display" style="font-size:1rem;font-weight:800;color:var(--dark);"></div>
                <div id="pesan_ukuran_display" style="font-size:0.78rem;color:var(--text-muted);"></div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
                <div class="form-group">
                    <label>Nama Customer</label>
                    <input type="text" value="{{ session('customer_nama') }}" readonly>
                </div>
                <div class="form-group">
                    <label>No. Telepon <span style="color:var(--danger);">*</span></label>
                    <input type="text" name="no_telp" placeholder="08123456789" required>
                </div>
                <div class="form-group">
                    <label>Harga Satuan</label>
                    <input type="text" id="pesan_harga_tampil" readonly>
                    <input type="hidden" name="harga_satuan" id="pesan_harga">
                    <input type="hidden" id="pesan_ukuran">
                </div>
                <div class="form-group">
                    <label>Jumlah (Kg) <span style="color:var(--danger);">*</span></label>
                    <input type="number" name="jumlah" id="pesan_jumlah" min="1" required oninput="hitungTotal()">
                </div>
            </div>
            <div class="form-group">
                <label>Total Harga</label>
                <input type="text" id="pesan_total_tampil" readonly style="font-size:1rem;font-weight:800;color:var(--primary);">
                <input type="hidden" name="total_harga" id="pesan_total">
            </div>
            <div class="form-group">
                <label>Alamat Pengiriman <span style="color:var(--danger);">*</span></label>
                <input type="text" name="alamat_pengiriman" placeholder="Masukkan alamat lengkap" required>
            </div>
            <div class="form-group">
                <label>Catatan <span style="color:var(--text-muted);font-weight:400;">(opsional)</span></label>
                <input type="text" name="catatan" placeholder="Contoh: antar pagi sebelum jam 8">
            </div>
            <button type="submit" class="login-btn" style="margin-top:8px;">
                <i class="fas fa-arrow-right"></i> Lanjut ke Pembayaran
            </button>
        </form>
    </div>
</div>

{{-- Modal Detail Produk --}}
<div class="modal-overlay" id="modalDetailProduk">
    <div class="modal-box" style="max-width:560px; padding: 24px;">
        <div class="modal-header" style="border-bottom: none; padding-bottom: 0; margin-bottom: 12px;">
            <h3><i class="fas fa-info-circle" style="color:var(--primary);"></i> Detail Produk</h3>
            <button class="modal-close" onclick="closeModal('modalDetailProduk')">&times;</button>
        </div>
        
        <div style="text-align: center; margin-bottom: 18px; border-radius: 12px; overflow: hidden; background: var(--gray); display: flex; align-items: center; justify-content: center; height: 260px;">
            <img id="detail_img" style="width: 100%; height: 100%; object-fit: cover; display: none;" alt="Gambar Ikan">
            <div id="detail_img_placeholder" style="font-size: 5rem; display: none;">🐟</div>
        </div>

        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 8px;">
            <div>
                <h2 id="detail_nama" style="font-size: 1.25rem; font-weight: 800; color: var(--dark);"></h2>
            </div>
        </div>

        <div style="margin: 16px 0;">
            <label style="font-size: 0.72rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; display: block; margin-bottom: 6px;">Pilih Ukuran</label>
            <select id="detail_ukuran_select" style="width: 100%; padding: 10px 14px; border: 1.5px solid var(--border); border-radius: 10px; font-family: inherit; font-size: 0.88rem; font-weight: 600; color: var(--dark); background: #fff; cursor: pointer; outline: none; transition: border-color 0.2s;" onchange="changeDetailSize(this.value)">
            </select>
        </div>

        <div style="background: var(--gray); border-radius: 12px; padding: 14px; margin: 16px 0; display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
            <div>
                <span style="font-size: 0.72rem; color: var(--text-muted); font-weight: 700; text-transform: uppercase;">Harga / Kg</span>
                <div id="detail_harga" style="font-size: 1.1rem; font-weight: 800; color: var(--primary); margin-top: 4px;"></div>
            </div>
            <div>
                <span style="font-size: 0.72rem; color: var(--text-muted); font-weight: 700; text-transform: uppercase;">Stok Tersedia</span>
                <div id="detail_stok" style="font-size: 1.1rem; font-weight: 800; color: var(--dark); margin-top: 4px;"></div>
            </div>
            <div id="detail_status_stok_wrapper" style="grid-column: span 2; border-top: 1px solid var(--border); padding-top: 10px; display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 0.72rem; color: var(--text-muted); font-weight: 700; text-transform: uppercase;">Status Stok</span>
                <span id="detail_status_badge" style="padding: 4px 12px; border-radius: 20px; font-size: 0.72rem; font-weight: 700; white-space: nowrap;"></span>
            </div>
            <div id="detail_min_order_wrapper" style="grid-column: span 2; display: none; border-top: 1px solid var(--border); padding-top: 10px;">
                <span style="font-size: 0.72rem; color: var(--text-muted); font-weight: 700; text-transform: uppercase;">Minimal Pembelian</span>
                <div id="detail_min_order" style="font-size: 0.85rem; font-weight: 700; color: var(--dark); margin-top: 2px;"></div>
            </div>
        </div>

        <div style="margin-bottom: 24px;">
            <h4 style="font-size: 0.82rem; font-weight: 700; color: var(--dark); margin-bottom: 8px;">Deskripsi Produk</h4>
            <p id="detail_deskripsi" style="font-size: 0.8rem; color: var(--text-muted); line-height: 1.6; white-space: pre-line;"></p>
        </div>

        <div style="display: flex; flex-direction: column; gap: 12px; border-top: 1px solid var(--border); padding-top: 18px;">
            <div style="display: flex; gap: 12px; width: 100%;">
                <button id="btn_detail_pesan" class="cust-btn-pesan" style="flex: 1; padding: 12px; display: flex; justify-content: center; align-items: center; gap: 8px;">
                    <i class="fas fa-shopping-cart"></i> Pesan Sekarang
                </button>
                
                <form id="form_detail_wishlist" action="{{ route('customer.wishlist.store') }}" method="POST" style="flex: 1; display: none; width: 100%;">
                    @csrf
                    <input type="hidden" name="stok_ikan_id" id="wishlist_stok_id">
                    <input type="hidden" name="ukuran" id="wishlist_ukuran">
                    
                    <div class="form-group" style="margin-bottom: 12px; text-align: left;">
                        <label style="font-size: 0.72rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; display: block; margin-bottom: 6px;">Jumlah yang Dibutuhkan (Kg) <span style="color:var(--danger);">*</span></label>
                        <input type="number" name="jumlah" id="wishlist_jumlah" min="1" value="1" required style="width: 100%; padding: 10px 14px; border: 1.5px solid var(--border); border-radius: 10px; font-family: inherit; font-size: 0.88rem; font-weight: 600; color: var(--dark); background: #fff; outline: none; transition: border-color 0.2s;">
                    </div>
                    
                    <button type="submit" style="width: 100%; padding: 12px; background: #db2777; color: #fff; font-family: inherit; font-size: 0.88rem; font-weight: 700; border: none; border-radius: 10px; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; transition: all 0.2s;"
                        onmouseover="this.style.background='#be185d'"
                        onmouseout="this.style.background='#db2777'">
                        <i class="fas fa-heart"></i> Tambah ke Wishlist
                    </button>
                </form>
            </div>
            
            <button class="btn" style="width: 100%; padding: 12px; justify-content: center; background: #e2e8f0; color: var(--text); border: none; border-radius: 10px; font-weight: 700; cursor: pointer;" onclick="closeModal('modalDetailProduk')">
                Tutup
            </button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Fungsi helper untuk membuka detail produk berdasarkan catalog ID
    function bukaDetailProduk(catalogId) {
        const p = window.produkData && window.produkData[catalogId];
        if (!p) return;
        openDetailProduk(
            p.id,
            p.nama,
            p.ukuran,
            p.harga,
            p.stok,
            p.minOrder,
            p.deskripsi,
            p.gambar,
            p.stokId,
            p.sizes
        );
    }

    // Fungsi helper untuk membuka modal pesan berdasarkan catalog ID
    function bukaPesanProduk(catalogId) {
        const p = window.produkData && window.produkData[catalogId];
        if (!p) return;
        openModalPesan(p.id, p.nama, p.ukuran, p.harga, p.stokId);
    }

    // Klik kartu produk → buka modal detail
    document.querySelectorAll('.cust-produk-card').forEach(function (card) {
        card.addEventListener('click', function (e) {
            // Jika klik dari tombol, biarkan event listener tombol menangani
            if (e.target.closest('.btn-pesan-trigger') || e.target.closest('.btn-wishlist-trigger')) return;
            const catalogId = card.dataset.catalogId;
            bukaDetailProduk(catalogId);
        });
    });

    // Klik tombol "Pesan" → buka modal pesan langsung
    document.querySelectorAll('.btn-pesan-trigger').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            const catalogId = btn.dataset.catalogId || btn.closest('.cust-produk-card').dataset.catalogId;
            bukaPesanProduk(catalogId);
        });
    });

    // Klik tombol "Tambah ke Wishlist" → buka modal detail (agar isi jumlah kg)
    document.querySelectorAll('.btn-wishlist-trigger').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            const catalogId = btn.dataset.catalogId || btn.closest('.cust-produk-card').dataset.catalogId;
            bukaDetailProduk(catalogId);
        });
    });
});

function openModalPesan(katalogId, nama, ukuran, harga, stokId) {
    document.getElementById('pesan_stok_id').value       = stokId;
    document.getElementById('pesan_ukuran').value        = ukuran;
    document.getElementById('pesan_harga').value         = harga;
    document.getElementById('pesan_harga_tampil').value  = 'Rp ' + Number(harga).toLocaleString('id-ID') + '/Kg';
    document.getElementById('pesan_jumlah').value        = '';
    document.getElementById('pesan_total_tampil').value  = '';
    document.getElementById('pesan_total').value         = '';
    document.getElementById('pesan_nama_display').textContent   = nama;
    document.getElementById('pesan_ukuran_display').textContent = ukuran;
    openModal('modalPesan');
}

function hitungTotal() {
    const jumlah = parseFloat(document.getElementById('pesan_jumlah').value) || 0;
    const harga  = parseFloat(document.getElementById('pesan_harga').value)  || 0;
    const total  = jumlah * harga;
    document.getElementById('pesan_total').value        = total;
    document.getElementById('pesan_total_tampil').value = total > 0 ? 'Rp ' + total.toLocaleString('id-ID') : '';
}

function openDetailProduk(katalogId, nama, ukuran, harga, stok, minOrder, deskripsi, gambar, stokId, sizesDataStr) {
    const imgEl = document.getElementById('detail_img');
    const placeholderEl = document.getElementById('detail_img_placeholder');

    if (gambar && gambar !== 'null' && gambar.trim() !== '') {
        imgEl.src = '/uploads/' + gambar;
        imgEl.style.display = 'block';
        placeholderEl.style.display = 'none';
    } else {
        imgEl.style.display = 'none';
        placeholderEl.style.display = 'flex';
    }

    document.getElementById('detail_nama').textContent = nama;
    document.getElementById('detail_deskripsi').textContent =
        (deskripsi && deskripsi.trim() !== '') ? deskripsi : 'Tidak ada deskripsi untuk produk ini.';

    // Simpan data sizes ke global dengan safe parse
    let sizes = [];
    try {
        sizes = JSON.parse(sizesDataStr || '[]');
    } catch (e) {
        // Fallback: buat satu entry dari data kartu saat ini
        sizes = [{
            id: stokId,
            ukuran: ukuran,
            stok: Number(stok),
            status: Number(stok) > 0 ? 'Tersedia' : 'Habis',
            harga: Number(harga),
            min_order: Number(minOrder) || 0
        }];
    }
    window.currentProductSizes = sizes;
    window.currentKatalogId = katalogId;

    // Isi dropdown select ukuran
    const selectEl = document.getElementById('detail_ukuran_select');
    selectEl.innerHTML = '';

    sizes.forEach(sz => {
        const option = document.createElement('option');
        option.value = sz.id;
        option.textContent = sz.ukuran + (sz.stok <= 0 ? ' (Stok Habis)' : ' - Tersedia');
        if (sz.id == stokId) {
            option.selected = true;
        }
        selectEl.appendChild(option);
    });

    // Update tampilan awal berdasarkan stokId terpilih
    updateDetailView(stokId);

    openModal('modalDetailProduk');
}

function changeDetailSize(stokId) {
    updateDetailView(stokId);
}

function updateDetailView(stokId) {
    const size = window.currentProductSizes.find(sz => sz.id == stokId);
    if (!size) return;

    // Update data harga & stok
    document.getElementById('detail_harga').textContent = 'Rp ' + Number(size.harga).toLocaleString('id-ID') + '/Kg';
    document.getElementById('detail_stok').textContent  = Number(size.stok).toLocaleString('id-ID') + ' Kg';

    const minOrderWrapper = document.getElementById('detail_min_order_wrapper');
    if (size.min_order && Number(size.min_order) > 0) {
        document.getElementById('detail_min_order').textContent = size.min_order + ' Kg';
        minOrderWrapper.style.display = 'block';
    } else {
        minOrderWrapper.style.display = 'none';
    }

    // Update status stok & tombol/form secara dinamis
    const badgeEl = document.getElementById('detail_status_badge');
    const btnPesan = document.getElementById('btn_detail_pesan');
    const formWishlist = document.getElementById('form_detail_wishlist');

    if (size.stok > 0) {
        // Stok tersedia
        badgeEl.textContent = '✓ Tersedia';
        badgeEl.style.background = '#e6fcf5';
        badgeEl.style.color = '#0ca678';
        
        btnPesan.style.display = 'flex';
        formWishlist.style.display = 'none';

        btnPesan.onclick = function () {
            closeModal('modalDetailProduk');
            openModalPesan(window.currentKatalogId, document.getElementById('detail_nama').textContent, size.ukuran, size.harga, size.id);
        };
    } else {
        // Stok habis
        badgeEl.textContent = '⚠ Habis';
        badgeEl.style.background = '#fff0f6';
        badgeEl.style.color = '#d6336c';

        btnPesan.style.display = 'none';
        formWishlist.style.display = 'block';

        // Set input fields form wishlist
        document.getElementById('wishlist_stok_id').value = size.id;
        document.getElementById('wishlist_ukuran').value  = size.ukuran;
        document.getElementById('wishlist_jumlah').value  = '1'; // Reset ke default 1
    }
}
</script>
@endsection