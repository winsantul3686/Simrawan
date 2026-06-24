@extends('layouts.app')

@section('title', 'Katalog Produk - SiMrawan')

@php $pageTitle = 'Katalog Produk'; @endphp

@section('content')

<div style="margin-bottom:18px;">
    <button class="btn btn-primary" onclick="openModal('modal-tambah')">
        <i class="fas fa-plus"></i> Tambah Produk
    </button>
</div>

@if($katalogList->isEmpty())
    <div class="card" style="text-align:center;padding:40px;color:var(--text-muted);">
        <i class="fas fa-fish" style="font-size:2rem;margin-bottom:10px;display:block;"></i>
        Belum ada katalog produk

    </div>
@else
<div class="katalog-grid">
    @foreach($katalogList as $produk)
    <div class="katalog-card">
        @if($produk->gambar)
            <img src="{{ asset('uploads/' . $produk->gambar) }}" alt="{{ $produk->stokIkan->jenis_ikan }}">
        @else
            <div class="img-placeholder"><i class="fas fa-fish"></i></div>
        @endif
        <div class="card-body">
            <div class="fish-name">{{ $produk->stokIkan->jenis_ikan }}</div>
            <div class="fish-size">{{ $produk->stokIkan->ukuran_sortasi }}</div>
            <div style="display:flex;align-items:center;justify-content:space-between;margin-top:6px;">
                <span class="fish-price">Rp {{ number_format($produk->stokIkan->harga_jual, 0, ',', '.') }}/Kg</span>
                <span class="badge {{ $produk->stokIkan->status === 'Tersedia' ? 'badge-primary' : 'badge-danger' }}">
                    {{ $produk->stokIkan->status }}
                </span>
            </div>
            <div class="fish-stok">Stok: <strong>{{ number_format($produk->stokIkan->jumlah_stok, 0) }} Kg</strong></div>
            @if($produk->deskripsi)
            <div class="fish-desc">{{ $produk->deskripsi }}</div>
            @endif
        </div>
        <div class="card-actions">
            <button class="btn btn-edit"
                onclick="openEditModal({{ $produk->id }}, '{{ addslashes($produk->deskripsi) }}')">
                <i class="fas fa-pen"></i> Edit
            </button>
            <button class="btn btn-danger"
                onclick="openDeleteModal({{ $produk->id }})">
                <i class="fas fa-trash"></i> Hapus
            </button>
        </div>
    </div>
    @endforeach
</div>
@endif

{{-- Modal Tambah --}}
<div class="modal-overlay" id="modal-tambah">
    <div class="modal">
        <div class="modal-header">
            <span class="modal-title">Tambah Produk</span>
            <button class="modal-close" onclick="closeModal('modal-tambah')">&times;</button>
        </div>
        <form action="{{ route('katalog.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Pilih Stok</label>
                <select name="stok_ikan_id" required>
                    <option value="">-- Pilih Stok Ikan --</option>
                    @foreach($stokList as $stok)
                    <option value="{{ $stok->id }}">
                        {{ $stok->jenis_ikan }} - {{ $stok->ukuran_sortasi }} ({{ number_format($stok->jumlah_stok,0) }} Kg)
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="deskripsi" rows="3" placeholder="Deskripsi produk..."></textarea>
            </div>
            <div class="form-group">
                <label>Gambar</label>
                <input type="file" name="gambar" accept="image/*">
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Edit --}}
<div class="modal-overlay" id="modal-edit">
    <div class="modal">
        <div class="modal-header">
            <span class="modal-title">Edit Produk</span>
            <button class="modal-close" onclick="closeModal('modal-edit')">&times;</button>
        </div>
        <form id="form-edit" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Deskripsi</label>
                <textarea id="edit-desc" name="deskripsi" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label>Gambar Baru (opsional)</label>
                <input type="file" name="gambar" accept="image/*">
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Hapus --}}
<div class="modal-overlay" id="modal-hapus">
    <div class="modal" style="max-width:380px;text-align:center;">
        <button class="modal-close" onclick="closeModal('modal-hapus')" style="position:absolute;top:16px;right:16px;">&times;</button>
        <p style="font-size:1rem;font-weight:600;margin:24px 0 20px;">Apakah anda yakin ingin menghapus?</p>
        <form id="form-hapus" method="POST">
            @csrf
            @method('DELETE')
            <div style="display:flex;gap:12px;justify-content:center;">
                <button type="submit" class="btn btn-success">Ya</button>
                <button type="button" class="btn btn-danger" onclick="closeModal('modal-hapus')">Batal</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
function openEditModal(id, desc) {
    document.getElementById('form-edit').action = '/katalog/' + id;
    document.getElementById('edit-desc').value = desc;
    openModal('modal-edit');
}
function openDeleteModal(id) {
    document.getElementById('form-hapus').action = '/katalog/' + id;
    openModal('modal-hapus');
}
</script>
@endsection