@extends('layouts.app')

@section('title', 'iPhone Store — Original Apple Smartphones')

@include('partials.sidebar')
@include('partials.header')

@section('content')
     <div class="container">
            <!-- Breadcrumbs -->
            <nav class="breadcrumbs">
                <a href="index.html">Главная</a> / <a href="#">Дом</a> / <a href="#">Парфюмерия для дома</a> / <a href="#">AROMATHEQUE</a>
            </nav>

            <div class="product-content">
                <!-- Gallery Section -->
                <div class="product-gallery">
                    <div class="gallery-thumbs">
                        <div class="thumb active"><img src="product_winter_hat_1767023941418.png" alt="thumb 1"></div>
                        <div class="thumb"><img src="product_jewelry_ring_1767023925787.png" alt="thumb 2"></div>
                        <div class="thumb"><img src="uploaded_image_1767023847148.png" alt="thumb 3"></div>
                        <div class="thumb"><img src="product_winter_hat_1767023941418.png" alt="thumb 4"></div>
                    </div>
                    <div class="gallery-main">
                        <span class="badge badge--ny gallery-badge">НГ НА ВБ</span>
                        <img id="mainImage" src="product_winter_hat_1767023941418.png" alt="Main product image">
                        <div class="gallery-actions">
                            <button class="gallery-action-btn"><img src="https://img.icons8.com/material-outlined/44/ffffff/like--v1.png" alt="like"></button>
                            <button class="gallery-action-btn"><img src="https://img.icons8.com/material-outlined/44/ffffff/share.png" alt="share"></button>
                        </div>
                    </div>
                </div>

                <!-- Info Section -->
                <div class="product-info">
                    <div class="info-header">
                        <span class="brand-tag">AROMATHEQUE</span>
                        <h1 class="product-title">Диффузор для дома с палочками набор</h1>
                        <div class="product-rating">
                            <span class="star">★</span> 4.9 · 12 535 оценок · <span class="questions">234 вопроса</span>
                        </div>
                    </div>

                    <div class="variants-section">
                        <p class="variants-label">хлопок, персик, вербена</p>
                        <div class="variants-grid">
                            <div class="variant active"><img src="product_winter_hat_1767023941418.png" alt="v1"></div>
                            <div class="variant"><img src="product_winter_hat_1767023941418.png" alt="v2"></div>
                            <div class="variant"><img src="product_winter_hat_1767023941418.png" alt="v3"></div>
                            <div class="variant"><img src="product_winter_hat_1767023941418.png" alt="v4"></div>
                        </div>
                    </div>

                    <div class="specs-brief">
                        <div class="spec-row"><span>Артикул</span> <span>370406489 <img src="https://img.icons8.com/ios/16/a0a0a0/copy.png" alt="copy"></span></div>
                        <div class="spec-row"><span>Объем товара</span> <span>150 мл</span></div>
                        <div class="spec-row"><span>Срок годности</span> <span>3 года</span></div>
                        <div class="spec-row"><span>Аромат</span> <span>хлопок бергамот; персик жасмин; вербена</span></div>
                        <div class="spec-row"><span>Страна производства</span> <span>Россия</span></div>
                    </div>

                    <button class="toggle-specs">Характеристики и описание</button>
                </div>

                <!-- Purchase Box -->
                <div class="purchase-box">
                    <div class="price-section">
                        <div class="main-price">539 ₽ <span class="original-price">550 ₽</span> <span class="discount-label">2 329 ₽</span></div>
                        <div class="wallet-promo">с WB Кошельком</div>
                    </div>
                    
                    <div class="purchase-actions">
                        <button class="btn btn-primary">Добавить в корзину</button>
                        <button class="btn btn-secondary">Купить сейчас</button>
                    </div>

                    <div class="delivery-info">
                        <div class="delivery-row">
                            <img src="https://img.icons8.com/ios/24/ffffff/box.png" alt="box">
                            <span>Завтра, <b>склад WB</b></span>
                        </div>
                        <div class="delivery-row">
                            <img src="https://img.icons8.com/ios-filled/24/ffffff/marker.png" alt="marker">
                            <span>BLOOM & WAX <span class="seller-rating">★ 4.8</span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection




@push('scripts')
    <script>
        
    </script>
@endpush