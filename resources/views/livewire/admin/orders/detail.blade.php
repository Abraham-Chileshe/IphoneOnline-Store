@section('title', __('Order') . ' #' . $order->id)

<div>
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 32px;">
        
        <!-- Left Column: Items & Totals -->
        <div>
            <!-- Items -->
            <div style="background: var(--admin-card); border: 1px solid var(--admin-border); border-radius: 16px; overflow: hidden; margin-bottom: 24px;">
                <div style="padding: 16px 24px; border-bottom: 1px solid var(--admin-border); font-weight: 600;">{{ __('Items') }}</div>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>{{ __('Product') }}</th>
                            <th>{{ __('Price') }}</th>
                            <th>{{ __('Qty') }}</th>
                            <th>{{ __('Total') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <div style="width: 40px; height: 40px; border-radius: 6px; overflow: hidden; background: #333;">
                                        <img src="{{ asset($item->product->image) }}" alt="" style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                    <div>
                                        <div style="font-weight: 500;">{{ $item->product->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ \App\Models\Product::formatPrice($item->price) }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ \App\Models\Product::formatPrice($item->price * $item->quantity) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Totals -->
             <div style="background: var(--admin-card); border: 1px solid var(--admin-border); border-radius: 16px; padding: 24px;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 14px; color: var(--text-muted);">
                    <span>{{ __('Subtotal') }}</span>
                    <span>{{ \App\Models\Product::formatPrice($order->total_amount) }}</span>
                </div>
                <!-- Add shipping if logic exists later -->
                <div style="display: flex; justify-content: space-between; margin-top: 16px; padding-top: 16px; border-top: 1px solid var(--admin-border); font-size: 18px; font-weight: 700;">
                    <span>{{ __('Total') }}</span>
                    <span>{{ \App\Models\Product::formatPrice($order->total_amount) }}</span>
                </div>
            </div>
        </div>

        <!-- Right Column: Customer & Status -->
        <div style="display: flex; flex-direction: column; gap: 24px;">
            
            <!-- Status Update -->
            <div style="background: var(--admin-card); border: 1px solid var(--admin-border); border-radius: 16px; padding: 24px;">
                <div style="font-weight: 600; margin-bottom: 16px;">{{ __('Order Status') }}</div>
                @if (session()->has('success'))
                    <div style="margin-bottom: 16px; padding: 10px; border-radius: 8px; background: rgba(52, 199, 89, 0.1); color: #34c759; font-size: 13px;">
                        {{ session('success') }}
                    </div>
                @endif
                <form wire:submit.prevent="updateStatus">
                    <div class="form-group" style="margin-bottom: 16px;">
                        <select wire:model.live="status" class="admin-select 
                            {{ $status == 'delivered' ? 'border-success' : '' }}
                            {{ $status == 'pending' ? 'border-warning' : '' }}
                            {{ $status == 'cancelled' ? 'border-danger' : '' }}
                            {{ in_array($status, ['processing', 'shipped']) ? 'border-info' : '' }}
                        ">
                            @foreach(\App\Models\Order::getStatuses() as $key => $label)
                                <option value="{{ $key }}">{{ __($label) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn-primary" style="width: 100%; padding: 10px; border-radius: 8px; background: var(--admin-accent); color: white; border: none; cursor: pointer; font-weight: 600;">
                        <span wire:loading.remove>{{ __('Update Status') }}</span>
                        <span wire:loading>{{ __('Updating...') }}</span>
                    </button>
                </form>
            </div>

            <!-- Customer Info -->
            <div style="background: var(--admin-card); border: 1px solid var(--admin-border); border-radius: 16px; padding: 24px;">
                <div style="font-weight: 600; margin-bottom: 16px;">{{ __('Customer') }}</div>
                
                <div style="margin-bottom: 24px;">
                    <div style="font-size: 13px; color: var(--text-muted); margin-bottom: 4px;">{{ __('Name') }}</div>
                    <div style="font-weight: 600;">{{ $order->user->name }}</div>
                </div>

                <div style="margin-bottom: 24px;">
                    <div style="font-size: 13px; color: var(--text-muted); margin-bottom: 8px;">{{ __('Contact') }}</div>
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        <a href="mailto:{{ $order->user->email }}" style="display: flex; align-items: center; gap: 10px; color: var(--text-main); text-decoration: none; font-size: 14px; transition: color 0.2s;">
                            <i class="fa-solid fa-envelope" style="color: var(--admin-accent); font-size: 16px; width: 20px;"></i>
                            {{ $order->user->email }}
                        </a>
                        @php $phone = $order->phone ?? $order->user->phone; @endphp
                        @if($phone)
                            <a href="tel:{{ $phone }}" style="display: flex; align-items: center; gap: 10px; color: var(--text-main); text-decoration: none; font-size: 14px; transition: color 0.2s;">
                                <i class="fa-solid fa-phone" style="color: #34c759; font-size: 16px; width: 20px;"></i>
                                {{ $phone }}
                            </a>
                        @endif
                    </div>
                </div>

                @if($order->shipping_address)
                <div>
                     <div style="font-size: 13px; color: var(--text-muted); margin-bottom: 4px;">{{ __('Shipping Address') }}</div>
                     <div style="font-size: 14px; line-height: 1.5;">
                        {{ $order->shipping_address }}<br>
                        {{ $order->city }}<br>
                        {{ $order->postal_code }}
                     </div>
                </div>
                @endif
            </div>

        </div>
    </div>
</div>
