<?php
session_start();
include "config.php";

if (!isset($_SESSION["CustomerID"])) {
    header("Location: login.php");
    exit;
}

$customerID = $_SESSION["CustomerID"];

// 找用户 cart
$stmt = $conn->prepare("SELECT CartID FROM cart WHERE CustomerID = ?");
$stmt->bind_param("s", $customerID);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $cartID = $row["CartID"];

    // 删除 cart items
    $stmt = $conn->prepare("DELETE FROM cartitems WHERE CartID = ?");
    $stmt->bind_param("s", $cartID);
    $stmt->execute();
}

// redirect 回 cart + toast
header("Location: cart.php?cleared=1");
exit;
