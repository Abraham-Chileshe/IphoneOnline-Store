<!-- Desktop Header -->
<header class="header">
    <div class="header__top">
        <div class="container">
            <div class="header__top-inner">
                <div class="header__location">
                    <div class="header__dropdown-container">
                        <button class="header__dropdown-btn" id="cityDropdownBtn">
                            <img src="https://img.icons8.com/ios-filled/50/ffffff/marker.png" alt="location" class="icon" style="width: 14px; height: 14px;">
                            <span>{{ session('selected_city') ? __(session('selected_city')) : __('All') }}</span>
                            <img src="https://img.icons8.com/ios-glyphs/30/ffffff/chevron-down.png" style="width: 10px; margin-left: 4px; opacity: 0.7;">
                        </button>
                        <div class="header__dropdown-menu" id="cityDropdownMenu">
                            <a href="#" onclick="event.preventDefault(); document.getElementById('city-all-form').submit();">{{ __('All') }}</a>
                            <a href="#" onclick="event.preventDefault(); document.getElementById('city-moscow-form').submit();">{{ __('Moscow') }}</a>
                            <a href="#" onclick="event.preventDefault(); document.getElementById('city-spb-form').submit();">{{ __('Saint Petersburg') }}</a>
                            <a href="#" onclick="event.preventDefault(); document.getElementById('city-novokuznetsk-form').submit();">{{ __('Novokuznetsk') }}</a>
                        </div>
                        
                        <form id="city-all-form" action="{{ route('city.switch', 'all') }}" method="POST" style="display: none;">@csrf</form>
                        <form id="city-moscow-form" action="{{ route('city.switch', 'Moscow') }}" method="POST" style="display: none;">@csrf</form>
                        <form id="city-spb-form" action="{{ route('city.switch', 'Saint Petersburg') }}" method="POST" style="display: none;">@csrf</form>
                        <form id="city-novokuznetsk-form" action="{{ route('city.switch', 'Novokuznetsk') }}" method="POST" style="display: none;">@csrf</form>
                    </div>
                </div>

                <style>
                    .header__dropdown-container {
                        position: relative;
                        display: inline-block;
                    }
                    .header__dropdown-btn {
                        background: none;
                        border: none;
                        color: white;
                        font-size: 13px;
                        font-weight: 600;
                        display: flex;
                        align-items: center;
                        gap: 6px;
                        cursor: pointer;
                        padding: 4px 8px;
                        border-radius: 8px;
                        transition: background 0.2s;
                    }
                    .header__dropdown-btn:hover {
                        background: rgba(255,255,255,0.1);
                    }
                    .header__dropdown-menu {
                        display: none;
                        position: absolute;
                        top: 100%;
                        left: 0;
                        background: #222;
                        border: 1px solid rgba(255,255,255,0.1);
                        border-radius: 12px;
                        min-width: 160px;
                        box-shadow: 0 10px 30px rgba(0,0,0,0.5);
                        z-index: 9999;
                        margin-top: 8px;
                        overflow: hidden;
                    }
                    .header__dropdown-menu.show {
                        display: block;
                    }
                    .header__dropdown-menu a {
                        color: rgba(255,255,255,0.8);
                        padding: 12px 16px;
                        text-decoration: none;
                        display: block;
                        font-size: 13px;
                        font-weight: 500;
                        transition: all 0.2s;
                    }
                    .header__dropdown-menu a:hover {
                        background: rgba(255,255,255,0.05);
                        color: white;
                    }
                </style>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        // Desktop Dropdown
                        const btn = document.getElementById('cityDropdownBtn');
                        const menu = document.getElementById('cityDropdownMenu');
                        
                        if (btn && menu) {
                            btn.addEventListener('click', function(e) {
                                e.stopPropagation();
                                menu.classList.toggle('show');
                            });
                        }

                        // Mobile Dropdown
                        const btnMobile = document.getElementById('cityDropdownBtnMobile');
                        const menuMobile = document.getElementById('cityDropdownMenuMobile');
                        
                        if (btnMobile && menuMobile) {
                            btnMobile.addEventListener('click', function(e) {
                                e.stopPropagation();
                                menuMobile.classList.toggle('show');
                            });
                        }
                        
                        document.addEventListener('click', function() {
                            if (menu) menu.classList.remove('show');
                            if (menuMobile) menuMobile.classList.remove('show');
                        });
                    });
                </script>
                <nav class="header__top-nav">
                    {{-- <a href="{{ route('home') }}">Home</a>
                    <a href="#">iPhones</a>
                    <a href="#">Accessories</a> --}}
                </nav>
                <div class="header__top-right">
                    @auth
                        <span style="opacity: 0.8; margin-right: 15px;">{{ __('Welcome') }}: {{ explode(' ', Auth::user()->name)[0] }}</span>
                    @endauth
                    <div style="display: flex; align-items: center; gap: 12px; margin-left: 15px; border-left: 1px solid rgba(255,255,255,0.2); padding-left: 15px;">
                        <a href="#" onclick="event.preventDefault(); document.getElementById('currency-usd-form').submit();" style="display: flex; align-items: center; gap: 4px; text-decoration: none; opacity: {{ session('currency') == 'USD' ? '1' : '0.4' }}; transition: opacity 0.2s;">
                            <img src="https://img.icons8.com/color/48/us-dollar-circled--v1.png" alt="dollar" class="icon" style="width: 20px;">
                            <span style="color: white; font-size: 13px; font-weight: 600;">USD</span>
                        </a>
                        <form id="currency-usd-form" action="{{ route('currency.switch', 'USD') }}" method="POST" style="display: none;">@csrf</form>
                        <span style="color: rgba(255,255,255,0.2);">|</span>
                        <a href="#" onclick="event.preventDefault(); document.getElementById('currency-rub-form').submit();" style="display: flex; align-items: center; gap: 4px; text-decoration: none; opacity: {{ session('currency') == 'RUB' ? '1' : '0.4' }}; transition: opacity 0.2s;">
                            <img src="https://img.icons8.com/color/48/ruble.png" alt="ruble" class="icon" style="width: 20px;">
                            <span style="color: white; font-size: 13px; font-weight: 600;">RUB</span>
                        </a>
                        <form id="currency-rub-form" action="{{ route('currency.switch', 'RUB') }}" method="POST" style="display: none;">@csrf</form>
                        <span style="color: rgba(255,255,255,0.2);">|</span>
                        <a href="#" onclick="event.preventDefault(); document.getElementById('currency-aed-form').submit();" style="display: flex; align-items: center; gap: 4px; text-decoration: none; opacity: {{ session('currency') == 'AED' ? '1' : '0.4' }}; transition: opacity 0.2s;">
                            <img src="https://img.icons8.com/color/48/united-arab-emirates.png" alt="uae" class="icon" style="width: 20px;">
                            <span style="color: white; font-size: 13px; font-weight: 600;">AED</span>
                        </a>
                        <form id="currency-aed-form" action="{{ route('currency.switch', 'AED') }}" method="POST" style="display: none;">@csrf</form>
                    </div>
                    
                    <div class="lang-switch" style="display: flex; gap: 10px; font-size: 13px; font-weight: 600; margin-left: 15px; border-left: 1px solid rgba(255,255,255,0.2); padding-left: 15px;">
                        <a href="#" onclick="event.preventDefault(); document.getElementById('lang-en-form').submit();" style="color: {{ app()->getLocale() == 'en' ? '#fff' : 'rgba(255,255,255,0.5)' }}; text-decoration: none; transition: color 0.2s;">EN</a>
                        <form id="lang-en-form" action="{{ route('lang.switch', 'en') }}" method="POST" style="display: none;">@csrf</form>
                        <span style="color: rgba(255,255,255,0.2);">|</span>
                        <a href="#" onclick="event.preventDefault(); document.getElementById('lang-ru-form').submit();" style="color: {{ app()->getLocale() == 'ru' ? '#fff' : 'rgba(255,255,255,0.5)' }}; text-decoration: none; transition: color 0.2s;">RU</a>
                        <form id="lang-ru-form" action="{{ route('lang.switch', 'ru') }}" method="POST" style="display: none;">@csrf</form>
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
           <div style="display: flex; align-items: center; gap: 12px; margin-left: 15px; border-left: 1px solid rgba(255,255,255,0.2); padding-left: 15px;">
                        <a href="#" onclick="event.preventDefault(); document.getElementById('currency-usd-form-mobile').submit();" style="display: flex; align-items: center; gap: 4px; text-decoration: none; opacity: {{ session('currency') == 'USD' ? '1' : '0.4' }}; transition: opacity 0.2s;">
                            <img src="https://img.icons8.com/color/48/us-dollar-circled--v1.png" alt="dollar" class="icon" style="width: 20px;">
                            <span style="color: white; font-size: 13px; font-weight: 600;">USD</span>
                        </a>
                        <form id="currency-usd-form-mobile" action="{{ route('currency.switch', 'USD') }}" method="POST" style="display: none;">@csrf</form>
                        <span style="color: rgba(255,255,255,0.2);">|</span>
                        <a href="#" onclick="event.preventDefault(); document.getElementById('currency-rub-form-mobile').submit();" style="display: flex; align-items: center; gap: 4px; text-decoration: none; opacity: {{ session('currency') == 'RUB' ? '1' : '0.4' }}; transition: opacity 0.2s;">
                            <img src="https://img.icons8.com/color/48/ruble.png" alt="ruble" class="icon" style="width: 20px;">
                            <span style="color: white; font-size: 13px; font-weight: 600;">RUB</span>
                        </a>
                        <form id="currency-rub-form-mobile" action="{{ route('currency.switch', 'RUB') }}" method="POST" style="display: none;">@csrf</form>
                        <span style="color: rgba(255,255,255,0.2);">|</span>
                        <a href="#" onclick="event.preventDefault(); document.getElementById('currency-aed-form-mobile').submit();" style="display: flex; align-items: center; gap: 4px; text-decoration: none; opacity: {{ session('currency') == 'AED' ? '1' : '0.4' }}; transition: opacity 0.2s;">
                            <img src="https://img.icons8.com/color/48/united-arab-emirates.png" alt="uae" class="icon" style="width: 20px;">
                            <span style="color: white; font-size: 13px; font-weight: 600;">AED</span>
                        </a>
                        <form id="currency-aed-form-mobile" action="{{ route('currency.switch', 'AED') }}" method="POST" style="display: none;">@csrf</form>
                    </div>
                    
                    <div class="lang-switch" style="display: flex; gap: 10px; font-size: 13px; font-weight: 600; margin-left: 15px; border-left: 1px solid rgba(255,255,255,0.2); padding-left: 15px;">
                        <a href="#" onclick="event.preventDefault(); document.getElementById('lang-en-form-mobile').submit();" style="color: {{ app()->getLocale() == 'en' ? '#fff' : 'rgba(255,255,255,0.5)' }}; text-decoration: none; transition: color 0.2s;">EN</a>
                        <form id="lang-en-form-mobile" action="{{ route('lang.switch', 'en') }}" method="POST" style="display: none;">@csrf</form>
                        <span style="color: rgba(255,255,255,0.2);">|</span>
                        <a href="#" onclick="event.preventDefault(); document.getElementById('lang-ru-form-mobile').submit();" style="color: {{ app()->getLocale() == 'ru' ? '#fff' : 'rgba(255,255,255,0.5)' }}; text-decoration: none; transition: color 0.2s;">RU</a>
                        <form id="lang-ru-form-mobile" action="{{ route('lang.switch', 'ru') }}" method="POST" style="display: none;">@csrf</form>
                    </div>
           
        </div>
    </div>
    <div class="header-mobile__main">
        <button class="header__burger header__burger--mobile" id="mobileBurger">
            <span></span><span></span><span></span>
        </button>
        <livewire:global-search layout="mobile" />

        <div class="header-mobile__location">
            <div class="header__dropdown-container">
                <button class="header__dropdown-btn" id="cityDropdownBtnMobile">
                    <img src="https://img.icons8.com/ios-filled/50/ffffff/marker.png" alt="location" class="icon" style="width: 14px; height: 14px;">
                    <span>{{ session('selected_city') ? __(session('selected_city')) : __('All') }}</span>
                </button>
                <div class="header__dropdown-menu" id="cityDropdownMenuMobile" style="right: 0; left: auto;">
                    <a href="#" onclick="event.preventDefault(); document.getElementById('city-all-form-mobile').submit();">{{ __('All') }}</a>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('city-moscow-form-mobile').submit();">{{ __('Moscow') }}</a>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('city-spb-form-mobile').submit();">{{ __('Saint Petersburg') }}</a>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('city-novokuznetsk-form-mobile').submit();">{{ __('Novokuznetsk') }}</a>
                </div>
                
                <form id="city-all-form-mobile" action="{{ route('city.switch', 'all') }}" method="POST" style="display: none;">@csrf</form>
                <form id="city-moscow-form-mobile" action="{{ route('city.switch', 'Moscow') }}" method="POST" style="display: none;">@csrf</form>
                <form id="city-spb-form-mobile" action="{{ route('city.switch', 'Saint Petersburg') }}" method="POST" style="display: none;">@csrf</form>
                <form id="city-novokuznetsk-form-mobile" action="{{ route('city.switch', 'Novokuznetsk') }}" method="POST" style="display: none;">@csrf</form>
            </div>
        </div>
    </div>
</header>