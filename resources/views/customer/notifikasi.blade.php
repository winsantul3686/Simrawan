@extends('layouts.app')

@section('title', 'Notifikasi - SiMrawan')

@section('no-sidebar')
@endsection

@section('content')
@include('components.navbar-customer')

<div style="padding:48px;max-width:100%;">

    {{-- Back button --}}
    <div style="margin-bottom:24px;">
        <a href="{{ route('customer.produk') }}"
           style="display:inline-flex;align-items:center;gap:8px;width:42px;height:42px;border-radius:50%;
                  background:linear-gradient(135deg,var(--primary),var(--accent));color:#fff;text-decoration:none;
                  justify-content:center;font-size:1.1rem;box-shadow:0 3px 10px rgba(0,188,212,0.25);transition:transform 0.2s;"
           onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
            <i class="fas fa-reply"></i>
        </a>
    </div>

    {{-- Tab --}}
    <div style="display:inline-flex;background:#f0f4f8;border:1.5px solid var(--primary);border-radius:30px;padding:4px;margin-bottom:24px;">
        <a href="{{ route('customer.notifikasi', ['tab'=>'pesanan']) }}"
           style="display:inline-flex;align-items:center;gap:6px;padding:7px 22px;border-radius:26px;text-decoration:none;font-size:0.82rem;font-weight:{{ $tab==='pesanan'?'700':'500' }};
                  color:{{ $tab==='pesanan'?'var(--primary)':'var(--text-muted)' }};
                  background:{{ $tab==='pesanan'?'#fff':'transparent' }};
                  box-shadow:{{ $tab==='pesanan'?'0 1px 6px rgba(0,188,212,0.12)':'none' }};transition:all 0.2s;">
            Notifikasi Pesanan
            @php $unreadPesanan = $notifPesanan->where('status','belum_dibaca')->count(); @endphp
            @if($unreadPesanan > 0)
                <span style="display:inline-flex;align-items:center;justify-content:center;background:var(--danger);color:#fff;font-size:0.6rem;padding:1px 6px;border-radius:10px;min-height:16px;">{{ $unreadPesanan }}</span>
            @endif
        </a>
        <a href="{{ route('customer.notifikasi', ['tab'=>'wishlist']) }}"
           style="display:inline-flex;align-items:center;gap:6px;padding:7px 22px;border-radius:26px;text-decoration:none;font-size:0.82rem;font-weight:{{ $tab==='wishlist'?'700':'500' }};
                  color:{{ $tab==='wishlist'?'var(--primary)':'var(--text-muted)' }};
                  background:{{ $tab==='wishlist'?'#fff':'transparent' }};
                  box-shadow:{{ $tab==='wishlist'?'0 1px 6px rgba(0,188,212,0.12)':'none' }};transition:all 0.2s;">
            Notifikasi Wishlist
            @php $unreadWishlist = $notifWishlist->where('status','belum_dibaca')->count(); @endphp
            @if($unreadWishlist > 0)
                <span style="display:inline-flex;align-items:center;justify-content:center;background:var(--danger);color:#fff;font-size:0.6rem;padding:1px 6px;border-radius:10px;min-height:16px;">{{ $unreadWishlist }}</span>
            @endif
        </a>
    </div>

    {{-- Isi Notifikasi --}}
    @php $list = $tab === 'pesanan' ? $notifPesanan : $notifWishlist; @endphp

    <h3 style="font-size:1rem;font-weight:700;margin-bottom:16px;">
        Notifikasi {{ $tab === 'pesanan' ? 'Pesanan' : 'Wishlist' }}
    </h3>

    @forelse($list as $n)
    <a href="{{ route('customer.notifikasi.show', ['type' => $tab, 'id' => $n->id]) }}" style="text-decoration:none;color:inherit;display:block;">
        <div style="background:#fff;border:1.5px solid {{ $n->status==='belum_dibaca'?'var(--primary)':'var(--border)' }};
                    border-left:{{ $n->status==='belum_dibaca'?'4px solid var(--primary)':'1.5px solid var(--border)' }};
                    border-radius:12px;padding:16px 20px;margin-bottom:10px;
                    display:flex;align-items:center;justify-content:space-between;gap:16px;
                    background:{{ $n->status==='belum_dibaca'?'#f0fdfe':'#fff' }};
                    transition:transform 0.2s, box-shadow 0.2s;"
             onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 4px 12px rgba(0,0,0,0.04)';"
             onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='none';">
            <div style="flex:1;">
                <div style="font-size:0.9rem;font-weight:700;margin-bottom:4px;color:var(--dark);">{{ $n->judul }}</div>
                <div style="font-size:0.78rem;color:var(--text-muted);line-height:1.5;">{{ $n->isi }}</div>
            </div>
            <div style="text-align:right;flex-shrink:0;">
                <div style="font-size:0.72rem;color:var(--text-muted);margin-bottom:6px;">
                    {{ \Carbon\Carbon::parse($n->created_at)->format('d F Y') }}
                </div>
                <span style="font-size:0.7rem;padding:4px 12px;border-radius:20px;font-weight:600;
                             background:{{ $n->status==='dibaca'?'#e8f5e9':'#fce4ec' }};
                             color:{{ $n->status==='dibaca'?'#388e3c':'#c62828' }};">
                    {{ $n->status === 'dibaca' ? 'Dibaca' : 'Belum dibaca' }}
                </span>
                <div style="font-size:0.7rem;color:var(--text-muted);margin-top:4px;">
                    {{ \Carbon\Carbon::parse($n->created_at)->format('H.i') }}
                </div>
            </div>
        </div>
    </a>
    @empty
    <div style="background:#fff;border-radius:12px;padding:48px;text-align:center;color:#aaa;box-shadow:var(--shadow);">
        <i class="fas fa-bell-slash" style="font-size:2.5rem;display:block;margin-bottom:12px;"></i>
        Tidak ada notifikasi {{ $tab === 'pesanan' ? 'pesanan' : 'wishlist' }}.
    </div>
    @endforelse

</div>
@endsection