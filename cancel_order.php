<?php
session_start();
include 'config.php';
include 'helper.php';

if (!isset($_SESSION["CustomerID"])) {
    die("Unauthorized");
}

$orderID = $_POST["order_id"] ?? $_GET["order_id"] ?? null;
$customerID = $_SESSION["CustomerID"];

if (!$orderID) {
    die("Invalid order ID request");
}

$conn->begin_transaction();

try {

    // 1️⃣ 确认 order 是 PENDING + 属于该用户
    $stmt = $conn->prepare("
        SELECT status
        FROM `order`
        WHERE OrderID = ? AND CustomerID = ?
        FOR UPDATE
    ");
    $stmt->bind_param("ss", $orderID, $customerID);
    $stmt->execute();
    $order = $stmt->get_result()->fetch_assoc();

    if (!$order || $order["status"] !== "PENDING") {
        throw new Exception("Order cannot be cancelled");
    }

    // 2️⃣ 更新 order status
    $stmt = $conn->prepare("
        UPDATE `order`
        SET status = 'CANCELLED'
        WHERE OrderID = ?
    ");
    $stmt->bind_param("s", $orderID);
    $stmt->execute();

    $stmt = $conn->prepare("
        UPDATE `deliveryinfo`
        SET status = 'CANCELLED'
        WHERE OrderID = ?
    ");
    $stmt->bind_param("s", $orderID);
    $stmt->execute();

    // 3️⃣ 记录 order history
    $historyID = genID("HIS");

    $stmt = $conn->prepare("
        INSERT INTO orderhistory
        (HistoryID, OrderID, status, changed_by_staff, changed_at, remark)
        VALUES (?, ?, 'CANCELLED', NULL, NOW(), 'Order cancelled by customer')
    ");
    $stmt->bind_param("ss", $historyID, $orderID);
    $stmt->execute();


    // 4️⃣（重要）恢复库存
    $stmt = $conn->prepare("
        SELECT ProductID, quantity
        FROM orderitems
        WHERE OrderID = ?
    ");
    $stmt->bind_param("s", $orderID);
    $stmt->execute();
    $items = $stmt->get_result();

    while ($item = $items->fetch_assoc()) {
        $stmt2 = $conn->prepare("
            UPDATE product
            SET stock_quantity = stock_quantity + ?
            WHERE ProductID = ?
        ");
        $stmt2->bind_param("is", $item["quantity"], $item["ProductID"]);
        $stmt2->execute();
    }

    $conn->commit();

    header("Location: my_orders.php?cancel=success");
    exit;

} catch (Exception $e) {
    $conn->rollback();
    die($e->getMessage());
}
