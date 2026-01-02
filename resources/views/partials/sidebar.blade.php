<!-- Sidebar Overlay -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- Sidebar -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar__header">
        <button class="sidebar__close" id="sidebarClose">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    <nav class="sidebar__nav">
        <ul class="sidebar__list">
            @if(Auth::check() && Auth::user()->isAdmin())
                <li class="sidebar__item sidebar__item--admin">
                    <a href="{{ route('admin.dashboard') }}" target="_blank">
                        <i class="fa-solid fa-gauge-high"></i>
                        {{ __('Store Admin') }}
                    </a>
                </li>
            @endif

            <li class="sidebar__item sidebar__item--sale">
                <a href="{{ route('home') }}">
                    <i class="fa-solid fa-percent"></i>
                    {{ __('SALE') }}
                </a>
            </li>

            @php
                $categoryIcons = [
                    'Smartphones' => 'fa-mobile-screen-button',
                    'iPhone' => 'fa-mobile-screen-button',
                    'Macbook' => 'fa-laptop',
                    'Laptop' => 'fa-laptop',
                    'iPad' => 'fa-tablet-screen-button',
                    'Tablet' => 'fa-tablet-screen-button',
                    'Apple Watch' => 'fa-clock',
                    'Watch' => 'fa-clock',
                    'AirPods' => 'fa-headphones',
                    'Headphones' => 'fa-headphones',
                    'Accessories' => 'fa-plug',
                ];
                $defaultIcon = 'fa-tag';
            @endphp

            @foreach($sidebarCategories as $category)
                <li class="sidebar__item">
                    <a href="{{ route('home', ['category' => $category->category]) }}" class="{{ request('category') == $category->category ? 'active' : '' }}">
                        @php
                            $icon = $categoryIcons[$category->category] ?? 
                                   $categoryIcons[Str::plural($category->category)] ?? 
                                   $categoryIcons[Str::singular($category->category)] ?? 
                                   $defaultIcon;
                        @endphp
                        <i class="fa-solid {{ $icon }}"></i>
                        {{ __($category->category) }}
                        <span class="category-count">{{ $category->total }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </nav>
</aside>
