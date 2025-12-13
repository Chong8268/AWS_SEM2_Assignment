<?php
session_start();
include 'config.php';

if (!isset($_SESSION["CustomerID"])) {
    header("Location: login.php");
    exit;
}

$customerID = $_SESSION["CustomerID"];

$stmt = $conn->prepare("
    SELECT * FROM `order`
    WHERE CustomerID = ?
      AND status NOT IN ('COMPLETED', 'CANCELLED')
    ORDER BY order_date DESC
");
$stmt->bind_param("s", $customerID);
$stmt->execute();
$orders = $stmt->get_result();
?>
<style>
.my-orders-wrap {
    max-width: 1000px;
    margin: 60px auto;
    padding: 0 20px;
}

.my-orders-title {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 30px;
}

/* Order Card */
.order-card {
    background: #161616;
    border-radius: 14px;
    padding: 22px 26px;
    margin-bottom: 18px;
    box-shadow: 0 12px 30px rgba(0,0,0,.35);
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: .25s;
}

.order-card:hover {
    transform: translateY(-3px);
}

/* Left info */
.order-info h4 {
    margin: 0 0 6px;
    font-size: 1.1rem;
}

.order-info p {
    margin: 2px 0;
    color: #bbb;
    font-size: .95rem;
}

/* Status badge */
.order-status {
    display: inline-block;
    margin-top: 6px;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: .8rem;
    font-weight: 700;
}

.status-pending {
    background: #ffd86b;
    color: #000;
}

.status-confirmed {
    background: #00ffa6;
    color: #000;
}

.status-cancelled {
    background: #ff6b6b;
    color: #fff;
}

/* Right actions */
.order-actions {
    text-align: right;
}

.order-total {
    font-size: 1.1rem;
    font-weight: 700;
    margin-bottom: 10px;
}

.order-btn {
    display: inline-block;
    padding: 8px 14px;
    border-radius: 8px;
    font-weight: 700;
    font-size: .85rem;
    text-decoration: none;
    margin-left: 6px;
    transition: .2s;
}

.btn-view {
    background: #222;
    color: #00ffa6;
}

.btn-view:hover {
    background: #00ffa6;
    color: #000;
}

.btn-cancel {
    background: #ff6b6b;
    color: #fff;
}

.btn-cancel:hover {
    background: #ff4f4f;
}
</style>

<?php include "header.php"; ?>

<div class="page-content">
<div class="container">

<div class="my-orders-wrap">
    <div class="my-orders-title">My Orders</div>

    <?php if ($orders->num_rows === 0): ?>
        <div style="color:#aaa; padding:20px;">
            You have no active orders.
        </div>
    <?php else: ?>

    <?php while ($row = $orders->fetch_assoc()): ?>
        <div class="order-card">

            <div class="order-info">
                <h4>Order #<?= $row['OrderID'] ?></h4>
                <p><?= date("d M Y, H:i", strtotime($row['order_date'])) ?></p>

                <?php
                $statusClass = strtolower(str_replace(' ', '-', $row['status']));
                ?>
                <span class="order-status status-<?= $statusClass ?>">
                    <?= strtoupper($row['status']) ?>
                </span>
            </div>

            <div class="order-actions">
                <div class="order-total">
                    RM <?= number_format($row['total_amount'], 2) ?>
                </div>

                <a class="order-btn btn-view"
                   href="order_history.php?order_id=<?= $row['OrderID'] ?>">
                    View
                </a>

                <?php if ($row['status'] === 'PENDING'): ?>
                    <a class="order-btn btn-cancel"
                       onclick="return confirm('Cancel this order?')"
                       href="cancel_order.php?order_id=<?= $row['OrderID'] ?>">
                        Cancel
                    </a>
                <?php endif; ?>
            </div>

        </div>
    <?php endwhile; ?>
    <?php endif; ?>
</div>
<div style="margin-top:30px;">
    <a href="all_history.php" style="color:#00ffa6;">
        View All Order History →
    </a>
</div>

</div>
</div>

<?php include "footer.php"; ?>
