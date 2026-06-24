@props(['username' => 'Admin'])

<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="logo">
            <span class="logo-si">Si</span><span class="logo-m">M</span><span class="logo-rawan">rawan</span>
        </div>
        <div class="sub">Mrawan Fish Farm</div>
    </div>

    <span class="sidebar-section">Utama</span>
    <ul class="sidebar-nav">
        <li>
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i> Halaman Utama
            </a>
        </li>
        <li>
            <a href="{{ route('stok.index') }}" class="{{ request()->routeIs('stok.*') ? 'active' : '' }}">
                <i class="fas fa-boxes"></i> Manajemen Stok
            </a>
        </li>
        <li>
            <a href="{{ route('katalog.index') }}" class="{{ request()->routeIs('katalog.*') ? 'active' : '' }}">
                <i class="fas fa-fish"></i> Katalog Produk
            </a>
        </li>
        <li>
            <a href="{{ route('transaksi.index') }}" class="{{ request()->routeIs('transaksi.*') ? 'active' : '' }}">
                <i class="fas fa-exchange-alt"></i> Transaksi
            </a>
        </li>
        <li>
            <a href="{{ route('laporan.index') }}" class="{{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i> Laporan Keuangan
            </a>
        </li>
    </ul>

    <hr class="sidebar-divider">
    <span class="sidebar-section">Sistem</span>
    <ul class="sidebar-nav">
        <li>
            <a href="{{ route('notifikasi.index') }}" class="{{ request()->routeIs('notifikasi.*') ? 'active' : '' }}">
                <i class="fas fa-bell"></i> Notifikasi
                @php
                    $unreadCount = \App\Models\Notifikasi::where('status','belum_dibaca')->count();
                @endphp
                @if($unreadCount > 0)
                    <span style="margin-left:auto;background:var(--danger);color:#fff;font-size:0.6rem;padding:2px 6px;border-radius:10px;display:inline-flex;align-items:center;justify-content:center;min-height:16px;">{{ $unreadCount }}</span>
                @endif
            </a>
        </li>
        <li>
            <a href="{{ route('profil.index') }}" class="{{ request()->routeIs('profil.*') ? 'active' : '' }}">
                <i class="fas fa-user-circle"></i> Profil Admin
            </a>
        </li>
        <li>
            <a href="{{ route('wishlist.index') }}" class="{{ request()->routeIs('wishlist.*') ? 'active' : '' }}">
                <i class="fas fa-heart"></i> Wishlist
            </a>
        </li>
    </ul>

    <div class="sidebar-user">
        <div class="avatar">{{ strtoupper(substr($username, 0, 1)) }}</div>
        <div class="info">
            <div class="name">{{ $username }}</div>
            <div class="role">Administrator</div>
        </div>
    </div>
</aside>