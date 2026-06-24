@extends('layouts.app')

@section('title', 'Daftar Akun - SiMrawan')

@section('no-sidebar')
@endsection

@section('content')
<div class="login-page">
    <div class="login-deco top-left">🐟</div>
    <div class="login-deco top-right">🐠</div>
    <div class="login-deco bot-left">🐡</div>
    <div class="login-deco bot-right">🐟</div>

    <div class="login-box" style="max-width:560px;">
        <div class="login-brand">
            <div class="logo"><span class="logo-si">Si</span><span class="logo-m">M</span><span class="logo-rawan">rawan</span></div>
            <div class="sub">Mrawan Fish Farm</div>
        </div>

        <h2>Daftar Akun Baru</h2>
        <p class="sub">Lengkapi data diri Anda untuk membuat akun</p>

        @if($errors->any())
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                {{ $errors->first() }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
        @endif

        <form action="{{ route('register.post') }}" method="POST">
            @csrf

            <div class="form-row">
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <div class="input-icon">
                        <i class="fas fa-user"></i>
                        <input type="text" name="nama" placeholder="Nama lengkap anda"
                               value="{{ old('nama') }}" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>No. Telp</label>
                    <div class="input-icon">
                        <i class="fas fa-phone"></i>
                        <input type="text" name="no_telp" placeholder="08123456789"
                               value="{{ old('no_telp') }}" required>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Username</label>
                    <div class="input-icon">
                        <i class="fas fa-user-tag"></i>
                        <input type="text" name="username" placeholder="username_anda"
                               value="{{ old('username') }}" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <div class="input-icon">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" placeholder="nama@email.com"
                               value="{{ old('email') }}" required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Alamat</label>
                <div class="input-icon" style="align-items:flex-start;">
                    <i class="fas fa-map-marker-alt" style="top:14px;transform:none;"></i>
                    <textarea name="alamat" placeholder="Alamat lengkap anda"
                              style="padding-left:36px;resize:vertical;min-height:90px;"
                              required>{{ old('alamat') }}</textarea>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Password</label>
                    <div class="input-icon">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" placeholder="••••••••" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Konfirmasi Password</label>
                    <div class="input-icon">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="konfirmasi_password" placeholder="••••••••" required>
                    </div>
                </div>
            </div>

            <div class="form-group" style="display:flex;align-items:center;gap:10px;">
                <input type="checkbox" name="setuju" id="setuju" value="1"
                       style="width:16px;height:16px;accent-color:var(--primary);"
                       {{ old('setuju') ? 'checked' : '' }}>
                <label for="setuju" style="margin:0;font-weight:400;font-size:0.82rem;cursor:pointer;">
                    Saya menyetujui <a href="#" style="color:var(--primary);text-decoration:underline;">syarat dan ketentuan</a> yang berlaku
                </label>
            </div>

            <button type="submit" class="login-btn" style="margin-top:10px;">
                Daftar Sekarang &rarr;
            </button>
        </form>

        <div class="login-links">
            Sudah punya akun? <a href="{{ route('login') }}">Login</a>
        </div>
        <a href="{{ route('beranda') }}" class="login-back">&larr; Kembali ke beranda</a>
    </div>
</div>
@endsection

@section('styles')
<style>
.login-box .form-group textarea {
    width: 100%;
    border: 1px solid var(--border);
    border-radius: 8px;
    font-family: 'Poppins', sans-serif;
    font-size: 0.83rem;
    color: var(--text);
    padding: 9px 12px;
    outline: none;
    transition: border 0.2s;
}
.login-box .form-group textarea:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(0,188,212,0.12);
}
</style>
@endsection