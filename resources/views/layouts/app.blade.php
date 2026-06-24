<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SiMrawan - Mrawan Fish Farm')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('styles')
</head>
<body>

@if(View::hasSection('no-sidebar'))
    {{-- Layout tanpa sidebar (login, register, customer pages) --}}
    @yield('content')
@else
    {{-- Layout dengan sidebar admin --}}
    <div class="app-wrapper">
        <x-sidebar :username="session('admin_nama', 'Admin')" />
        <div class="main-content">
            <x-topbar :username="session('admin_nama', 'Admin')" :title="$pageTitle ?? 'Dashboard'" />
            @if(View::hasSection('extra-topbar'))
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
                @if($errors->any())
                    <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}</div>
                @endif
                @yield('content')
            </div>
        </div>
    </div>
@endif

<script>
// Helper modal: buka/tutup
function openModal(id) {
    const el = document.getElementById(id);
    if (el) el.classList.add('active');
}
function closeModal(id) {
    const el = document.getElementById(id);
    if (el) el.classList.remove('active');
}
// Tutup modal ketika klik backdrop
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.modal-overlay').forEach(function(m) {
        m.addEventListener('click', function(e) {
            if (e.target === this) this.classList.remove('active');
        });
    });
    
    // Auto-hide alerts after 5 seconds
    const setupAlertTimeout = function(alert) {
        setTimeout(function() {
            if (alert.parentNode) {
                alert.style.transition = 'opacity 0.5s, transform 0.5s';
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-8px)';
                setTimeout(function() { alert.remove(); }, 500);
            }
        }, 5000);
    };
    document.querySelectorAll('.alert').forEach(setupAlertTimeout);

    // Disable native browser validation tooltips
    document.querySelectorAll('form').forEach(function(form) {
        form.setAttribute('novalidate', 'true');
    });

    // Handle form submission validation
    document.addEventListener('submit', function(e) {
        const form = e.target;
        const requiredInputs = form.querySelectorAll('input[required], textarea[required], select[required]');
        
        if (requiredInputs.length === 0) return;

        let hasEmpty = false;
        let firstEmpty = null;

        requiredInputs.forEach(function(input) {
            let isEmpty = false;
            if (input.type === 'file') {
                isEmpty = input.files.length === 0;
            } else {
                isEmpty = !input.value || !input.value.trim();
            }

            if (isEmpty) {
                hasEmpty = true;
                if (!firstEmpty) firstEmpty = input;
                input.style.borderColor = '#c62828';
                input.style.boxShadow = '0 0 0 3px rgba(198, 40, 40, 0.1)';
                
                const clearError = function() {
                    if (input.value && input.value.trim()) {
                        input.style.borderColor = '';
                        input.style.boxShadow = '';
                        input.removeEventListener('input', clearError);
                        input.removeEventListener('change', clearError);
                    }
                };
                input.addEventListener('input', clearError);
                input.addEventListener('change', clearError);
            } else {
                input.style.borderColor = '';
                input.style.boxShadow = '';
            }
        });

        if (hasEmpty) {
            e.preventDefault();
            e.stopPropagation();

            if (firstEmpty) firstEmpty.focus();

            // Hapus modal lama jika ada
            const existModal = document.getElementById('modal-validation-error');
            if (existModal) existModal.remove();

            // Buat modal overlay baru untuk menampilkan popup error
            const modalOverlay = document.createElement('div');
            modalOverlay.className = 'modal-overlay active';
            modalOverlay.id = 'modal-validation-error';
            modalOverlay.style.display = 'flex';
            
            modalOverlay.innerHTML = `
                <div class="modal" style="max-width:380px; text-align:center; padding: 32px 24px; border-radius: 18px;">
                    <div style="font-size: 3rem; color: var(--danger); margin-bottom: 16px;">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
                    <h3 style="font-size: 1.15rem; font-weight: 800; color: var(--dark); margin-bottom: 8px;">Gagal</h3>
                    <p style="font-size: 0.88rem; color: var(--text-muted); line-height: 1.5; margin-bottom: 24px;">
                        Data tidak boleh kosong.
                    </p>
                    <button type="button" id="btn-close-validation-modal" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 11px; font-weight: 700; border-radius: 10px;">
                        Oke
                    </button>
                </div>
            `;

            document.body.appendChild(modalOverlay);

            // Event listener untuk menutup modal
            modalOverlay.querySelector('#btn-close-validation-modal').addEventListener('click', function() {
                modalOverlay.classList.remove('active');
                setTimeout(function() { modalOverlay.remove(); }, 200);
            });

            modalOverlay.addEventListener('click', function(evt) {
                if (evt.target === modalOverlay) {
                    modalOverlay.classList.remove('active');
                    setTimeout(function() { modalOverlay.remove(); }, 200);
                }
            });
        }
    });
});
</script>
@yield('scripts')
</body>
</html>