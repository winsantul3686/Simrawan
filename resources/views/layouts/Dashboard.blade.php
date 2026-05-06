@extends('layouts.app')

@section('title', 'Dashboard - SiMrawan')

@php $pageTitle = 'Dashboard'; @endphp

@section('content')

{{-- Stat Cards --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="label">Total Penjualan</div>
        <div class="value">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</div>
        <div class="sub">Transaksi selesai</div>
    </div>
    <div class="stat-card">
        <div class="label">Jumlah Pesanan Masuk</div>
        <div class="value">{{ $jumlahPesanan }}</div>
        <div class="sub">Total pesanan</div>
    </div>
    <div class="stat-card">
        <div class="label">Jumlah Customer</div>
        <div class="value">{{ $jumlahCustomer }}</div>
        <div class="sub">Customer terdaftar</div>
    </div>
    <div class="stat-card">
        <div class="label">Stok</div>
        <div class="value">{{ number_format($totalStok, 0, ',', '.') }} Kg</div>
        <div class="sub">Total stok aktif</div>
    </div>
</div>

{{-- Konten Bawah --}}
<div class="dash-grid">
    {{-- Grafik Penjualan Bulanan --}}
    <div class="card">
        <div class="card-header">
            <span class="card-title">Penjualan Bulanan</span>
        </div>
        <div style="position:relative; height:280px;">
            <canvas id="chartPenjualan"></canvas>
        </div>
    </div>

    {{-- Stok Ikan Tersedia --}}
    <div class="card">
        <div class="card-header">
            <span class="card-title">Stok Ikan Tersedia</span>
        </div>
        @forelse($stokTersedia as $stok)
        <div class="stok-list-item">
            <div>
                <div class="name">{{ $stok->jenis_ikan }} - {{ $stok->ukuran_sortasi }}</div>
                <div class="sub">Rp {{ number_format($stok->harga_jual, 0, ',', '.') }}/kg</div>
            </div>
            <span class="qty">{{ number_format($stok->jumlah_stok, 0) }}kg</span>
        </div>
        @empty
            <p style="color:var(--text-muted);font-size:0.82rem;padding:16px 0;">Stok kosong.</p>
        @endforelse
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    @php
        $namaBulan = ['','Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'];

        // Buat array lengkap 12 bulan, isi 0 kalau tidak ada data
        $bulanLabels = [];
        $bulanData   = [];

        // Kelompokkan data dari DB ke array [bulan => total]
        $mapData = [];
        foreach ($penjualanBulanan as $pb) {
            $mapData[(int)$pb->bulan] = (float)$pb->total;
        }

        // Ambil bulan yang relevan: kalau ada data pakai range dari data, kalau kosong tampilkan Jan-Des tahun ini
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

    // Gradient fill
    const gradient = ctx.createLinearGradient(0, 0, 0, 280);
    gradient.addColorStop(0, 'rgba(0, 188, 212, 0.35)');
    gradient.addColorStop(1, 'rgba(0, 188, 212, 0.02)');

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
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7,
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
                            return 'Rp ' + ctx.parsed.y.toLocaleString('id-ID');
                        }
                    },
                    backgroundColor: '#0f1b4c',
                    titleColor: '#00bcd4',
                    bodyColor: '#fff',
                    padding: 10,
                    cornerRadius: 8,
                }
            },
            scales: {
                x: {
                    grid: {
                        color: 'rgba(0,0,0,0.05)',
                        drawBorder: false,
                    },
                    ticks: {
                        font: { family: 'Poppins', size: 12 },
                        color: '#718096',
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0,0,0,0.05)',
                        drawBorder: false,
                    },
                    ticks: {
                        font: { family: 'Poppins', size: 11 },
                        color: '#718096',
                        callback: function(value) {
                            if (value >= 1000000) return (value/1000000).toFixed(1) + 'Jt';
                            if (value >= 1000)    return (value/1000).toFixed(0) + 'Rb';
                            return value;
                        }
                    }
                }
            }
        }
    });
</script>
@endsection