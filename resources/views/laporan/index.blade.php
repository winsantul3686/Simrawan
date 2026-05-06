@extends('layouts.app')

@section('title', 'Laporan Keuangan - SiMrawan')

@php $pageTitle = 'Laporan Keuangan'; @endphp

@section('content')

{{-- Stat Cards --}}
<div class="laporan-grid">
    <div class="laporan-stat">
        <div class="label">Total Pendapatan (Selesai)</div>
        <div class="value">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
    </div>
    <div class="laporan-stat" style="border-left-color:var(--accent);">
        <div class="label">Total Transaksi</div>
        <div class="value" style="color:var(--accent);">{{ $totalTransaksi }}</div>
    </div>
    <div class="laporan-stat" style="border-left-color:var(--success);">
        <div class="label">Transaksi Selesai</div>
        <div class="value" style="color:var(--success);">{{ $transaksiSelesai }}</div>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">

    {{-- Laporan Bulanan --}}
    <div class="card">
        <div class="card-header">
            <span class="card-title">Rekap Penjualan Bulanan</span>
        </div>
        @if($laporanBulanan->isEmpty())
            <p style="color:var(--text-muted);font-size:0.82rem;">Belum ada data penjualan selesai.</p>
        @else
        @php $namaBulan = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember']; @endphp
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Bulan</th>
                        <th>Tahun</th>
                        <th>Transaksi</th>
                        <th>Pendapatan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($laporanBulanan as $lb)
                    <tr>
                        <td>{{ $namaBulan[$lb->bulan] ?? $lb->bulan }}</td>
                        <td>{{ $lb->tahun }}</td>
                        <td><span class="badge badge-info">{{ $lb->jumlah_transaksi }}x</span></td>
                        <td style="color:var(--primary);font-weight:700;">Rp {{ number_format($lb->total_pendapatan, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

    {{-- Rekap Per Produk --}}
    <div class="card">
        <div class="card-header">
            <span class="card-title">Rekap Penjualan Per Produk</span>
        </div>
        @if($rekapProduk->isEmpty())
            <p style="color:var(--text-muted);font-size:0.82rem;">Belum ada data.</p>
        @else
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Terjual (Kg)</th>
                        <th>Pendapatan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rekapProduk as $rp)
                    <tr>
                        <td>
                            <strong>{{ $rp->stokIkan->jenis_ikan }}</strong><br>
                            <small style="color:var(--text-muted);">{{ $rp->stokIkan->ukuran_sortasi }}</small>
                        </td>
                        <td style="font-weight:600;">{{ number_format($rp->total_kg, 1) }} Kg</td>
                        <td style="color:var(--primary);font-weight:700;">Rp {{ number_format($rp->total_pendapatan, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

</div>

@endsection