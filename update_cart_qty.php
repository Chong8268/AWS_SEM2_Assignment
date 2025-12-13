<?php
include "config.php";

$itemID = $_GET['id'];
$newQty = (int)$_GET['qty'];

// 查库存
$stmt = $conn->prepare("
    SELECT p.stock_quantity
    FROM cartitems ci
    JOIN Product p ON ci.ProductID = p.ProductID
    WHERE ci.ItemsID = ?
");
$stmt->bind_param("s", $itemID);
$stmt->execute();
$stock = $stmt->get_result()->fetch_assoc()['stock_quantity'];

if ($newQty > $stock) {
    header("Location: cart.php");
    exit;
}

// 更新数量
$stmt = $conn->prepare("
    UPDATE cartitems
    SET quantity = ?
    WHERE ItemsID = ?
");
$stmt->bind_param("is", $newQty, $itemID);
$stmt->execute();

header("Location: cart.php");
exit;
