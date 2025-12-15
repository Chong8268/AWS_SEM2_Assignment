<?php
include 'admin_header.php';
/* =======================
   📊 DASHBOARD STATS SQL
   ======================= */

// Pending orders
$pendingOrders = $conn->query("
    SELECT COUNT(*) AS total 
    FROM `order` 
    WHERE status = 'PENDING'
")->fetch_assoc()['total'] ?? 0;

// Today orders
$todayOrders = $conn->query("
    SELECT COUNT(*) AS total
    FROM `order`
    WHERE DATE(order_date) = CURDATE()
")->fetch_assoc()['total'] ?? 0;

// Today revenue
$todayRevenue = $conn->query("
    SELECT IFNULL(SUM(total_amount),0) AS total
    FROM `order`
    WHERE DATE(order_date) = CURDATE()
      AND status NOT IN ('CANCELLED')
")->fetch_assoc()['total'] ?? 0;

// Total customers
$totalCustomers = $conn->query("
    SELECT COUNT(*) AS total 
    FROM customer
")->fetch_assoc()['total'] ?? 0;

// Total products
$totalProducts = $conn->query("
    SELECT COUNT(*) AS total 
    FROM product
")->fetch_assoc()['total'] ?? 0;
?>


<style>
/* =======================
   LAYOUT
   ======================= */
.admin-wrap {
    max-width: 1280px;
    margin: 60px auto;
    padding: 0 32px;
}

/* =======================
   SECTION
   ======================= */
.admin-section {
    margin-bottom: 70px;
}

.admin-section-title {
    font-size: 1.6rem;
    font-weight: 700;
    margin-bottom: 30px;
    color: #fff;
}

/* =======================
   GRID SYSTEM
   ======================= */
.admin-grid {
    display: grid;
    gap: 28px;
}

/* --- Overview cards --- */
.stats-grid {
    grid-template-columns: repeat(3, 1fr);
}

/* --- Management buttons --- */
.action-grid {
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
}

/* =======================
   CARD BASE
   ======================= */
.admin-card {
    background: #161616;
    border-radius: 18px;
    padding: 28px;
    box-shadow: 0 12px 30px rgba(0,0,0,.45);
    transition: all .25s ease;
}

/* =======================
   STAT CARDS
   ======================= */
.stat-card {
    text-align: center;
}

.stat-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 45px rgba(0,0,0,.6);
}

.admin-stat {
    font-size: 2.6rem;
    font-weight: 800;
    color: #00ffa6;
    margin-bottom: 10px;
}

/* =======================
   ACTION BUTTON CARDS
   ======================= */
.admin-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 90px;
    font-size: 1.1rem;
    font-weight: 700;
    color: #fff;
    text-decoration: none;
    border-radius: 18px;
}

.admin-btn:hover {
    background: #00ffa6;
    color: #000;
    transform: translateY(-4px);
}

/* =======================
   RESPONSIVE
   ======================= */
@media (max-width: 1024px) {
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 640px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }
}

</style>

<div class="admin-wrap">

    <h1 style="margin-bottom:40px;">Welcome, Admin</h1>

    <!-- =======================
         📊 OVERVIEW
         ======================= -->
    <div class="admin-section">
        <h2 class="admin-section-title">Overview</h2>

        <div class="admin-grid stats-grid">
            <div class="admin-card stat-card">
                <div class="admin-stat"><?= $pendingOrders ?></div>
                <div>Pending Orders</div>
            </div>

            <div class="admin-card stat-card">
                <div class="admin-stat"><?= $todayOrders ?></div>
                <div>Today Orders</div>
            </div>

            <div class="admin-card stat-card">
                <div class="admin-stat">RM <?= number_format($todayRevenue,2) ?></div>
                <div>Today Revenue</div>
            </div>

            <div class="admin-card stat-card">
                <div class="admin-stat"><?= $totalCustomers ?></div>
                <div>Total Customers</div>
            </div>

            <div class="admin-card stat-card">
                <div class="admin-stat"><?= $totalProducts ?></div>
                <div>Total Products</div>
            </div>
        </div>
    </div>

    <!-- =======================
         ⚙️ MANAGEMENT
         ======================= -->
    <div class="admin-section">
        <h2 class="admin-section-title">Management</h2>

        <div class="admin-grid action-grid">
            <a href="admin_orders.php" class="admin-card admin-btn">
                Manage Orders
            </a>

            <a href="admin_products.php" class="admin-card admin-btn">
                Manage Products
            </a>

            <a href="admin_delivery_status.php" class="admin-card admin-btn">
                Delivery Management
            </a>

            <a href="admin_order_history.php" class="admin-card admin-btn">
                Order Logs
            </a>

            <a href="admin_payment_history.php" class="admin-card admin-btn">
                Payment Logs
            </a>
        </div>
    </div>

</div>

<?php include 'footer.php'; ?>
