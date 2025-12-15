<?php
session_start();
include 'config.php';

if (!isset($_SESSION['StaffID']) || $_SESSION['Role'] !== 'RIDER') {
    header("Location: admin_delivery_status.php");
    exit;
}

$deliveryId = $_POST['delivery_id'] ?? '';
$action     = $_POST['action'] ?? '';

$stmt = $conn->prepare("
    SELECT OrderID, status
    FROM deliveryinfo
    WHERE DeliveryID = ?
");
$stmt->bind_param("s", $deliveryId);
$stmt->execute();
$delivery = $stmt->get_result()->fetch_assoc();

if (!$delivery) {
    header("Location: admin_delivery_status.php");
    exit;
}

if ($action === 'pickup' && $delivery['status'] === 'PENDING') {
    $conn->query("UPDATE deliveryinfo SET status='DELIVERING' WHERE DeliveryID='$deliveryId'");
}

if ($action === 'arrive' && $delivery['status'] === 'DELIVERING') {
    $conn->query("UPDATE deliveryinfo SET status='COMPLETED' WHERE DeliveryID='$deliveryId'");
    $conn->query("UPDATE `order` SET status='COMPLETED' WHERE OrderID='{$delivery['OrderID']}'");
}

header("Location: admin_delivery_status.php");
exit;
