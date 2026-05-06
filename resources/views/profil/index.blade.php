@extends('layouts.app')

@section('title', 'Profil Admin - SiMrawan')

@php $pageTitle = 'Profil Admin'; @endphp

@section('content')

<div style="max-width:780px;margin:0 auto;">
    <div class="card" style="border: 1.5px solid transparent;
        background: linear-gradient(#fff,#fff) padding-box,
        linear-gradient(135deg, var(--primary), var(--accent)) border-box;
        border-radius: 16px;">

        @if(session('success'))
            <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
        @endif

        {{-- Header Profil --}}
        <div style="display:flex;align-items:center;gap:20px;margin-bottom:28px;">
            <div style="width:90px;height:90px;border-radius:50%;
                background:linear-gradient(135deg,var(--primary),var(--accent));
                display:flex;align-items:center;justify-content:center;
                font-size:2.2rem;font-weight:700;color:#fff;flex-shrink:0;">
                {{ strtoupper(substr($admin->nama, 0, 1)) }}
            </div>
            <div>
                <button onclick="openModal('modal-edit-profil')"
                    style="background:none;border:none;color:var(--accent);font-family:inherit;font-size:0.85rem;font-weight:600;cursor:pointer;display:flex;align-items:center;gap:6px;margin-bottom:4px;padding:0;">
                    <i class="fas fa-pen"></i> Edit Profil
                </button>
                <div style="font-size:1.3rem;font-weight:700;">{{ $admin->nama }}</div>
                <div style="font-size:0.8rem;color:var(--text-muted);">Role admin</div>
            </div>
        </div>

        {{-- Info Fields (Read Only) --}}
        <div class="form-row">
            <div class="form-group">
                <label>Nama</label>
                <input type="text" value="{{ $admin->nama }}" readonly
                    style="background:#f9fafb;border-color:var(--primary);">
            </div>
            <div class="form-group">
                <label>No.Telepon</label>
                <input type="text" value="{{ $admin->no_telp ?? '-' }}" readonly
                    style="background:#f9fafb;border-color:var(--primary);">
            </div>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="text" value="{{ $admin->email ?? '-' }}" readonly
                style="background:#f9fafb;border-color:var(--primary);">
        </div>
        <div class="form-group">
            <label>Alamat</label>
            <textarea readonly rows="3" style="background:#f9fafb;border-color:var(--primary);
                width:100%;padding:9px 12px;border:1px solid;border-radius:8px;
                font-family:inherit;font-size:0.83rem;resize:none;">{{ $admin->alamat ?? '-' }}</textarea>
        </div>

        <div style="margin-top:8px;">
            <button onclick="openModal('modal-reset-password')"
                style="background:none;border:none;color:var(--primary);font-family:inherit;font-size:0.85rem;font-weight:600;cursor:pointer;padding:0;display:inline-flex;align-items:center;gap:6px;">
                <i class="fas fa-key"></i> Reset Password
            </button>
        </div>
    </div>
</div>

{{-- Modal Edit Profil --}}
<div class="modal-overlay" id="modal-edit-profil">
    <div class="modal" style="max-width:560px;">
        <div class="modal-header">
            <span class="modal-title"><i class="fas fa-pen" style="color:var(--primary);"></i> Edit Profil</span>
            <button class="modal-close" onclick="closeModal('modal-edit-profil')">&times;</button>
        </div>
        <form action="{{ route('profil.update') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-row">
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="nama" value="{{ $admin->nama }}" required>
                </div>
                <div class="form-group">
                    <label>No. Telepon</label>
                    <input type="text" name="no_telp" value="{{ $admin->no_telp }}">
                </div>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ $admin->email }}">
            </div>
            <div class="form-group">
                <label>Alamat</label>
                <textarea name="alamat" rows="3" style="width:100%;padding:9px 12px;border:1px solid var(--border);border-radius:8px;font-family:inherit;font-size:0.83rem;resize:vertical;">{{ $admin->alamat }}</textarea>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Reset Password --}}
<div class="modal-overlay" id="modal-reset-password">
    <div class="modal" style="max-width:520px;">
        <div class="modal-header">
            <span class="modal-title" style="font-size:1.1rem;">Reset Password</span>
            <button class="modal-close" onclick="closeModal('modal-reset-password')">&times;</button>
        </div>
        <form action="{{ route('profil.reset-password') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Password Lama</label>
                <div class="input-icon">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password_lama" placeholder="••••••••" required>
                </div>
            </div>
            <div class="form-group">
                <label>Password Baru</label>
                <div class="input-icon">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password_baru" placeholder="••••••••" required>
                </div>
            </div>
            <div class="form-group">
                <label>Konfirmasi Password Baru</label>
                <div class="input-icon">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="konfirmasi_baru" placeholder="••••••••" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
// Auto-open reset password modal if there was an error with it
@if(session('error') && str_contains(session('error',''), 'Password'))
    openModal('modal-reset-password');
@endif
</script>
@endsection