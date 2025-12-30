<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="footer__inner">
            <div class="footer__col">
                <h4>iPhone Lineup</h4>
                <ul>
                    <li><a href="#">iPhone 15 Pro</a></li>
                    <li><a href="#">iPhone 15</a></li>
                    <li><a href="#">iPhone 14</a></li>
                    <li><a href="#">iPhone 13</a></li>
                </ul>
            </div>
            <div class="footer__col">
                <h4>Apple Services</h4>
                <ul>
                    <li><a href="#">Apple Music</a></li>
                    <li><a href="#">Apple TV+</a></li>
                    <li><a href="#">iCloud</a></li>
                    <li><a href="#">Apple Arcade</a></li>
                </ul>
            </div>
            <div class="footer__col">
                <h4>Support</h4>
                <ul>
                    <li><a href="#">Help & Repair</a></li>
                    <li><a href="#">Warranty</a></li>
                    <li><a href="#">Order Status</a></li>
                    <li><a href="#">Contact Us</a></li>
                </ul>
            </div>
            <div class="footer__col">
                <h4>About Us</h4>
                <p>© 2025 iPhone Store. All rights reserved.</p>
            </div>
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
    <a href="{{ route('cart.index') }}" class="mobile-nav__item {{ request()->routeIs('cart.*') ? 'active' : '' }}">
        <img src="https://img.icons8.com/ios/50/ffffff/shopping-cart.png" alt="cart">
    </a>
    <a href="#" class="mobile-nav__item">
        <img src="https://img.icons8.com/ios/50/ffffff/like--v1.png" alt="wishlist">
    </a>
    <a href="{{ route('login') }}" class="mobile-nav__item">
        <img src="https://img.icons8.com/ios/50/ffffff/user.png" alt="profile">
    </a>
</nav>

<div class="chat-toggle">
    <img src="https://img.icons8.com/ios-filled/50/ffffff/chat.png" alt="chat">
</div>
