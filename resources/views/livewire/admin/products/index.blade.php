@section('title', 'Products')

<div>
    <div style="display: flex; justify-content: flex-end; margin-bottom: 24px;">
        <a href="{{ route('admin.products.create') }}" class="btn-primary" style="text-decoration: none; padding: 10px 20px; border-radius: 8px; font-size: 14px;">+ Add Product</a>
    </div>

    <div class="data-table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 80px;">Image</th>
                    <th>Name</th>
                    <th>Brand</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Actions</th>
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
                            {{ $product->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        <div style="display: flex; gap: 8px;">
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="action-btn">Edit</a>
                            <button wire:confirm="Are you sure?" wire:click="delete({{ $product->id }})" class="action-btn" style="background: rgba(255, 59, 48, 0.1); color: #ff3b30;">Delete</button>
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
