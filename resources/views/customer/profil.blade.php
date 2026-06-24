@extends('layouts.app')

@section('title', 'Profil - SiMrawan')

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
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 2px 5px rgba(0,0,0,0.02);
    }
    .readonly-input:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(124, 77, 255, 0.08);
    }
    .profile-card {
        border: 1.5px solid transparent;
        background: linear-gradient(#fff, #fff) padding-box,
                    linear-gradient(135deg, var(--primary), var(--accent)) border-box;
        border-radius: 20px;
        padding: 48px;
        box-shadow: 0 10px 30px rgba(124, 77, 255, 0.05), 0 1px 3px rgba(0, 188, 212, 0.05);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .profile-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 20px 40px rgba(124, 77, 255, 0.08), 0 1px 8px rgba(0, 188, 212, 0.05);
    }
    .avatar-glow {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .avatar-glow:hover {
        transform: scale(1.05) rotate(3deg);
        box-shadow: 0 8px 25px rgba(0, 188, 212, 0.35);
    }
    .reset-pass-btn {
        background: none;
        border: none;
        color: var(--primary);
        font-family: inherit;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        padding: 0;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: color 0.2s;
    }
    .reset-pass-btn:hover {
        color: var(--accent);
    }
    .modal-box input, .modal-box textarea {
        border: 1.5px solid var(--border);
        border-radius: 8px;
        padding: 11px 14px;
        font-family: inherit;
        font-size: 0.88rem;
        color: var(--text);
        width: 100%;
        outline: none;
        transition: all 0.3s ease;
    }
    .modal-box input:focus, .modal-box textarea:focus {
        border-color: transparent;
        background: linear-gradient(#fff, #fff) padding-box,
                    linear-gradient(135deg, var(--primary), var(--accent)) border-box;
        box-shadow: 0 0 0 4px rgba(0, 188, 212, 0.15);
    }
    .btn-gradient {
        background: linear-gradient(135deg, var(--primary), var(--accent));
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 12px 20px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        justify-content: center;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 188, 212, 0.2);
        font-family: inherit;
        font-size: 0.88rem;
    }
    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(124, 77, 255, 0.3);
        opacity: 0.95;
    }
    .btn-gradient:active {
        transform: translateY(0);
    }
</style>
@endsection

@section('content')
@include('components.navbar-customer')

<div style="padding:48px;max-width:100%;">

    @if(session('success'))
        <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
    @endif

    <div class="profile-card" style="max-width: 900px; margin: 0 auto;">

        {{-- Header --}}
        <div style="display:flex;align-items:center;gap:24px;margin-bottom:32px;">
            <div class="avatar-glow" style="width:100px;height:100px;border-radius:50%;
                background:linear-gradient(135deg, var(--primary), var(--accent));
                display:flex;align-items:center;justify-content:center;
                font-size:2.5rem;font-weight:700;color:#fff;flex-shrink:0;box-shadow:0 4px 15px rgba(0,188,212,0.2);">
                {{ strtoupper(substr($customer->nama, 0, 1)) }}
            </div>
            <div>
                <button onclick="openModal('modal-edit-profil')"
                    style="background:none;border:none;color:var(--accent);font-family:inherit;font-size:0.88rem;font-weight:700;cursor:pointer;display:flex;align-items:center;gap:6px;margin-bottom:6px;padding:0;transition:color 0.2s;" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='var(--accent)'">
                    <i class="far fa-edit"></i> Edit Profil
                </button>
                <div style="font-size:1.6rem;font-weight:800;color:var(--dark);line-height:1.2;">{{ $customer->nama }}</div>
                <div style="font-size:0.85rem;color:var(--text-muted);font-weight:600;margin-top:2px;">Role customer</div>
            </div>
        </div>

        {{-- Info (Read Only) --}}
        <div class="form-row" style="margin-bottom: 20px;">
            <div class="form-group" style="margin-bottom: 0;">
                <label style="font-weight: 700; color: var(--dark); font-size: 0.85rem; margin-bottom: 8px; display: block; letter-spacing: 0.3px;">Nama</label>
                <input type="text" value="{{ $customer->nama }}" readonly class="readonly-input">
            </div>
            <div class="form-group" style="margin-bottom: 0;">
                <label style="font-weight: 700; color: var(--dark); font-size: 0.85rem; margin-bottom: 8px; display: block; letter-spacing: 0.3px;">No.Telepon</label>
                <input type="text" value="{{ $customer->no_telp ?? '-' }}" readonly class="readonly-input">
            </div>
        </div>
        
        <div class="form-group" style="margin-bottom: 20px;">
            <label style="font-weight: 700; color: var(--dark); font-size: 0.85rem; margin-bottom: 8px; display: block; letter-spacing: 0.3px;">Email</label>
            <input type="text" value="{{ $customer->email ?? '-' }}" readonly class="readonly-input">
        </div>
        
        <div class="form-group" style="margin-bottom: 24px;">
            <label style="font-weight: 700; color: var(--dark); font-size: 0.85rem; margin-bottom: 8px; display: block; letter-spacing: 0.3px;">Alamat</label>
            <textarea readonly rows="3" class="readonly-input" style="resize:none;line-height:1.6;">{{ $customer->alamat ?? '-' }}</textarea>
        </div>

        <div style="margin-top:8px;">
            <button onclick="openModal('modal-reset-password')" class="reset-pass-btn">
                <i class="fas fa-key"></i> Reset Password
            </button>
        </div>
    </div>
</div>

{{-- Modal Edit Profil --}}
<div class="modal-overlay" id="modal-edit-profil">
    <div class="modal-box" style="max-width:560px;">
        <div class="modal-header">
            <h3><i class="fas fa-pen" style="color:var(--primary);"></i> Edit Profil</h3>
            <button class="modal-close" onclick="closeModal('modal-edit-profil')">&times;</button>
        </div>
        <form action="{{ route('customer.profil.update') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-row">
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="nama" value="{{ $customer->nama }}" required>
                </div>
                <div class="form-group">
                    <label>No. Telepon</label>
                    <input type="text" name="no_telp" value="{{ $customer->no_telp }}">
                </div>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ $customer->email }}">
            </div>
            <div class="form-group">
                <label>Alamat</label>
                <textarea name="alamat" rows="3" style="resize:vertical;">{{ $customer->alamat }}</textarea>
            </div>
            <button type="submit" class="btn-gradient" style="width:100%;margin-top:8px;">
                <i class="fas fa-save"></i> Simpan Perubahan
            </button>
        </form>
    </div>
</div>

{{-- Modal Reset Password --}}
<div class="modal-overlay" id="modal-reset-password">
    <div class="modal-box" style="max-width:460px;">
        <div class="modal-header">
            <h3><i class="fas fa-key" style="color:var(--primary);"></i> Reset Password</h3>
            <button class="modal-close" onclick="closeModal('modal-reset-password')">&times;</button>
        </div>
        <form action="{{ route('customer.profil.reset-password') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Password Lama</label>
                <div class="input-icon">
                    <i class="fas fa-lock" style="color:var(--primary); font-size:0.83rem;"></i>
                    <input type="password" name="password_lama" placeholder="••••••••" required>
                </div>
            </div>
            <div class="form-group">
                <label>Password Baru</label>
                <div class="input-icon">
                    <i class="fas fa-lock" style="color:var(--primary); font-size:0.83rem;"></i>
                    <input type="password" name="password_baru" placeholder="••••••••" required>
                </div>
            </div>
            <div class="form-group">
                <label>Konfirmasi Password Baru</label>
                <div class="input-icon">
                    <i class="fas fa-lock" style="color:var(--primary); font-size:0.83rem;"></i>
                    <input type="password" name="konfirmasi_baru" placeholder="••••••••" required>
                </div>
            </div>
            <button type="submit" class="btn-gradient" style="width:100%;margin-top:8px;">
                <i class="fas fa-save"></i> Simpan
            </button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
@if(session('error') && str_contains(session('error', ''), 'Password'))
    openModal('modal-reset-password');
@endif
</script>
@endsection