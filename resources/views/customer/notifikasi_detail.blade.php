@extends('layouts.app')

@section('title', 'Detail Notifikasi - SiMrawan')

@section('no-sidebar')
@endsection

@section('styles')
<style>
    .back-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary), var(--accent));
        color: #fff;
        text-decoration: none;
        box-shadow: 0 4px 15px rgba(0, 188, 212, 0.3);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        flex-shrink: 0;
    }
    .back-btn:hover {
        transform: scale(1.1) rotate(-8deg);
        box-shadow: 0 8px 25px rgba(124, 77, 255, 0.4);
    }
    .detail-card {
        flex: 1;
        background: #fff;
        border-radius: 16px;
        padding: 40px;
        box-shadow: var(--shadow-lg);
        border: 1px solid rgba(0,0,0,0.04);
        transition: transform 0.3s ease;
    }
    .gradient-box {
        border: 1.5px solid transparent;
        background: linear-gradient(#fff, #fff) padding-box,
                    linear-gradient(135deg, var(--primary), var(--accent)) border-box;
        border-radius: 16px;
        padding: 32px;
        position: relative;
        box-shadow: 0 4px 20px rgba(0,0,0,0.02);
    }
    .badge-read {
        font-size: 0.82rem;
        padding: 8px 22px;
        border-radius: 20px;
        font-weight: 700;
        background: #00bcd4;
        background: linear-gradient(135deg, #00e676, #00c853);
        color: #fff;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        box-shadow: 0 3px 10px rgba(0, 200, 83, 0.25);
    }
</style>
@endsection

@section('content')
@include('components.navbar-customer')

<div style="padding:48px; max-width:100%; display:flex; gap:28px; align-items:flex-start;">
    
    {{-- Back Button --}}
    <a href="{{ route('customer.notifikasi', ['tab' => $type]) }}" class="back-btn" title="Kembali ke Notifikasi">
        <i class="fas fa-reply" style="font-size: 1.25rem;"></i>
    </a>

    {{-- Detail Card --}}
    <div class="detail-card">
        <h2 style="font-size:1.15rem; font-weight:800; color:var(--dark); margin-bottom:24px; letter-spacing:-0.3px;">
            Notifikasi {{ $type === 'pesanan' ? 'Pesanan' : 'Wishlist' }}
        </h2>
        
        <div class="gradient-box">
            <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:16px; gap:20px; flex-wrap: wrap;">
                <h1 style="font-size:1.75rem; font-weight:800; color:var(--dark); margin:0; line-height:1.2; letter-spacing:-0.5px;">
                    {{ $notif->judul }}
                </h1>
                <span style="font-size:0.82rem; color:var(--text-muted); font-weight:600; margin-top:4px;">
                    {{ $notif->date }}
                </span>
            </div>
            
            <p style="font-size:1rem; color:var(--text); line-height:1.8; margin-bottom:28px; font-weight: 500;">
                {{ $notif->isi }}
            </p>
            
            <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap: wrap; gap: 12px;">
                <span class="badge-read">
                    <i class="fas fa-check-circle"></i> Dibaca
                </span>
                <span style="font-size:0.82rem; color:var(--text-muted); font-weight:600;">
                    {{ $notif->time }}
                </span>
            </div>
        </div>
    </div>

</div>
@endsection
