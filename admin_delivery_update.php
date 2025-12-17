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
    SELECT d.OrderID, d.status, p.method as payment_method
    FROM deliveryinfo d
    JOIN payment p ON p.OrderID = d.OrderID
    WHERE d.DeliveryID = ?
");
$stmt->bind_param("s", $deliveryId);
$stmt->execute();
$delivery = $stmt->get_result()->fetch_assoc();

if (!$delivery) {
    header("Location: admin_delivery_status.php");
    exit;
}

if ($action === 'pickup' && $delivery['status'] === 'READY_TO_PICKUP') {
    $stmt = $conn->prepare("UPDATE deliveryinfo SET status='DELIVERING' WHERE DeliveryID=?");
    $stmt->bind_param("s", $deliveryId);
    $stmt->execute();
    
    $stmt = $conn->prepare("UPDATE `order` SET status='DELIVERING' WHERE OrderID=?");
    $stmt->bind_param("s", $delivery['OrderID']);
    $stmt->execute();
    
    $historyId = 'HIS_' . date('YmdHis') . '_' . bin2hex(random_bytes(4));
    $staffId = $_SESSION['StaffID'];
    $remark = "Pick up by Rider";
    
    $stmt = $conn->prepare("INSERT INTO orderhistory (HistoryID, OrderID, status, changed_by_staff, changed_at, remark) VALUES (?, ?, 'DELIVERING', ?, NOW(), ?)");
    $stmt->bind_param("ssss", $historyId, $delivery['OrderID'], $staffId, $remark);
    $stmt->execute();
}

if ($action === 'arrive' && $delivery['status'] === 'DELIVERING') {
    $isCOD = (strtoupper($delivery['payment_method']) === 'COD');
    
    if ($isCOD) {
        $stmt = $conn->prepare("UPDATE deliveryinfo SET status='ARRIVE' WHERE DeliveryID=?");
        $stmt->bind_param("s", $deliveryId);
        $stmt->execute();
        
        $stmt = $conn->prepare("UPDATE `order` SET status='ARRIVE' WHERE OrderID=?");
        $stmt->bind_param("s", $delivery['OrderID']);
        $stmt->execute();
        
        $historyId = 'HIS_' . date('YmdHis') . '_' . bin2hex(random_bytes(4));
        $staffId = $_SESSION['StaffID'];
        $remark = "Rider has arrived at destination. Waiting for payment.";
        
        $stmt = $conn->prepare("INSERT INTO orderhistory (HistoryID, OrderID, status, changed_by_staff, changed_at, remark) VALUES (?, ?, 'ARRIVE', ?, NOW(), ?)");
        $stmt->bind_param("ssss", $historyId, $delivery['OrderID'], $staffId, $remark);
        $stmt->execute();
    } else {
        $stmt = $conn->prepare("UPDATE deliveryinfo SET status='COMPLETED' WHERE DeliveryID=?");
        $stmt->bind_param("s", $deliveryId);
        $stmt->execute();
        
        $stmt = $conn->prepare("UPDATE `order` SET status='COMPLETED' WHERE OrderID=?");
        $stmt->bind_param("s", $delivery['OrderID']);
        $stmt->execute();
        
        $historyId = 'HIS_' . date('YmdHis') . '_' . bin2hex(random_bytes(4));
        $staffId = $_SESSION['StaffID'];
        $remark = "Delivery completed successfully!";
        
        $stmt = $conn->prepare("INSERT INTO orderhistory (HistoryID, OrderID, status, changed_by_staff, changed_at, remark) VALUES (?, ?, 'COMPLETED', ?, NOW(), ?)");
        $stmt->bind_param("ssss", $historyId, $delivery['OrderID'], $staffId, $remark);
        $stmt->execute();
    }
}

if ($action === 'complete' && $delivery['status'] === 'ARRIVE') {
    $stmt = $conn->prepare("UPDATE deliveryinfo SET status='COMPLETED' WHERE DeliveryID=?");
    $stmt->bind_param("s", $deliveryId);
    $stmt->execute();
    
    $stmt = $conn->prepare("UPDATE `order` SET status='COMPLETED' WHERE OrderID=?");
    $stmt->bind_param("s", $delivery['OrderID']);
    $stmt->execute();
    
    $historyId = 'HIS_' . date('YmdHis') . '_' . bin2hex(random_bytes(4));
    $staffId = $_SESSION['StaffID'];
    $remark = "Payment received. Order completed successfully.";
    
    $stmt = $conn->prepare("INSERT INTO orderhistory (HistoryID, OrderID, status, changed_by_staff, changed_at, remark) VALUES (?, ?, 'COMPLETED', ?, NOW(), ?)");
    $stmt->bind_param("ssss", $historyId, $delivery['OrderID'], $staffId, $remark);
    $stmt->execute();
}

header("Location: admin_delivery_status.php");
exit;
