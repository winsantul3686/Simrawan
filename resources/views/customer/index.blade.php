@extends('layouts.app')

@section('title', 'Customer - SiMrawan')

@php $pageTitle = 'Customer'; @endphp

@section('content')

<div class="card">
    <div class="card-header">
        <span class="card-title">Daftar Customer</span>
        <span style="font-size:0.8rem;color:var(--text-muted);">Total: {{ $customerList->count() }} customer</span>
    </div>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>No. Telp</th>
                    <th>Alamat</th>
                    <th>Transaksi</th>
                    <th>Bergabung</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customerList as $i => $c)
                <tr>
                    <td>{{ str_pad($i+1, 2, '0', STR_PAD_LEFT) }}</td>
                    <td style="font-weight:600;">{{ $c->nama }}</td>
                    <td>{{ $c->email }}</td>
                    <td>{{ $c->no_telp }}</td>
                    <td style="max-width:200px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $c->alamat }}</td>
                    <td>
                        <span class="badge badge-info">{{ $c->transaksis_count }} pesanan</span>
                    </td>
                    <td>{{ $c->created_at->format('d M Y') }}</td>
                    <td>
                        <button class="btn btn-danger btn-sm"
                            onclick="openDeleteModal({{ $c->id }}, '{{ $c->nama }}')">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" style="text-align:center;color:var(--text-muted);padding:30px;">Belum ada customer terdaftar.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Hapus --}}
<div class="modal-overlay" id="modal-hapus">
    <div class="modal" style="max-width:380px;text-align:center;">
        <button class="modal-close" onclick="closeModal('modal-hapus')" style="position:absolute;top:16px;right:16px;">&times;</button>
        <i class="fas fa-exclamation-triangle" style="font-size:2rem;color:var(--warning);margin:20px 0 10px;display:block;"></i>
        <p style="font-size:1rem;font-weight:600;margin-bottom:6px;">Hapus Customer?</p>
        <p id="hapus-nama" style="font-size:0.82rem;color:var(--text-muted);margin-bottom:20px;"></p>
        <form id="form-hapus" method="POST">
            @csrf
            @method('DELETE')
            <div style="display:flex;gap:12px;justify-content:center;">
                <button type="submit" class="btn btn-success">Ya, Hapus</button>
                <button type="button" class="btn btn-danger" onclick="closeModal('modal-hapus')">Batal</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
function openDeleteModal(id, nama) {
    document.getElementById('form-hapus').action = '/customer/' + id;
    document.getElementById('hapus-nama').textContent = 'Customer "' + nama + '" akan dihapus permanen.';
    openModal('modal-hapus');
}
</script>
@endsection