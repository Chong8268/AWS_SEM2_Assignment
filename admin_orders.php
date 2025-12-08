<?php include 'admin_header.php'; ?>

<div class="admin-page">
<div class="admin-wrap">

    <h1>Manage Orders</h1>

    <table class="admin-table">
        <tr>
            <th>Order ID</th>
            <th>Customer</th>
            <th>Total (RM)</th>
            <th>Status</th>
            <th>Action</th>
        </tr>

        <!-- Example row -->
        <tr>
            <td>#1001</td>
            <td>John Doe</td>
            <td>24.90</td>
            <td><span class="status pending">Pending</span></td>
            <td><a class="admin-btn-sm" href="admin_order_view.php?id=1001">View</a></td>
        </tr>

    </table>

</div>
</div>

<?php include 'footer.php'; ?>
