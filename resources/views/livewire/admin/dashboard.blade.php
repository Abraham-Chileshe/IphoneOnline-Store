@section('title', 'Overview')

<div>
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">Total Revenue</div>
            <div class="stat-value">$124,500</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Total Orders</div>
            <div class="stat-value">1,240</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Customers</div>
            <div class="stat-value">843</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Avg. Order Value</div>
            <div class="stat-value">$185</div>
        </div>
    </div>

    <!-- Recent Activity Table Placeholder -->
    <h3>Recent Orders</h3>
    <div class="data-table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Placeholder Data -->
                <tr>
                    <td>#ORD-7352</td>
                    <td>Alex Johnson</td>
                    <td>Oct 24, 2025</td>
                    <td>$1,299</td>
                    <td><span class="status-badge status-success">Completed</span></td>
                    <td><button class="action-btn">View</button></td>
                </tr>
                <tr>
                    <td>#ORD-7351</td>
                    <td>Maria Garcia</td>
                    <td>Oct 24, 2025</td>
                    <td>$45</td>
                    <td><span class="status-badge status-warning">Pending</span></td>
                    <td><button class="action-btn">View</button></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
