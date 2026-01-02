<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - iPhone Online Store</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    
    @livewireStyles
</head>
<body class="admin-body">
    <!-- Mobile Header/Toggle -->
    <div class="admin-mobile-header" style="display: none; height: 60px; background: var(--admin-sidebar); border-bottom: 1px solid var(--admin-border); padding: 0 20px; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 200;">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-logo" style="font-size: 18px;">{{ __('Store Admin') }}</a>
        <button id="sidebarToggle" style="background: none; border: none; cursor: pointer; padding: 10px;">
            <i class="fa-solid fa-bars" style="color: white; font-size: 24px;"></i>
        </button>
    </div>

    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="admin-sidebar" id="sidebar">
            <div class="sidebar-header">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-logo">{{ __('Store Admin') }}</a>
            </div>
            
            <nav class="sidebar-nav">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-line"></i>
                    <span>{{ __('Dashboard') }}</span>
                </a>
                
                <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-box"></i>
                    <span>{{ __('Products') }}</span>
                </a>
                
                <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span>{{ __('Orders') }}</span>
                </a>
                
                <a href="{{ route('admin.cities.index') }}" class="nav-link {{ request()->routeIs('admin.cities.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-location-dot"></i>
                    <span>{{ __('Cities') }}</span>
                </a>
                
                <a href="{{ route('admin.customers.index') }}" class="nav-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-users"></i>
                    <span>{{ __('Customers') }}</span>
                </a>
                
                <a href="{{ route('admin.settings') }}" class="nav-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                    <i class="fa-solid fa-gears"></i>
                    <span>{{ __('Settings') }}</span>
                </a>
            </nav>

            <div class="sidebar-footer">
                <a href="{{ route('home') }}" class="nav-link">
                    <i class="fa-solid fa-house"></i>
                    <span>{{ __('Back to Store') }}</span>
                </a>
            </div>

        </aside>

        <!-- Main Content -->
        <main class="admin-main">
            <header class="admin-header">
                <h1 class="admin-title">@yield('title', __('Dashboard'))</h1>
                <div class="admin-user" style="display: flex; align-items: center; gap: 20px;">
                    <div class="lang-switch" style="display: flex; gap: 10px; font-size: 13px; font-weight: 600;">
                        <a href="#" onclick="event.preventDefault(); document.getElementById('admin-lang-en-form').submit();" style="color: {{ app()->getLocale() == 'en' ? 'var(--admin-accent)' : 'var(--text-muted)' }}; text-decoration: none;">EN</a>
                        <form id="admin-lang-en-form" action="{{ route('lang.switch', 'en') }}" method="POST" style="display: none;">@csrf</form>
                        <span style="color: var(--admin-border);">|</span>
                        <a href="#" onclick="event.preventDefault(); document.getElementById('admin-lang-ru-form').submit();" style="color: {{ app()->getLocale() == 'ru' ? 'var(--admin-accent)' : 'var(--text-muted)' }}; text-decoration: none;">RU</a>
                        <form id="admin-lang-ru-form" action="{{ route('lang.switch', 'ru') }}" method="POST" style="display: none;">@csrf</form>
                    </div>
                    <span class="admin-user-name">{{ auth()->user()->name }}</span>
                </div>

            </header>

            <div class="admin-content">
                {{ $slot }}
            </div>
        </main>
    </div>

    <!-- Sidebar Overlay -->
    <div id="sidebarOverlay" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); backdrop-filter: blur(4px); z-index: 140;"></div>

    <script>
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');

        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', () => {
                sidebar.classList.toggle('open');
                overlay.style.display = sidebar.classList.contains('open') ? 'block' : 'none';
            });
        }

        if (overlay) {
            overlay.addEventListener('click', () => {
                sidebar.classList.remove('open');
                overlay.style.display = 'none';
            });
        }
    </script>

    @livewireScripts
</body>
</html>
