<?php
session_start();
include 'config.php';

if (!isset($_SESSION['StaffID']) || $_SESSION['Role'] !== 'ADMIN') {
    header("Location: admin_login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: admin_products.php");
    exit;
}

$productId     = $_POST['product_id'];
$currentStatus = $_POST['current_status'];

$newStatus = ($currentStatus === 'ACTIVE') ? 'INACTIVE' : 'ACTIVE';

$stmt = $conn->prepare("
    UPDATE product
    SET status = ?
    WHERE ProductID = ?
");
$stmt->bind_param("ss", $newStatus, $productId);
$stmt->execute();

header("Location: admin_products.php");
exit;
