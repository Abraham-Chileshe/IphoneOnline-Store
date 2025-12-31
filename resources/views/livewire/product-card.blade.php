<article class="product-card reveal" wire:ignore.self>
    <a href="{{ route('products.show', $product->id) }}">
        <div class="product-card__img-wrapper">
            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="product-card__img">
            @auth
                <button class="product-card__wishlist {{ $isInWishlist ? 'product-card__wishlist--active' : '' }}" wire:click.prevent="toggleWishlist">
                    @if($isInWishlist)
                        <img src="https://img.icons8.com/material-rounded/44/ff3b30/like.png" alt="wishlist">
                    @else
                        <img src="https://img.icons8.com/material-outlined/44/000000/like--v1.png" alt="wishlist">
                    @endif
                </button>
            @endauth

            <div class="product-card__badges">
                @if($product->discount_percentage > 0)
                    <span class="badge badge--discount">-{{ $product->discount_percentage }}%</span>
                @endif
                @if($product->badge_text)
                    <div class="badge badge--{{ $product->badge_type ?? 'price' }}">
                        @if(strtoupper($product->badge_text) === 'GOOD PRICE')
                            <img src="https://img.icons8.com/ios-filled/50/ffffff/thumb-up--v1.png" alt="thumb">
                        @endif
                        {{ strtoupper($product->badge_text) }}
                    </div>
                @endif
            </div>
        </div>
        <div class="product-card__info">
            <div class="product-card__price-row">
                <span class="product-card__price">${{ number_format($product->price, 0, ',', ' ') }}</span>
                @if($product->old_price)
                    <span class="old-price">${{ number_format($product->old_price, 0, ',', ' ') }}</span>
                @endif
            </div>
            <div class="product-card__wallet"></div>
            <div class="product-card__brand-row">
                <img src="https://img.icons8.com/color/48/verified-badge.png" alt="verified" class="verified-icon">
                <span class="product-card__name">{{ $product->name }}</span>
            </div>
            <div class="product-card__rating">
                <span class="star">★</span> {{ $product->rating }} · {{ $product->reviews_count }} reviews
            </div>

            @auth
                @if($product->stock <= 0)
                    <button class="product-card__buy-btn product-card__buy-btn--unavailable" disabled>
                        Unavailable
                    </button>
                @elseif($isAdded)
                    <button class="product-card__buy-btn" disabled>
                        Added to Cart
                    </button>
                @else
                    <button class="product-card__buy-btn" wire:click.prevent="addToCart" wire:loading.attr="disabled" wire:target="addToCart">
                        <span wire:loading.remove wire:target="addToCart">
                            <img src="https://img.icons8.com/ios-filled/50/ffffff/shopping-cart.png" alt="cart">
                            Add to Cart
                        </span>
                        <span wire:loading wire:target="addToCart">Adding...</span>
                    </button>
                @endif
            @endauth

            @guest
                <button class="product-card__buy-btn" onclick="event.preventDefault(); window.location.href='{{ route('login') }}'">
                    Contact
                </button>
            @endguest

        </div>
    </a>
</article>
