@extends('layouts.app')

@section('title', 'Notifikasi - SiMrawan')

@php $pageTitle = 'Notifikasi'; @endphp

@section('content')

{{-- Tab Header (inline di topbar area) --}}
@section('extra-topbar')
    <div class="notif-tabs">
        <a href="{{ route('notifikasi.index', ['tab'=>'pesanan']) }}"
           class="notif-tab {{ $tab === 'pesanan' ? 'active' : '' }}">
            Notifikasi Pesanan
            @php $unreadPesanan = $notifPesanan->where('status','belum_dibaca')->count(); @endphp
            @if($unreadPesanan > 0)
                <span class="tab-badge">{{ $unreadPesanan }}</span>
            @endif
        </a>
        <a href="{{ route('notifikasi.index', ['tab'=>'wishlist']) }}"
           class="notif-tab {{ $tab === 'wishlist' ? 'active' : '' }}">
            Notifikasi Wishlist
            @php $unreadWishlist = $notifWishlist->where('status','belum_dibaca')->count(); @endphp
            @if($unreadWishlist > 0)
                <span class="tab-badge">{{ $unreadWishlist }}</span>
            @endif
        </a>
    </div>
@endsection

{{-- Notifikasi Pesanan --}}
@if($tab === 'pesanan')
<div>
    <h3 style="font-size:1rem;font-weight:700;margin-bottom:16px;">Notifikasi Pesanan</h3>
    @forelse($notifPesanan as $n)
    <div class="notif-item {{ $n->status === 'belum_dibaca' ? 'unread' : '' }}">
        <div class="notif-content">
            <div class="notif-title">{{ $n->judul }}</div>
            <div class="notif-isi">{{ $n->isi }}</div>
        </div>
        <div class="notif-meta">
            <div class="notif-tanggal">{{ $n->created_at->format('d F Y') }}</div>
            <span class="badge {{ $n->status === 'dibaca' ? 'badge-success' : 'badge-danger' }}"
                  style="font-size:0.7rem;padding:4px 12px;border-radius:20px;">
                {{ $n->status === 'dibaca' ? 'Dibaca' : 'Belum dibaca' }}
            </span>
            <div class="notif-waktu">{{ $n->created_at->format('H.i') }}</div>
        </div>
    </div>
    @empty
    <div class="card" style="text-align:center;padding:30px;color:var(--text-muted);">
        Tidak ada notifikasi pesanan.
    </div>
    @endforelse
</div>

{{-- Notifikasi Wishlist --}}
@else
<div>
    <h3 style="font-size:1rem;font-weight:700;margin-bottom:16px;">Notifikasi Wishlist</h3>
    @forelse($notifWishlist as $n)
    <div class="notif-item {{ $n->status === 'belum_dibaca' ? 'unread' : '' }}">
        <div class="notif-content">
            <div class="notif-title">{{ $n->judul }}</div>
            <div class="notif-isi">{{ $n->isi }}</div>
        </div>
        <div class="notif-meta">
            <div class="notif-tanggal">{{ $n->created_at->format('d F Y') }}</div>
            <span class="badge {{ $n->status === 'dibaca' ? 'badge-success' : 'badge-danger' }}"
                  style="font-size:0.7rem;padding:4px 12px;border-radius:20px;">
                {{ $n->status === 'dibaca' ? 'Dibaca' : 'Belum dibaca' }}
            </span>
            <div class="notif-waktu">{{ $n->created_at->format('H.i') }}</div>
        </div>
    </div>
    @empty
    <div class="card" style="text-align:center;padding:30px;color:var(--text-muted);">
        Tidak ada notifikasi wishlist.
    </div>
    @endforelse
</div>
@endif

@endsection

@section('styles')
<style>
/* Tab Pills di bawah judul topbar */
.notif-tabs {
    display: flex;
    gap: 0;
    background: #f0f4f8;
    border: 1.5px solid var(--primary);
    border-radius: 30px;
    padding: 4px;
}
.notif-tab {
    padding: 7px 22px;
    border-radius: 26px;
    text-decoration: none;
    font-size: 0.82rem;
    font-weight: 500;
    color: var(--text-muted);
    transition: all 0.2s;
    display: flex;
    align-items: center;
    gap: 6px;
}
.notif-tab.active {
    background: #fff;
    color: var(--primary);
    font-weight: 700;
    box-shadow: 0 1px 6px rgba(0,188,212,0.12);
}
.tab-badge {
    background: var(--danger);
    color: #fff;
    font-size: 0.6rem;
    padding: 1px 6px;
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 16px;
}

/* Notif Items */
.notif-item {
    background: #fff;
    border: 1.5px solid var(--border);
    border-radius: 12px;
    padding: 16px 20px;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    transition: box-shadow 0.2s;
}
.notif-item:hover { box-shadow: 0 2px 12px rgba(0,188,212,0.1); }
.notif-item.unread {
    border-left: 4px solid var(--primary);
    background: #f0fdfe;
}
.notif-content { flex: 1; }
.notif-title { font-size: 0.9rem; font-weight: 700; margin-bottom: 2px; }
.notif-isi { font-size: 0.78rem; color: var(--text-muted); }
.notif-meta { text-align: right; flex-shrink: 0; }
.notif-tanggal { font-size: 0.72rem; color: var(--text-muted); margin-bottom: 6px; }
.notif-waktu { font-size: 0.7rem; color: var(--text-muted); margin-top: 4px; }
</style>
@endsection