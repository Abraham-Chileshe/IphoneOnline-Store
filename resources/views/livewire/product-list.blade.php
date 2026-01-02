<div>
    @if (session()->has('success'))
        <div class="alert alert-success" style="margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger" style="margin-bottom: 20px;">
            {{ session('error') }}
        </div>
    @endif

    @if (session()->has('info'))
        <div class="alert alert-info" style="margin-bottom: 20px;">
            {{ session('info') }}
        </div>
    @endif


    <section class="product-grid">
        @forelse($products as $product)
            <livewire:product-card :product="$product" :key="'product-'.$product->id" />
        @empty
            <p style="color: white; text-align: center; grid-column: 1/-1;">{{ __('No products found') }}</p>
        @endforelse
    </section>

</div>
