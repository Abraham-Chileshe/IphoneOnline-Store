@section('title', __('Products'))

<div>
    @if (session()->has('success'))
        <div style="background: rgba(52, 199, 89, 0.1); color: #34c759; padding: 12px 16px; border-radius: 8px; margin-bottom: 24px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="display: flex; justify-content: flex-end; margin-bottom: 24px;">
        <a href="{{ route('admin.products.create') }}" class="btn-primary" style="text-decoration: none; padding: 10px 20px; border-radius: 8px; font-size: 14px;">+ {{ __('Add Product') }}</a>
    </div>

    <div class="data-table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 80px;">{{ __('Image') }}</th>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Brand') }}</th>
                    <th>{{ __('Price') }}</th>
                    <th>{{ __('Stock') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                <tr>
                    <td>
                        <div style="width: 40px; height: 40px; border-radius: 8px; overflow: hidden; background: #333;">
                            <img src="{{ asset($product->image) }}" alt="" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                    </td>
                    <td>
                        <div style="font-weight: 500;">{{ $product->name }}</div>
                        <div style="font-size: 12px; color: var(--text-muted);">ID: #{{ $product->id }}</div>
                    </td>
                    <td>{{ $product->brand }}</td>
                    <td>${{ number_format($product->price, 2) }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>
                        <span class="status-badge {{ $product->is_active ? 'status-success' : 'status-danger' }}">
                            {{ $product->is_active ? __('Active') : __('Inactive') }}
                        </span>
                    </td>
                    <td>
                        <div style="display: flex; gap: 8px;">
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="action-btn">{{ __('Edit') }}</a>
                            <button wire:confirm="{{ __('Are you sure?') }}" wire:click="delete({{ $product->id }})" class="action-btn" style="background: rgba(255, 59, 48, 0.1); color: #ff3b30;">{{ __('Delete') }}</button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    <div style="margin-top: 24px;">
        {{ $products->links() }}
    </div>
</div>
