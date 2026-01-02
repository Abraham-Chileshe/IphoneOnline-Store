@section('title', __('Orders'))

<div>
    <div class="data-table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>{{ __('Order ID') }}</th>
                    <th>{{ __('Customer') }}</th>
                    <th>{{ __('Date') }}</th>
                    <th>{{ __('Total') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>
                        <div style="font-weight: 500;">{{ $order->user ? $order->user->name : __('Guest / Deleted') }}</div>
                        <div style="font-size: 12px; color: var(--text-muted);">{{ $order->user ? $order->user->email : '-' }}</div>
                    </td>
                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                    <td>${{ number_format($order->total_price, 2) }}</td>
                    <td>
                        <span class="status-badge 
                            {{ $order->status == 'completed' ? 'status-success' : '' }}
                            {{ $order->status == 'pending' ? 'status-warning' : '' }}
                            {{ $order->status == 'cancelled' ? 'status-danger' : '' }}
                        ">
                            {{ __(ucfirst($order->status)) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.orders.detail', $order->id) }}" class="action-btn">{{ __('View Details') }}</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 40px; color: var(--text-muted);">
                        {{ __('No orders found.') }}
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>


    <div style="margin-top: 24px;">
        {{ $orders->links() }}
    </div>
</div>
