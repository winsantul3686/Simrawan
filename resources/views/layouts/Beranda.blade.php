<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="SiMrawan - Platform digital pemesanan ikan segar berkualitas tinggi dari Mrawan Fish Farm. Pesan online, pantau stok, dan nikmati kemudahan transaksi.">
    <title>SiMrawan - Mrawan Fish Farm</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        /* ===== BERANDA OVERRIDES ===== */
        body { background: #fff; }

        /* ===== HERO ===== */
        .hero {
            display: flex; align-items: center;
            padding: 72px 60px 60px; gap: 48px;
            min-height: 88vh;
            background: linear-gradient(135deg, #f0fffe 0%, #f7f5ff 100%);
            position: relative; overflow: hidden;
        }
        .hero::before {
            content: '';
            position: absolute; top: -120px; right: -120px;
            width: 600px; height: 600px; border-radius: 50%;
            background: radial-gradient(circle, rgba(0,188,212,0.1), transparent 70%);
        }
        .hero::after {
            content: '';
            position: absolute; bottom: -80px; left: -80px;
            width: 400px; height: 400px; border-radius: 50%;
            background: radial-gradient(circle, rgba(124,77,255,0.07), transparent 70%);
        }
        .hero-text { flex: 1; position: relative; z-index: 1; }
        .hero-badge {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(0,188,212,0.1); color: var(--primary);
            padding: 6px 16px; border-radius: 30px; font-size: 0.75rem;
            font-weight: 700; margin-bottom: 20px; border: 1px solid rgba(0,188,212,0.2);
        }
        .hero-text h1 {
            font-size: 3rem; font-weight: 800; line-height: 1.15;
            margin-bottom: 18px; color: var(--dark);
            letter-spacing: -1.5px;
        }
        .hero-text h1 span { color: var(--primary); }
        .hero-text p {
            color: var(--text-muted); font-size: 1rem;
            margin-bottom: 34px; max-width: 440px; line-height: 1.8;
        }
        .hero-btns { display: flex; gap: 14px; margin-bottom: 44px; flex-wrap: wrap; }
        .btn-hero-primary {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: #fff; padding: 14px 32px; border-radius: 50px; border: none;
            font-family: inherit; font-size: 0.95rem; font-weight: 700; cursor: pointer;
            text-decoration: none; display: inline-flex; align-items: center; gap: 10px;
            box-shadow: 0 6px 24px rgba(0,188,212,0.35);
            transition: all 0.25s;
        }
        .btn-hero-primary:hover { transform: translateY(-2px); box-shadow: 0 10px 32px rgba(0,188,212,0.42); }
        .btn-hero-secondary {
            background: #fff; color: var(--text);
            padding: 14px 32px; border-radius: 50px;
            border: 2px solid var(--border); font-family: inherit;
            font-size: 0.95rem; font-weight: 700; cursor: pointer;
            text-decoration: none; transition: all 0.2s;
        }
        .btn-hero-secondary:hover { border-color: var(--primary); color: var(--primary); }
        .hero-stats { display: flex; gap: 36px; flex-wrap: wrap; }
        .hero-stat {
            text-align: center;
        }
        .hero-stat .val {
            font-size: 1.6rem; font-weight: 800; color: var(--dark);
            letter-spacing: -1px;
        }
        .hero-stat .lbl { font-size: 0.68rem; color: var(--text-muted); font-weight: 500; margin-top: 2px; }
        .hero-stat-divider { width: 1px; background: var(--border); align-self: stretch; }

        /* Hero Image Slider */
        .hero-img { flex: 1.6; position: relative; z-index: 1; min-width: 0; }
        .hero-img-box {
            border-radius: 28px; overflow: hidden;
            height: 500px;
            position: relative;
            box-shadow: 0 24px 80px rgba(0,0,0,0.2);
        }
        /* Slider */
        .hero-slider { position: relative; width: 100%; height: 100%; }
        .hero-slide {
            position: absolute; inset: 0;
            opacity: 0; transition: opacity 0.6s ease;
            pointer-events: none;
        }
        .hero-slide.active { opacity: 1; pointer-events: auto; }
        .hero-slide img {
            width: 100%; height: 100%; object-fit: cover;
            display: block;
        }
        .hero-slide-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(180deg, transparent 40%, rgba(0,0,0,0.45) 100%);
        }
        .hero-slide-caption {
            position: absolute; bottom: 20px; left: 20px; right: 20px;
            color: #fff; font-size: 0.82rem; font-weight: 600;
            text-shadow: 0 1px 4px rgba(0,0,0,0.5);
        }
        /* Nav buttons */
        .slider-btn {
            position: absolute; top: 50%; transform: translateY(-50%);
            width: 38px; height: 38px; border-radius: 50%;
            background: rgba(255,255,255,0.9); border: none; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.9rem; color: #1e293b;
            box-shadow: 0 4px 16px rgba(0,0,0,0.15);
            z-index: 10; transition: all 0.2s;
        }
        .slider-btn:hover { background: #fff; transform: translateY(-50%) scale(1.08); }
        .slider-btn.prev { left: 12px; }
        .slider-btn.next { right: 12px; }
        /* Dots */
        .slider-dots {
            position: absolute; bottom: 14px; left: 50%; transform: translateX(-50%);
            display: flex; gap: 6px; z-index: 10;
        }
        .slider-dot {
            width: 7px; height: 7px; border-radius: 50%;
            background: rgba(255,255,255,0.5); border: none; cursor: pointer;
            transition: all 0.2s; padding: 0;
        }
        .slider-dot.active { background: #fff; width: 20px; border-radius: 4px; }
        /* Float badges */
        .hero-float-badge {
            position: absolute;
            background: #fff;
            border-radius: 16px;
            padding: 12px 16px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.12);
            font-size: 0.78rem;
            font-weight: 700;
            z-index: 20;
        }
        .hero-float-badge.top-right { top: 24px; right: -12px; color: var(--success); }
        .hero-float-badge.bot-left { bottom: 28px; left: -12px; color: var(--primary); }
        .hero-float-badge .badge-icon { font-size: 1.2rem; display: block; margin-bottom: 2px; }

        /* ===== SECTION BASE ===== */
        .section { padding: 80px 60px; }
        .section-title { text-align:center; font-size:1.8rem; font-weight:800; margin-bottom:10px; color:var(--dark); letter-spacing:-0.5px; }
        .section-sub   { text-align:center; color:var(--text-muted); font-size:0.9rem; margin-bottom:50px; line-height:1.7; }

        /* ===== WHY SECTION ===== */
        .why-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:20px; }
        .why-card {
            border:1.5px solid var(--border); border-radius:18px; padding:28px 22px;
            transition: all 0.25s; background: #fff;
            position: relative; overflow: hidden;
        }
        .why-card::before {
            content: '';
            position: absolute; top: 0; left: 0; right: 0; height: 3px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            transform: scaleX(0); transform-origin: left;
            transition: transform 0.3s;
        }
        .why-card:hover { box-shadow: 0 8px 32px rgba(0,188,212,0.12); border-color: var(--primary); transform: translateY(-4px); }
        .why-card:hover::before { transform: scaleX(1); }
        .why-card .icon {
            width: 52px; height: 52px; border-radius: 14px;
            background: linear-gradient(135deg, rgba(0,188,212,0.12), rgba(124,77,255,0.08));
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem; margin-bottom: 16px;
        }
        .why-card h4 { font-size:0.92rem; font-weight:700; margin-bottom:8px; color: var(--dark); }
        .why-card p  { font-size:0.78rem; color:var(--text-muted); line-height:1.7; }

        /* ===== KATALOG SECTION ===== */
        .katalog-section { background: #fafbff; }
        .pub-katalog-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:24px; }
        .pub-katalog-card {
            background:#fff; border-radius:20px; overflow:hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
            transition: all 0.25s;
            border: 1.5px solid var(--border);
        }
        .pub-katalog-card:hover { transform: translateY(-6px); box-shadow: 0 16px 40px rgba(0,188,212,0.14); border-color: rgba(0,188,212,0.3); }
        .pub-katalog-card .card-img {
            height: 200px; background: linear-gradient(135deg, #e0f7fa, #b2ebf2);
            display: flex; align-items: center; justify-content: center; font-size: 5rem;
            position: relative; overflow: hidden;
        }
        .pub-katalog-card .card-img img { width:100%; height:100%; object-fit:cover; }
        .pub-katalog-card .card-body { padding: 20px; }
        .pub-katalog-card .fish-name { font-weight:800; font-size:1rem; color: var(--dark); }
        .pub-katalog-card .fish-size { font-size:0.73rem; color:var(--text-muted); margin-bottom:12px; margin-top:2px; }
        .pub-katalog-card .meta { display:flex; justify-content:space-between; align-items:center; margin-bottom:6px; }
        .pub-katalog-card .meta label { font-size:0.72rem; color:var(--text-muted); font-weight:600; }
        .pub-katalog-card .meta span  { font-size:0.85rem; font-weight:700; }
        .pub-katalog-card .price { color:var(--primary); }
        .pub-katalog-card .desc { font-size:0.74rem; color:var(--text-muted); margin-top:10px; padding-top:10px; border-top:1px solid var(--border); line-height:1.6; }
        .btn-pesan {
            width:100%; margin:14px 0 0; padding:11px;
            background:linear-gradient(135deg,var(--primary),var(--accent));
            color:#fff; border:none; border-radius:12px; font-family:inherit;
            font-size:0.88rem; font-weight:700; cursor:pointer;
            display:flex; align-items:center; justify-content:center; gap:8px;
            transition: all 0.2s;
            box-shadow: 0 4px 16px rgba(0,188,212,0.25);
        }
        .btn-pesan:hover { opacity:0.88; transform:translateY(-1px); }

        /* ===== FOOTER ===== */
        .pub-footer {
            background: linear-gradient(135deg, var(--dark) 0%, var(--dark2) 100%);
            color:#ccc; padding:60px 60px 24px;
        }
        .pub-footer-inner { display:flex; gap:60px; margin-bottom:36px; flex-wrap: wrap; }
        .footer-brand { flex:1.5; min-width: 220px; }
        .footer-brand .logo { font-size:1.5rem; font-weight:800; letter-spacing: -0.5px; }
        .footer-brand .logo-si,
        .footer-brand .logo-m { color:var(--primary); font-style:italic; }
        .footer-brand .logo-m { font-size:1.8rem; }
        .footer-brand .logo-rawan { color:#fff; }
        .footer-brand .sub { font-size:0.62rem; color:rgba(255,255,255,0.35); margin-top:2px; }
        .footer-brand p { font-size:0.78rem; color:rgba(255,255,255,0.5); margin-top:14px; line-height:1.8; max-width:280px; }
        .footer-links { display:flex; gap:48px; flex-wrap: wrap; }
        .footer-links h4 { color:#fff; font-size:0.82rem; font-weight:700; margin-bottom:16px; letter-spacing:0.3px; }
        .footer-links ul { list-style:none; }
        .footer-links ul li { margin-bottom:10px; }
        .footer-links ul li a {
            color:rgba(255,255,255,0.5); font-size:0.78rem; text-decoration:none;
            transition: all 0.2s; display: inline-flex; align-items: center; gap: 6px;
        }
        .footer-links ul li a:hover { color:var(--primary); padding-left: 4px; }
        .footer-bottom {
            border-top:1px solid rgba(255,255,255,0.08);
            padding-top:20px; text-align:center;
            font-size:0.72rem; color:rgba(255,255,255,0.3);
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1024px) {
            .hero { padding: 52px 36px; }
            .why-grid { grid-template-columns: repeat(2, 1fr); }
            .pub-katalog-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 768px) {
            .hero { flex-direction: column; text-align: center; padding: 40px 24px; min-height: auto; }
            .hero-text h1 { font-size: 2rem; }
            .hero-img { max-width: 100%; }
            .hero-btns { justify-content: center; }
            .hero-stats { justify-content: center; }
            .section { padding: 52px 24px; }
            .pub-katalog-grid { grid-template-columns: 1fr; }
            .why-grid { grid-template-columns: 1fr; }
            .pub-footer { padding: 40px 24px 20px; }
            .pub-footer-inner { gap: 36px; }
        }
    </style>
</head>
<body>

{{-- Navbar --}}
@include('components.navbar-customer')

{{-- Hero --}}
<section class="hero" id="beranda">
    <div class="hero-text">
        <div class="hero-badge">
            <i class="fas fa-fish"></i> Platform Ikan Segar #1 di Jember
        </div>
        <h1>Ikan Segar dari<br><span>Mrawan</span> Fish Farm</h1>
        <p>Platform digital untuk pemesanan ikan segar berkualitas tinggi. Pantau stok real-time, pesan online mudah, dan nikmati kemudahan transaksi modern.</p>
        <div class="hero-btns">
            @if(session('customer_id'))
                <a href="{{ route('customer.produk') }}" class="btn-hero-primary">
                    <i class="fas fa-shopping-cart"></i> Pesan Sekarang
                </a>
                <a href="{{ route('customer.riwayat') }}" class="btn-hero-secondary">
                    <i class="fas fa-list-alt"></i> Riwayat Pembelian
                </a>
            @else
                <a href="#produk" class="btn-hero-primary">
                    Lihat Produk Kami <i class="fas fa-arrow-right"></i>
                </a>
                <a href="{{ route('register') }}" class="btn-hero-secondary">
                    Daftar Gratis
                </a>
            @endif
        </div>
        <div class="hero-stats">
            <div class="hero-stat">
                <div class="val">150+</div>
                <div class="lbl">Kultura Tersedia</div>
            </div>
            <div class="hero-stat-divider"></div>
            <div class="hero-stat">
                <div class="val">100%</div>
                <div class="lbl">Organik & Segar</div>
            </div>
            <div class="hero-stat-divider"></div>
            <div class="hero-stat">
                <div class="val">15+</div>
                <div class="lbl">Mitra Bisnis</div>
            </div>
        </div>
    </div>
    <div class="hero-img">
        <div class="hero-img-box">
            <div class="hero-slider" id="heroSlider">
                <!-- Slide 1: Panen Lele -->
                <div class="hero-slide active">
                    <img src="{{ asset('images/hero_panen_lele.png') }}" alt="Panen Lele Mrawan Fish Farm">
                    <div class="hero-slide-overlay"></div>
                    <div class="hero-slide-caption">🎣 Panen langsung dari kolam kami</div>
                </div>
                <!-- Slide 2: Produk Lele -->
                <div class="hero-slide">
                    <img src="{{ asset('images/produk_lele.png') }}" alt="Ikan Lele Segar">
                    <div class="hero-slide-overlay"></div>
                    <div class="hero-slide-caption">🐟 Ikan Lele segar berkualitas premium</div>
                </div>
                <!-- Slide 3: Produk Nila -->
                <div class="hero-slide">
                    <img src="{{ asset('images/produk_nila.png') }}" alt="Ikan Nila Segar">
                    <div class="hero-slide-overlay"></div>
                    <div class="hero-slide-caption">🐠 Ikan Nila pilihan siap kirim</div>
                </div>

                <!-- Tombol Navigasi -->
                <button class="slider-btn prev" onclick="heroSliderPrev()" aria-label="Sebelumnya">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="slider-btn next" onclick="heroSliderNext()" aria-label="Berikutnya">
                    <i class="fas fa-chevron-right"></i>
                </button>

                <!-- Dots -->
                <div class="slider-dots" id="sliderDots"></div>
            </div>
        </div>
    </div>
</section>

{{-- Why SiMrawan --}}
<section class="section" id="kenapa" style="background:#fff;">
    <h2 class="section-title">Kenapa Memilih SiMrawan?</h2>
    <p class="section-sub">Dipanen langsung dari kolam kami dengan standar kualitas terbaik<br>untuk memastikan kesegaran dan nutrisi optimal</p>
    <div class="why-grid">
        <div class="why-card">
            <div class="icon">🛒</div>
            <h4>Pesan Online Mudah</h4>
            <p>Lihat katalog produk, pantau stok dan lakukan permintaan pesanan kapan saja dengan mudah via platform digital kami.</p>
        </div>
        <div class="why-card">
            <div class="icon">📊</div>
            <h4>Stok Real-Time</h4>
            <p>Pantau ketersediaan ikan secara langsung. Dapatkan informasi stok dan update harga terkini setiap saat.</p>
        </div>
        <div class="why-card">
            <div class="icon">💳</div>
            <h4>Pembayaran Mudah</h4>
            <p>Upload bukti transfer pembayaran dengan mudah untuk mengkonfirmasi pesanan Anda dengan cepat dan aman.</p>
        </div>
        <div class="why-card">
            <div class="icon">⭐</div>
            <h4>Kualitas Terjamin</h4>
            <p>Ikan dipanen dengan standar tinggi, dijamin selalu segar dari kolam kami langsung ke tangan Anda.</p>
        </div>
    </div>
</section>

{{-- Katalog Produk --}}
<section class="section katalog-section" id="produk">
    <h2 class="section-title">Ikan Segar Berkualitas Premium</h2>
    <p class="section-sub">Dipanen langsung dari kolam kami dengan standar kualitas terbaik<br>untuk memastikan kesegaran dan nutrisi optimal</p>

    @if($produkUnggulan->isEmpty())
    <div style="text-align:center;padding:60px;color:var(--text-muted);">
        <div style="font-size:4rem;margin-bottom:16px;">🐟</div>
        <div style="font-size:1.1rem;font-weight:600;margin-bottom:8px;">Produk segera tersedia!</div>
        <p style="font-size:0.85rem;">Daftarkan akun untuk mendapatkan informasi terbaru.</p>
        <a href="{{ route('register') }}" class="btn-hero-primary" style="margin-top:24px;display:inline-flex;">
            <i class="fas fa-user-plus"></i> Daftar Sekarang
        </a>
    </div>
    @else
    <div class="pub-katalog-grid">
        @foreach($produkUnggulan as $p)
        @php
            $namaIkan = strtolower($p->stokIkan->jenis_ikan ?? '');
            $imgIkan = 'images/produk_lele.png'; // default
            if (str_contains($namaIkan, 'nila'))   $imgIkan = 'images/produk_nila.png';
            elseif (str_contains($namaIkan, 'patin')) $imgIkan = 'images/produk_patin.png';
            elseif (str_contains($namaIkan, 'mas') || str_contains($namaIkan, 'karper')) $imgIkan = 'images/produk_mas.png';
        @endphp
        <div class="pub-katalog-card">
            <div class="card-img">
                @if($p->gambar)
                    <img src="{{ asset('uploads/'.$p->gambar) }}" alt="{{ $p->stokIkan->jenis_ikan }}">
                @else
                    <img src="{{ asset($imgIkan) }}" alt="{{ $p->stokIkan->jenis_ikan }}">
                @endif
            </div>
            <div class="card-body">
                <div class="fish-name">{{ $p->stokIkan->jenis_ikan }}</div>
                <div class="fish-size">{{ $p->stokIkan->ukuran_sortasi }}</div>
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;">
                    <span class="badge badge-primary" style="font-size:0.65rem;">🟢 Tersedia</span>
                    <span style="font-size:0.75rem;color:var(--text-muted);">Stok: <strong>{{ number_format($p->stokIkan->jumlah_stok,0) }} Kg</strong></span>
                </div>
                <div class="meta">
                    <label>Harga / Kg</label>
                    <span class="price" style="font-size:1rem;">Rp {{ number_format($p->stokIkan->harga_jual,0,',','.') }}</span>
                </div>
                <div class="meta">
                    <label>Min. Order</label>
                    <span>5 Kg</span>
                </div>
                @if($p->deskripsi)
                <div class="desc">{{ Str::limit($p->deskripsi, 80) }}</div>
                @endif
                @if(session('customer_id'))
                    <a href="{{ route('customer.produk') }}" class="btn-pesan">
                        <i class="fas fa-shopping-cart"></i> Pesan Sekarang
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-pesan">
                        <i class="fas fa-sign-in-alt"></i> Login untuk Pesan
                    </a>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    @if(session('customer_id'))
    <div style="text-align:center;margin-top:36px;">
        <a href="{{ route('customer.produk') }}" class="btn-hero-primary">
            <i class="fas fa-th-large"></i> Lihat Semua Produk
        </a>
    </div>
    @endif
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
                <h4>Navigasi</h4>
                <ul>
                    <li><a href="{{ route('beranda') }}"><i class="fas fa-home" style="width:14px;"></i> Beranda</a></li>
                    <li><a href="#produk"><i class="fas fa-fish" style="width:14px;"></i> Katalog Produk</a></li>
                    <li><a href="#kenapa"><i class="fas fa-question-circle" style="width:14px;"></i> Tentang Kami</a></li>
                    @if(session('customer_id'))
                        <li><a href="{{ route('customer.riwayat') }}"><i class="fas fa-list" style="width:14px;"></i> Riwayat Pembelian</a></li>
                    @endif
                </ul>
            </div>
            <div>
                <h4>Akun</h4>
                <ul>
                    @if(session('customer_id'))
                        <li><a href="{{ route('customer.profil') }}"><i class="fas fa-user-circle" style="width:14px;"></i> Profil Saya</a></li>
                        <li><a href="{{ route('customer.wishlist') }}"><i class="fas fa-heart" style="width:14px;"></i> Wishlist</a></li>
                        <li><a href="{{ route('customer.notifikasi') }}"><i class="fas fa-bell" style="width:14px;"></i> Notifikasi</a></li>
                    @else
                        <li><a href="{{ route('login') }}"><i class="fas fa-sign-in-alt" style="width:14px;"></i> Login</a></li>
                        <li><a href="{{ route('register') }}"><i class="fas fa-user-plus" style="width:14px;"></i> Daftar</a></li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <p>© 2026 SiMrawan — Mrawan Fish Farm. Dibuat oleh Tim B6 Universitas Jember.</p>
    </div>
</footer>

<script>
// ===== HERO SLIDER =====
(function() {
    const slider = document.getElementById('heroSlider');
    if (!slider) return;
    const slides = slider.querySelectorAll('.hero-slide');
    const dotsContainer = document.getElementById('sliderDots');
    let current = 0;
    let timer;

    // Build dots
    slides.forEach((_, i) => {
        const dot = document.createElement('button');
        dot.className = 'slider-dot' + (i === 0 ? ' active' : '');
        dot.setAttribute('aria-label', 'Slide ' + (i + 1));
        dot.onclick = () => goTo(i);
        dotsContainer.appendChild(dot);
    });

    function goTo(index) {
        slides[current].classList.remove('active');
        dotsContainer.children[current].classList.remove('active');
        current = (index + slides.length) % slides.length;
        slides[current].classList.add('active');
        dotsContainer.children[current].classList.add('active');
        resetTimer();
    }

    function resetTimer() {
        clearInterval(timer);
        timer = setInterval(() => goTo(current + 1), 4000);
    }

    window.heroSliderPrev = () => goTo(current - 1);
    window.heroSliderNext = () => goTo(current + 1);

    resetTimer();
})();
</script>

</body>
</html>