<div>
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif

    <section class="profile-section">
        <h2 class="section-title">{{ __('In Cart') }} ({{ $cartItems->count() }})</h2>
        @if($cartItems->isNotEmpty())
            <div class="cart-summary-grid">
                @foreach($cartItems as $item)
                    <div class="cart-mini-card">
                        @php
                            $imagePath = $item->product->image;
                            if ($imagePath && !str_starts_with($imagePath, 'http')) {
                                $imagePath = asset('storage/' . $imagePath);
                            }
                        @endphp
                        <a href="{{ route('products.show', $item->product->id) }}" class="cart-item-link">
                            <img src="{{ $imagePath ?? 'https://via.placeholder.com/150' }}" alt="{{ $item->product->name }}">
                            <div class="cart-mini-name">{{ $item->product->name }}</div>
                        </a>
                        <div class="cart-mini-price">{{ $item->product->formatted_price }}</div>
                        <div class="cart-quantity-controls">
                            <button wire:click="decrementQuantity({{ $item->id }})" class="qty-btn" {{ $item->quantity <= 1 ? 'disabled' : '' }}>-</button>
                            <span class="qty-display">{{ $item->quantity }}</span>
                            <button wire:click="incrementQuantity({{ $item->id }})" class="qty-btn">+</button>
                        </div>
                        <button wire:click="removeItem({{ $item->id }})" class="btn-remove" title="{{ __('Remove item') }}">
                            <img src="https://img.icons8.com/ios-glyphs/30/ffffff/trash.png" alt="remove">
                        </button>
                    </div>
                @endforeach
            </div>

            <div class="cart-total-footer">
                <div class="total-info">
                    <span>{{ __('Order Total') }}:</span>
                    <span class="total-price">{{ \App\Models\Product::formatPrice($total) }}</span>
                </div>
                <button wire:click="placeOrder" class="btn-checkout" wire:loading.attr="disabled">
                    <span wire:loading.remove>{{ __('Place Order') }}</span>
                    <span wire:loading>{{ __('Processing...') }}</span>
                </button>
            </div>
        @else
            <p class="empty-msg">{{ __('Your cart is empty') }}</p>
        @endif
    </section>

    <style>
        .cart-mini-card {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            background: var(--bg-card);
            backdrop-filter: blur(10px);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 20px;
            transition: all 0.3s ease;
            width: 100%;
            max-width: 220px;
            margin: 0 auto;
        }

        .cart-item-link {
            text-decoration: none;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 10px;
        }

        .cart-item-link:hover .cart-mini-name {
            color: var(--primary-purple);
        }

        .cart-mini-card:hover {
            transform: translateY(-5px);
            background: var(--bg-card-hover);
            border-color: var(--primary-purple);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        [data-theme="dark"] .cart-mini-card:hover {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .cart-mini-card img {
            width: 100%;
            height: 120px;
            object-fit: contain;
            margin-bottom: 15px;
            filter: drop-shadow(0 5px 15px rgba(0,0,0,0.1));
        }

        .cart-mini-name {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-main);
            margin-bottom: 8px;
            text-align: center;
            width: 100%;
            word-wrap: break-word;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            height: 34px;
            line-height: 1.2;
            transition: color 0.2s;
        }

        .cart-mini-price {
            font-size: 18px;
            font-weight: 800;
            color: var(--primary-purple);
            margin-bottom: 15px;
        }

        .cart-quantity-controls {
            display: flex;
            align-items: center;
            gap: 15px;
            background: var(--border-color);
            border-radius: 30px;
            padding: 6px 12px;
            border: 1px solid var(--border-color);
        }

        .qty-btn {
            background: var(--primary-purple);
            border: none;
            color: white;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-weight: 700;
            font-size: 18px;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .qty-btn:hover:not(:disabled) {
            transform: scale(1.1);
            background: #e012be;
        }

        .qty-btn:active:not(:disabled) {
            transform: scale(0.95);
        }

        .qty-btn:disabled {
            background: var(--bg-card);
            color: var(--text-muted);
            opacity: 0.5;
            cursor: not-allowed;
        }

        .qty-display {
            font-size: 16px;
            font-weight: 700;
            min-width: 24px;
            text-align: center;
            color: var(--text-main);
        }

        .btn-remove {
            position: absolute;
            top: 12px;
            right: 12px;
            background: rgba(255, 59, 48, 0.1);
            border: 1px solid rgba(255, 59, 48, 0.2);
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            opacity: 0.6;
        }

        .cart-mini-card:hover .btn-remove {
            opacity: 1;
            background: #ff3b30;
            border-color: #ff3b30;
            transform: rotate(90deg);
        }

        .btn-remove img {
            width: 14px !important;
            height: 14px !important;
            margin: 0 !important;
            filter: brightness(0) invert(1);
        }

        .btn-remove:hover {
            box-shadow: 0 4px 12px rgba(255, 59, 48, 0.4);
        }

        .cart-total-footer {
            margin-top: 40px;
            padding: 30px;
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .total-price {
            font-size: 32px;
            font-weight: 900;
            color: var(--primary-purple);
        }

        .btn-checkout {
            background: linear-gradient(135deg, var(--primary-purple), #e012be);
            color: white;
            border: none;
            border-radius: 16px;
            padding: 18px 50px;
            font-weight: 800;
            font-size: 18px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 8px 25px rgba(181, 19, 154, 0.3);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-checkout:hover:not(:disabled) {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 12px 30px rgba(181, 19, 154, 0.4);
        }

        .alert {
            padding: 20px;
            border-radius: 16px;
            margin-bottom: 30px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: rgba(48, 209, 88, 0.1);
            border: 1px solid rgba(48, 209, 88, 0.3);
            color: #248a3d;
        }

        [data-theme="dark"] .alert-success {
            color: #30d158;
        }

        .alert-error {
            background: rgba(255, 69, 58, 0.1);
            border: 1px solid rgba(255, 69, 58, 0.3);
            color: #d1342b;
        }

        [data-theme="dark"] .alert-error {
            color: #ff453a;
        }
    </style>
</div>
