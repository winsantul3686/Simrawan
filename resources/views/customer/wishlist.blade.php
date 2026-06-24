@extends('layouts.app')

@section('title', 'Wishlist - SiMrawan')

@section('no-sidebar')
@endsection

@section('styles')
<style>
    .page-header {
        background: linear-gradient(135deg, #fff5f7 0%, #f5f0ff 100%);
        padding: 36px 0 32px;
        border-bottom: 1px solid var(--border);
    }
    .page-header h2 { font-size: 1.6rem; font-weight: 800; color: var(--dark); margin-bottom: 4px; letter-spacing: -0.5px; }
    .wishlist-container { padding: 32px 48px; max-width: 100%; }
    .wishlist-grid-cust { display: grid; grid-template-columns: repeat(auto-fill, minmax(270px, 1fr)); gap: 22px; }
    @media (max-width: 768px) {
        .page-header { padding: 24px 20px; }
        .wishlist-container { padding: 24px 20px; }
    }
</style>
@endsection

@section('content')
@include('components.navbar-customer')

<div class="page-header">
    <div style="max-width: 100%; padding: 0 48px;">
        <div>
            <h2>❤️ Wishlist Saya</h2>
            <p style="font-size:0.85rem;color:var(--text-muted);margin-bottom:0;">Produk yang kamu inginkan</p>
        </div>
    </div>
</div>

<div class="wishlist-container">
    @if(session('success'))
        <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
    @endif

    <div class="wishlist-grid-cust">
        @forelse($wishlistList as $w)
        <div class="cust-produk-card">
            @php $katalog = $w->stokIkan->katalog ?? null; @endphp
            <div class="cust-produk-img">
                @if($katalog && $katalog->gambar)
                    <img src="{{ asset('uploads/' . $katalog->gambar) }}" alt="{{ $w->stokIkan->jenis_ikan }}">
                @else
                    <div class="cust-produk-img-placeholder">🐟</div>
                @endif
            </div>

            <div class="cust-produk-body">
                <div style="display:flex;align-items:start;justify-content:space-between;margin-bottom:8px;">
                    <div>
                        <div style="font-weight:800;font-size:0.97rem;color:var(--dark);">{{ $w->stokIkan->jenis_ikan }}</div>
                        <div style="font-size:0.75rem;color:var(--text-muted);margin-top:2px;">{{ $w->ukuran }}</div>
                    </div>
                    @php $isWishlist = $w->status === 'Belum Tersedia'; @endphp
                    <span style="background:{{ $isWishlist ? '#fce4ec' : '#e8f5e9' }};
                                 color:{{ $isWishlist ? '#c62828' : '#2e7d32' }};
                                 padding:3px 10px;border-radius:20px;font-size:0.68rem;font-weight:700;white-space:nowrap;">
                        {{ $isWishlist ? '⏳ Wishlist' : '✅ Tersedia' }}
                    </span>
                </div>

                <div style="background:var(--gray);border-radius:10px;padding:12px;margin-bottom:14px;">
                    <div style="display:flex;justify-content:space-between;margin-bottom:5px;">
                        <span style="font-size:0.72rem;color:var(--text-muted);font-weight:600;">JUMLAH DIMINTA</span>
                        <span style="font-weight:700;">{{ $w->jumlah }} Kg</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;">
                        <span style="font-size:0.72rem;color:var(--text-muted);font-weight:600;">TANGGAL DIMINTA</span>
                        <span style="font-size:0.78rem;font-weight:600;">{{ \Carbon\Carbon::parse($w->tanggal_diminta)->format('d M Y') }}</span>
                    </div>
                </div>

                @if($w->status === 'Tersedia')
                <a href="{{ route('customer.produk') }}" class="cust-btn-pesan" style="margin-bottom:8px;text-decoration:none;">
                    <i class="fas fa-shopping-cart"></i> Pesan Sekarang
                </a>
                @endif

                <form action="{{ route('customer.wishlist.destroy', $w->id) }}" method="POST"
                      onsubmit="return showConfirmHapus(event, this)">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        style="width:100%;padding:9px;border:1.5px solid #fee2e2;background:#fff;border-radius:10px;
                               color:var(--danger);font-family:inherit;font-size:0.82rem;font-weight:600;
                               cursor:pointer;transition:all 0.2s;display:flex;align-items:center;justify-content:center;gap:6px;"
                        onmouseover="this.style.background='#fff5f5'"
                        onmouseout="this.style.background='#fff'">
                        <i class="fas fa-trash"></i> Hapus Wishlist
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div style="grid-column:1/-1;text-align:center;padding:80px 0;">
            <div style="font-size:4rem;margin-bottom:16px;">❤️</div>
            <div style="font-size:1.1rem;font-weight:700;color:var(--dark);margin-bottom:8px;">Wishlist kamu masih kosong</div>
            <p style="font-size:0.85rem;color:var(--text-muted);margin-bottom:20px;">Tambahkan produk yang kamu inginkan ke wishlist</p>
            <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;">
                <a href="{{ route('customer.produk') }}" class="btn btn-outline">
                    <i class="fas fa-fish"></i> Lihat Produk
                </a>
            </div>
        </div>
        @endforelse
    </div>
</div>

{{-- Modal Tambah Wishlist --}}
<div class="modal-overlay" id="modalTambahWishlist">
    <div class="modal-box" style="max-width:480px;">
        <div class="modal-header">
            <h3><i class="fas fa-heart" style="color:var(--danger);"></i> Tambah Wishlist</h3>
            <button class="modal-close" onclick="closeModal('modalTambahWishlist')">&times;</button>
        </div>
        <form action="{{ route('customer.wishlist.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Nama Customer</label>
                <input type="text" value="{{ session('customer_nama') }}" readonly>
            </div>
            <div class="form-group">
                <label>Nama Produk <span style="color:var(--danger);">*</span></label>
                <select name="stok_ikan_id" required onchange="isiUkuran(this)">
                    <option value="">-- Pilih Produk --</option>
                    @foreach($produkList as $p)
                    <option value="{{ $p->stokIkan->id }}"
                            data-ukuran="{{ $p->stokIkan->ukuran_sortasi }}">
                        {{ $p->stokIkan->jenis_ikan }} - {{ $p->stokIkan->ukuran_sortasi }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Ukuran</label>
                    <input type="text" name="ukuran" id="wishlist_ukuran" readonly required>
                </div>
                <div class="form-group">
                    <label>Jumlah (Kg) <span style="color:var(--danger);">*</span></label>
                    <input type="number" name="jumlah" min="1" required placeholder="Contoh: 10">
                </div>
            </div>
            <button type="submit" class="login-btn" style="margin-top:8px;">
                <i class="fas fa-heart"></i> Simpan Wishlist
            </button>
        </form>
    </div>
</div>

{{-- Modal Konfirmasi Hapus Wishlist --}}
<div class="modal-overlay" id="modalConfirmHapus">
    <div class="modal-box" style="max-width:380px; text-align:center; padding: 32px 24px; border-radius: 18px;">
        <div style="font-size: 3rem; color: var(--danger); margin-bottom: 16px;">
            <i class="fas fa-trash-alt"></i>
        </div>
        <h3 style="font-size: 1.15rem; font-weight: 800; color: var(--dark); margin-bottom: 8px;">Konfirmasi Hapus</h3>
        <p style="font-size: 0.88rem; color: var(--text-muted); line-height: 1.5; margin-bottom: 24px;">
            Hapus wishlist ini?
        </p>
        <div style="display: flex; gap: 12px;">
            <button type="button" id="btn_confirm_hapus_ya" class="btn btn-danger" style="flex: 1; justify-content: center; padding: 11px; font-weight: 700; border-radius: 10px;">
                Ya
            </button>
            <button type="button" onclick="closeModal('modalConfirmHapus')" class="btn" style="flex: 1; justify-content: center; padding: 11px; font-weight: 700; border-radius: 10px; background: #e2e8f0; color: var(--text); border: none;">
                Batal
            </button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
let activeHapusForm = null;

function showConfirmHapus(event, formElement) {
    event.preventDefault();
    activeHapusForm = formElement;
    openModal('modalConfirmHapus');
    return false;
}

document.addEventListener('DOMContentLoaded', function() {
    const yaBtn = document.getElementById('btn_confirm_hapus_ya');
    if (yaBtn) {
        yaBtn.addEventListener('click', function() {
            if (activeHapusForm) {
                activeHapusForm.submit();
            }
        });
    }
});

function isiUkuran(sel) {
    const opt = sel.options[sel.selectedIndex];
    document.getElementById('wishlist_ukuran').value = opt.dataset.ukuran || '';
}
</script>
@endsection