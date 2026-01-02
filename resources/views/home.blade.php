@extends('layouts.app')

@section('title', 'iPhone Store — Original Apple Smartphones')

@section('content')
    <div class="container">
        <!-- Promo Banner -->
        <section class="promo-banner">
            <div class="promo-banner__content">
                <img src="https://img.icons8.com/color/96/wallet.png" alt="wallet">
                <span>{{ __('Save up to 5% with maximum wallet and WB Club') }}</span>
            </div>
            <div class="promo-banner__ad"> <span class="badge">{{ __('Ad') }}</span></div>
        </section>

        <!-- Hero Banners Slideshow -->
        <section class="hero-banners-carousel" 
                 x-data="{ 
                    realActive: 1, 
                    isTransitioning: true,
                    slides: [
                        { img: '{{ asset('images/products/iphone_promo_banner_4.png') }}' }, // Ghost of last
                        { img: '{{ asset('images/products/iphone_hero_banner_dark_1767025086208.png') }}' },
                        { img: '{{ asset('images/products/iphone_winter_banner_dark_1767025109339.png') }}' },
                        { img: '{{ asset('images/products/iphone_promo_banner_3.png') }}' },
                        { img: '{{ asset('images/products/iphone_promo_banner_4.png') }}' },
                        { img: '{{ asset('images/products/iphone_hero_banner_dark_1767025086208.png') }}' }  // Ghost of first
                    ],
                    get dotCount() { return this.slides.length - 2 },
                    next() {
                        this.isTransitioning = true;
                        this.realActive++;
                        if (this.realActive === this.slides.length - 1) {
                            setTimeout(() => {
                                this.isTransitioning = false;
                                this.realActive = 1;
                            }, 600);
                        }
                    },
                    prev() {
                        this.isTransitioning = true;
                        this.realActive--;
                        if (this.realActive === 0) {
                            setTimeout(() => {
                                this.isTransitioning = false;
                                this.realActive = this.slides.length - 2;
                            }, 600);
                        }
                    },
                    goTo(index) {
                        this.isTransitioning = true;
                        this.realActive = index + 1;
                    },
                    init() { setInterval(() => this.next(), 5000) }
                 }">
            <div class="carousel-container" 
                 :style="'transform: translateX(calc(25% - ' + realActive + ' * 50% - ' + realActive + ' * 20px)); transition: ' + (isTransitioning ? 'transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1)' : 'none')">
                <template x-for="(slide, index) in slides" :key="index">
                    <div class="hero-banner" :class="{ 'active': realActive === index }">
                        <div class="hero-banner__img" :style="'background-image: url(' + slide.img + ')'"></div>
                        <span class="ad-label">{{ __('Ad') }}</span>
                    </div>
                </template>
            </div>

            <!-- Slider Controls -->
            <button class="slider-arrow slider-arrow--prev" @click="prev()">
                <img src="https://img.icons8.com/ios-filled/50/ffffff/back.png" alt="prev">
            </button>
            <button class="slider-arrow slider-arrow--next" @click="next()">
                <img src="https://img.icons8.com/ios-filled/50/ffffff/forward.png" alt="next">
            </button>

            <!-- Slider Dots -->
            <div class="slider-dots">
                <template x-for="i in dotCount" :key="i">
                    <div class="slider-dot" 
                         :class="{ 'active': (realActive === 0 ? dotCount : (realActive === slides.length - 1 ? 1 : realActive)) === i }" 
                         @click="goTo(i-1)"></div>
                </template>
            </div>
        </section>

        <!-- Product Grid -->
        <livewire:product-list />
    </div>
@endsection
