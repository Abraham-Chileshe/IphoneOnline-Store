@extends('layouts.app')

@section('title', 'iPhone Store — Original Apple Smartphones')

@section('content')
     <div class="container">
            <!-- Breadcrumbs -->
            <nav class="breadcrumbs">
                <a href="{{ route('home') }}">Home</a> / <a href="#">{{ $product->category ?? 'Smartphones' }}</a> / <a href="#">{{ $product->brand }}</a> / {{ $product->name }}
            </nav>

            <div class="product-content">
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
                        <p style="color: var(--text-muted); line-height: 1.6;">{{ $product->description }}</p>
                        <div class="spec-row" style="margin-top: 20px;"><span>SKU</span> <span>{{ str_pad($product->id, 8, '0', STR_PAD_LEFT) }} <img src="https://img.icons8.com/ios/16/a0a0a0/copy.png" alt="copy"></span></div>
                        <div class="spec-row"><span>Category</span> <span>{{ $product->category ?? 'iPhone' }}</span></div>
                        <div class="spec-row"><span>Availability</span> <span>{{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}</span></div>
                    </div>

                    <button class="toggle-specs">Specifications & Description</button>
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
                            <button class="btn btn-primary" id="addToCartBtn" onclick="sendAddToCart({{ $product->id }})">Add to Cart</button>
                            <button class="btn btn-secondary">Buy Now</button>
                        @endauth
                        @guest
                            <button class="btn btn-primary" onclick="window.location.href='{{ route('login') }}'">Contact</button>
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
            const qty = parseInt(quantityInput.value);
            const btn = document.getElementById('addToCartBtn');
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
                btn.innerText = 'Added!';
                btn.style.background = '#28a745'; 
                
                setTimeout(() => {
                    btn.disabled = false;
                    btn.innerText = originalText;
                    btn.style.background = ''; 
                }, 2000);
            })
            .catch(error => {
                console.error('Error:', error);
                btn.disabled = false;
                btn.innerText = originalText;
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