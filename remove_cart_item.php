<?php
session_start();
include "config.php";

if (!isset($_SESSION["CustomerID"])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET["item_id"])) {
    header("Location: cart.php");
    exit;
}

$itemID = $_GET["item_id"];

$stmt = $conn->prepare("
    SELECT p.name 
    FROM cartitems ci
    JOIN product p ON ci.ProductID = p.ProductID
    WHERE ci.ItemsID = ?
");
$stmt->bind_param("i", $itemID);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $itemName = $row["name"];
} else {
    header("Location: cart.php");
    exit;
}

$stmt = $conn->prepare("DELETE FROM cartitems WHERE ItemsID = ?");
$stmt->bind_param("i", $itemID);
$stmt->execute();

header("Location: cart.php?removed=" . urlencode($itemName));
exit;
