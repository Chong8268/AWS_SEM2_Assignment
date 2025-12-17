<?php
include 'admin_header.php';
include 'config.php';

$isAdmin = isset($_SESSION['StaffID']) && $_SESSION['Role'] === 'ADMIN';

$result = $conn->query("
    SELECT 
        o.OrderID,
        c.Name AS CustomerName,
        o.total_amount,
        o.status,
        o.order_date
    FROM `order` o
    JOIN customer c ON o.CustomerID = c.CustomerID
    WHERE o.status IN ('PENDING','ACCEPTED','PREPARING')
    ORDER BY o.order_date ASC
");

$actionText = [
    'PENDING'   => 'Accept Order',
    'ACCEPTED' => 'Start Preparing',
    'PREPARING'=> 'Ready for Pickup'
];
?>

<style>
.status {
    padding: 6px 12px;
    border-radius: 20px;
    font-weight: 700;
    font-size: 12px;
}

.status.pending { background:#555; }
.status.accepted { background:#3498db; }
.status.preparing { background:#f1c40f; color:#000; }
.status.delivering { background:#9b59b6; }
.status.completed { background:#2ecc71; }
.status.cancelled { background:#e74c3c; }
</style>

<div class="admin-page">
<div class="admin-wrap">

<h1>Manage Orders</h1>

<table class="admin-table">
<tr>
    <th>Order ID</th>
    <th>Customer</th>
    <th>Order Time</th>
    <th>Total (RM)</th>
    <th>Status</th>
    <th>Action</th>
</tr>

<?php while ($row = $result->fetch_assoc()): ?>
<tr>
    <td>#<?= $row['OrderID'] ?></td>
    <td><?= htmlspecialchars($row['CustomerName']) ?></td>
    <td><?= date('d/m/Y H:i', strtotime($row['order_date'])) ?></td>
    <td><?= number_format($row['total_amount'], 2) ?></td>
    <td><?= $row['status'] ?></td>
    <td>
        <a class="admin-btn-sm" href="admin_order_view.php?id=<?= $row['OrderID'] ?>">
            View
        </a>

        <?php if (isset($actionText[$row['status']])): ?>
        <form method="post" action="update_order_status.php" style="display:inline;">
            <input type="hidden" name="order_id" value="<?= $row['OrderID'] ?>">
            <button class="admin-btn-sm" <?= !$isAdmin ? 'disabled style="opacity:0.5;cursor:not-allowed;"' : '' ?>>
                <?= $actionText[$row['status']] ?>
            </button>
        </form>
        <?php endif; ?>
    </td>
</tr>
<?php endwhile; ?>
</table>

</div>
</div>

<?php include 'footer.php'; ?>
