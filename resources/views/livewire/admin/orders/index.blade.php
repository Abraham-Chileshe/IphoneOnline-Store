@section('title', 'Orders')

<div>
    <div class="data-table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>
                        <div style="font-weight: 500;">{{ $order->user ? $order->user->name : 'Guest / Deleted' }}</div>
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
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.orders.detail', $order->id) }}" class="action-btn">View Details</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 40px; color: var(--text-muted);">
                        No orders found.
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
