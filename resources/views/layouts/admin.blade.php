<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - iPhone Online Store</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    
    @livewireStyles
</head>
<body class="admin-body">
    <div class="admin-layout">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <div class="sidebar-header">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-logo">{{ __('Store Admin') }}</a>
            </div>
            
            <nav class="sidebar-nav">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <span>{{ __('Dashboard') }}</span>
                </a>
                
                <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <span>{{ __('Products') }}</span>
                </a>
                
                <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <span>{{ __('Orders') }}</span>
                </a>
                
                <a href="{{ route('admin.customers.index') }}" class="nav-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
                    <span>{{ __('Customers') }}</span>
                </a>
            </nav>

            <div class="sidebar-footer">
                <a href="{{ route('home') }}" class="nav-link">
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
                        <a href="{{ route('lang.switch', 'en') }}" style="color: {{ app()->getLocale() == 'en' ? 'var(--admin-accent)' : 'var(--text-muted)' }}; text-decoration: none;">EN</a>
                        <span style="color: var(--admin-border);">|</span>
                        <a href="{{ route('lang.switch', 'ru') }}" style="color: {{ app()->getLocale() == 'ru' ? 'var(--admin-accent)' : 'var(--text-muted)' }}; text-decoration: none;">RU</a>
                    </div>
                    <span>{{ auth()->user()->name }}</span>
                </div>

            </header>

            <div class="admin-content">
                {{ $slot }}
            </div>
        </main>
    </div>

    @livewireScripts
</body>
</html>
