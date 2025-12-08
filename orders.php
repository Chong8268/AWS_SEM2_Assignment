<?php include 'header.php'; ?>

<style>
.orders-page {
    padding: 40px 20px;
    max-width: 1100px;
    margin: auto;
}

.orders-title {
    font-size: 2rem;
    margin-bottom: 20px;
}

/* order card */
.orders-card {
    background: #181818;
    padding: 20px;
    border-radius: 14px;
    margin-bottom: 14px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

/* status styles */
.orders-status {
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 700;
    display: inline-block;
}

.orders-pending { background: #ffaa00; color: #000; }
.orders-completed { background: #00ffa6; color: #000; }
.orders-cancelled { background: #ff6b6b; color: #fff; }

/* view link */
.orders-view {
    color: #00ffa6;
    text-decoration: none;
    font-weight: 700;
}
.orders-view:hover {
    text-decoration: underline;
}
</style>

<div class="page-content">
<div class="orders-page">

    <h2 class="orders-title">My Orders</h2>

    <!-- Example Order Card -->
    <div class="orders-card">
        <div>
            <h3>Order #12345</h3>
            <div>Date: 2025-03-01</div>
            <div>Total: RM 15.50</div>
        </div>

        <div style="text-align:right;">
            <span class="orders-status orders-pending">Pending</span>
            <br><br>
            <a class="orders-view" href="order_details.php?id=12345">View</a>
        </div>
    </div>

</div>
</div>

<?php include 'footer.php'; ?>
