@extends('layouts.app')

@section('title', 'Transaksi - SiMrawan')

@php $pageTitle = 'Transaksi'; @endphp

@section('content')

<div class="card">
    <div class="card-header">
        <span class="card-title">Pesanan Masuk</span>
    </div>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>No. Pesanan</th>
                    <th>Nama Customer</th>
                    <th>Tanggal</th>
                    <th>Total Harga</th>
                    <th>Bukti Bayar</th>
                    <th>Tgl Upload</th>
                    <th>Status</th>
                    <th>Status Pembayaran</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksiList as $t)
                <tr>
                    <td>{{ $t->no_pesanan }}</td>
                    <td>{{ $t->customer->nama }}</td>
                    <td>{{ $t->created_at->format('d F Y') }}</td>
                    <td style="color:var(--primary);font-weight:600;">Rp {{ number_format($t->total_harga, 0, ',', '.') }}</td>
                    <td>
                        @if($t->bukti_bayar)
                            <a href="{{ asset('uploads/'.$t->bukti_bayar) }}" target="_blank" style="color:var(--primary);">Lihat Bukti</a>
                        @else
                            <span style="color:var(--text-muted);">-</span>
                        @endif
                    </td>
                    <td>{{ $t->tgl_upload ? \Carbon\Carbon::parse($t->tgl_upload)->format('d M Y') : '-' }}</td>
                    <td>
                        @php
                            $badgeMap = [
                                'Menunggu'   => 'badge-warning',
                                'Diproses'   => 'badge-info',
                                'Dikirim'    => 'badge-primary',
                                'Selesai'    => 'badge-success',
                                'Dibatalkan' => 'badge-danger',
                            ];
                        @endphp
                        <span class="badge {{ $badgeMap[$t->status] ?? 'badge-info' }}">{{ $t->status }}</span>
                    </td>
                    <td>
                        @php
                            $bayarMap = [
                                'Menunggu Konfirmasi' => 'badge-warning',
                                'Dikonfirmasi'        => 'badge-success',
                                'Ditolak'             => 'badge-danger',
                            ];
                        @endphp
                        <span class="badge {{ $bayarMap[$t->status_pembayaran] ?? 'badge-warning' }}">
                            {{ $t->status_pembayaran ?? 'Menunggu Konfirmasi' }}
                        </span>
                    </td>
                    <td>
                        <button class="btn btn-edit"
                            onclick="openDetailModal(
                                {{ $t->id }},
                                '{{ $t->customer->nama }}',
                                '{{ $t->stokIkan->jenis_ikan }}',
                                '{{ $t->ukuran }}',
                                {{ $t->jumlah }},
                                {{ $t->total_harga }},
                                '{{ $t->status }}',
                                '{{ addslashes($t->alamat_pengiriman) }}',
                                '{{ $t->bukti_bayar ?? "" }}',
                                '{{ $t->status_pembayaran ?? 'Menunggu Konfirmasi' }}'
                            )">
                            Detail
                        </button>
                    </td>
                </tr>
                @empty
                <tr><td colspan="9" style="text-align:center;color:var(--text-muted);padding:30px;">Belum ada transaksi.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Detail Pesanan --}}
<div class="modal-overlay" id="modal-detail">
    <div class="modal" style="max-width:580px;">
        <div class="modal-header">
            <span class="modal-title">Detail Pesanan</span>
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
        <div class="form-row">
            <div class="form-group">
                <label>Total Harga</label>
                <input type="text" id="d-harga" readonly>
            </div>
            <div class="form-group">
                <label>Bukti Pembayaran</label>
                <input type="text" id="d-bukti" readonly>
            </div>
        </div>
        <div class="form-group">
            <label>Alamat</label>
            <input type="text" id="d-alamat" readonly>
        </div>

        <form id="form-update-status" method="POST">
            @csrf
            @method('PUT')
            <div class="form-row">
                <div class="form-group">
                    <label>Update Status Pesanan</label>
                    <select name="status" id="d-status">
                        <option value="Menunggu">Menunggu</option>
                        <option value="Diproses">Diproses</option>
                        <option value="Dikirim">Dikirim</option>
                        <option value="Selesai">Selesai</option>
                        <option value="Dibatalkan">Dibatalkan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Status Pembayaran</label>
                    <input type="text" id="d-status-pembayaran-text" readonly>
                    <input type="hidden" name="status_pembayaran" id="d-status-pembayaran">
                </div>
            </div>

            {{-- Tombol Konfirmasi & Tolak Pembayaran --}}
            <div style="display:flex;gap:10px;margin-bottom:12px;">
                <button type="button" id="btn-konfirmasi-bayar"
                    style="flex:1;display:flex;align-items:center;justify-content:center;gap:8px;
                           padding:11px;border:none;border-radius:10px;font-family:inherit;
                           font-size:0.85rem;font-weight:700;cursor:pointer;transition:all 0.25s;
                           background:linear-gradient(135deg,#43a047,#00c853);color:#fff;
                           box-shadow:0 4px 14px rgba(67,160,71,0.3);"
                    onmouseover="this.style.opacity='0.88';this.style.transform='translateY(-1px)'"
                    onmouseout="this.style.opacity='1';this.style.transform='translateY(0)'"
                    onclick="setStatusPembayaran('Dikonfirmasi')">
                    <i class="fas fa-check-circle"></i> Konfirmasi Pembayaran
                </button>
                <button type="button" id="btn-tolak-bayar"
                    style="flex:1;display:flex;align-items:center;justify-content:center;gap:8px;
                           padding:11px;border:none;border-radius:10px;font-family:inherit;
                           font-size:0.85rem;font-weight:700;cursor:pointer;transition:all 0.25s;
                           background:linear-gradient(135deg,#e53935,#c62828);color:#fff;
                           box-shadow:0 4px 14px rgba(229,57,53,0.3);"
                    onmouseover="this.style.opacity='0.88';this.style.transform='translateY(-1px)'"
                    onmouseout="this.style.opacity='1';this.style.transform='translateY(0)'"
                    onclick="setStatusPembayaran('Ditolak')">
                    <i class="fas fa-times-circle"></i> Tolak Pembayaran
                </button>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
function openDetailModal(id, customer, produk, ukuran, jumlah, harga, status, alamat, bukti, statusPembayaran) {
    document.getElementById('d-customer').value = customer;
    document.getElementById('d-produk').value = produk;
    document.getElementById('d-ukuran').value = ukuran;
    document.getElementById('d-jumlah').value = jumlah + ' Kg';
    document.getElementById('d-harga').value = 'Rp ' + parseInt(harga).toLocaleString('id-ID');
    document.getElementById('d-alamat').value = alamat;
    document.getElementById('d-bukti').value = bukti || '-';
    document.getElementById('d-status').value = status;
    
    const statusPembayaranVal = statusPembayaran || 'Menunggu Konfirmasi';
    document.getElementById('d-status-pembayaran').value = statusPembayaranVal;
    document.getElementById('d-status-pembayaran-text').value = statusPembayaranVal;
    
    document.getElementById('form-update-status').action = '/transaksi/' + id;

    // Update tampilan tombol sesuai status pembayaran saat ini
    updatePaymentButtons(statusPembayaran);

    openModal('modal-detail');
}

function updatePaymentButtons(statusPembayaran) {
    const btnKonfirmasi = document.getElementById('btn-konfirmasi-bayar');
    const btnTolak      = document.getElementById('btn-tolak-bayar');

    if (statusPembayaran === 'Dikonfirmasi') {
        btnKonfirmasi.style.opacity = '0.45';
        btnKonfirmasi.style.cursor  = 'not-allowed';
        btnKonfirmasi.disabled      = true;
        btnTolak.style.opacity      = '1';
        btnTolak.style.cursor       = 'pointer';
        btnTolak.disabled           = false;
    } else if (statusPembayaran === 'Ditolak') {
        btnTolak.style.opacity      = '0.45';
        btnTolak.style.cursor       = 'not-allowed';
        btnTolak.disabled           = true;
        btnKonfirmasi.style.opacity = '1';
        btnKonfirmasi.style.cursor  = 'pointer';
        btnKonfirmasi.disabled      = false;
    } else {
        btnKonfirmasi.style.opacity = '1';
        btnKonfirmasi.style.cursor  = 'pointer';
        btnKonfirmasi.disabled      = false;
        btnTolak.style.opacity      = '1';
        btnTolak.style.cursor       = 'pointer';
        btnTolak.disabled           = false;
    }
}

function setStatusPembayaran(nilai) {
    document.getElementById('d-status-pembayaran').value = nilai;
    document.getElementById('d-status-pembayaran-text').value = nilai;
    document.getElementById('form-update-status').submit();
}
</script>
@endsection