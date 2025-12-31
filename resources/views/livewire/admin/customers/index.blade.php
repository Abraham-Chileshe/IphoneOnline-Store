@section('title', 'Customers')

<div>
    <div class="data-table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Role</th>
                    <th>Joined Date</th>
                    <th>Orders</th>
                </tr>
            </thead>
            <tbody>
                @foreach($customers as $customer)
                <tr>
                    <td>
                        <div style="font-weight: 500;">{{ $customer->name }}</div>
                        <div style="font-size: 12px; color: var(--text-muted);">{{ $customer->email }}</div>
                    </td>
                    <td>
                        <span class="status-badge {{ $customer->isAdmin() ? 'status-warning' : 'status-success' }}">
                            {{ ucfirst($customer->role) }}
                        </span>
                    </td>
                    <td>{{ $customer->created_at->format('M d, Y') }}</td>
                    <td>--</td> <!-- Placeholder for order count -->
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div style="margin-top: 24px;">
        {{ $customers->links() }}
    </div>
</div>
