<?php
session_start();
include 'config.php';

if (!isset($_SESSION["CustomerID"])) {
    header("Location: login.php");
    exit;
}

$orderid = $_GET['id'] ?? '';
$cid = $_SESSION['CustomerID'];

if ($orderid === '') {
    die("Invalid order ID.");
}

/* ---------- 1️⃣ 确认订单属于该用户 ---------- */
$stmt = $conn->prepare("
    SELECT *
    FROM `order`
    WHERE OrderID = ? AND CustomerID = ?
");
$stmt->bind_param("ss", $orderid, $cid);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

if (!$order) {
    die("Order not found.");
}

/* ---------- 2️⃣ 获取订单商品 ---------- */
$stmt = $conn->prepare("
    SELECT oi.*, p.name
    FROM orderitems oi
    JOIN product p ON oi.ProductID = p.ProductID
    WHERE oi.OrderID = ?
");
$stmt->bind_param("s", $orderid);
$stmt->execute();
$items = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Order #<?= htmlspecialchars($orderid) ?></title>

<style>
body {
    background:#0f0f0f;
    color:#fff;
    font-family:Poppins, sans-serif;
}
.wrap {
    padding:40px;
    max-width:900px;
    margin:auto;
}
h1 {
    margin-bottom:10px;
}
.order-meta {
    color:#bbb;
    margin-bottom:30px;
}
table {
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
}
th, td {
    padding:14px;
    border-bottom:1px solid #333;
    text-align:left;
}
th {
    background:#181818;
}
.total {
    text-align:right;
    font-size:1.3rem;
    font-weight:700;
    margin-top:25px;
}
</style>
</head>

<body>
<div class="wrap">

<h1>Order #<?= htmlspecialchars($orderid) ?></h1>

<div class="order-meta">
    <div><strong>Date:</strong> <?= date("d M Y, H:i", strtotime($order['order_date'])) ?></div>
    <div><strong>Status:</strong> <?= strtoupper($order['status']) ?></div>
</div>

<h3>Items</h3>

<table>
<tr>
    <th>Product</th>
    <th>Qty</th>
    <th>Unit (RM)</th>
    <th>Total (RM)</th>
</tr>

<?php while ($it = $items->fetch_assoc()): ?>
<tr>
    <td><?= htmlspecialchars($it['name']) ?></td>
    <td><?= $it['quantity'] ?></td>
    <td><?= number_format($it['unit_price'], 2) ?></td>
    <td><?= number_format($it['quantity'] * $it['unit_price'], 2) ?></td>
</tr>
<?php endwhile; ?>
</table>

<div class="total">
    Total: RM <?= number_format($order['total_amount'], 2) ?>
</div>

</div>
</body>
</html>
