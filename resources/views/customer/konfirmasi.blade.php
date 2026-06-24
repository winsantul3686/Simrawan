@extends('layouts.app')

@section('title', 'Konfirmasi Pesanan - SiMrawan')

@section('no-sidebar')
@endsection

@section('styles')
<style>
    .readonly-input {
        border: 1.5px solid transparent !important;
        background: linear-gradient(#fff, #fff) padding-box,
                    linear-gradient(135deg, var(--primary), var(--accent)) border-box !important;
        border-radius: 10px;
        padding: 12px 16px;
        font-family: inherit;
        font-size: 0.88rem;
        color: var(--text);
        width: 100%;
        outline: none;
        box-shadow: 0 2px 5px rgba(0,0,0,0.02);
    }
    .upload-icon-circle {
        transition: all 0.3s ease;
    }
    .upload-icon-circle:hover {
        transform: scale(1.1);
        background: #e0f7fa !important;
        color: var(--accent) !important;
    }
    .btn-submit-konfirmasi {
        width: 100%;
        justify-content: center;
        padding: 14px;
        border-radius: 12px;
        background: #00c853;
        border: none;
        font-size: 0.95rem;
        font-weight: 800;
        color: #fff;
        box-shadow: 0 4px 15px rgba(0,200,83,0.25);
        transition: all 0.3s ease;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-submit-konfirmasi:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 200, 83, 0.35);
        opacity: 0.95;
    }
    .btn-submit-konfirmasi:active {
        transform: translateY(0);
    }
</style>
@endsection

@section('content')
@include('components.navbar-customer')

<div style="min-height:calc(100vh - 64px);display:flex;align-items:center;justify-content:center;padding:40px 24px;background:linear-gradient(135deg,#f0fffe,#f3f0ff);">
    <div style="background:#fff;border-radius:22px;box-shadow:0 8px 40px rgba(0,0,0,0.08);width:100%;max-width:580px;overflow:hidden;border:1px solid rgba(0,0,0,0.03);">

        {{-- Header --}}
        <div style="background:linear-gradient(135deg,var(--primary),var(--accent));padding:28px 32px;color:#fff;">
            <div style="font-size:0.8rem;opacity:0.85;margin-bottom:4px;">Pesanan berhasil dibuat!</div>
            <div style="font-size:1.3rem;font-weight:800;">Konfirmasi Pembayaran</div>
            <div style="font-size:0.82rem;opacity:0.8;margin-top:6px;">Upload bukti transfer untuk menyelesaikan pesanan Anda</div>
        </div>

        <div style="padding:32px;">
            @if(session('error'))
                <div class="alert alert-error" style="margin-bottom: 20px;"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
            @endif

            {{-- No. Pesanan & Total Harga --}}
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px;">
                <div class="form-group" style="margin-bottom:0;">
                    <label style="font-weight: 700; color: var(--dark); font-size: 0.85rem; margin-bottom: 8px; display: block; letter-spacing: 0.3px;">No. Pesanan</label>
                    <input type="text" value="{{ $transaksi->no_pesanan }}" readonly class="readonly-input">
                </div>
                <div class="form-group" style="margin-bottom:0;">
                    <label style="font-weight: 700; color: var(--dark); font-size: 0.85rem; margin-bottom: 8px; display: block; letter-spacing: 0.3px;">Total Harga</label>
                    <input type="text" value="Rp {{ number_format($transaksi->total_harga,0,',','.') }}" readonly class="readonly-input" style="color:var(--primary); font-weight:800;">
                </div>
            </div>

            {{-- Batas Waktu Pembayaran --}}
            <div style="margin-bottom: 20px;">
                <label style="font-weight: 700; color: var(--dark); font-size: 0.85rem; margin-bottom: 8px; display: block; letter-spacing: 0.3px;">Bukti Pembayaran</label>
                <div style="display:flex;justify-content:flex-end;">
                    <span id="countdown_timer" data-target="{{ \Carbon\Carbon::parse($transaksi->created_at)->addDay()->toIso8601String() }}" style="background:#00bcd4;color:#fff;font-size:0.75rem;padding:6px 14px;border-radius:20px;font-weight:700;box-shadow: 0 2px 8px rgba(0, 188, 212, 0.15); transition: background 0.3s;">
                        Batas Waktu Pembayaran : {{ \Carbon\Carbon::parse($transaksi->created_at)->addDay()->format('d M Y, H:i') }} WIB
                    </span>
                </div>
            </div>

            {{-- Upload Bukti & QRIS Box --}}
            <form action="{{ route('customer.pesanan.upload', $transaksi->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div style="border:2px solid rgba(0,188,212,0.25);border-radius:16px;padding:24px;margin-bottom:24px;display:grid;grid-template-columns:1.2fr 1fr;gap:20px;align-items:center;background:#fff;position:relative;">
                    
                    {{-- QRIS Section (Left) --}}
                    <div style="text-align:center;border-right:1.5px solid var(--border);padding-right:20px;">
                        <img src="{{ asset('images/qris.png') }}" alt="QRIS Code" style="width:100%;max-width:180px;height:auto;border-radius:8px;box-shadow:0 3px 12px rgba(0,0,0,0.06);display:block;margin:0 auto;">
                    </div>
                    
                    {{-- Upload Area (Right) --}}
                    <div style="text-align:center;">
                        <label for="bukti_input" style="cursor:pointer;display:flex;flex-direction:column;align-items:center;gap:12px;">
                            <div class="upload-icon-circle" style="width:56px;height:56px;border-radius:50%;background:#f0fdfe;display:flex;align-items:center;justify-content:center;color:var(--primary);">
                                <i class="fas fa-arrow-up-from-bracket" style="font-size:1.4rem;"></i>
                            </div>
                            <span class="btn-gradient" style="background:linear-gradient(135deg,var(--primary),var(--accent));color:#fff;border:none;border-radius:20px;font-size:0.75rem;font-weight:700;padding:8px 18px;pointer-events:none;box-shadow: 0 4px 12px rgba(0,188,212,0.15);">
                                Upload File
                            </span>
                            <span id="file_name" style="font-size:0.68rem;color:var(--text-muted);margin-top:2px;display:block;max-width:150px;word-break:break-all;line-height:1.4;">
                                JPG, PNG, atau PDF · Maks 2MB
                            </span>
                        </label>
                        <input type="file" id="bukti_input" name="bukti_bayar" accept=".jpg,.jpeg,.png,.pdf" required style="display:none;" onchange="showFileName(this)">
                    </div>
                </div>

                <button type="submit" class="btn-submit-konfirmasi">
                    <i class="fas fa-check-circle"></i> Konfirmasi Pesanan
                </button>
            </form>

            <a href="{{ route('customer.riwayat') }}"
               style="display:block;text-align:center;margin-top:16px;font-size:0.82rem;color:var(--text-muted);text-decoration:none;transition:color 0.2s;font-weight:600;"
               onmouseover="this.style.color='var(--primary)'"
               onmouseout="this.style.color='var(--text-muted)'">
                <i class="fas fa-clock"></i> Bayar nanti → Lihat di Riwayat
            </a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function showFileName(input) {
    const span = document.getElementById('file_name');
    if (input.files && input.files[0]) {
        span.textContent = '✅ ' + input.files[0].name;
        span.style.color = 'var(--success)';
        span.style.fontWeight = '700';
    }
}

function startCountdown() {
    const el = document.getElementById('countdown_timer');
    if (!el) return;
    
    const targetDate = new Date(el.getAttribute('data-target')).getTime();
    const dateStr = "{{ \Carbon\Carbon::parse($transaksi->created_at)->addDay()->format('d M Y, H:i') }} WIB";
    
    function updateTimer() {
        const now = new Date().getTime();
        const distance = targetDate - now;
        
        if (distance < 0) {
            el.innerHTML = 'Batas Waktu Pembayaran : Telah Habis';
            el.style.background = 'var(--danger)';
            el.style.boxShadow = '0 2px 8px rgba(229, 57, 53, 0.3)';
            return;
        }
        
        const hours = Math.floor(distance / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
        const pad = (num) => String(num).padStart(2, '0');
        el.innerHTML = `Batas Waktu Pembayaran : ${dateStr} (Sisa ${pad(hours)}:${pad(minutes)}:${pad(seconds)})`;
    }
    
    updateTimer();
    setInterval(updateTimer, 1000);
}

document.addEventListener('DOMContentLoaded', startCountdown);
</script>
@endsection