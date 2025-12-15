<?php
session_start();
include 'config.php';

if (!isset($_SESSION['StaffID'])) {
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

if ($action === 'pickup' && $delivery['status'] === 'READY_TO_PICKUP') {
    // Update delivery status
    $stmt = $conn->prepare("UPDATE deliveryinfo SET status='DELIVERING' WHERE DeliveryID=?");
    $stmt->bind_param("s", $deliveryId);
    $stmt->execute();
    
    // Update order status
    $stmt = $conn->prepare("UPDATE `order` SET status='DELIVERING' WHERE OrderID=?");
    $stmt->bind_param("s", $delivery['OrderID']);
    $stmt->execute();
    
    // Insert into order history
    $historyId = 'HIS_' . date('YmdHis') . '_' . bin2hex(random_bytes(4));
    $staffId = $_SESSION['StaffID'];
    $remark = "Pick up by Rider";
    
    $stmt = $conn->prepare("INSERT INTO orderhistory (HistoryID, OrderID, status, changed_by_staff, changed_at, remark) VALUES (?, ?, 'DELIVERING', ?, NOW(), ?)");
    $stmt->bind_param("ssss", $historyId, $delivery['OrderID'], $staffId, $remark);
    $stmt->execute();
}

if ($action === 'arrive' && $delivery['status'] === 'DELIVERING') {
    // Update delivery status
    $stmt = $conn->prepare("UPDATE deliveryinfo SET status='COMPLETED' WHERE DeliveryID=?");
    $stmt->bind_param("s", $deliveryId);
    $stmt->execute();
    
    // Update order status
    $stmt = $conn->prepare("UPDATE `order` SET status='COMPLETED' WHERE OrderID=?");
    $stmt->bind_param("s", $delivery['OrderID']);
    $stmt->execute();
    
    // Insert into order history
    $historyId = 'HIS_' . date('YmdHis') . '_' . bin2hex(random_bytes(4));
    $staffId = $_SESSION['StaffID'];
    $remark = "Your Meals Have Arrive!";
    
    $stmt = $conn->prepare("INSERT INTO orderhistory (HistoryID, OrderID, status, changed_by_staff, changed_at, remark) VALUES (?, ?, 'COMPLETED', ?, NOW(), ?)");
    $stmt->bind_param("ssss", $historyId, $delivery['OrderID'], $staffId, $remark);
    $stmt->execute();
}

header("Location: admin_delivery_status.php");
exit;
