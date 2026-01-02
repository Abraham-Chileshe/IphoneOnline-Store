<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div style="display: flex; justify-content: center; align-items: center; padding: 8px 0;">
            <p style="margin: 0; color: var(--text-muted); font-size: 14px; text-align: center;">
                © {{ date('Y') }} {{ __('iPhone Store') }}. {{ __('All rights reserved') }}. {{ __('Developed by') }} Chileshe.
            </p>
        </div>
    </div>
</footer>

<!-- Mobile Bottom Navigation -->
<nav class="mobile-nav">
    <a href="{{ route('home') }}" class="mobile-nav__item {{ request()->routeIs('home') ? 'active' : '' }}">
        <img src="https://img.icons8.com/ios-filled/50/{{ request()->routeIs('home') ? 'a23ff2' : 'ffffff' }}/home.png" alt="home">
    </a>
    <a href="#" class="mobile-nav__item">
        <img src="https://img.icons8.com/ios/50/ffffff/search--v1.png" alt="search">
    </a>
    @auth
        <a href="{{ route('profile.index', ['tab' => 'cart']) }}" class="mobile-nav__item {{ request()->get('tab') === 'cart' ? 'active' : '' }}">
            <img src="https://img.icons8.com/ios/50/ffffff/shopping-cart.png" alt="cart">
        </a>
        <a href="{{ route('profile.index', ['tab' => 'wishlist']) }}" class="mobile-nav__item {{ request()->get('tab') === 'wishlist' ? 'active' : '' }}">
            <img src="https://img.icons8.com/ios/50/ffffff/like--v1.png" alt="wishlist">
        </a>
        <a href="{{ route('profile.index') }}" class="mobile-nav__item {{ request()->routeIs('profile.*') && !request()->has('tab') ? 'active' : '' }}">
            <img src="https://img.icons8.com/ios/50/ffffff/user.png" alt="profile">
        </a>
    @else
        <a href="{{ route('cart.index') }}" class="mobile-nav__item {{ request()->routeIs('cart.*') ? 'active' : '' }}">
            <img src="https://img.icons8.com/ios/50/ffffff/shopping-cart.png" alt="cart">
        </a>
        <a href="{{ route('login') }}" class="mobile-nav__item">
            <img src="https://img.icons8.com/ios/50/ffffff/like--v1.png" alt="wishlist">
        </a>
        <a href="{{ route('login') }}" class="mobile-nav__item">
            <img src="https://img.icons8.com/ios/50/ffffff/user.png" alt="profile">
        </a>
    @endauth

</nav>

<div class="chat-toggle">
    <img src="https://img.icons8.com/ios-filled/50/ffffff/chat.png" alt="chat">
</div>
