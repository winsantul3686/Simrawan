@extends('layouts.app')

@section('title', 'Login - SiMrawan')

@section('no-sidebar')
@endsection

@section('content')
<div class="login-page">
    <div class="login-deco top-left">🐟</div>
    <div class="login-deco top-right">🐠</div>
    <div class="login-deco bot-left">🐡</div>
    <div class="login-deco bot-right">🐟</div>

    <div class="login-box">
        <div class="login-brand">
            <div class="logo"><span class="logo-si">Si</span><span class="logo-m">M</span><span class="logo-rawan">rawan</span></div>
            <div class="sub">Mrawan Fish Farm</div>
        </div>

        <h2>LOGIN</h2>
        <p class="sub">Masukkan email dan password anda</p>

        @if(session('error'))
            <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
        @endif
        @if(session('success'))
            <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="username">Email / Username</label>
                <div class="input-icon">
                    <i class="fas fa-user"></i>
                    <input type="text" id="username" name="username"
                           placeholder="Email atau username"
                           value="{{ old('username') }}" required>
                </div>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-icon">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password" name="password"
                           placeholder="Masukkan Password" required>
                </div>
            </div>
            <button type="submit" class="login-btn">
                Login &rarr;
            </button>
        </form>

        <div class="login-links">
            Belum punya akun? <a href="{{ route('register') }}">Register</a>
        </div>
        <a href="{{ route('beranda') }}" class="login-back">&larr; Kembali ke beranda</a>
    </div>
</div>
@endsection