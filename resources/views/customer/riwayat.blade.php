@extends('layouts.app')

@section('title', 'Riwayat Pembelian - SiMrawan')

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
    .riwayat-container { padding: 32px 48px; max-width: 100%; }
    .riwayat-table-wrap {
        background: #fff;
        border-radius: 18px;
        box-shadow: var(--shadow);
        overflow: hidden;
        border: 1.5px solid var(--border);
    }
    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 13px;
        border-radius: 20px;
        font-size: 0.72rem;
        font-weight: 700;
        white-space: nowrap;
    }
    @media (max-width: 768px) {
        .page-header { padding: 24px 20px; }
        .riwayat-container { padding: 24px 20px; }
    }
</style>
@endsection

@section('content')
@include('components.navbar-customer')

<div class="page-header">
    <div style="max-width: 100%; padding: 0 48px;">
        <h2>📋 Riwayat Pembelian</h2>
        <p>Daftar semua pesanan kamu</p>
    </div>
</div>

<div class="riwayat-container">
    @if(session('success'))
        <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
    @endif

    <div class="riwayat-table-wrap">
        <table>
            <thead>
                <tr>
                    <th>No. Pesanan</th>
                    <th>Produk</th>
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
                @forelse($pesananList as $i => $p)
                <tr>
                    <td>
                        <span style="font-weight:700;color:var(--dark);">{{ $p->no_pesanan }}</span>
                    </td>
                    <td>
                        <div style="font-weight:600;font-size:0.83rem;">{{ $p->stokIkan->jenis_ikan }}</div>
                        <div style="font-size:0.72rem;color:var(--text-muted);">{{ $p->ukuran }} · {{ $p->jumlah }} Kg</div>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($p->created_at)->format('d M Y') }}</td>
                    <td style="color:var(--primary);font-weight:700;">Rp {{ number_format($p->total_harga,0,',','.') }}</td>
                    <td>
                        @if($p->bukti_bayar)
                            <a href="{{ asset('uploads/bukti/' . $p->bukti_bayar) }}" target="_blank"
                               style="color:var(--primary);font-weight:600;text-decoration:none;font-size:0.8rem;">
                                <i class="fas fa-file-image"></i> Lihat
                            </a>
                        @else
                            <span style="color:#aaa;font-size:0.8rem;">Belum upload</span>
                        @endif
                    </td>
                    <td style="font-size:0.8rem;">{{ $p->tgl_upload ? \Carbon\Carbon::parse($p->tgl_upload)->format('d M Y') : '-' }}</td>
                    <td>
                        @php
                            $statusStyle = match($p->status) {
                                'Menunggu'   => ['#fff3e0','#fb8c00','⏳'],
                                'Diproses'   => ['#e3f2fd','#1976d2','⚙️'],
                                'Dikirim'    => ['#e8eaf6','#3949ab','🚚'],
                                'Selesai'    => ['#e8f5e9','#2e7d32','✅'],
                                'Dibatalkan' => ['#fce4ec','#c62828','❌'],
                                default      => ['#f5f5f5','#666','•'],
                            };
                        @endphp
                        <span class="status-pill" style="background:{{ $statusStyle[0] }};color:{{ $statusStyle[1] }};">
                            {{ $statusStyle[2] }} {{ $p->status }}
                        </span>
                    </td>
                    <td>
                        @php
                            $bayarStyle = match($p->status_pembayaran ?? 'Menunggu Konfirmasi') {
                                'Dikonfirmasi' => ['#e8f5e9','#2e7d32','✅'],
                                'Ditolak'      => ['#fce4ec','#c62828','❌'],
                                default        => ['#fff3e0','#fb8c00','⏳'],
                            };
                        @endphp
                        <span class="status-pill" style="background:{{ $bayarStyle[0] }};color:{{ $bayarStyle[1] }};">
                            {{ $bayarStyle[2] }} {{ $p->status_pembayaran ?? 'Menunggu Konfirmasi' }}
                        </span>
                    </td>
                    <td>
                        <button class="btn btn-primary btn-sm"
                                onclick="openModalDetail(
                                    '{{ $p->no_pesanan }}',
                                    '{{ $p->stokIkan->jenis_ikan }}',
                                    '{{ $p->ukuran }}',
                                    {{ $p->jumlah }},
                                    {{ $p->total_harga }},
                                    '{{ addslashes($p->alamat_pengiriman) }}',
                                    '{{ addslashes($p->catatan ?? '') }}',
                                    '{{ $p->bukti_bayar }}',
                                    '{{ $p->status }}',
                                    {{ $p->id }},
                                    '{{ $p->status_pembayaran ?? 'Menunggu Konfirmasi' }}'
                                )">
                            <i class="fas fa-eye"></i> Detail
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" style="text-align:center;padding:60px;">
                        <div style="font-size:3rem;margin-bottom:14px;">📦</div>
                        <div style="font-size:1rem;font-weight:700;color:var(--dark);margin-bottom:8px;">Belum ada pesanan</div>
                        <p style="font-size:0.83rem;color:var(--text-muted);margin-bottom:20px;">Yuk mulai pesan ikan segar dari kami!</p>
                        <a href="{{ route('customer.produk') }}" class="btn btn-primary">
                            <i class="fas fa-shopping-cart"></i> Pesan Sekarang
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Detail Pesanan --}}
<div class="modal-overlay" id="modalDetail">
    <div class="modal-box" style="max-width:520px;">
        <div class="modal-header">
            <h3><i class="fas fa-receipt" style="color:var(--primary);"></i> Detail Pesanan</h3>
            <button class="modal-close" onclick="closeModal('modalDetail')">&times;</button>
        </div>
        <div style="font-size:0.83rem;">
            <div style="background:var(--gray);border-radius:12px;padding:16px;margin-bottom:16px;">
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                    <div>
                        <div style="font-size:0.7rem;color:var(--text-muted);font-weight:600;margin-bottom:3px;">NO. PESANAN</div>
                        <div id="d_nopesanan" style="font-weight:700;"></div>
                    </div>
                    <div>
                        <div style="font-size:0.7rem;color:var(--text-muted);font-weight:600;margin-bottom:3px;">CUSTOMER</div>
                        <div style="font-weight:700;">{{ session('customer_nama') }}</div>
                    </div>
                    <div>
                        <div style="font-size:0.7rem;color:var(--text-muted);font-weight:600;margin-bottom:3px;">PRODUK</div>
                        <div id="d_produk" style="font-weight:700;"></div>
                    </div>
                    <div>
                        <div style="font-size:0.7rem;color:var(--text-muted);font-weight:600;margin-bottom:3px;">UKURAN</div>
                        <div id="d_ukuran" style="font-weight:700;"></div>
                    </div>
                    <div>
                        <div style="font-size:0.7rem;color:var(--text-muted);font-weight:600;margin-bottom:3px;">JUMLAH</div>
                        <div id="d_jumlah" style="font-weight:700;"></div>
                    </div>
                    <div>
                        <div style="font-size:0.7rem;color:var(--text-muted);font-weight:600;margin-bottom:3px;">TOTAL HARGA</div>
                        <div id="d_total" style="font-weight:800;color:var(--primary);font-size:1rem;"></div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Alamat Pengiriman</label>
                <input type="text" id="d_alamat" readonly>
            </div>
            <div class="form-group">
                <label>Catatan</label>
                <input type="text" id="d_catatan" readonly>
            </div>
            <div class="form-group">
                <label>Bukti Pembayaran</label>
                <div id="d_bukti" style="padding:10px;background:var(--gray);border-radius:8px;font-size:0.82rem;"></div>
            </div>
            <div class="form-group">
                <label>Status Pembayaran</label>
                <div id="d_status_pembayaran" style="padding:10px;border-radius:8px;font-size:0.83rem;font-weight:700;"></div>
            </div>
            <div id="btn_upload_wrap"></div>
            <div id="btn_batalkan_wrap"></div>
        </div>
    </div>
</div>

{{-- Modal Konfirmasi Batal --}}
<div class="modal-overlay" id="modalConfirmBatal">
    <div class="modal-box" style="max-width:380px; text-align:center; padding: 32px 24px; border-radius: 18px;">
        <div style="font-size: 3rem; color: #fb8c00; margin-bottom: 16px;">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <h3 style="font-size: 1.15rem; font-weight: 800; color: var(--dark); margin-bottom: 8px;">Konfirmasi Batal</h3>
        <p style="font-size: 0.88rem; color: var(--text-muted); line-height: 1.5; margin-bottom: 24px;">
            Yakin ingin membatalkan pesanan ini?
        </p>
        <div style="display: flex; gap: 12px;">
            <button type="button" id="btn_confirm_batal_ya" class="btn btn-danger" style="flex: 1; justify-content: center; padding: 11px; font-weight: 700; border-radius: 10px;">
                Ya
            </button>
            <button type="button" onclick="closeModal('modalConfirmBatal')" class="btn" style="flex: 1; justify-content: center; padding: 11px; font-weight: 700; border-radius: 10px; background: #e2e8f0; color: var(--text); border: none;">
                Batal
            </button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
let activeCancelForm = null;

function showConfirmBatal(event, formElement) {
    event.preventDefault();
    activeCancelForm = formElement;
    openModal('modalConfirmBatal');
    return false;
}

document.addEventListener('DOMContentLoaded', function() {
    const yaBtn = document.getElementById('btn_confirm_batal_ya');
    if (yaBtn) {
        yaBtn.addEventListener('click', function() {
            if (activeCancelForm) {
                activeCancelForm.submit();
            }
        });
    }
});

function openModalDetail(noPesanan, produk, ukuran, jumlah, total, alamat, catatan, bukti, status, id, statusPembayaran) {
    document.getElementById('d_nopesanan').textContent = noPesanan;
    document.getElementById('d_produk').textContent    = produk;
    document.getElementById('d_ukuran').textContent    = ukuran;
    document.getElementById('d_jumlah').textContent    = jumlah + ' Kg';
    document.getElementById('d_total').textContent     = 'Rp ' + Number(total).toLocaleString('id-ID');
    document.getElementById('d_alamat').value          = alamat;
    document.getElementById('d_catatan').value         = catatan || '-';

    // Status Pembayaran
    const spEl = document.getElementById('d_status_pembayaran');
    const spColors = { 'Dikonfirmasi': ['#e8f5e9','#2e7d32'], 'Ditolak': ['#fce4ec','#c62828'] };
    const spColor = spColors[statusPembayaran] || ['#fff3e0','#fb8c00'];
    spEl.style.background = spColor[0];
    spEl.style.color = spColor[1];
    spEl.textContent = statusPembayaran || 'Menunggu Konfirmasi';

    // Bukti bayar
    const buktiDiv = document.getElementById('d_bukti');
    buktiDiv.innerHTML = bukti
        ? `<a href="/uploads/bukti/${bukti}" target="_blank" style="color:var(--primary);font-weight:600;display:inline-flex;align-items:center;gap:6px;"><i class="fas fa-file-image"></i> Lihat Bukti Pembayaran</a>`
        : '<span style="color:#aaa;"><i class="fas fa-clock"></i> Belum diupload</span>';

    // Upload button (jika belum ada bukti bayar & status Menunggu)
    const uploadDiv = document.getElementById('btn_upload_wrap');
    uploadDiv.innerHTML = (!bukti && status === 'Menunggu')
        ? `<a href="/customer/pesanan/konfirmasi/${id}" class="btn btn-primary" style="width:100%;justify-content:center;margin-top:8px;display:flex;">
               <i class="fas fa-upload"></i> Upload Bukti Pembayaran
           </a>`
        : '';

    // Batalkan button
    const batalDiv = document.getElementById('btn_batalkan_wrap');
    batalDiv.innerHTML = status === 'Menunggu'
        ? `<form action="/customer/pesanan/batalkan/${id}" method="POST" onsubmit="return showConfirmBatal(event, this)">
               <input type="hidden" name="_token" value="{{ csrf_token() }}">
               <button type="submit" class="btn btn-danger" style="width:100%;justify-content:center;margin-top:8px;display:flex;">
                   <i class="fas fa-times"></i> Batalkan Pesanan
               </button>
           </form>`
        : '';

    openModal('modalDetail');
}
</script>
@endsection