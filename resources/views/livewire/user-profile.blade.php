<div>
    <div class="profile-container">
        <aside class="profile-sidebar">
            <nav class="sidebar-menu">
                <button wire:click="setTab('personal-info')" class="sidebar-btn {{ $activeTab === 'personal-info' ? 'active' : '' }}">
                    <img src="https://img.icons8.com/ios-filled/50/ffffff/user.png" alt="profile">
                    <span>{{ __('Personal Info') }}</span>
                </button>
                <button wire:click="setTab('orders')" class="sidebar-btn {{ $activeTab === 'orders' ? 'active' : '' }}">
                    <img src="https://img.icons8.com/ios-filled/50/ffffff/package.png" alt="orders">
                    <span>{{ __('Orders') }}</span>
                    @if($orders->count() > 0)
                        <span class="nav-badge">{{ $orders->count() }}</span>
                    @endif
                </button>
                <button wire:click="setTab('wishlist')" class="sidebar-btn {{ $activeTab === 'wishlist' ? 'active' : '' }}">
                    <img src="https://img.icons8.com/ios-filled/50/ffffff/like.png" alt="wishlist">
                    <span>{{ __('Wishlist') }}</span>
                    @if($wishlistItems->count() > 0)
                        <span class="nav-badge">{{ $wishlistItems->count() }}</span>
                    @endif
                </button>

                <button wire:click="setTab('cart')" class="sidebar-btn {{ $activeTab === 'cart' ? 'active' : '' }}">
                    <img src="https://img.icons8.com/ios-filled/50/ffffff/shopping-cart.png" alt="cart">
                    <span>{{ __('My Cart') }}</span>
                    @if($cartCount > 0)
                        <span class="nav-badge nav-badge-cart">{{ $cartCount }}</span>
                    @endif
                </button>
            </nav>
        </aside>

        <main class="profile-content">
            @if (session()->has('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if($activeTab === 'personal-info')
                <section class="profile-section">
                    <h2 class="section-title">{{ __('Personal Information') }}</h2>
                    <form wire:submit.prevent="updateProfile" class="grid-form">
                        <div class="form-group full-width">
                            <label for="name">{{ __('Full Name') }}</label>
                            <input type="text" wire:model="name" id="name" class="profile-input" required>
                            @error('name') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">{{ __('Email') }}</label>
                            <input type="email" wire:model="email" id="email" class="profile-input" required>
                            @error('email') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="phone">{{ __('Phone') }}</label>
                            <input type="text" wire:model="phone" id="phone" class="profile-input">
                            @error('phone') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group full-width">
                            <label for="address">{{ __('Shipping Address') }}</label>
                            <input type="text" wire:model="address" id="address" class="profile-input">
                            @error('address') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="city">{{ __('City') }}</label>
                            <input type="text" wire:model="city" id="city" class="profile-input">
                            @error('city') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="postal_code">{{ __('Postal Code') }}</label>
                            <input type="text" wire:model="postal_code" id="postal_code" class="profile-input">
                            @error('postal_code') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit" class="btn-save" wire:loading.attr="disabled">
                            <span wire:loading.remove>{{ __('Save Changes') }}</span>
                            <span wire:loading>{{ __('Saving...') }}</span>
                        </button>
                    </form>
                </section>
            @elseif($activeTab === 'cart')
                <livewire:cart-summary />
            @elseif($activeTab === 'orders')
                <section class="profile-section">
                    <h2 class="section-title">{{ __('Your Orders') }} ({{ $orders->count() }})</h2>
                    @if($orders->isNotEmpty())
                        <div class="orders-list">
                            @foreach($orders as $order)
                                <div class="order-card">
                                    <div class="order-header">
                                        <div class="order-id">{{ __('Order') }} #{{ $order->id }}</div>
                                        <div class="order-status status-{{ $order->status }}">{{ __(ucfirst($order->status)) }}</div>
                                    </div>
                                    <div class="order-body">
                                        <div class="order-items-mini">
                                            @foreach($order->items as $item)
                                                <div class="order-item-row">
                                                    <span>{{ $item->product->name ?? __('Deleted Product') }} x {{ $item->quantity }}</span>
                                                    <span>{{ \App\Models\Product::formatPrice($item->price * $item->quantity) }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="order-footer">
                                            <div class="order-date">{{ $order->created_at->format('M d, Y') }}</div>
                                            <div class="order-total-amount">{{ __('Total') }}: {{ \App\Models\Product::formatPrice($order->total_amount) }}</div>
                                        </div>

                                        <div class="order-contact-store">
                                            <div class="contact-store-label">
                                                <i class="fa-solid fa-headset"></i>
                                                {{ __('Need help? Contact Store Owner') }}
                                            </div>
                                            <div class="contact-store-items">
                                                <a href="tel:{{ \App\Models\Setting::get('admin_phone') }}" class="contact-store-link">
                                                    <i class="fa-solid fa-phone"></i>
                                                    {{ \App\Models\Setting::get('admin_phone', '+260 977 123456') }}
                                                </a>
                                                <span class="contact-store-sep">|</span>
                                                <a href="mailto:{{ \App\Models\Setting::get('admin_email') }}" class="contact-store-link">
                                                    <i class="fa-solid fa-envelope"></i>
                                                    {{ \App\Models\Setting::get('admin_email', 'admin@example.com') }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="empty-msg">{{ __("You haven't placed any orders yet.") }}</p>
                    @endif
                </section>
            @elseif($activeTab === 'wishlist')
                <section class="profile-section">
                    <h2 class="section-title">{{ __('Your Wishlist') }} ({{ $wishlistItems->count() }})</h2>
                    @if($wishlistItems->isNotEmpty())
                        <div class="product-grid" style="grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));">
                            @foreach($wishlistItems as $item)
                                @if($item->product)
                                    <livewire:product-card :product="$item->product" :key="'wishlist-'.$item->product->id" />
                                @endif
                            @endforeach
                        </div>
                    @else
                        <p class="empty-msg">{{ __('Your wishlist is empty.') }}</p>
                    @endif
                </section>
            @endif

        </main>
    </div>

    <style>
        .profile-container {
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 30px;
            margin-bottom: 50px;
        }

        .profile-sidebar {
            background: var(--bg-card);
            backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 20px;
            height: fit-content;
        }

        .sidebar-menu {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .sidebar-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            border-radius: 12px;
            color: var(--text-main);
            background: transparent;
            border: none;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            text-align: left;
            width: 100%;
        }

        .sidebar-btn:hover, .sidebar-btn.active {
            background: var(--primary-purple);
            color: white;
        }

        .sidebar-btn img {
            width: 20px;
            filter: brightness(0) invert(1);
            transition: filter 0.2s;
        }

        [data-theme="light"] .sidebar-btn img {
            filter: brightness(0);
        }

        .sidebar-btn:hover img, .sidebar-btn.active img {
            filter: brightness(0) invert(1);
        }

        .nav-badge {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            padding: 2px 8px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            margin-left: auto;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-btn.active .nav-badge {
            background: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.5);
        }

        .nav-badge-cart {
            background: #ff3b30; /* Bright red for attention */
            box-shadow: 0 0 10px rgba(255, 59, 48, 0.4);
        }

        [data-theme="light"] .nav-badge:not(.nav-badge-cart) {
            background: rgba(0, 0, 0, 0.05);
            color: #1d1d1f;
            border: 1px solid rgba(0, 0, 0, 0.1);
        }

        [data-theme="light"] .sidebar-btn.active .nav-badge:not(.nav-badge-cart) {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }

        .profile-content {
            display: flex;
            flex-direction: column;
            gap: 30px;
        }

        .profile-section {
            background: var(--bg-card);
            backdrop-filter: blur(20px);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            padding: 30px;
        }

        .section-title {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 25px;
            color: var(--text-main);
        }

        .grid-form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-group label {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-muted);
        }

        .profile-input {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 12px 15px;
            color: var(--text-main);
            outline: none;
            font-size: 16px;
            transition: all 0.2s;
        }

        [data-theme="light"] .profile-input {
            background: #ffffff;
        }

        .profile-input:focus {
            border-color: var(--primary-purple);
        }

        .full-width {
            grid-column: span 2;
        }

        .btn-save {
            background: var(--primary-purple);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 15px 30px;
            font-weight: 700;
            cursor: pointer;
            width: fit-content;
            margin-top: 10px;
            transition: transform 0.2s;
        }

        .btn-save:hover:not(:disabled) {
            transform: scale(1.02);
            background: #e012be;
        }

        .btn-save:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .cart-summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 15px;
        }

        .cart-mini-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 15px;
            text-align: center;
        }

        .cart-mini-card img {
            width: 100%;
            height: 100px;
            object-fit: contain;
            margin-bottom: 10px;
        }

        .cart-mini-name {
            font-size: 14px;
            font-weight: 500;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            margin-bottom: 5px;
            color: var(--text-main);
        }

        .cart-mini-price {
            color: var(--primary-purple);
            font-weight: 700;
        }

        .empty-msg {
            color: var(--text-muted);
            text-align: center;
            padding: 20px;
        }

        .alert {
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 20px;
        }

        .alert-success {
            background: rgba(48, 209, 88, 0.1);
            border: 1px solid rgba(48, 209, 88, 0.3);
            color: #248a3d;
        }

        [data-theme="dark"] .alert-success {
            color: #30d158;
        }

        .error {
            color: #ff3b30;
            font-size: 12px;
        }

        @media (max-width: 992px) {
            .profile-container {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .grid-form, .cart-summary-grid {
                grid-template-columns: 1fr;
            }
            .full-width {
                grid-column: span 1;
            }
        }
        /* Orders Styling */
        .order-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            margin-bottom: 20px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        [data-theme="light"] .order-card {
            background: #ffffff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        .order-header {
            background: var(--bg-card-hover);
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--border-color);
        }

        [data-theme="light"] .order-header {
            background: rgba(0, 0, 0, 0.02);
        }

        .order-id {
            font-weight: 700;
            color: var(--primary-purple);
        }

        .order-status {
            font-size: 12px;
            padding: 4px 12px;
            border-radius: 20px;
            font-weight: 600;
        }

        .status-pending { background: rgba(255, 159, 10, 0.2); color: #ff9f0a; }
        .status-processing { background: rgba(10, 132, 255, 0.2); color: #0a84ff; }
        .status-shipped { background: rgba(191, 90, 242, 0.2); color: #bf5af2; }
        .status-delivered, .status-completed { background: rgba(48, 209, 88, 0.2); color: #30d158; }
        .status-cancelled { background: rgba(255, 69, 58, 0.2); color: #ff453a; }

        .order-body {
            padding: 20px;
        }

        .order-item-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 14px;
            color: var(--text-muted);
        }

        .order-footer {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px dashed var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .order-total-amount {
            font-weight: 700;
            font-size: 16px;
        }

        .order-date {
            font-size: 12px;
            color: var(--text-muted);
        }

        .order-contact-store {
            margin-top: 20px;
            padding: 15px;
            background: rgba(203, 17, 171, 0.05);
            border: 1px dashed var(--primary-purple);
            border-radius: 12px;
            display: flex;
            flex-direction: column;
            gap: 10px;
            align-items: center;
        }

        .contact-store-label {
            font-size: 13px;
            font-weight: 700;
            color: var(--primary-purple);
            display: flex;
            align-items: center;
            gap: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .contact-store-items {
            display: flex;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .contact-store-link {
            color: var(--text-main);
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: color 0.2s;
        }

        .contact-store-link:hover {
            color: var(--primary-purple);
        }

        .contact-store-link i {
            color: var(--primary-purple);
            font-size: 14px;
        }

        .contact-store-sep {
            color: var(--border-color);
            font-weight: 300;
        }

        @media (max-width: 576px) {
            .contact-store-sep {
                display: none;
            }
            .contact-store-items {
                flex-direction: column;
                gap: 8px;
            }
        }
    </style>
</div>
