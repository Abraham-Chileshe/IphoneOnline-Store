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
                        <span style="opacity: 0.8; margin-right: 15px;">Welcome: {{ explode(' ', Auth::user()->name)[0] }}</span>
                    @endauth
                    <img src="https://img.icons8.com/color/48/us-dollar-circled--v1.png" alt="dollar" class="icon">
                    <span>USD</span>
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
                                <span>Profile</span>
                            </a>
                            <a href="{{ route('logout') }}" class="header__action"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <img src="https://img.icons8.com/ios/50/ffffff/logout-rounded-left.png" alt="logout">
                                <span>Logout</span>
                            </a>
                        </div>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="header__action">
                            <img src="https://img.icons8.com/ios/50/ffffff/user.png" alt="login">
                            <span>Login</span>
                        </a>
                    @endauth
                    @auth
                        <a href="{{ route('profile.index', ['tab' => 'wishlist']) }}" class="header__action">
                            <img src="https://img.icons8.com/ios/50/ffffff/like.png" alt="wishlist">
                            <span>Wishlist</span>
                        </a>
                    @endauth
                    @auth
                        <a href="{{ route('profile.index', ['tab' => 'cart']) }}" class="header__action">
                            <img src="https://img.icons8.com/ios/50/ffffff/shopping-cart.png" alt="cart">
                            <span>Cart</span>
                        </a>
                    @else
                        <a href="{{ route('cart.index') }}" class="header__action">
                            <img src="https://img.icons8.com/ios/50/ffffff/shopping-cart.png" alt="cart">
                            <span>Cart</span>
                        </a>
                    @endauth


                    <button class="header__action" id="themeToggle">
                        <img src="https://img.icons8.com/ios/50/ffffff/sun--v1.png" alt="theme" id="themeIcon">
                        <span id="themeText">Light</span>
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
            <a href="{{ route('home') }}" class="active">Home</a>
             <a href="#">Accessories</a>
            <a href="#">Iphones</a>
           
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