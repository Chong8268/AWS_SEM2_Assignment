<?php
session_start();
include 'config.php';

if (!isset($_SESSION['StaffID']) || $_SESSION['Role'] !== 'ADMIN') {
    header("Location: admin_login.php");
    exit;
}

$orderId = $_POST['order_id'] ?? '';
if ($orderId === '') {
    header("Location: admin_orders.php");
    exit;
}

$stmt = $conn->prepare("
    SELECT o.status, c.Name, c.Phone, c.Address
    FROM `order` o
    JOIN customer c ON o.CustomerID = c.CustomerID
    WHERE o.OrderID = ?
");
$stmt->bind_param("s", $orderId);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

$nextStatus = [
    'PENDING'   => 'ACCEPTED',
    'ACCEPTED' => 'PREPARING',
    'PREPARING'=> 'READY_TO_PICKUP'
];

if (!isset($nextStatus[$order['status']])) {
    header("Location: admin_orders.php");
    exit;
}

$newStatus = $nextStatus[$order['status']];

/* update order */
$upd = $conn->prepare("UPDATE `order` SET status=? WHERE OrderID=?");
$upd->bind_param("ss", $newStatus, $orderId);
$upd->execute();

$historyId = 'HIS_' . date('YmdHis') . '_' . bin2hex(random_bytes(4));
$staffId = $_SESSION['StaffID'];

$remarkMap = [
    'ACCEPTED' => 'Order accepted by admin',
    'PREPARING' => 'Kitchen started preparation',
    'READY_TO_PICKUP' => 'Order handed to delivery'
];
$remark = $remarkMap[$newStatus] ?? "Order status updated to {$newStatus}";

$histStmt = $conn->prepare("
    INSERT INTO orderhistory 
    (HistoryID, OrderID, status, changed_by_staff, changed_at, remark)
    VALUES (?, ?, ?, ?, NOW(), ?)
");
$histStmt->bind_param("sssss", $historyId, $orderId, $newStatus, $staffId, $remark);
$histStmt->execute();

/* create delivery when READY */
if ($newStatus === 'READY_TO_PICKUP') {

    $chk = $conn->prepare("SELECT 1 FROM deliveryinfo WHERE OrderID=?");
    $chk->bind_param("s", $orderId);
    $chk->execute();

    if ($chk->get_result()->num_rows === 0) {
        $deliveryId = 'DEL_' . bin2hex(random_bytes(4));
        $ins = $conn->prepare("
            INSERT INTO deliveryinfo
            (DeliveryID, OrderID, receiver_name, receiver_phone, address, status)
            VALUES (?, ?, ?, ?, ?, 'READY_TO_PICKUP')
        ");
        $ins->bind_param(
            "sssss",
            $deliveryId,
            $orderId,
            $order['Name'],
            $order['Phone'],
            $order['Address']
        );
        $ins->execute();
    } else {
        // Update existing delivery record to READY_TO_PICKUP
        $upd = $conn->prepare("UPDATE deliveryinfo SET status='READY_TO_PICKUP' WHERE OrderID=?");
        $upd->bind_param("s", $orderId);
        $upd->execute();
    }
}

header("Location: admin_orders.php");
exit;
