@extends('layouts.app')

@section('title', 'Wishlist - SiMrawan')

@php $pageTitle = 'Wishlist'; @endphp

@section('content')

@if($wishlistList->isEmpty())
    <div class="card" style="text-align:center;padding:40px;color:var(--text-muted);">
        <i class="fas fa-heart" style="font-size:2rem;margin-bottom:10px;display:block;color:#f06292;"></i>
        Belum ada wishlist dari customer.
    </div>
@else
<div class="wishlist-grid">
    @foreach($wishlistList as $w)
    <div class="wishlist-card">
        <div class="img-placeholder"><i class="fas fa-fish"></i></div>
        <div class="card-body">
            <div class="cust-name">{{ $w->customer->nama }}</div>
            <div class="fish-info">
                <span class="fish-name">{{ $w->stokIkan->jenis_ikan }}</span>
                <span class="badge badge-primary" style="font-size:0.65rem;">Wishlist</span>
            </div>
            <div class="info-row">
                <span>Tanggal diminta <strong>{{ \Carbon\Carbon::parse($w->tanggal_diminta)->format('d F Y') }}</strong></span>
            </div>
            <div class="info-row" style="margin-top:4px;">
                <span>Status <strong>{{ $w->status }}</strong></span>
            </div>
            <div style="margin-top:10px;">
                <button class="btn btn-edit" style="width:100%;justify-content:center;"
                    onclick="openDetailModal({{ $w->id }}, '{{ $w->customer->nama }}', '{{ $w->stokIkan->jenis_ikan }}', '{{ $w->ukuran }}', {{ $w->jumlah }}, '{{ $w->status }}')">
                    Detail
                </button>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif

{{-- Modal Detail Wishlist --}}
<div class="modal-overlay" id="modal-detail">
    <div class="modal" style="max-width:480px;">
        <div class="modal-header">
            <span class="modal-title">Detail Wishlist</span>
            <button class="modal-close" onclick="closeModal('modal-detail')">&times;</button>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Nama Customer</label>
                <input type="text" id="d-customer" readonly>
            </div>
            <div class="form-group">
                <label>Nama Produk</label>
                <input type="text" id="d-produk" readonly>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Ukuran</label>
                <input type="text" id="d-ukuran" readonly>
            </div>
            <div class="form-group">
                <label>Jumlah (Kg)</label>
                <input type="text" id="d-jumlah" readonly>
            </div>
        </div>
        <div class="form-group">
            <label>Total Harga</label>
            <input type="text" value="-" readonly>
        </div>

        <form id="form-update" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Status</label>
                <select name="status" id="d-status">
                    <option value="Belum Tersedia">Belum Tersedia</option>
                    <option value="Tersedia">Tersedia</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">Simpan</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
function openDetailModal(id, customer, produk, ukuran, jumlah, status) {
    document.getElementById('d-customer').value = customer;
    document.getElementById('d-produk').value = produk;
    document.getElementById('d-ukuran').value = ukuran;
    document.getElementById('d-jumlah').value = jumlah + ' Kg';
    document.getElementById('d-status').value = status;
    document.getElementById('form-update').action = '/wishlist/' + id;
    openModal('modal-detail');
}
</script>
@endsection