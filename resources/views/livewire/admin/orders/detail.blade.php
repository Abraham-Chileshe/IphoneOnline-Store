@section('title', 'Order #' . $order->id)

<div>
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 32px;">
        
        <!-- Left Column: Items & Totals -->
        <div>
            <!-- Items -->
            <div style="background: var(--admin-card); border: 1px solid var(--admin-border); border-radius: 16px; overflow: hidden; margin-bottom: 24px;">
                <div style="padding: 16px 24px; border-bottom: 1px solid var(--admin-border); font-weight: 600;">Items</div>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <div style="width: 40px; height: 40px; border-radius: 6px; overflow: hidden; background: #333;">
                                        <img src="{{ $item->product->image_url }}" alt="" style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                    <div>
                                        <div style="font-weight: 500;">{{ $item->product->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>${{ number_format($item->price, 2) }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Totals -->
             <div style="background: var(--admin-card); border: 1px solid var(--admin-border); border-radius: 16px; padding: 24px;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 14px; color: var(--text-muted);">
                    <span>Subtotal</span>
                    <span>${{ number_format($order->total_price, 2) }}</span>
                </div>
                <!-- Add shipping if logic exists later -->
                <div style="display: flex; justify-content: space-between; margin-top: 16px; padding-top: 16px; border-top: 1px solid var(--admin-border); font-size: 18px; font-weight: 700;">
                    <span>Total</span>
                    <span>${{ number_format($order->total_price, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Right Column: Customer & Status -->
        <div style="display: flex; flex-direction: column; gap: 24px;">
            
            <!-- Status Update -->
            <div style="background: var(--admin-card); border: 1px solid var(--admin-border); border-radius: 16px; padding: 24px;">
                <div style="font-weight: 600; margin-bottom: 16px;">Order Status</div>
                @if (session()->has('message'))
                    <div style="margin-bottom: 16px; padding: 10px; border-radius: 8px; background: rgba(52, 199, 89, 0.1); color: #34c759; font-size: 13px;">
                        {{ session('message') }}
                    </div>
                @endif
                <form wire:submit.prevent="updateStatus">
                    <select wire:model="status" style="width: 100%; background: rgba(255,255,255,0.05); border: 1px solid var(--admin-border); color: white; padding: 10px 12px; border-radius: 8px; margin-bottom: 16px;">
                        <option value="pending">Pending</option>
                        <option value="shipped">Shipped</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                    <button type="submit" class="btn-primary" style="width: 100%; padding: 10px; border-radius: 8px; background: var(--admin-accent); color: white; border: none; cursor: pointer;">Update Status</button>
                </form>
            </div>

            <!-- Customer Info -->
            <div style="background: var(--admin-card); border: 1px solid var(--admin-border); border-radius: 16px; padding: 24px;">
                <div style="font-weight: 600; margin-bottom: 16px;">Customer</div>
                
                <div style="margin-bottom: 24px;">
                    <div style="font-size: 13px; color: var(--text-muted); margin-bottom: 4px;">Name</div>
                    <div>{{ $order->user->name }}</div>
                </div>

                <div style="margin-bottom: 24px;">
                    <div style="font-size: 13px; color: var(--text-muted); margin-bottom: 4px;">Contact</div>
                    <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                        <a href="mailto:{{ $order->user->email }}" class="action-btn" style="text-decoration: none;">Email</a>
                        @if($order->user->phone)
                            <a href="tel:{{ $order->user->phone }}" class="action-btn" style="text-decoration: none;">Call</a>
                        @endif
                    </div>
                </div>

                @if($order->shipping_address)
                <div>
                     <div style="font-size: 13px; color: var(--text-muted); margin-bottom: 4px;">Shipping Address</div>
                     <div style="font-size: 14px; line-height: 1.5;">
                        {{ $order->shipping_address }}<br>
                        {{ $order->shipping_city }}<br>
                        {{ $order->shipping_zip }}
                     </div>
                </div>
                @endif
            </div>

        </div>
    </div>
</div>
