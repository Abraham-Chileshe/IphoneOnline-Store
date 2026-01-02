<!-- Desktop Header -->
<header class="header">
    <div class="header__top">
        <div class="container">
            <div class="header__top-inner">
                <div class="header__location">
                    <img src="https://img.icons8.com/ios-filled/50/ffffff/marker.png" alt="location" class="icon">
                    <span>Lusaka</span>
                </div>
                <nav class="header__top-nav">
                    {{-- <a href="{{ route('home') }}">Home</a>
                    <a href="#">iPhones</a>
                    <a href="#">Accessories</a> --}}
                </nav>
                <div class="header__top-right">
                    @auth
                        <span style="opacity: 0.8; margin-right: 15px;">{{ __('Welcome') }}: {{ explode(' ', Auth::user()->name)[0] }}</span>
                    @endauth
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <img src="https://img.icons8.com/color/48/us-dollar-circled--v1.png" alt="dollar" class="icon">
                        <span>{{ __('USD') }}</span>
                    </div>
                    <div class="lang-switch" style="display: flex; gap: 10px; font-size: 13px; font-weight: 600; margin-left: 15px; border-left: 1px solid rgba(255,255,255,0.2); padding-left: 15px;">
                        <a href="{{ route('lang.switch', 'en') }}" style="color: {{ app()->getLocale() == 'en' ? '#fff' : 'rgba(255,255,255,0.5)' }}; text-decoration: none; transition: color 0.2s;">EN</a>
                        <span style="color: rgba(255,255,255,0.2);">|</span>
                        <a href="{{ route('lang.switch', 'ru') }}" style="color: {{ app()->getLocale() == 'ru' ? '#fff' : 'rgba(255,255,255,0.5)' }}; text-decoration: none; transition: color 0.2s;">RU</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header__main">

        <div class="container">
            <div class="header__main-inner">
                <div class="header__logo">
                    <a href="{{ route('home') }}" class="logo-wb">Ab</a>
                </div>
                <button class="header__burger" id="desktopBurger">
                    <span></span><span></span><span></span>
                </button>
                <livewire:global-search layout="desktop" />

                <div class="header__actions">

                    @auth
                        <div class="user-menu" style="display: flex; align-items: center; gap: 15px;">
                            <a href="{{ route('profile.index') }}" class="header__action">
                                <img src="https://img.icons8.com/ios/50/ffffff/user.png" alt="profile">
                                <span>{{ __('Profile') }}</span>
                            </a>
                            <a href="{{ route('logout') }}" class="header__action"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <img src="https://img.icons8.com/ios/50/ffffff/logout-rounded-left.png" alt="logout">
                                <span>{{ __('Logout') }}</span>
                            </a>
                        </div>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="header__action">
                            <img src="https://img.icons8.com/ios/50/ffffff/user.png" alt="login">
                            <span>{{ __('Login') }}</span>
                        </a>
                    @endauth
                    @auth
                        <a href="{{ route('profile.index', ['tab' => 'wishlist']) }}" class="header__action">
                            <img src="https://img.icons8.com/ios/50/ffffff/like.png" alt="wishlist">
                            <span>{{ __('Wishlist') }}</span>
                        </a>
                    @endauth
                    @auth
                        <a href="{{ route('profile.index', ['tab' => 'cart']) }}" class="header__action">
                            <img src="https://img.icons8.com/ios/50/ffffff/shopping-cart.png" alt="cart">
                            <span>{{ __('Cart') }}</span>
                        </a>
                    @else
                        <a href="{{ route('cart.index') }}" class="header__action">
                            <img src="https://img.icons8.com/ios/50/ffffff/shopping-cart.png" alt="cart">
                            <span>{{ __('Cart') }}</span>
                        </a>
                    @endauth


                    <button class="header__action" id="themeToggle" data-light="{{ __('Light') }}" data-dark="{{ __('Dark') }}">
                        <img src="https://img.icons8.com/ios/50/ffffff/sun--v1.png" alt="theme" id="themeIcon">
                        <span id="themeText">{{ __('Light') }}</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Mobile Header -->
<header class="header-mobile">
    <div class="header-mobile__top-nav">
        <div class="header-mobile__nav-scroll">
            <a href="{{ route('home') }}" class="active">{{ __('Home') }}</a>
             <a href="#">{{ __('Accessories') }}</a>
            <a href="#">{{ __('iPhones') }}</a>
           
        </div>
    </div>
    <div class="header-mobile__main">
        <button class="header__burger header__burger--mobile" id="mobileBurger">
            <span></span><span></span><span></span>
        </button>
        <livewire:global-search layout="mobile" />

        <div class="header-mobile__location">
            <img src="https://img.icons8.com/ios-filled/50/ffffff/marker.png" alt="location">
        </div>
    </div>
</header>