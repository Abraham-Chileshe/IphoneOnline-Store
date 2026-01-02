<!-- Sidebar Overlay -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- Sidebar -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar__header">
        <button class="sidebar__close" id="sidebarClose">
            <img src="https://img.icons8.com/ios/50/ffffff/multiply.png" alt="close">
        </button>
    </div>
    <nav class="sidebar__nav">
        <ul class="sidebar__list">
            @if(Auth::check() && Auth::user()->isAdmin())
                <li class="sidebar__item sidebar__item--admin">
                    <a href="{{ route('admin.dashboard') }}" target="_blank">
                        <img src="https://img.icons8.com/ios-filled/50/ffffff/control-panel.png" alt="admin">
                        {{ __('Store Admin') }}
                    </a>
                </li>
            @endif

            <li class="sidebar__item sidebar__item--sale">
                <a href="{{ route('home') }}">
                    <img src="https://img.icons8.com/ios-filled/50/ffffff/percentage.png" alt="sale">
                    {{ __('SALE') }}
                </a>
            </li>

            @php
                $categoryIcons = [
                    'Smartphones' => 'iphone.png',
                    'iPhone' => 'iphone.png',
                    'Macbook' => 'macbook.png',
                    'Laptop' => 'macbook.png',
                    'iPad' => 'ipad.png',
                    'Tablet' => 'ipad.png',
                    'Apple Watch' => 'apple-watch.png',
                    'Watch' => 'apple-watch.png',
                    'AirPods' => 'headphones.png',
                    'Accessories' => 'lightning-cable.png',
                ];
                $defaultIcon = 'lightning-cable.png';
            @endphp

            @foreach($sidebarCategories as $category)
                <li class="sidebar__item">
                    <a href="{{ route('home', ['category' => $category->category]) }}">
                        @php
                            $icon = $categoryIcons[$category->category] ?? 
                                   $categoryIcons[Str::plural($category->category)] ?? 
                                   $categoryIcons[Str::singular($category->category)] ?? 
                                   $defaultIcon;
                        @endphp
                        <img src="https://img.icons8.com/ios-filled/50/ffffff/{{ $icon }}" alt="{{ $category->category }}">
                        {{ __($category->category) }}
                        <span class="category-count" style="margin-left: auto; font-size: 12px; opacity: 0.6;">{{ $category->total }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </nav>
</aside>
