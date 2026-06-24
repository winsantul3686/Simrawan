@extends('layouts.app')

@section('title', 'Laporan Keuangan - SiMrawan')

@php $pageTitle = 'Laporan Keuangan'; @endphp

@section('styles')
<style>
    /* ===== Section Label ===== */
    .section-label {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: var(--text-muted);
        margin: 0 0 14px;
    }

    /* ===== Laporan Summary Cards ===== */
    .laporan-summary-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 24px;
    }
    .laporan-summary-card {
        background: #fff;
        border-radius: 12px;
        padding: 20px 24px;
        box-shadow: var(--shadow);
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .laporan-summary-card .ls-label {
        font-size: 0.95rem;
        font-weight: 600;
        color: #222;
    }
    .laporan-summary-card .ls-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-top: 4px;
    }
    .laporan-summary-card .ls-value {
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--primary);
    }
    .laporan-summary-card .ls-value.pengeluaran { color: var(--danger); }
    .laporan-summary-card .ls-value.laba { color: var(--success); }

    /* ===== Buttons ===== */
    .btn-lihat {
        background: linear-gradient(135deg, var(--primary), var(--accent));
        color: #fff;
        border: none;
        border-radius: 20px;
        padding: 6px 18px;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        white-space: nowrap;
    }
    .btn-lihat:hover { opacity: 0.88; color: #fff; }
    .btn-tambah-pengeluaran {
        background: linear-gradient(135deg, #00c853, #43a047);
        color: #fff;
        border: none;
        border-radius: 24px;
        padding: 10px 22px;
        font-size: 0.88rem;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .btn-tambah-pengeluaran:hover { opacity: 0.9; color: #fff; }

    /* ===== Pengeluaran Header ===== */
    .pengeluaran-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }
    .pengeluaran-header-left h3 {
        font-size: 1rem;
        font-weight: 700;
        margin: 0 0 2px;
    }
    .pengeluaran-header-left p {
        font-size: 0.8rem;
        color: var(--text-muted);
        margin: 0;
    }

    /* ===== Detail List (modals) ===== */
    .detail-list { list-style: none; padding: 0; margin: 0; }
    .detail-list li { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid var(--border); font-size: 0.85rem; }
    .detail-list li:last-child { border-bottom: none; }
    .detail-list li strong { color: #222; }

    /* ===== Modal Konfirmasi Hapus ===== */
    .confirm-icon-wrap {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: linear-gradient(135deg, #ff5252, #ff1744);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
        box-shadow: 0 4px 16px rgba(255, 23, 68, 0.25);
    }
    .confirm-icon-wrap i {
        font-size: 1.6rem;
        color: #fff;
    }
    .confirm-modal-body {
        text-align: center;
        padding: 8px 0 20px;
    }
    .confirm-modal-body h4 {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--dark);
        margin: 0 0 8px;
    }
    .confirm-modal-body p {
        font-size: 0.85rem;
        color: var(--text-muted);
        margin: 0;
        line-height: 1.5;
    }
    .confirm-modal-footer {
        display: flex;
        gap: 10px;
        margin-top: 4px;
    }
    .btn-cancel-confirm {
        flex: 1;
        padding: 11px 16px;
        border-radius: 10px;
        border: 1.5px solid var(--border);
        background: #fff;
        color: var(--text-muted);
        font-family: inherit;
        font-size: 0.88rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }
    .btn-cancel-confirm:hover {
        border-color: var(--text-muted);
        color: var(--dark);
    }
    .btn-confirm-hapus {
        flex: 1;
        padding: 11px 16px;
        border-radius: 10px;
        border: none;
        background: linear-gradient(135deg, #ff5252, #ff1744);
        color: #fff;
        font-family: inherit;
        font-size: 0.88rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 4px 12px rgba(255,23,68,0.2);
    }
    .btn-confirm-hapus:hover {
        opacity: 0.9;
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(255,23,68,0.3);
    }
</style>
@endsection

@section('content')

{{-- ===== LAPORAN KEUANGAN ===== --}}
<p class="section-label"><i class="fas fa-file-invoice-dollar" style="margin-right:6px;"></i>Laporan Keuangan</p>

<div class="laporan-summary-grid">
    <div class="laporan-summary-card">
        <div class="ls-label">Total Pemasukan</div>
        <div class="ls-row">
            <div class="ls-value">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</div>
            <button class="btn-lihat" onclick="openModal('modal-pemasukan')">Lihat</button>
        </div>
    </div>
    <div class="laporan-summary-card">
        <div class="ls-label">Total Pengeluaran</div>
        <div class="ls-row">
            <div class="ls-value pengeluaran">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</div>
            <button class="btn-lihat" onclick="openModal('modal-pengeluaran-detail')">Lihat</button>
        </div>
    </div>
    <div class="laporan-summary-card">
        <div class="ls-label">Laporan Laba</div>
        <div class="ls-row">
            <div class="ls-value laba">Rp {{ number_format($laba, 0, ',', '.') }}</div>
            <button class="btn-lihat" onclick="openModal('modal-laba')">Lihat</button>
        </div>
        <div style="font-size:0.73rem;color:var(--text-muted);margin-top:2px;">Harga jual &minus; modal</div>
    </div>
</div>

{{-- Tabel Pemasukan --}}
<div class="card" style="margin-bottom:28px;">
    <div class="card-header">
        <div class="pengeluaran-header-left">
            <h3 style="font-size:1rem;font-weight:700;margin:0 0 2px;">Pemasukan</h3>
            <p style="font-size:0.8rem;color:var(--text-muted);margin:0;">Daftar transaksi penjualan selesai</p>
        </div>
        <span style="font-size:0.75rem;font-weight:700;color:var(--success);background:#e8f5e9;padding:6px 14px;border-radius:20px;">
            Total: Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
        </span>
    </div>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>No. Pesanan</th>
                    <th>Tanggal</th>
                    <th>Customer</th>
                    <th>Detail Ikan</th>
                    <th>Total Pemasukan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pemasukans as $pem)
                <tr>
                    <td><span style="font-weight:700;color:var(--dark);">{{ $pem->no_pesanan }}</span></td>
                    <td>{{ $pem->updated_at->format('d/m/Y') }}</td>
                    <td>{{ $pem->customer->nama ?? '-' }}</td>
                    <td>
                        <div style="font-weight:600;font-size:0.83rem;">{{ $pem->stokIkan->jenis_ikan ?? 'Ikan' }}</div>
                        <div style="font-size:0.72rem;color:var(--text-muted);">{{ $pem->ukuran }} · {{ $pem->jumlah }} Kg</div>
                    </td>
                    <td style="font-weight:700;color:var(--success);">Rp {{ number_format($pem->total_harga, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center;color:var(--text-muted);padding:30px 0;">
                        Belum ada data pemasukan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Tabel Pengeluaran --}}
<div class="card">
    <div class="pengeluaran-header">
        <div class="pengeluaran-header-left">
            <h3>Pengeluaran</h3>
            <p>Catat pengeluaran operasional</p>
        </div>
        <button class="btn-tambah-pengeluaran" onclick="openModal('modal-tambah')">
            <i class="fas fa-plus"></i> Tambah Pengeluaran
        </button>
    </div>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Deskripsi</th>
                    <th>Kategori</th>
                    <th>Jumlah</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengeluarans as $p)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($p->tanggal)->format('d/m/Y') }}</td>
                    <td>{{ $p->deskripsi }}</td>
                    <td><span class="badge badge-info">{{ $p->kategori }}</span></td>
                    <td style="font-weight:700;color:var(--danger);">Rp {{ number_format($p->jumlah, 0, ',', '.') }}</td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm"
                            onclick="openDeleteModal({{ $p->id }}, '{{ addslashes($p->deskripsi) }}')"
                            title="Hapus pengeluaran">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center;color:var(--text-muted);padding:30px 0;">
                        Belum ada data pengeluaran
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ===== MODALS ===== --}}

{{-- Modal Tambah Pengeluaran --}}
<div class="modal-overlay" id="modal-tambah">
    <div class="modal">
        <div class="modal-header">
            <span class="modal-title">Tambah Pengeluaran</span>
            <button class="modal-close" onclick="closeModal('modal-tambah')">&times;</button>
        </div>
        <form action="{{ route('laporan.pengeluaran.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Tanggal</label>
                <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <input type="text" name="deskripsi" class="form-control" placeholder="Contoh: Pembelian pakan ikan" required>
            </div>
            <div class="form-group">
                <label>Kategori</label>
                <select name="kategori" class="form-control" required>
                    <option value="">-- Pilih Kategori --</option>
                    <option value="Pakan">Pakan</option>
                    <option value="Operasional">Operasional</option>
                    <option value="Peralatan">Peralatan</option>
                    <option value="Gaji">Gaji</option>
                    <option value="Lain-lain">Lain-lain</option>
                </select>
            </div>
            <div class="form-group">
                <label>Jumlah (Rp)</label>
                <input type="number" name="jumlah" class="form-control" placeholder="0" min="0" required>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn" onclick="closeModal('modal-tambah')" style="background:var(--border);">Batal</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Detail Pemasukan --}}
<div class="modal-overlay" id="modal-pemasukan">
    <div class="modal" style="max-width:700px;">
        <div class="modal-header">
            <span class="modal-title">Detail Pemasukan</span>
            <button class="modal-close" onclick="closeModal('modal-pemasukan')">&times;</button>
        </div>
        <div style="max-height:350px;overflow-y:auto;margin-bottom:15px;padding-right:5px;">
            @if($pemasukans->isEmpty())
                <p style="color:var(--text-muted);font-size:0.85rem;text-align:center;padding:20px 0;">Belum ada data pemasukan.</p>
            @else
                <table style="width:100%;border-collapse:collapse;font-size:0.85rem;text-align:left;">
                    <thead>
                        <tr style="border-bottom:2px solid var(--border);color:var(--text-muted);font-weight:600;">
                            <th style="padding:8px 4px;">Tanggal</th>
                            <th style="padding:8px 4px;">No. Pesanan</th>
                            <th style="padding:8px 4px;">Customer</th>
                            <th style="padding:8px 4px;">Detail Ikan</th>
                            <th style="padding:8px 4px;text-align:right;">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pemasukans as $pem)
                            <tr style="border-bottom:1px solid var(--border);">
                                <td style="padding:8px 4px;">{{ $pem->updated_at->format('d/m/Y') }}</td>
                                <td style="padding:8px 4px;font-weight:600;color:var(--dark);">{{ $pem->no_pesanan }}</td>
                                <td style="padding:8px 4px;">{{ $pem->customer->nama ?? '-' }}</td>
                                <td style="padding:8px 4px;">{{ $pem->stokIkan->jenis_ikan ?? 'Ikan' }} ({{ $pem->jumlah }} Kg)</td>
                                <td style="padding:8px 4px;text-align:right;font-weight:700;color:var(--success);">Rp {{ number_format($pem->total_harga, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
        <div style="padding-top:12px;border-top:2px solid var(--border);display:flex;justify-content:space-between;align-items:center;">
            <strong>Total Pemasukan (Transaksi Selesai)</strong>
            <strong style="color:var(--primary);font-size:1.1rem;">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</strong>
        </div>
    </div>
</div>

{{-- Modal Detail Pengeluaran --}}
<div class="modal-overlay" id="modal-pengeluaran-detail">
    <div class="modal">
        <div class="modal-header">
            <span class="modal-title">Detail Pengeluaran</span>
            <button class="modal-close" onclick="closeModal('modal-pengeluaran-detail')">&times;</button>
        </div>
        @if($pengeluarans->isEmpty())
            <p style="color:var(--text-muted);font-size:0.85rem;">Belum ada data pengeluaran.</p>
        @else
        <ul class="detail-list">
            @foreach($pengeluarans as $p)
            <li>
                <span>{{ $p->deskripsi }} <span class="badge badge-info" style="margin-left:4px;">{{ $p->kategori }}</span></span>
                <strong style="color:var(--danger);">Rp {{ number_format($p->jumlah, 0, ',', '.') }}</strong>
            </li>
            @endforeach
        </ul>
        <div style="margin-top:12px;padding-top:12px;border-top:2px solid var(--border);display:flex;justify-content:space-between;">
            <strong>Total</strong>
            <strong style="color:var(--danger);">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</strong>
        </div>
        @endif
    </div>
</div>

{{-- Modal Laba --}}
<div class="modal-overlay" id="modal-laba">
    <div class="modal">
        <div class="modal-header">
            <span class="modal-title">Laporan Laba</span>
            <button class="modal-close" onclick="closeModal('modal-laba')">&times;</button>
        </div>
        <ul class="detail-list">
            <li>
                <span>Total Pemasukan (Harga Jual)</span>
                <strong style="color:var(--primary);">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</strong>
            </li>
            <li>
                <span>Total Modal (Harga Modal &times; Qty)</span>
                <strong style="color:var(--danger);">Rp {{ number_format($totalModal, 0, ',', '.') }}</strong>
            </li>
        </ul>
        <div style="margin-top:12px;padding-top:12px;border-top:2px solid var(--border);display:flex;justify-content:space-between;">
            <strong>Total Laba</strong>
            <strong style="color:{{ $laba >= 0 ? 'var(--success)' : 'var(--danger)' }};">
                Rp {{ number_format($laba, 0, ',', '.') }}
            </strong>
        </div>
        <p style="font-size:0.75rem;color:var(--text-muted);margin-top:10px;">
            Laba dihitung dari <strong>harga jual &minus; harga modal &times; jumlah</strong> pada seluruh transaksi berstatus <strong>Selesai</strong>.
        </p>
    </div>
</div>

{{-- Modal Konfirmasi Hapus Pengeluaran --}}
<div class="modal-overlay" id="modal-konfirmasi-hapus">
    <div class="modal" style="max-width:420px;">
        <div class="modal-header" style="border-bottom:none;padding-bottom:0;">
            <span></span>
            <button class="modal-close" onclick="closeModal('modal-konfirmasi-hapus')">&times;</button>
        </div>
        <div class="confirm-modal-body">
            <div class="confirm-icon-wrap">
                <i class="fas fa-trash-alt"></i>
            </div>
            <h4>Hapus Pengeluaran?</h4>
            <p>Data pengeluaran <strong id="konfirmasi-deskripsi" style="color:var(--dark);"></strong> akan dihapus secara permanen dan tidak dapat dikembalikan.</p>
        </div>
        <form id="form-hapus-pengeluaran" method="POST">
            @csrf
            @method('DELETE')
            <div class="confirm-modal-footer">
                <button type="button" class="btn-cancel-confirm" onclick="closeModal('modal-konfirmasi-hapus')">
                    <i class="fas fa-times"></i> Batal
                </button>
                <button type="submit" class="btn-confirm-hapus">
                    <i class="fas fa-trash-alt"></i> Ya, Hapus
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
function openDeleteModal(id, deskripsi) {
    document.getElementById('konfirmasi-deskripsi').textContent = deskripsi;
    document.getElementById('form-hapus-pengeluaran').action = '/laporan/pengeluaran/' + id;
    openModal('modal-konfirmasi-hapus');
}
</script>
@endsection
