@extends('layouts.app')

@section('title', 'Katalog Produk - SiMrawan')

@php $pageTitle = 'Produk'; @endphp

@section('styles')
<style>
    /* Styling Halaman Beranda Produk Sesuai image_d337ba.png */
    .beranda-subtext {
        text-align: center;
        color: #64748b;
        font-size: 0.95rem;
        line-height: 1.5;
        margin-bottom: 40px;
    }
    
    .katalog-header {
        margin-bottom: 24px;
    }
    
    .katalog-header h2 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 2px;
    }
    
    .katalog-header p {
        font-size: 0.88rem;
        color: #94a3b8;
    }

    /* Container Grid untuk Card Produk */
    .produk-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 30px;
        margin-bottom: 40px;
    }

    /* Wrapper Card Utama */
    .card-produk {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
        border: 1px solid #f1f5f9;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    /* Box Gambar Warna Biru Muda Sesuai Gambar Mockup */
    .card-produk .box-gambar {
        background: #e0f7fa; /* Warna latar biru muda air */
        height: 240px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .card-produk .box-gambar img {
        width: 130px;
        height: 130px;
        object-fit: contain;
    }

    /* Area Konten Teks */
    .card-produk .konten-produk {
        padding: 20px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .card-produk .nama-ikan {
        font-size: 1.2rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 2px;
    }

    .card-produk .ukuran-ikan {
        font-size: 0.85rem;
        color: #64748b;
        margin-bottom: 10px;
    }

    .card-produk .badge-tersedia {
        background: #4f46e5;
        color: #fff;
        font-size: 0.75rem;
        font-weight: 600;
        padding: 4px 12px;
        border-radius: 8px;
        display: inline-block;
        margin-bottom: 14px;
        width: fit-content;
    }

    /* List Detail Nilai Properti */
    .card-produk .detail-baris {
        display: flex;
        justify-content: space-between;
        font-size: 0.88rem;
        margin-bottom: 6px;
        color: #64748b;
    }

    .card-produk .detail-baris .nilai {
        font-weight: 600;
        color: #1e293b;
    }

    .card-produk .detail-baris .nilai-harga {
        color: #06b6d4; /* Warna cyan/biru terang sesuai mockup */
        font-weight: 700;
    }

    .card-produk .deskripsi-singkat {
        font-size: 0.85rem;
        color: #94a3b8;
        border-top: 1px solid #f1f5f9;
        padding-top: 10px;
        margin-top: 8px;
        margin-bottom: 16px;
    }

    /* Tombol Pesanan Gradasi Ungu-Biru Sesuai image_d337ba.png */
    .btn-pesan-gradasi {
        background: linear-gradient(90deg, #0284c7 0%, #6366f1 100%);
        color: #fff;
        border: none;
        padding: 12px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.9rem;
        text-align: center;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        cursor: pointer;
        box-shadow: 0 4px 10px rgba(99, 102, 241, 0.2);
        transition: opacity 0.2s;
    }

    .btn-pesan-gradasi:hover {
        opacity: 0.9;
    }
</style>
@endsection

@section('content')
<div style="padding: 10px 24px;">

    <!-- Teks Atas -->
    <div class="beranda-subtext">
        Dipanen langsung dari kolam kami dengan standar kualitas terbaik<br>
        untuk memastikan kesegaran dan nutrisi optimal
    </div>

    <!-- Header Judul Menu -->
    <div class="katalog-header">
        <h2>Katalog Produk</h2>
        <p>Pilih ikan segar berkualitas</p>
    </div>

    <!-- Grid Pembungkus Card -->
    <div class="produk-grid">
        @forelse($katalogs as $katalog)
        <div class="card-produk">
            <!-- Box Gambar Latar Biru Muda -->
            <div class="box-gambar">
                @if($katalog->gambar)
                    <img src="{{ asset('storage/' . $katalog->gambar) }}" alt="Ikan">
                @else
                    <!-- Jika gambar kosong, render icon ikan default -->
                    <img src="https://api.iconify.design/twemoji:fish.svg" alt="Ikan Default">
                @endif
            </div>

            <!-- Konten Data Ikan -->
            <div class="konten-produk">
                <div class="nama-ikan">{{ $katalog->stokIkan->jenis_ikan ?? 'Nama Ikan' }}</div>
                <div class="ukuran-ikan">{{ $katalog->stokIkan->ukuran_sortasi ?? 'Ukuran tidak diset' }}</div>
                
                <div class="badge-tersedia">Tersedia</div>

                <div class="detail-baris">
                    <span>Harga</span>
                    <span class="nilai-harga">Rp {{ number_format($katalog->stokIkan->harga_jual ?? 0, 0, ',', '.') }}/Kg</span>
                </div>
                
                <div class="detail-baris">
                    <span>Stok</span>
                    <span class="nilai">{{ $katalog->stokIkan->jumlah_stok ?? 0 }} Kg</span>
                </div>
                
                <div class="detail-baris">
                    <span>Min Order</span>
                    <span class="nilai">5/Kg</span>
                </div>

                <div class="deskripsi-singkat">
                    {{ $katalog->deskripsi ?? 'Ikan segar pilihan langsung panen.' }}
                </div>

                <!-- Tombol Pesan mengarah ke Form Checkout Detail (Melalui id rute show) -->
                <a href="{{ route('customer.produk.show', $katalog->id) }}" class="btn-pesan-gradasi">
                    <i class="fas fa-shopping-cart"></i> Pesan
                </a>
            </div>
        </div>
        @empty
        <div style="grid-column: 1/-1; text-align: center; color: #94a3b8; padding: 40px 0;">
            <i class="fas fa-fish-sub" style="font-size: 3rem; margin-bottom: 10px; display: block;"></i>
            Belum ada katalog produk
        </div>
        @endforelse
    </div>

</div>
@endsection