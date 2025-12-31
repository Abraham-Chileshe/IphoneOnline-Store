@extends('layouts.app')

@section('title', 'iPhone Store — Original Apple Smartphones')

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
        <livewire:product-list />
    </div>
@endsection
