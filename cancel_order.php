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

    $historyID = genID("HIS");

    $stmt = $conn->prepare("
        INSERT INTO orderhistory
        (HistoryID, OrderID, status, changed_by_staff, changed_at, remark)
        VALUES (?, ?, 'CANCELLED', NULL, NOW(), 'Order cancelled by customer')
    ");
    $stmt->bind_param("ss", $historyID, $orderID);
    $stmt->execute();

    $stmt = $conn->prepare("
        SELECT PaymentID, method, amount, account_last4
        FROM payment
        WHERE OrderID = ?
    ");
    $stmt->bind_param("s", $orderID);
    $stmt->execute();
    $paymentResult = $stmt->get_result()->fetch_assoc();

    if ($paymentResult && $paymentResult["method"] !== "COD") {
        $refundID = genID("REF_");
        $refundAmount = $paymentResult["amount"];
        $refundMethod = "Refund - " . $paymentResult["method"];
        $originalPaymentID = $paymentResult["PaymentID"];
        $accountLast4 = $paymentResult["account_last4"];
        
        $stmt = $conn->prepare("
            INSERT INTO payment
            (PaymentID, OrderID, amount, method, account_last4)
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->bind_param("ssdss", $refundID, $orderID, $refundAmount, $refundMethod, $accountLast4);
        $stmt->execute();
        
        $historyRefundID = genID("PHIST_");
        $refundRemark = "Refund issued for cancelled order - Original payment method: " . $paymentResult["method"];
        
        $stmt = $conn->prepare("
            INSERT INTO paymenthistory
            (HistoryID, PaymentID, OrderID, transaction_type, amount, method, account_last4, status, remark)
            VALUES (?, ?, ?, 'REFUND', ?, ?, ?, 'SUCCESS', ?)
        ");
        $stmt->bind_param("sssdsss", $historyRefundID, $refundID, $orderID, $refundAmount, $refundMethod, $accountLast4, $refundRemark);
        $stmt->execute();
    }

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
