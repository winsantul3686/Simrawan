<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiMrawan - Mrawan Fish Farm</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        /* ===== NAVBAR ===== */
        .pub-navbar {
            display: flex; align-items: center; padding: 14px 48px;
            background: #fff; box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            position: sticky; top: 0; z-index: 100; gap: 20px;
        }
        .pub-brand .logo { font-size: 1.5rem; font-weight: 700; line-height:1; }
        .pub-brand .logo-si { color: var(--primary); font-style: italic; }
        .pub-brand .logo-m  { color: var(--primary); font-size: 1.8rem; }
        .pub-brand .logo-rawan { color: var(--dark); }
        .pub-brand .sub { font-size: 0.62rem; color: #999; }
        .pub-menu { display:flex; list-style:none; gap:6px; background:#f5f5f5; border-radius:30px; padding:5px 10px; margin:0 auto; }
        .pub-menu li a { text-decoration:none; color:#666; font-size:0.83rem; padding:6px 16px; border-radius:20px; transition:all 0.2s; }
        .pub-menu li a:hover { background:#fff; color:var(--primary); }
        .pub-auth { display:flex; gap:10px; align-items:center; }
        .link-login  { color:var(--primary); text-decoration:none; font-weight:600; font-size:0.88rem; }
        .link-register { background:linear-gradient(135deg,var(--primary),var(--accent)); color:#fff; padding:8px 22px; border-radius:20px; text-decoration:none; font-size:0.83rem; font-weight:600; }

        /* ===== HERO ===== */
        .hero { display:flex; align-items:center; padding:60px 48px; gap:40px; min-height:480px; }
        .hero-text { flex:1; }
        .hero-text h1 { font-size:2.4rem; font-weight:800; line-height:1.2; margin-bottom:16px; }
        .hero-text p  { color:var(--text-muted); font-size:0.92rem; margin-bottom:28px; max-width:420px; line-height:1.7; }
        .hero-btns { display:flex; gap:12px; margin-bottom:32px; }
        .btn-hero-primary {
            background:linear-gradient(135deg,var(--primary),var(--accent));
            color:#fff; padding:12px 28px; border-radius:30px; border:none;
            font-family:inherit; font-size:0.9rem; font-weight:700; cursor:pointer;
            text-decoration:none; display:inline-flex; align-items:center; gap:8px;
        }
        .btn-hero-secondary {
            background:#fff; color:var(--text); padding:12px 28px; border-radius:30px;
            border:1.5px solid var(--border); font-family:inherit; font-size:0.9rem;
            font-weight:600; cursor:pointer; text-decoration:none;
        }
        .hero-stats { display:flex; gap:32px; }
        .hero-stat .val { font-size:1.4rem; font-weight:700; }
        .hero-stat .lbl { font-size:0.7rem; color:var(--text-muted); }
        .hero-img { flex:1; max-width:520px; }
        .hero-img-box {
            border-radius:24px; overflow:hidden; background:linear-gradient(135deg,#e0f7fa,#b2ebf2);
            height:320px; display:flex; align-items:center; justify-content:center;
            position:relative;
        }
        .hero-img-box .fish-emoji { font-size:8rem; filter:drop-shadow(0 8px 24px rgba(0,188,212,0.3)); }
        .hero-nav-btn {
            position:absolute; top:50%; transform:translateY(-50%);
            width:36px; height:36px; border-radius:50%; background:rgba(255,255,255,0.8);
            border:none; cursor:pointer; font-size:1rem; color:var(--dark);
            display:flex; align-items:center; justify-content:center;
        }
        .hero-nav-btn.left  { left:12px; }
        .hero-nav-btn.right { right:12px; }

        /* ===== WHY ===== */
        .section { padding: 60px 48px; }
        .section-title { text-align:center; font-size:1.5rem; font-weight:700; margin-bottom:8px; }
        .section-sub   { text-align:center; color:var(--text-muted); font-size:0.87rem; margin-bottom:40px; }
        .why-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:16px; }
        .why-card {
            border:1.5px solid var(--border); border-radius:14px; padding:20px;
            transition:box-shadow 0.2s;
        }
        .why-card:hover { box-shadow:0 4px 20px rgba(0,188,212,0.12); border-color:var(--primary); }
        .why-card .icon { font-size:1.8rem; margin-bottom:10px; }
        .why-card h4 { font-size:0.88rem; font-weight:700; margin-bottom:6px; }
        .why-card p  { font-size:0.76rem; color:var(--text-muted); line-height:1.6; }

        /* ===== KATALOG ===== */
        .katalog-section { background:var(--gray); }
        .pub-katalog-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:20px; }
        .pub-katalog-card {
            background:#fff; border-radius:16px; overflow:hidden;
            box-shadow:0 2px 12px rgba(0,0,0,0.06);
        }
        .pub-katalog-card .card-img {
            height:180px; background:linear-gradient(135deg,#e0f7fa,#b2ebf2);
            display:flex; align-items:center; justify-content:center; font-size:4rem;
        }
        .pub-katalog-card .card-img img { width:100%; height:100%; object-fit:cover; }
        .pub-katalog-card .card-body { padding:16px; }
        .pub-katalog-card .fish-name { font-weight:700; font-size:0.95rem; }
        .pub-katalog-card .fish-size { font-size:0.72rem; color:var(--text-muted); margin-bottom:8px; }
        .pub-katalog-card .meta { display:flex; justify-content:space-between; align-items:center; margin-bottom:4px; }
        .pub-katalog-card .meta label { font-size:0.72rem; color:var(--text-muted); }
        .pub-katalog-card .meta span  { font-size:0.82rem; font-weight:600; }
        .pub-katalog-card .price { color:var(--primary); }
        .pub-katalog-card .desc { font-size:0.75rem; color:var(--text-muted); margin-top:8px; padding-top:8px; border-top:1px solid var(--border); }
        .btn-pesan {
            width:100%; margin:12px 0 0; padding:10px;
            background:linear-gradient(135deg,var(--primary),var(--accent));
            color:#fff; border:none; border-radius:10px; font-family:inherit;
            font-size:0.85rem; font-weight:700; cursor:pointer;
            display:flex; align-items:center; justify-content:center; gap:8px;
        }

        /* ===== FOOTER ===== */
        .pub-footer { background:var(--dark); color:#ccc; padding:50px 48px 20px; }
        .pub-footer-inner { display:flex; gap:60px; margin-bottom:30px; }
        .footer-brand { flex:1.2; }
        .footer-brand .logo { font-size:1.4rem; font-weight:700; }
        .footer-brand .logo-si, .footer-brand .logo-m { color:var(--primary); font-style:italic; }
        .footer-brand .logo-m { font-size:1.7rem; }
        .footer-brand .logo-rawan { color:#fff; }
        .footer-brand .sub { font-size:0.62rem; color:rgba(255,255,255,0.4); }
        .footer-brand p { font-size:0.78rem; color:rgba(255,255,255,0.5); margin-top:10px; line-height:1.7; max-width:280px; }
        .footer-links { display:flex; gap:48px; }
        .footer-links h4 { color:#fff; font-size:0.82rem; font-weight:700; margin-bottom:14px; }
        .footer-links ul { list-style:none; }
        .footer-links ul li { margin-bottom:8px; }
        .footer-links ul li a { color:rgba(255,255,255,0.55); font-size:0.78rem; text-decoration:none; transition:color 0.2s; }
        .footer-links ul li a:hover { color:var(--primary); }
        .footer-bottom { border-top:1px solid rgba(255,255,255,0.1); padding-top:16px; text-align:center; font-size:0.72rem; color:rgba(255,255,255,0.35); }
    </style>
</head>
<body style="background:#fff;">

{{-- Navbar --}}
<nav class="pub-navbar">
    <div class="pub-brand">
        <div class="logo"><span class="logo-si">Si</span><span class="logo-m">M</span><span class="logo-rawan">rawan</span></div>
        <div class="sub">Mrawan Fish Farm</div>
    </div>
    <ul class="pub-menu">
        <li><a href="#beranda">Beranda</a></li>
        <li><a href="#produk">Produk</a></li>
        <li><a href="#">Wishlist</a></li>
        <li><a href="#">Riwayat</a></li>
    </ul>
    <div class="pub-auth">
        <a href="{{ route('login') }}" class="link-login">Login</a>
        <a href="{{ route('register') }}" class="link-register">Register</a>
    </div>
</nav>

{{-- Hero --}}
<section class="hero" id="beranda">
    <div class="hero-text">
        <h1>Ikan Segar dari<br>Mrawan Fish Farm</h1>
        <p>Platform digital untuk pemesanan ikan segar berkualitas tinggi. Pantau stok, pesan online, dan nikmati kemudahan transaksi.</p>
        <div class="hero-btns">
            <a href="#produk" class="btn-hero-primary">Lihat produk kami &rarr;</a>
            <a href="{{ route('register') }}" class="btn-hero-secondary">Daftar sekarang</a>
        </div>
        <div class="hero-stats">
            <div class="hero-stat">
                <div class="val">150+</div>
                <div class="lbl">Kultura Tersedia</div>
            </div>
            <div class="hero-stat">
                <div class="val">100%</div>
                <div class="lbl">Organik</div>
            </div>
            <div class="hero-stat">
                <div class="val">15++</div>
                <div class="lbl">Mitra Bisnis</div>
            </div>
        </div>
    </div>
    <div class="hero-img">
        <div class="hero-img-box">
            <span class="fish-emoji">🐟</span>
            <button class="hero-nav-btn left"><i class="fas fa-chevron-left"></i></button>
            <button class="hero-nav-btn right"><i class="fas fa-chevron-right"></i></button>
        </div>
    </div>
</section>

{{-- Why SiMrawan --}}
<section class="section" style="background:#fafbff;">
    <h2 class="section-title">Kenapa Memilih SiMrawan?</h2>
    <p class="section-sub">Dipanen langsung dari kolam kami dengan standar kualitas terbaik<br>untuk memastikan kesegaran dan nutrisi optimal</p>
    <div class="why-grid">
        <div class="why-card">
            <div class="icon">🛒</div>
            <h4>Pesan Online Mudah</h4>
            <p>Lihat katalog produk, beri stok dan lakukan permintaan pesanan kapan saja dengan mudah via platform digital.</p>
        </div>
        <div class="why-card">
            <div class="icon">👥</div>
            <h4>Stok Real-Time</h4>
            <p>Pantau stok ikan secara langsung. Dapatkan informasi ketersediaan ikan dan update Stok real-time.</p>
        </div>
        <div class="why-card">
            <div class="icon">💳</div>
            <h4>Pembayaran Mudah</h4>
            <p>Upload bukti transfer pembayaran modern untuk mengkonfirmasi pesanan Anda dengan cepat.</p>
        </div>
        <div class="why-card">
            <div class="icon">⭐</div>
            <h4>Kualitas Terjamin</h4>
            <p>Ikan lele dipanen dengan standar tinggi, dipastikan dari kualitas tinggi, dipanen dengan baik dan dijamin selalu segar.</p>
        </div>
    </div>
</section>

{{-- Katalog --}}
<section class="section katalog-section" id="produk">
    <h2 class="section-title">Ikan Segar Berkualitas Premium</h2>
    <p class="section-sub">Dipanen langsung dari kolam kami dengan standar kualitas terbaik<br>untuk memastikan kesegaran dan nutrisi optimal</p>

    <div style="margin-bottom:16px;">
        <span style="font-weight:700;font-size:1rem;">Katalog Produk</span>
        <p style="font-size:0.8rem;color:var(--text-muted);">Pilih ikan segar berkualitas</p>
    </div>

    @if($produkUnggulan->isEmpty())
    <div style="text-align:center;padding:40px;color:var(--text-muted);">
        <div style="font-size:3rem;margin-bottom:12px;">🐟</div>
        Produk segera tersedia. Daftarkan akun untuk info terbaru!
    </div>
    @else
    <div class="pub-katalog-grid">
        @foreach($produkUnggulan as $p)
        <div class="pub-katalog-card">
            <div class="card-img">
                @if($p->gambar)
                    <img src="{{ asset('uploads/'.$p->gambar) }}" alt="{{ $p->stokIkan->jenis_ikan }}">
                @else
                    🐟
                @endif
            </div>
            <div class="card-body">
                <div class="fish-name">{{ $p->stokIkan->jenis_ikan }}</div>
                <div class="fish-size">{{ $p->stokIkan->ukuran_sortasi }}</div>
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:4px;">
                    <span class="badge badge-primary" style="font-size:0.68rem;">Tersedia</span>
                </div>
                <div class="meta">
                    <label>Harga</label>
                    <span class="price">Rp {{ number_format($p->stokIkan->harga_jual,0,',','.') }}/Kg</span>
                </div>
                <div class="meta">
                    <label>Stok</label>
                    <span>{{ number_format($p->stokIkan->jumlah_stok,0) }} Kg</span>
                </div>
                <div class="meta">
                    <label>Min Order</label>
                    <span>5/Kg</span>
                </div>
                @if($p->deskripsi)
                <div class="desc">{{ $p->deskripsi }}</div>
                @endif
                <a href="{{ route('login') }}" class="btn-pesan">
                    🛒 Pesan
                </a>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</section>

{{-- Footer --}}
<footer class="pub-footer">
    <div class="pub-footer-inner">
        <div class="footer-brand">
            <div class="logo"><span class="logo-si">Si</span><span class="logo-m">M</span><span class="logo-rawan">rawan</span></div>
            <div class="sub">Mrawan Fish Farm</div>
            <p>Sistem informasi manajemen operasional untuk Mrawan Fish Farm. Mempermudah transaksi dan pengelolaan stok ikan lele.</p>
        </div>
        <div class="footer-links">
            <div>
                <h4>Menu</h4>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Katalog Produk</a></li>
                    <li><a href="#">Cara Pemesanan</a></li>
                    <li><a href="#">Tentang Kami</a></li>
                </ul>
            </div>
            <div>
                <h4>Akun</h4>
                <ul>
                    <li><a href="{{ route('login') }}">Login</a></li>
                    <li><a href="{{ route('register') }}">Daftar</a></li>
                    <li><a href="#">Riwayat Pesanan</a></li>
                    <li><a href="#">Wishlist</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <p>© 2026 SiMrawan — Mrawan Fish Farm. Dibuat oleh Tim B6 Universitas Jember.</p>
    </div>
</footer>

</body>
</html>