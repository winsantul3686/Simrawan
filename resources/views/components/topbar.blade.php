@props(['username' => 'Admin', 'title' => 'Dashboard'])

<header class="topbar">
    <h1>{{ $title }}</h1>

    <div class="topbar-right">
        <!-- Notifikasi -->
        <a href="{{ route('notifikasi.index') }}" class="notif-icon">
            <i class="fas fa-bell"></i>

            @php
                $unread = \App\Models\Notifikasi::where('status','belum_dibaca')->count();
            @endphp

            @if($unread > 0)
                <span class="notif-badge">{{ $unread }}</span>
            @endif
        </a>

        <!-- Info Admin -->
        <div class="admin-info">
            <span class="name">{{ $username }}</span>
            <span class="role">Administrator</span>
        </div>

        <!-- Tombol Logout -->
        <button onclick="openModal('modal-logout')" class="btn-logout">
            <i class="fas fa-sign-out-alt"></i> Logout
        </button>
    </div>
</header>

{{-- Modal Logout --}}
<div class="modal-overlay" id="modal-logout">
    <div class="modal modal-sm modal-center">
        <button class="modal-close" onclick="closeModal('modal-logout')">
            &times;
        </button>

        <p class="modal-title">
            Apakah anda yakin ingin logout?
        </p>

        <form action="{{ route('logout') }}" method="POST">
            @csrf

            <div class="modal-actions center">
                <button type="submit" class="btn btn-success">
                    Ya
                </button>
                <button type="button" class="btn btn-danger" onclick="closeModal('modal-logout')">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>