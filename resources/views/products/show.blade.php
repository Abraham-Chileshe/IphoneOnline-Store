@extends('layouts.app')

@section('title', $product->name . ' — iPhone Store')

@section('content')
<div class="container" style="max-width: 1400px; margin: 0 auto; padding: 20px;">
    <!-- Breadcrumbs -->
    <nav class="breadcrumbs" style="margin-bottom: 25px; white-space: nowrap; overflow-x: auto; padding-bottom: 10px; -webkit-overflow-scrolling: touch; scrollbar-width: none;">
        <a href="{{ route('home') }}">{{ __('Home') }}</a> / 
        <a href="{{ route('home', ['category' => $product->category]) }}">{{ $product->category ?? __('Smartphones') }}</a> / 
        <span>{{ $product->brand }}</span> / 
        <span style="color: var(--text-muted); padding-right: 20px;">{{ $product->name }}</span>
    </nav>

    <div class="product-layout">
        <!-- 1. Gallery Section -->
        <div class="gallery-section">
            <div class="gallery-container">
                <div class="gallery-thumbs">
                    <div class="thumb active" onclick="switchMainImage('{{ asset($product->image) }}', this)">
                        <img src="{{ asset($product->image) }}" alt="main">
                    </div>
                    @if($product->image_2)
                        <div class="thumb" onclick="switchMainImage('{{ asset($product->image_2) }}', this)">
                            <img src="{{ asset($product->image_2) }}" alt="thumb 2">
                        </div>
                    @endif
                    @if($product->image_3)
                        <div class="thumb" onclick="switchMainImage('{{ asset($product->image_3) }}', this)">
                            <img src="{{ asset($product->image_3) }}" alt="thumb 3">
                        </div>
                    @endif
                    @if($product->image_4)
                        <div class="thumb" onclick="switchMainImage('{{ asset($product->image_4) }}', this)">
                            <img src="{{ asset($product->image_4) }}" alt="thumb 4">
                        </div>
                    @endif
                </div>
                <div class="gallery-main">
                    @if($product->discount_percentage > 0)
                        <span class="gallery-sale-badge">-{{ $product->discount_percentage }}%</span>
                    @endif
                    <img id="mainProductImage" src="{{ asset($product->image) }}" alt="{{ $product->name }}">
                    
                    <div class="gallery-overlay-actions">
                        <button class="overlay-btn" title="{{ __('Add to Wishlist') }}">
                            <i class="fa-regular fa-heart"></i>
                        </button>
                        <button class="overlay-btn" title="{{ __('Share') }}">
                            <i class="fa-solid fa-share-nodes"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Info Section -->
        <div class="info-section">
            <div class="info-card">
                <span class="info-brand">{{ $product->brand }}</span>
                <h1 class="info-title">{{ $product->name }}</h1>
                
                <div class="info-rating">
                    <div class="stars">
                        <i class="fa-solid fa-star"></i>
                        <span>{{ $product->rating }}</span>
                    </div>
                    <span class="sep">·</span>
                    <span class="reviews-link">{{ number_format($product->reviews_count, 0, ',', ' ') }} {{ __('reviews') }}</span>
                    <span class="sep">·</span>
                    <span class="ask-btn">{{ __('Ask a question') }}</span>
                </div>

                <div class="info-description">
                    <h3>{{ __('Description') }}</h3>
                    <p>{{ $product->description }}</p>
                </div>

                <div class="info-specs">
                    <div class="spec-item">
                        <span class="spec-label">{{ __('SKU') }}</span>
                        <span class="spec-value">
                            {{ str_pad($product->id, 8, '0', STR_PAD_LEFT) }}
                            <i class="fa-regular fa-copy copy-icon"></i>
                        </span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">{{ __('Category') }}</span>
                        <span class="spec-value">{{ $product->category ?? __('iPhone') }}</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">{{ __('Brand') }}</span>
                        <span class="spec-value">{{ $product->brand }}</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">{{ __('Availability') }}</span>
                        <span class="spec-value stock-status {{ $product->stock > 0 ? 'in-stock' : 'out-of-stock' }}">
                            <i class="fa-solid {{ $product->stock > 0 ? 'fa-circle-check' : 'fa-circle-xmark' }}"></i>
                            @if($product->stock > 0)
                                {{ __('In Stock') }} ({{ $product->stock }} {{ __($product->stock == 1 ? 'unit' : 'units') }} {{ __('available') }})
                            @else
                                {{ __('Out of Stock') }}
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. Purchase Section -->
        <div class="purchase-section">
            <div class="purchase-card">
                <div class="price-header">
                    <div class="price-main-row">
                        <span class="price-current" id="dynamicPrice">{{ $product->formatted_price }}</span>
                        @if($product->old_price)
                            <span class="price-old">{{ $product->formatted_old_price }}</span>
                        @endif
                    </div>
                    @if($product->discount_percentage > 0)
                        <div class="price-discount-tag">-{{ $product->discount_percentage }}%</div>
                    @endif
                </div>
                
                <div class="wallet-promo-card">
                    <i class="fa-solid fa-wallet"></i>
                    <span>{{ __('Price with WB Wallet') }}</span>
                </div>

                <div class="purchase-controls">
                    <div class="qty-control-group">
                        <label>{{ __('Quantity') }}:</label>
                        <div class="qty-stepper">
                            <button class="step-btn" onclick="modifyQty(-1)"><i class="fa-solid fa-minus"></i></button>
                            <input type="number" id="buyQuantity" value="1" min="1" max="{{ $product->stock }}" readonly>
                            <button class="step-btn" onclick="modifyQty(1)"><i class="fa-solid fa-plus"></i></button>
                        </div>
                    </div>

                    <div class="action-buttons">
                        @auth
                            @if($product->stock > 0)
                                <button class="btn-buy-primary" 
                                        id="mainAddToCartBtn" 
                                        onclick="handleAddToCart({{ $product->id }})"
                                        data-in-cart="{{ $isInCart ? 'true' : 'false' }}"
                                        style="{{ $isInCart ? 'background: #22c55e;' : '' }}">
                                    <i class="fa-solid {{ $isInCart ? 'fa-cart-check' : 'fa-cart-plus' }}"></i>
                                    <span>{{ $isInCart ? __('Added to Cart') : __('Add to Cart') }}</span>
                                </button>
                                <button class="btn-buy-outline" onclick="handleBuyNow({{ $product->id }})">
                                    {{ __('Buy Now') }}
                                </button>
                            @else
                                <button class="btn-buy-disabled" disabled>
                                    <i class="fa-solid fa-ban"></i>
                                    {{ __('Out of Stock') }}
                                </button>
                            @endif
                        @else
                            <button class="btn-buy-primary" onclick="window.location.href='{{ route('login') }}'">
                                <i class="fa-solid fa-right-to-bracket"></i>
                                {{ __('Sign In to Purchase') }}
                            </button>
                        @endauth
                    </div>
                </div>

                <div class="delivery-perks">
                    <div class="perk">
                        <i class="fa-solid fa-truck-fast"></i>
                        <div>
                            <span>{{ __('Delivery') }}: <b>{{ Auth::check() ? __('Tomorrow') : __('Contact') }}</b></span>
                        </div>
                    </div>
                    <div class="perk">
                        <i class="fa-solid fa-store"></i>
                        <div>
                            <span>{{ __('Sold by') }}: <b>{{ __('Official Apple Store') }}</b></span>
                            <div class="seller-rating">
                                <i class="fa-solid fa-star"></i> 5.0
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Reviews Section --}}
    <div class="reviews-section-wrapper">
        <livewire:product-reviews :productId="$product->id" />
    </div>
</div>
@endsection

@push('styles')
<style>
    :root {
        --card-radius: 24px;
        --inner-radius: 16px;
    }

    .product-layout {
        display: grid;
        grid-template-columns: 1fr 1fr 400px;
        gap: 40px;
        align-items: start;
    }

    @media (max-width: 1300px) {
        .product-layout {
            grid-template-columns: 1.2fr 1fr;
        }
        .purchase-section {
            grid-column: 1 / -1;
            display: flex;
            justify-content: center;
        }
        .purchase-card {
            width: 100%;
            max-width: 600px;
        }
    }

    @media (max-width: 992px) {
        .product-layout {
            grid-template-columns: 1fr;
        }
    }

    /* --- Gallery --- */
    .gallery-container {
        display: flex;
        gap: 20px;
    }
    
    .gallery-thumbs {
        display: flex;
        flex-direction: column;
        gap: 12px;
        width: 100px;
    }

    .thumb {
        width: 100px;
        height: 120px;
        border-radius: 16px;
        overflow: hidden;
        border: 2px solid transparent;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
        background: var(--bg-card);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 5px;
    }

    [data-theme="light"] .thumb {
        background: #f5f5f7;
        border-color: rgba(0, 0, 0, 0.03);
    }

    .thumb.active {
        border-color: var(--primary-purple);
        box-shadow: 0 0 15px rgba(203, 17, 171, 0.2);
    }

    .thumb:hover {
        transform: scale(1.05);
    }

    .thumb img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .gallery-main {
        flex: 1;
        position: relative;
        background: var(--bg-card);
        border-radius: var(--card-radius);
        padding: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 600px;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }

    [data-theme="light"] .gallery-main {
        background: #f5f5f7;
    }

    .gallery-main img {
        max-width: 100%;
        max-height: 520px;
        object-fit: contain;
        filter: drop-shadow(0 20px 40px rgba(0, 0, 0, 0.15));
    }

    .gallery-sale-badge {
        position: absolute;
        top: 20px;
        left: 20px;
        background: #ef4444;
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-weight: 800;
        font-size: 14px;
        box-shadow: 0 4px 10px rgba(239, 68, 68, 0.3);
    }

    .gallery-overlay-actions {
        position: absolute;
        top: 20px;
        right: 20px;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .overlay-btn {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: rgba(0,0,0,0.5);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.1);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
    }

    .overlay-btn:hover {
        background: var(--primary-purple);
        transform: scale(1.1);
    }

    /* --- Info --- */
    .info-card {
        background: var(--bg-card);
        border-radius: var(--card-radius);
        padding: 30px;
        border: 1px solid var(--border-color);
    }

    .info-brand {
        color: var(--primary-purple);
        font-weight: 800;
        text-transform: uppercase;
        font-size: 14px;
        letter-spacing: 1px;
    }

    .info-title {
        font-size: 32px;
        font-weight: 800;
        color: var(--text-main);
        margin: 10px 0 15px;
    }

    .info-rating {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 30px;
    }

    .info-rating .stars {
        display: flex;
        align-items: center;
        gap: 6px;
        background: rgba(255, 204, 0, 0.1);
        padding: 4px 10px;
        border-radius: 8px;
        color: #ffcc00;
        font-weight: 700;
    }

    .sep { color: var(--border-color); }
    .reviews-link { color: var(--text-muted); font-weight: 500; cursor: pointer; }
    .ask-btn { color: var(--primary-purple); font-weight: 600; cursor: pointer; }

    .info-description h3 {
        font-size: 18px;
        margin-bottom: 12px;
        color: var(--text-main);
    }

    .info-description p {
        color: var(--text-muted);
        line-height: 1.7;
    }

    .info-specs {
        margin-top: 30px;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .spec-item {
        display: flex;
        justify-content: space-between;
        padding-bottom: 8px;
        border-bottom: 1px dashed var(--border-color);
    }

    .spec-label { color: var(--text-muted); font-size: 14px; }
    .spec-value { color: var(--text-main); font-weight: 600; font-size: 14px; }

    .stock-status { display: flex; align-items: center; gap: 6px; }
    .in-stock { color: #22c55e; }
    .out-of-stock { color: #ef4444; }

    /* --- Purchase Card --- */
    .purchase-card {
        background: var(--bg-card);
        border-radius: var(--card-radius);
        padding: 30px;
        border: 1px solid var(--border-color);
        position: sticky;
        top: 20px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }

    .price-header {
        margin-bottom: 20px;
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
    }

    .price-main-row {
        display: flex;
        flex-direction: column;
    }

    .price-current {
        font-size: 36px;
        font-weight: 900;
        color: var(--text-main);
    }

    .price-old {
        color: var(--text-muted);
        text-decoration: line-through;
        font-size: 18px;
    }

    .price-discount-tag {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
        padding: 4px 10px;
        border-radius: 8px;
        font-weight: 800;
    }

    .wallet-promo-card {
        background: rgba(203, 17, 171, 0.05);
        border: 1px solid rgba(203, 17, 171, 0.1);
        padding: 12px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        gap: 10px;
        color: var(--primary-purple);
        font-size: 13px;
        font-weight: 700;
        margin-bottom: 25px;
    }

    .qty-control-group {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 25px;
    }

    .qty-control-group label {
        font-weight: 700;
        color: var(--text-muted);
    }

    .qty-stepper {
        display: flex;
        align-items: center;
        gap: 5px;
        background: var(--bg-dark);
        padding: 4px;
        border-radius: 12px;
        border: 1px solid var(--border-color);
    }

    .step-btn {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: none;
        background: var(--bg-card);
        color: var(--text-main);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }

    .step-btn:hover { background: var(--primary-purple); color: white; }

    #buyQuantity {
        width: 40px;
        background: transparent;
        border: none;
        color: var(--text-main);
        text-align: center;
        font-weight: 800;
        font-size: 16px;
    }

    .action-buttons {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .btn-buy-primary {
        width: 100%;
        padding: 18px;
        border-radius: 16px;
        border: none;
        background: var(--primary-gradient);
        color: white;
        font-weight: 800;
        font-size: 16px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: all 0.3s;
    }

    .btn-buy-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(203, 17, 171, 0.4);
    }

    .btn-buy-outline {
        width: 100%;
        padding: 16px;
        border-radius: 16px;
        border: 2px solid var(--border-color);
        background: transparent;
        color: var(--text-main);
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-buy-outline:hover { background: var(--border-color); }

    .delivery-perks {
        margin-top: 30px;
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .perk {
        display: flex;
        align-items: center;
        gap: 15px;
        font-size: 13px;
        color: var(--text-muted);
    }

    .perk i {
        font-size: 20px;
        color: var(--primary-purple);
        width: 30px;
        text-align: center;
    }

    .seller-rating {
        color: #ffcc00;
        font-weight: 700;
        margin-top: 4px;
    }

    .reviews-section-wrapper {
        margin-top: 80px;
        padding-top: 60px;
        border-top: 1px solid var(--border-color);
    }

    /* Mobile Refinements */
    @media (max-width: 768px) {
        .container {
            padding: 15px !important;
        }

        .product-layout {
            gap: 20px;
        }

        .gallery-container {
            flex-direction: column-reverse; /* Thumbs below main */
            gap: 15px;
        }

        .gallery-thumbs {
            flex-direction: row; /* Horizontal thumbs */
            width: 100%;
            height: auto;
            overflow-x: auto;
            padding-bottom: 5px;
            scrollbar-width: none;
            -webkit-overflow-scrolling: touch;
        }

        .gallery-thumbs::-webkit-scrollbar {
            display: none;
        }

        .thumb {
            width: 80px;
            height: 90px;
            flex-shrink: 0;
        }

        .gallery-main {
            min-height: 400px;
            padding: 20px;
        }

        .gallery-main img {
            max-height: 380px;
        }

        .info-title {
            font-size: 24px;
        }

        .info-card, .purchase-card {
            padding: 20px;
            border-radius: 20px;
        }

        .price-current {
            font-size: 30px;
        }

        .reviews-section-wrapper {
            margin-top: 40px;
            padding-top: 40px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    const productData = {
        price: {{ $product->price }},
        stock: {{ $product->stock }},
        currency: '{{ session('currency', 'USD') }}',
        rubRate: {{ \App\Models\Setting::get('usd_to_rub_rate', 90) }},
        aedRate: {{ \App\Models\Setting::get('usd_to_aed_rate', 3.67) }}
    };

    function switchMainImage(src, thumb) {
        document.getElementById('mainProductImage').src = src;
        document.querySelectorAll('.thumb').forEach(t => t.classList.remove('active'));
        thumb.classList.add('active');
    }

    function modifyQty(change) {
        const input = document.getElementById('buyQuantity');
        let val = parseInt(input.value) + change;
        if (val >= 1 && val <= productData.stock) {
            input.value = val;
            updateDisplayPrice(val);
        }
    }

    function updateDisplayPrice(qty) {
        const totalUsd = productData.price * qty;
        let formatted = '';

        if (productData.currency === 'RUB') {
            const amount = totalUsd * productData.rubRate;
            formatted = amount.toLocaleString('ru-RU', { minimumFractionDigits: 0 }).replace(/,/g, ' ') + ' RUB';
        } else if (productData.currency === 'AED') {
            const amount = totalUsd * productData.aedRate;
            formatted = amount.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).replace(/,/g, ' ') + ' AED';
        } else {
            formatted = '$' + totalUsd.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).replace(/,/g, ' ');
        }

        document.getElementById('dynamicPrice').innerText = formatted;
    }

    function handleAddToCart(productId) {
        const btn = document.getElementById('mainAddToCartBtn');
        const isInCart = btn.getAttribute('data-in-cart') === 'true';
        if (isInCart) {
            window.location.href = '{{ route('profile.index') }}?tab=cart';
            return;
        }

        const qty = parseInt(document.getElementById('buyQuantity').value);
        btn.disabled = true;
        const btnText = btn.querySelector('span');
        const originalText = btnText.innerText;
        btnText.innerText = '{{ __('Adding...') }}';

        fetch('{{ route('cart.add') }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ product_id: productId, quantity: qty })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                btn.style.background = '#22c55e';
                btnText.innerText = '{{ __('Added to Cart') }}';
                btn.querySelector('i').className = 'fa-solid fa-cart-check';
                btn.setAttribute('data-in-cart', 'true');
                btn.disabled = false;
                
                // Refresh small cart count if exists
                if (window.Livewire) {
                    window.Livewire.dispatch('cart-updated');
                }
            }
        });
    }

    function handleBuyNow(productId) {
        const qty = parseInt(document.getElementById('buyQuantity').value);
        fetch('{{ route('cart.add') }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ product_id: productId, quantity: qty })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) window.location.href = '{{ route('profile.index') }}?tab=cart';
        });
    }
</script>
@endpush
