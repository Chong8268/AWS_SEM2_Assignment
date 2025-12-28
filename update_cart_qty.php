<?php
include "config.php";

$itemID = $_GET['id'];
$newQty = (int)$_GET['qty'];

$stmt = $conn->prepare("
    SELECT p.stock_quantity
    FROM cartitems ci
    JOIN Product p ON ci.productID = p.productID
    WHERE ci.ItemsID = ?
");
$stmt->bind_param("s", $itemID);
$stmt->execute();
$stock = $stmt->get_result()->fetch_assoc()['stock_quantity'];

if ($newQty > $stock) {
    header("Location: cart.php");
    exit;
}

$stmt = $conn->prepare("
    UPDATE cartitems
    SET quantity = ?
    WHERE ItemsID = ?
");
$stmt->bind_param("is", $newQty, $itemID);
$stmt->execute();

header("Location: cart.php");
exit;
