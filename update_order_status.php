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
            VALUES (?, ?, ?, ?, ?, 'PENDING')
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
    }
}

header("Location: admin_orders.php");
exit;