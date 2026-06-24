<nav class="pub-navbar">
    <div class="pub-brand">
        <a href="{{ session('customer_id') ? route('customer.produk') : route('beranda') }}" style="text-decoration:none;">
            <div class="logo"><span class="logo-si">Si</span><span class="logo-m">M</span><span class="logo-rawan">rawan</span></div>
            <div class="sub">Mrawan Fish Farm</div>
        </a>
    </div>
    
    <ul class="pub-menu">
        @if(!session('customer_id'))
            <li><a href="{{ route('beranda') }}" class="{{ request()->routeIs('beranda') ? 'active' : '' }}">Beranda</a></li>
        @endif
        <li><a href="{{ route('customer.produk') }}" class="{{ request()->routeIs('customer.produk') ? 'active' : '' }}">Produk</a></li>
        
        {{-- Jika customer login, menu Wishlist, Riwayat, dan Profil akan muncul sejajar di sini --}}
        @if(session('customer_id'))
            <li><a href="{{ route('customer.wishlist') }}" class="{{ request()->routeIs('customer.wishlist') ? 'active' : '' }}">Wishlist</a></li>
            <li><a href="{{ route('customer.riwayat') }}" class="{{ request()->routeIs('customer.riwayat') ? 'active' : '' }}">Riwayat</a></li>
            <li><a href="{{ route('customer.profil') }}" class="{{ request()->routeIs('customer.profil') ? 'active' : '' }}">Profil</a></li>
        @endif
    </ul>
    
    <div class="pub-auth">
        @if(session('customer_id'))
            @php
                $unreadTrans = \App\Models\Transaksi::where('customer_id', session('customer_id'))->where('is_read', false)->count();
                $unreadWish = \App\Models\Wishlist::where('customer_id', session('customer_id'))->where('is_read', false)->count();
                $unreadCount = $unreadTrans + $unreadWish;
            @endphp
            <a href="{{ route('customer.notifikasi') }}" style="color:var(--primary);font-size:1.15rem;margin-right:12px;text-decoration:none;display:inline-flex;align-items:center;position:relative;transition:transform 0.2s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                <i class="far fa-bell"></i>
                @if($unreadCount > 0)
                    <span style="position:absolute;top:-7px;right:-7px;background:#ff1744;color:#fff;font-size:0.62rem;font-weight:800;border-radius:50%;width:15px;height:15px;display:flex;align-items:center;justify-content:center;box-shadow:0 1px 4px rgba(255,23,68,0.4);border:1px solid #fff;">
                        {{ $unreadCount }}
                    </span>
                @endif
            </a>
            
            <span style="font-weight:700;font-size:0.88rem;color:var(--dark);margin-right:16px;display:inline-flex;align-items:center;">
                {{ session('customer_nama', 'Customer') }}
            </span>
            
            <form action="{{ route('logout') }}" method="POST" style="margin:0; display:inline-flex; flex-direction:column; align-items:center; vertical-align:middle;">
                @csrf
                <button type="submit" style="background:none;border:none;cursor:pointer;display:inline-flex;flex-direction:column;align-items:center;padding:0;transition:transform 0.2s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                    <i class="fas fa-sign-out-alt" style="color:#00bcd4;font-size:1.1rem;margin-bottom:1px;"></i>
                    <span style="font-size:0.62rem;font-weight:700;color:#7c4dff;line-height:1;">Logout</span>
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" class="link-login">Login</a>
            <a href="{{ route('register') }}" class="link-register">Register</a>
        @endif
    </div>
</nav>