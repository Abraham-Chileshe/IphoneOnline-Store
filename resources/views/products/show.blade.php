@extends('layouts.app')

@section('title', 'iPhone Store — Original Apple Smartphones')

@section('content')
     <div class="container" style="max-width: 1400px; margin: 0 auto; padding: 20px;">
            <!-- Breadcrumbs -->
            <nav class="breadcrumbs" style="margin-bottom: 30px;">
                <a href="{{ route('home') }}">Home</a> / <a href="#">{{ $product->category ?? 'Smartphones' }}</a> / <a href="#">{{ $product->brand }}</a> / {{ $product->name }}
            </nav>

            <div class="product-content"
                <!-- Gallery Section -->
                <div class="product-gallery">
                    <div class="gallery-thumbs">
                        <div class="thumb active"><img src="{{ $product->image }}" alt="{{ $product->name }}"></div>
                        @if($product->image_2) <div class="thumb"><img src="{{ $product->image_2 }}" alt="thumb 2"></div> @endif
                        @if($product->image_3) <div class="thumb"><img src="{{ $product->image_3 }}" alt="thumb 3"></div> @endif
                    </div>
                    <div class="gallery-main">
                        @if($product->discount_percentage > 0)
                            <span class="badge badge--ny gallery-badge">SALE -{{ $product->discount_percentage }}%</span>
                        @endif
                        <img id="mainImage" src="{{ $product->image }}" alt="{{ $product->name }}">
                        <div class="gallery-actions">
                            @auth
                                <button class="gallery-action-btn"><img src="https://img.icons8.com/material-outlined/44/ffffff/like--v1.png" alt="like"></button>
                            @endauth
                            <button class="gallery-action-btn"><img src="https://img.icons8.com/material-outlined/44/ffffff/share.png" alt="share"></button>
                        </div>
                    </div>
                </div>

                <!-- Info Section -->
                <div class="product-info">
                    <div class="info-header">
                        <span class="brand-tag">{{ $product->brand }}</span>
                        <h1 class="product-title">{{ $product->name }}</h1>
                        <div class="product-rating">
                            <span class="star">★</span> {{ $product->rating }} · {{ number_format($product->reviews_count, 0, ',', ' ') }} reviews · <span class="questions">Ask a question</span>
                        </div>
                    </div>

                    <div class="specs-brief">
                        <div class="product-description" style="margin-bottom: 20px;">
                            <h3 style="font-size: 18px; margin-bottom: 10px; color: var(--text-main);">Description</h3>
                            <p style="color: var(--text-muted); line-height: 1.8;">{{ $product->description }}</p>
                        </div>
                        
                        <div class="spec-row" style="margin-top: 20px;"><span>SKU</span> <span>{{ str_pad($product->id, 8, '0', STR_PAD_LEFT) }} <img src="https://img.icons8.com/ios/16/a0a0a0/copy.png" alt="copy"></span></div>
                        <div class="spec-row"><span>Category</span> <span>{{ $product->category ?? 'iPhone' }}</span></div>
                        <div class="spec-row"><span>Brand</span> <span>{{ $product->brand }}</span></div>
                        <div class="spec-row">
                            <span>Availability</span> 
                            <span style="color: {{ $product->stock > 0 ? '#22c55e' : '#ef4444' }}; font-weight: 600;">
                                @if($product->stock > 0)
                                    In Stock ({{ $product->stock }} {{ Str::plural('unit', $product->stock) }} available)
                                @else
                                    Out of Stock
                                @endif
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Purchase Box -->
                <div class="purchase-box">
                    <div class="price-section">
                        <div class="main-price">
                            $<span id="totalPrice">{{ number_format($product->price, 0, ',', ' ') }}</span>
                            @if($product->old_price)
                                <span class="original-price">${{ number_format($product->old_price, 0, ',', ' ') }}</span>
                                <span class="discount-label">-{{ $product->discount_percentage }}%</span>
                            @endif
                        </div>
                        <div class="wallet-promo">Price with WB Wallet</div>
                    </div>

                    <!-- Quantity Selector -->
                    <div class="quantity-selector">
                        <span class="quantity-label">Quantity:</span>
                        <div class="quantity-controls">
                            <button class="qty-btn" onclick="updateQuantity(-1)">−</button>
                            <input type="number" id="productQuantity" value="1" min="1" max="{{ $product->stock }}" readonly>
                            <button class="qty-btn" onclick="updateQuantity(1)">+</button>
                        </div>
                    </div>
                    
                    <div class="purchase-actions">
                        @auth
                            @if($product->stock > 0)
                                <button class="btn btn-primary" 
                                        id="addToCartBtn" 
                                        onclick="sendAddToCart({{ $product->id }})"
                                        data-in-cart="{{ $isInCart ? 'true' : 'false' }}"
                                        style="{{ $isInCart ? 'background: #22c55e;' : '' }}">
                                    {{ $isInCart ? '✓ Added to Cart' : 'Add to Cart' }}
                                </button>
                                <button class="btn btn-secondary" onclick="buyNow({{ $product->id }})">Buy Now</button>
                            @else
                                <button class="btn btn-primary" disabled style="opacity: 0.5; cursor: not-allowed;">Out of Stock</button>
                            @endif
                        @endauth
                        @guest
                            <button class="btn btn-primary" onclick="window.location.href='{{ route('login') }}'">Sign In to Purchase</button>
                        @endguest
                    </div>

                    <div class="delivery-info">
                        <div class="delivery-row">
                            <img src="https://img.icons8.com/ios/24/ffffff/box.png" alt="box">
                            @auth
                                <span>Delivery: <b>Tomorrow</b></span>
                            @endauth
                            @guest
                                <span>Delivery: <b>Contact</b></span>
                            @endguest
                        </div>
                        <div class="delivery-row">
                            <img src="https://img.icons8.com/ios-filled/24/ffffff/marker.png" alt="marker">
                            <span>Sold by <b>Official Apple Store</b> <span class="seller-rating">★ 5.0</span></span>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Reviews Section --}}
            <div style="margin-top: 60px;">
                <livewire:product-reviews :productId="$product->id" />
            </div>
        </div>
@endsection

@push('styles')
<style>
    .product-content {
        display: grid;
        grid-template-columns: 1fr 1fr 400px;
        gap: 40px;
        margin-bottom: 40px;
    }
    
    @media (max-width: 1200px) {
        .product-content {
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }
        
        .purchase-box {
            grid-column: 1 / -1;
            max-width: 500px;
            margin: 0 auto;
        }
    }
    
    @media (max-width: 768px) {
        .product-content {
            grid-template-columns: 1fr;
            gap: 20px;
        }
    }
    
    .product-gallery {
        min-height: 500px;
    }
    
    .product-info {
        padding: 20px;
    }
    
    .specs-brief {
        margin-top: 20px;
        padding: 20px;
        background: rgba(255, 255, 255, 0.03);
        border-radius: 12px;
    }
    
    .spec-row {
        padding: 12px 0;
        border-bottom: 1px solid var(--border-color);
    }
    
    .spec-row:last-child {
        border-bottom: none;
    }
    
    .purchase-box {
        position: sticky;
        top: 20px;
        height: fit-content;
    }
    
    .purchase-actions {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin: 20px 0;
    }
    
    .btn {
        width: 100%;
        padding: 16px;
        font-size: 16px;
        font-weight: 600;
        border-radius: 12px;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .btn-primary {
        background: var(--primary-gradient);
        color: white;
    }
    
    .btn-primary:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(203, 17, 171, 0.3);
    }
    
    .btn-primary[data-in-cart="true"] {
        background: #22c55e !important;
        cursor: pointer;
    }
    
    .btn-primary[data-in-cart="true"]:hover {
        background: #16a34a !important;
        box-shadow: 0 10px 20px rgba(34, 197, 94, 0.3);
    }
    
    .btn-primary[data-in-cart="true"]::after {
        content: ' - Click to View Cart';
        font-size: 12px;
        opacity: 0;
        transition: opacity 0.3s;
    }
    
    .btn-primary[data-in-cart="true"]:hover::after {
        opacity: 0.8;
    }
    
    .btn-secondary {
        background: rgba(255, 255, 255, 0.1);
        color: var(--text-main);
        border: 2px solid var(--border-color);
    }
    
    .btn-secondary:hover {
        background: rgba(255, 255, 255, 0.15);
        transform: translateY(-2px);
    }
    
    .quantity-selector {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 15px 0;
        margin: 20px 0;
    }
    
    .quantity-controls {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .qty-btn {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        border: 1px solid var(--border-color);
        background: rgba(255, 255, 255, 0.05);
        color: var(--text-main);
        font-size: 20px;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .qty-btn:hover {
        background: rgba(255, 255, 255, 0.1);
    }
    
    #productQuantity {
        width: 60px;
        height: 40px;
        text-align: center;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        background: rgba(255, 255, 255, 0.05);
        color: var(--text-main);
        font-size: 16px;
        font-weight: 600;
    }
    
    .delivery-info {
        margin-top: 20px;
        padding: 20px;
        background: rgba(255, 255, 255, 0.03);
        border-radius: 12px;
    }
    
    .delivery-row {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 0;
    }
    
    /* Light mode adjustments */
    [data-theme="light"] .specs-brief,
    [data-theme="light"] .delivery-info {
        background: rgba(0, 0, 0, 0.03);
    }
    
    [data-theme="light"] .btn-secondary {
        background: rgba(0, 0, 0, 0.05);
    }
    
    [data-theme="light"] .btn-secondary:hover {
        background: rgba(0, 0, 0, 0.1);
    }
    
    [data-theme="light"] .qty-btn,
    [data-theme="light"] #productQuantity {
        background: rgba(0, 0, 0, 0.05);
    }
    
    [data-theme="light"] .qty-btn:hover {
        background: rgba(0, 0, 0, 0.1);
    }
</style>
@endpush




@push('scripts')
    <script>
        const basePrice = {{ $product->price }};
        const quantityInput = document.getElementById('productQuantity');
        const totalPriceElement = document.getElementById('totalPrice');

        function updateQuantity(change) {
            let currentQty = parseInt(quantityInput.value);
            let newQty = currentQty + change;
            
            if (newQty >= 1 && newQty <= {{ $product->stock }}) {
                quantityInput.value = newQty;
                updatePrice(newQty);
            }
        }

        function updatePrice(qty) {
            const total = basePrice * qty;
            totalPriceElement.innerText = total.toLocaleString('en-US', { minimumFractionDigits: 0, maximumFractionDigits: 0 }).replace(/,/g, ' ');
        }

        function sendAddToCart(productId) {
            const btn = document.getElementById('addToCartBtn');
            const isInCart = btn.getAttribute('data-in-cart') === 'true';
            
            // If already in cart, go to cart page
            if (isInCart) {
                window.location.href = '{{ route('profile.index') }}?tab=cart';
                return;
            }
            
            const qty = parseInt(quantityInput.value);
            const originalText = btn.innerText;
            
            btn.disabled = true;
            btn.innerText = 'Adding...';

            fetch('{{ route('cart.add') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ product_id: productId, quantity: qty })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update button to "Added to Cart" state
                    btn.innerText = '✓ Added to Cart';
                    btn.style.background = '#22c55e';
                    btn.setAttribute('data-in-cart', 'true');
                    btn.disabled = false;
                    
                    // Show temporary success message
                    const successMsg = document.createElement('div');
                    successMsg.style.cssText = 'position: fixed; top: 20px; right: 20px; background: #22c55e; color: white; padding: 15px 25px; border-radius: 8px; z-index: 9999; box-shadow: 0 4px 12px rgba(0,0,0,0.15);';
                    successMsg.textContent = '✓ Product added to cart!';
                    document.body.appendChild(successMsg);
                    
                    setTimeout(() => {
                        successMsg.style.transition = 'opacity 0.3s';
                        successMsg.style.opacity = '0';
                        setTimeout(() => successMsg.remove(), 300);
                    }, 2000);
                } else {
                    throw new Error(data.message || 'Failed to add to cart');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                btn.innerText = 'Error - Try Again';
                btn.style.background = '#ef4444';
                setTimeout(() => {
                    btn.disabled = false;
                    btn.innerText = originalText;
                    btn.style.background = '';
                }, 2000);
            });
        }

        function buyNow(productId) {
            const qty = parseInt(quantityInput.value);
            
            // Add to cart first
            fetch('{{ route('cart.add') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ product_id: productId, quantity: qty })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Redirect to profile page (cart/checkout)
                    window.location.href = '{{ route('profile.index') }}?tab=cart';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to process. Please try again.');
            });
        }

        // Thumbnail switching logic
        document.querySelectorAll('.thumb').forEach(thumb => {
            thumb.addEventListener('click', function() {
                // Update main image
                const newSrc = this.querySelector('img').src;
                document.getElementById('mainImage').src = newSrc;
                
                // Update active state
                document.querySelectorAll('.thumb').forEach(t => t.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>
@endpush