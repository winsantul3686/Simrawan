@extends('layouts.app')

@section('title', 'Halaman Utama - SiMrawan')

@php $pageTitle = 'Halaman Utama'; @endphp

@section('styles')
<style>
    .stat-card:nth-child(1) { border-bottom-color: var(--primary); }
    .stat-card:nth-child(2) { border-bottom-color: var(--accent); }
    .stat-card:nth-child(3) { border-bottom-color: var(--success); }
    .stat-card:nth-child(4) { border-bottom-color: var(--warning); }
    .stat-card:nth-child(1) .value { color: var(--primary); }
    .stat-card:nth-child(2) .value { color: var(--accent); }
    .stat-card:nth-child(3) .value { color: var(--success); }
    .stat-card:nth-child(4) .value { color: var(--warning); }
    .stat-card:nth-child(1) .stat-icon { background: rgba(0,188,212,0.1); color: var(--primary); }
    .stat-card:nth-child(2) .stat-icon { background: rgba(124,77,255,0.1); color: var(--accent); }
    .stat-card:nth-child(3) .stat-icon { background: rgba(67,160,71,0.1); color: var(--success); }
    .stat-card:nth-child(4) .stat-icon { background: rgba(251,140,0,0.1); color: var(--warning); }
    .stat-icon {
        width: 44px; height: 44px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.1rem; margin-bottom: 16px;
    }
</style>
@endsection

@section('content')

{{-- Stat Cards --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-wallet"></i></div>
        <div class="label">Total Penjualan</div>
        <div class="value">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</div>
        <div class="sub">Dari transaksi selesai</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-shopping-bag"></i></div>
        <div class="label">Jumlah Pesanan</div>
        <div class="value">{{ number_format($jumlahPesanan, 0) }}</div>
        <div class="sub">Total semua pesanan</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-users"></i></div>
        <div class="label">Jumlah Customer</div>
        <div class="value">{{ number_format($jumlahCustomer, 0) }}</div>
        <div class="sub">Customer terdaftar</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="fas fa-boxes"></i></div>
        <div class="label">Total Stok</div>
        <div class="value">{{ number_format($totalStok, 0, ',', '.') }} Kg</div>
        <div class="sub">Total stok aktif</div>
    </div>
</div>

{{-- Konten Bawah --}}
<div class="dash-grid">
    {{-- Grafik Penjualan Bulanan --}}
    <div class="card">
        <div class="card-header">
            <span class="card-title">📈 Penjualan Bulanan</span>
            <span style="font-size:0.72rem;color:var(--text-muted);background:var(--gray);padding:4px 12px;border-radius:20px;">
                Tahun {{ date('Y') }}
            </span>
        </div>
        <div style="position:relative; height:280px;">
            <canvas id="chartPenjualan"></canvas>
        </div>
    </div>

    {{-- Stok Ikan Tersedia --}}
    <div class="card">
        <div class="card-header">
            <span class="card-title">🐟 Stok Tersedia</span>
            <a href="{{ route('stok.index') }}" style="font-size:0.75rem;color:var(--primary);text-decoration:none;font-weight:600;">
                Kelola <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        @forelse($stokTersedia as $stok)
        <div class="stok-list-item">
            <div>
                <div class="name">{{ $stok->jenis_ikan }}</div>
                <div class="sub">{{ $stok->ukuran_sortasi }} · Rp {{ number_format($stok->harga_jual, 0, ',', '.') }}/kg</div>
            </div>
            <span class="qty">{{ number_format($stok->jumlah_stok, 0) }} kg</span>
        </div>
        @empty
            <div style="text-align:center;padding:32px 0;color:var(--text-muted);">
                <i class="fas fa-box-open" style="font-size:2rem;display:block;margin-bottom:10px;opacity:0.4;"></i>
                <span style="font-size:0.83rem;">Stok kosong.</span>
            </div>
        @endforelse
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    @php
        $namaBulan = ['','Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'];
        $bulanLabels = [];
        $bulanData   = [];
        $mapData = [];
        foreach ($penjualanBulanan as $pb) {
            $mapData[(int)$pb->bulan] = (float)$pb->total;
        }
        if (!empty($mapData)) {
            $minBulan = min(array_keys($mapData));
            $maxBulan = max(array_keys($mapData));
        } else {
            $minBulan = 1;
            $maxBulan = 12;
        }
        for ($b = $minBulan; $b <= $maxBulan; $b++) {
            $bulanLabels[] = $namaBulan[$b];
            $bulanData[]   = $mapData[$b] ?? 0;
        }
    @endphp

    const labels = @json($bulanLabels);
    const dataValues = @json($bulanData);

    const ctx = document.getElementById('chartPenjualan').getContext('2d');

    const gradient = ctx.createLinearGradient(0, 0, 0, 280);
    gradient.addColorStop(0, 'rgba(0, 188, 212, 0.3)');
    gradient.addColorStop(1, 'rgba(0, 188, 212, 0.01)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Penjualan (Rp)',
                data: dataValues,
                borderColor: '#00bcd4',
                borderWidth: 2.5,
                backgroundColor: gradient,
                pointBackgroundColor: '#00bcd4',
                pointBorderColor: '#fff',
                pointBorderWidth: 2.5,
                pointRadius: 5,
                pointHoverRadius: 8,
                pointHoverBackgroundColor: '#7c4dff',
                fill: true,
                tension: 0.4,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(ctx) {
                            return ' Rp ' + ctx.parsed.y.toLocaleString('id-ID');
                        }
                    },
                    backgroundColor: '#0f1b4c',
                    titleColor: '#00bcd4',
                    bodyColor: '#fff',
                    padding: 12,
                    cornerRadius: 10,
                    titleFont: { family: 'Poppins', size: 12, weight: '600' },
                    bodyFont: { family: 'Poppins', size: 13, weight: '700' },
                }
            },
            scales: {
                x: {
                    grid: { color: 'rgba(0,0,0,0.04)', drawBorder: false },
                    ticks: { font: { family: 'Poppins', size: 11 }, color: '#718096' }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(0,0,0,0.04)', drawBorder: false },
                    ticks: {
                        font: { family: 'Poppins', size: 11 },
                        color: '#718096',
                        callback: function(value) {
                            if (value >= 1000000) return 'Rp' + (value/1000000).toFixed(1) + 'Jt';
                            if (value >= 1000)    return 'Rp' + (value/1000).toFixed(0) + 'Rb';
                            return 'Rp' + value;
                        }
                    }
                }
            }
        }
    });
</script>
@endsection
