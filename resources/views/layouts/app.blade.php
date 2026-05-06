<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SiMrawan - Mrawan Fish Farm')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('styles')
</head>
<body>

@hasSection('no-sidebar')
    {{-- Layout tanpa sidebar (login, dll) --}}
    @yield('content')
@else
    {{-- Layout dengan sidebar admin --}}
    <div class="app-wrapper">
        <x-sidebar :username="session('admin_nama', 'Admin')" />
        <div class="main-content">
            <x-topbar :username="session('admin_nama', 'Admin')" :title="$pageTitle ?? 'Dashboard'" />
            @hasSection('extra-topbar')
            <div style="padding:12px 28px 0;background:#fff;border-bottom:1px solid var(--border);">
                @yield('extra-topbar')
            </div>
            @endif
            <div class="content-area">
                @if(session('success'))
                    <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
                @endif
                @yield('content')
            </div>
        </div>
    </div>
@endif

<script>
// Helper: buka/tutup modal
function openModal(id) { document.getElementById(id).classList.add('active'); }
function closeModal(id) { document.getElementById(id).classList.remove('active'); }
document.querySelectorAll('.modal-overlay').forEach(m => {
    m.addEventListener('click', function(e) {
        if (e.target === this) this.classList.remove('active');
    });
});
</script>
@yield('scripts')
</body>
</html>