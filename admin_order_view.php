<?php
include 'admin_header.php';

if (!isset($_GET['id'])) {
    header("Location: admin_orders.php");
    exit;
}

$orderId = $_GET['id'];

$orderStmt = $conn->prepare("
    SELECT 
        o.OrderID,
        o.order_date,
        o.status,
        o.total_amount,
        c.Name AS CustomerName,
        c.Phone
    FROM `order` o
    JOIN customer c ON o.CustomerID = c.CustomerID
    WHERE o.OrderID = ?
");
$orderStmt->bind_param("s", $orderId);
$orderStmt->execute();
$order = $orderStmt->get_result()->fetch_assoc();

if (!$order) {
    header("Location: admin_orders.php");
    exit;
}

$itemStmt = $conn->prepare("
    SELECT 
        p.Name AS ProductName,
        oi.quantity,
        oi.unit_price
    FROM orderitems oi
    JOIN product p ON oi.ProductID = p.ProductID
    WHERE oi.OrderID = ?
");
$itemStmt->bind_param("s", $orderId);
$itemStmt->execute();
$items = $itemStmt->get_result();

$historyStmt = $conn->prepare("
    SELECT
        oh.status,
        oh.changed_at,
        oh.remark,
        s.Name AS StaffName
    FROM orderhistory oh
    LEFT JOIN staff s 
        ON oh.changed_by_staff = s.StaffID
    WHERE oh.OrderID = ?
    ORDER BY oh.changed_at ASC
");
$historyStmt->bind_param("s", $orderId);
$historyStmt->execute();
$histories = $historyStmt->get_result();
?>

<div class="admin-page">
<div class="admin-wrap">

    <h1>Order #<?= htmlspecialchars($order['OrderID']) ?></h1>

    <div class="admin-card" style="margin-bottom:30px;">
        <p><strong>Customer:</strong> <?= htmlspecialchars($order['CustomerName']) ?></p>
        <p><strong>Phone:</strong> <?= htmlspecialchars($order['Phone']) ?></p>
        <p><strong>Order Time:</strong> <?= date('d/m/Y H:i', strtotime($order['order_date'])) ?></p>
        <p><strong>Status:</strong> <?= $order['status'] ?></p>
        <p><strong>Total:</strong> RM <?= number_format($order['total_amount'],2) ?></p>
    </div>

    <h3>Order Items</h3>
    <table class="admin-table">
        <tr>
            <th>Item</th>
            <th>Qty</th>
            <th>Unit Price (RM)</th>
            <th>Subtotal (RM)</th>
        </tr>

        <?php while ($item = $items->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($item['ProductName']) ?></td>
            <td><?= $item['quantity'] ?></td>
            <td><?= number_format($item['unit_price'], 2) ?></td>
            <td><?= number_format($item['unit_price'] * $item['quantity'], 2) ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <h3 style="margin-top:40px;">Order History</h3>
    <table class="admin-table">
        <tr>
            <th>Status</th>
            <th>Changed By</th>
            <th>Changed At</th>
            <th>Remark</th>
        </tr>

        <?php while ($h = $histories->fetch_assoc()): ?>
        <tr>
            <td><?= $h['status'] ?></td>
            <td><?= $h['StaffName'] ? htmlspecialchars($h['StaffName']) : 'Customer' ?></td>
            <td><?= date('d/m/Y H:i', strtotime($h['changed_at'])) ?></td>
            <td><?= htmlspecialchars($h['remark']) ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <a href="admin_orders.php" class="admin-btn-sm" style="margin-top:30px;">
        ← Back to Orders
    </a>

</div>
</div>

<?php include 'footer.php'; ?>
