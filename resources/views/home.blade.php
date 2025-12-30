@extends('layouts.app')

@section('title', 'iPhone Store — Original Apple Smartphones')

@include('partials.sidebar')
@include('partials.header')

@section('content')
    <div class="container">
        <!-- Promo Banner -->
        <section class="promo-banner">
            <div class="promo-banner__content">
                <img src="https://img.icons8.com/color/96/wallet.png" alt="wallet">
                <span>Save up to 5% with maximum wallet and WB Club</span>
            </div>
            <div class="promo-banner__ad"> <span class="badge">Ad</span></div>
        </section>

        <!-- Hero Banners Carousel -->
        <section class="hero-banners-carousel">
            <div class="carousel-container">
                <div class="hero-banner hero-banner--large">
                    <div class="hero-banner__img"
                        style="background-image: url('{{ asset('images/products/iphone_hero_banner_dark_1767025086208.png') }}');">
                    </div>
                    <span class="ad-label">Ad</span>
                </div>
                <div class="hero-banner hero-banner--large">
                    <div class="hero-banner__img"
                        style="background-image: url('{{ asset('images/products/iphone_winter_banner_dark_1767025109339.png') }}');">
                    </div>
                    <span class="ad-label">Ad</span>
                </div>
                <div class="hero-banner hero-banner--large">
                    <div class="hero-banner__img"
                        style="background-image: url('{{ asset('images/products/iphone_hero_banner_dark_1767025086208.png') }}');">
                    </div>
                    <span class="ad-label">Ad</span>
                </div>
            </div>
        </section>

        <!-- Product Grid -->
        <section class="product-grid">
            @forelse($products as $product)
                <article class="product-card reveal">
                    <a href="{{ route('products.show', $product->id) }}">
                        <div class="product-card__img-wrapper">
                            <img src="{{ $product->image }}" alt="{{ $product->name }}" class="product-card__img">
                            <button class="product-card__wishlist">
                                <img src="https://img.icons8.com/material-outlined/44/000000/like--v1.png" alt="wishlist">
                            </button>
                            <div class="product-card__badges">
                                @if($product->discount_percentage > 0)
                                    <span class="badge badge--discount">-{{ $product->discount_percentage }}%</span>
                                @endif
                                @if($product->is_good_price)
                                    <div class="badge badge--price">
                                        <img src="https://img.icons8.com/ios-filled/50/ffffff/thumb-up--v1.png" alt="thumb"> GOOD
                                        PRICE
                                    </div>
                                @endif
                                {{-- <span class="badge badge--ny">NEW YEAR SALE</span> --}}
                            </div>
                        </div>
                        <div class="product-card__info">
                            <div class="product-card__price-row">
                                {{-- <span class="price-icon">⬢</span> --}}
                                <span class="product-card__price">${{ number_format($product->price, 0, ',', ' ') }}</span>
                                @if($product->old_price)
                                    <span class="old-price">${{ number_format($product->old_price, 0, ',', ' ') }}</span>
                                @endif
                            </div>
                            <div class="product-card__wallet"></div>
                            <div class="product-card__brand-row">
                                <img src="https://img.icons8.com/color/48/verified-badge.png" alt="verified"
                                    class="verified-icon">
                                {{-- <span class="product-card__brand">{{ $product->brand }}</span>
                                <span class="separator">/</span> --}}
                                <span class="product-card__name">{{ $product->name }}</span>
                            </div>
                            <div class="product-card__rating">
                                <span class="star">★</span> {{ $product->rating }} · {{ $product->reviews_count }} reviews
                            </div>
                            <button class="product-card__buy-btn"
                                onclick="event.preventDefault(); addToCart({{ $product->id }})">
                                <img src="https://img.icons8.com/ios-filled/50/ffffff/shopping-cart.png" alt="cart">
                                Tomorrow
                            </button>
                        </div>
                    </a>
                </article>
            @empty
                <p style="color: white; text-align: center; grid-column: 1/-1;">No products found</p>
            @endforelse
        </section>
    </div>
@endsection




@push('scripts')
    <script>
        function addToCart(productId) {
            fetch('{{ route('cart.add') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ product_id: productId, quantity: 1 })
            })
                .then(response => response.json())
                .then(data => {
                    alert('Product added to cart!');
                });
        }
    </script>
@endpush