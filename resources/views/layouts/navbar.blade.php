<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">

        <a class="navbar-brand fw-bold" href="#">
            Address Book
        </a>

        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            @auth
            <ul class="navbar-nav me-auto">

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                       href="{{ route('dashboard') }}">
                        Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('countries.*') ? 'active' : '' }}"
                       href="{{ route('countries.index') }}">
                        Countries
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('states.*') ? 'active' : '' }}"
                       href="{{ route('states.index') }}">
                        States
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('cities.*') ? 'active' : '' }}"
                       href="{{ route('cities.index') }}">
                        Cities
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('areas.*') ? 'active' : '' }}"
                       href="{{ route('areas.index') }}">
                        Areas
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('addressbooks.*') ? 'active' : '' }}"
                       href="{{ route('addressbooks.index') }}">
                        Address Book
                    </a>
                </li>

            </ul>

            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-person-circle me-1" viewBox="0 0 16 16" style="vertical-align: -2px;">
                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                            <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                        </svg>
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
            @else
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}"
                       href="{{ route('login') }}">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('register') ? 'active' : '' }}"
                       href="{{ route('register') }}">Register</a>
                </li>
            </ul>
            @endauth

        </div>

    </div>
</nav>

<!-- Premium Toast Notifications Container -->
<div id="custom-toast-container">
    @if(session('success'))
    <div class="toast-custom success" id="successToast">
        <div class="toast-custom-content">
            <div class="toast-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
            </div>
            <div class="toast-message">
                <span class="toast-title">Success</span>
                <span class="toast-text">{{ session('success') }}</span>
            </div>
        </div>
        <button class="toast-close">&times;</button>
        <div class="toast-progress"></div>
    </div>
    @endif

    @if(session('error'))
    <div class="toast-custom error" id="errorToast">
        <div class="toast-custom-content">
            <div class="toast-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
            </div>
            <div class="toast-message">
                <span class="toast-title">Error</span>
                <span class="toast-text">{{ session('error') }}</span>
            </div>
        </div>
        <button class="toast-close">&times;</button>
        <div class="toast-progress"></div>
    </div>
    @endif
</div>

<style>
/* Toast Container */
#custom-toast-container {
    position: fixed;
    top: 24px;
    right: 24px;
    z-index: 99999;
    pointer-events: none;
}

/* Toast Box */
.toast-custom {
    pointer-events: auto;
    width: 380px;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1), 0 5px 15px rgba(0, 0, 0, 0.05);
    border-radius: 12px;
    padding: 16px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: relative;
    overflow: hidden;
    margin-bottom: 12px;
    transform: translateX(120%);
    transition: transform 0.45s cubic-bezier(0.175, 0.885, 0.32, 1.275), opacity 0.4s ease;
    border: 1px solid rgba(255, 255, 255, 0.6);
}

.toast-custom.show {
    transform: translateX(0);
}

.toast-custom.hide {
    transform: translateY(-15px) scale(0.95);
    opacity: 0;
    transition: transform 0.3s ease, opacity 0.3s ease;
}

/* Success Toast Styling */
.toast-custom.success {
    border-left: 5px solid #10b981;
}
.toast-custom.success .toast-icon {
    color: #10b981;
    background: rgba(16, 185, 129, 0.12);
}
.toast-custom.success .toast-progress {
    background: linear-gradient(90deg, #10b981, #34d399);
}

/* Error Toast Styling */
.toast-custom.error {
    border-left: 5px solid #ef4444;
}
.toast-custom.error .toast-icon {
    color: #ef4444;
    background: rgba(239, 68, 68, 0.12);
}
.toast-custom.error .toast-progress {
    background: linear-gradient(90deg, #ef4444, #f87171);
}

/* Toast Content */
.toast-custom-content {
    display: flex;
    align-items: center;
    gap: 16px;
}

.toast-icon {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.toast-message {
    display: flex;
    flex-direction: column;
}

.toast-title {
    font-size: 15px;
    font-weight: 700;
    color: #1f2937;
    font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
}

.toast-text {
    font-size: 13px;
    color: #4b5563;
    margin-top: 2px;
    font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
}

/* Close Button */
.toast-close {
    background: none;
    border: none;
    font-size: 22px;
    color: #9ca3af;
    cursor: pointer;
    padding: 0 4px;
    line-height: 1;
    transition: color 0.2s ease;
    align-self: flex-start;
    margin-top: -2px;
}

.toast-close:hover {
    color: #4b5563;
}

/* Progress Bar */
.toast-progress {
    position: absolute;
    bottom: 0;
    left: 0;
    height: 4px;
    width: 100%;
}

.toast-progress.active {
    animation: toast-progress-anim 4.5s linear forwards;
}

@keyframes toast-progress-anim {
    100% {
        width: 0%;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const toasts = document.querySelectorAll('.toast-custom');
    toasts.forEach(toast => {
        // Entrance animation
        setTimeout(() => {
            toast.classList.add('show');
            const progress = toast.querySelector('.toast-progress');
            if (progress) {
                progress.classList.add('active');
            }
        }, 150);

        // Auto close timeout
        const autoCloseTimeout = setTimeout(() => {
            triggerClose(toast);
        }, 4600);

        // Manual close
        const closeBtn = toast.querySelector('.toast-close');
        if (closeBtn) {
            closeBtn.addEventListener('click', () => {
                clearTimeout(autoCloseTimeout);
                triggerClose(toast);
            });
        }
    });

    function triggerClose(toastElement) {
        toastElement.classList.remove('show');
        toastElement.classList.add('hide');
        setTimeout(() => {
            toastElement.remove();
        }, 350);
    }
});
</script>
</body>
</html>