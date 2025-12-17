<?php
session_start();
include 'config.php';

if (!isset($_SESSION["CustomerID"])) {
    header("Location: login.php");
    exit;
}

$customerID = $_SESSION["CustomerID"];
$orderID = $_GET['order_id'] ?? '';

if ($orderID === '') {
    die("Invalid order ID.");
}

$stmt = $conn->prepare("
    SELECT OrderID, order_date, total_amount, status
    FROM `order`
    WHERE OrderID = ? AND CustomerID = ?
");
$stmt->bind_param("ss", $orderID, $customerID);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

if (!$order) {
    die("Order not found or unauthorized access.");
}

$stmt = $conn->prepare("
    SELECT *
    FROM orderhistory
    WHERE OrderID = ?
    ORDER BY changed_at ASC
");
$stmt->bind_param("s", $orderID);
$stmt->execute();
$history = $stmt->get_result();
?>

<?php include "header.php"; ?>

<style>
.order-history-wrap {
    max-width: 900px;
    margin: 60px auto;
    padding: 0 20px;
}

.order-header {
    margin-bottom: 30px;
}

.order-header h2 {
    font-size: 2rem;
    margin-bottom: 8px;
}

.order-meta {
    color: #aaa;
    font-size: .95rem;
}

.timeline {
    position: relative;
    margin-top: 40px;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 10px;
    top: 0;
    width: 2px;
    height: 100%;
    background: #333;
}

.timeline-item {
    position: relative;
    margin-bottom: 30px;
}

.timeline-dot {
    position: absolute;
    left: -1px;
    top: 4px;
    width: 14px;
    height: 14px;
    border-radius: 50%;
    background: #666;
}

.timeline-content {
    background: #161616;
    border-radius: 12px;
    padding: 18px 22px;
    box-shadow: 0 8px 20px rgba(0,0,0,.35);
}

.status-PENDING { background:#ffd86b; color:#000; }
.status-CONFIRMED { background:#00ffa6; color:#000; }
.status-CANCELLED { background:#ff6b6b; color:#fff; }
.status-COMPLETED { background:#4da3ff; color:#fff; }

.status-badge {
    display:inline-block;
    padding:6px 12px;
    border-radius:20px;
    font-size:.75rem;
    font-weight:700;
    margin-bottom:6px;
}

.timeline-time {
    color:#aaa;
    font-size:.85rem;
    margin-top:6px;
}
</style>

<div class="page-content">
<div class="order-history-wrap">

    <div class="order-header">
        <h2>Order History</h2>
        <div class="order-meta">
            Order ID: <strong><?= htmlspecialchars($orderID) ?></strong><br>
            Placed on <?= date("d M Y, H:i", strtotime($order['order_date'])) ?><br>
            Total: RM <?= number_format($order['total_amount'], 2) ?>
        </div>
    </div>

    <?php if ($history->num_rows === 0): ?>
        <p style="color:#bbb;">No history records found.</p>
    <?php else: ?>
        <div class="timeline">

        <?php while ($row = $history->fetch_assoc()): ?>
            <div class="timeline-item">
                <div class="timeline-dot"></div>

                <div class="timeline-content">
                    <span class="status-badge status-<?= strtoupper($row['status']) ?>">
                        <?= strtoupper($row['status']) ?>
                    </span>

                    <div>
                        <?= htmlspecialchars($row['remark'] ?: 'Status updated') ?>
                    </div>

                    <div class="timeline-time">
                        <?= date("d M Y, H:i:s", strtotime($row['changed_at'])) ?>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>

        </div>
    <?php endif; ?>

    <div style="margin-top:30px;">
        <a href="all_history.php" style="color:#00ffa6;text-decoration:none;">
            ← Back to My Orders
        </a>
    </div>

</div>
</div>

<?php include "footer.php"; ?>
