<?php
session_start();
include 'config.php';

if (!isset($_SESSION['customer_id'])) {
    header("Location: login.html");
    exit();
}

$orderid = $_GET['orderid'] ?? 0;
$cid = $_SESSION['customer_id'];

// Ensure customer owns this order
$stmt = $conn->prepare("
    SELECT *
    FROM `Order`
    WHERE OrderID = :oid AND CustomerID = :cid
");
$stmt->execute([':oid'=>$orderid, ':cid'=>$cid]);
$order = $stmt->fetch();

if (!$order) { die("Order not found."); }

// Fetch items
$items = $conn->prepare("
    SELECT oi.*, p.name
    FROM OrderItems oi
    JOIN Product p ON oi.productID = p.ProductID
    WHERE oi.orderID = :oid
");
$items->execute([':oid'=>$orderid]);
$items = $items->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Order #<?= $orderid ?></title>

<style>
  body { background:#0f0f0f; color:#fff; font-family:Poppins; }
  .wrap { padding:40px; max-width:900px; margin:auto; }
  table { width:100%; border-collapse:collapse; }
  th, td { padding:14px; border-bottom:1px solid #333; }
  th { background:#181818; }
</style>

</head>

<body>
<div class="wrap">
<h1>Order #<?= $orderid ?></h1>

<p>
  <strong>Date:</strong> <?= $order['order_date'] ?><br>
  <strong>Status:</strong> <?= $order['status'] ?><br>
</p>

<h3>Items</h3>

<table>
<tr>
  <th>Product</th><th>Qty</th><th>Unit (RM)</th><th>Total (RM)</th>
</tr>

<?php foreach ($items as $it): ?>
<tr>
  <td><?= htmlspecialchars($it['name']) ?></td>
  <td><?= $it['quantity'] ?></td>
  <td><?= number_format($it['unit_price'],2) ?></td>
  <td><?= number_format($it['quantity'] * $it['unit_price'],2) ?></td>
</tr>
<?php endforeach; ?>

</table>

<h2>Total: RM <?= number_format($order['total_amount'],2) ?></h2>

</div>
</body>
</html>
