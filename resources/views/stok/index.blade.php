@extends('layouts.app')

@section('title', 'Manajemen Stok - SiMrawan')

@php $pageTitle = 'Manajemen Stok'; @endphp

@section('content')

<div class="card">
    <div class="card-header">
        <span class="card-title">Daftar Stok Ikan</span>
        <button class="btn btn-primary" onclick="openModal('modal-tambah')">
            <i class="fas fa-plus"></i> Tambah Stok
        </button>
    </div>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Jenis Ikan</th>
                    <th>Ukuran (Ekor/Kg)</th>
                    <th>Stok (Kg)</th>
                    <th>Harga Modal</th>
                    <th>Harga Jual</th>
                    <th>Status</th>
                    <th>Update Terakhir</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($stokList as $i => $stok)
                <tr>
                    <td>{{ str_pad($i+1, 2, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $stok->jenis_ikan }}</td>
                    <td>{{ $stok->ukuran_sortasi }}</td>
                    <td style="color:var(--primary);font-weight:600;">{{ number_format($stok->jumlah_stok, 0) }} Kg</td>
                    <td>Rp {{ number_format($stok->harga_modal, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($stok->harga_jual, 0, ',', '.') }}</td>
                    <td>
                        <span class="badge {{ $stok->status === 'Tersedia' ? 'badge-success' : 'badge-danger' }}">
                            {{ $stok->status }}
                        </span>
                    </td>
                    <td>{{ $stok->updated_at->format('d M Y') }}</td>
                    <td style="display:flex;gap:6px;">
                        <button class="btn btn-edit"
                            onclick="openEditModal(
                                {{ $stok->id }},
                                '{{ $stok->jenis_ikan }}',
                                '{{ $stok->ukuran_sortasi }}',
                                {{ $stok->jumlah_stok }},
                                {{ $stok->harga_modal }},
                                {{ $stok->harga_jual }}
                            )">
                            Edit
                        </button>
                        <button class="btn btn-danger"
                            onclick="openDeleteModal({{ $stok->id }})">
                            Hapus
                        </button>
                    </td>
                </tr>
                @empty
                <tr><td colspan="9" style="text-align:center;color:var(--text-muted);padding:30px;">Belum ada data stok.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Tambah Stok --}}
<div class="modal-overlay" id="modal-tambah">
    <div class="modal">
        <div class="modal-header">
            <span class="modal-title">Tambah Stok Ikan</span>
            <button class="modal-close" onclick="closeModal('modal-tambah')">&times;</button>
        </div>
        <form action="{{ route('stok.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Jenis Ikan</label>
                <input type="text" name="jenis_ikan" placeholder="Lele, Nila, DII" required>
            </div>
            <div class="form-group">
                <label>Ukuran Sortasi</label>
                <input type="text" name="ukuran_sortasi" placeholder="7-9 ekor/kg" required>
            </div>
            <div class="form-group">
                <label>Jumlah Stok (Kg)</label>
                <input type="number" name="jumlah_stok" placeholder="Masukkan jumlah stok" min="0" step="0.01" required>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Harga Modal per Kg</label>
                    <input type="number" name="harga_modal" placeholder="Masukkan harga" min="0" required>
                </div>
                <div class="form-group">
                    <label>Harga Jual per Kg</label>
                    <input type="number" name="harga_jual" placeholder="Masukkan harga" min="0" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Edit Stok --}}
<div class="modal-overlay" id="modal-edit">
    <div class="modal">
        <div class="modal-header">
            <span class="modal-title">Edit Stok Ikan</span>
            <button class="modal-close" onclick="closeModal('modal-edit')">&times;</button>
        </div>
        <form id="form-edit" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Jenis Ikan</label>
                <input type="text" id="edit-jenis" name="jenis_ikan" required>
            </div>
            <div class="form-group">
                <label>Ukuran Sortasi</label>
                <input type="text" id="edit-ukuran" name="ukuran_sortasi" required>
            </div>
            <div class="form-group">
                <label>Jumlah Stok (Kg)</label>
                <input type="number" id="edit-stok" name="jumlah_stok" min="0" step="0.01" required>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Harga Modal per Kg</label>
                    <input type="number" id="edit-modal" name="harga_modal" min="0" required>
                </div>
                <div class="form-group">
                    <label>Harga Jual per Kg</label>
                    <input type="number" id="edit-jual" name="harga_jual" min="0" required>
                </div>
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
                <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Ya</button>
                <button type="button" class="btn btn-danger" onclick="closeModal('modal-hapus')">Batal</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
function openEditModal(id, jenis, ukuran, stok, modal, jual) {
    document.getElementById('form-edit').action = '/stok/' + id;
    document.getElementById('edit-jenis').value = jenis;
    document.getElementById('edit-ukuran').value = ukuran;
    document.getElementById('edit-stok').value = stok;
    document.getElementById('edit-modal').value = modal;
    document.getElementById('edit-jual').value = jual;
    openModal('modal-edit');
}
function openDeleteModal(id) {
    document.getElementById('form-hapus').action = '/stok/' + id;
    openModal('modal-hapus');
}
</script>
@endsection