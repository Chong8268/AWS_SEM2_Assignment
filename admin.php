<?php include 'admin_header.php'; ?>

<div class="admin-wrap">

    <h1>Welcome, Admin</h1>

    <!-- STAT CARDS -->
    <div class="admin-grid">
        <div class="admin-card">
            <div class="admin-stat">23</div>
            <div>Pending Orders</div>
        </div>

        <div class="admin-card">
            <div class="admin-stat">120</div>
            <div>Total Customers</div>
        </div>

        <div class="admin-card">
            <div class="admin-stat">48</div>
            <div>Total Products</div>
        </div>
    </div>

    <!-- ACTION CARDS -->
    <div class="admin-grid" style="margin-top:40px;">
        <a href="admin_orders.php" class="admin-btn admin-card">Manage Orders</a>
        <a href="admin_products.php" class="admin-btn admin-card">Manage Products</a>
        <a href="Delivery_Status.php" class="admin-btn admin-card">Delivery Management</a>
    </div>

</div>

<?php include 'footer.php'; ?>
