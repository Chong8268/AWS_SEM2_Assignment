<?php
include 'config.php';
session_start();

if (!isset($_SESSION["CustomerID"])) {
    header("Location: login.php");
    exit;
}

$customerID = $_SESSION["CustomerID"];
$address = trim($_POST["address"]);
$phone   = trim($_POST["phone"]);
$payment = $_POST["payment"];

if ($address === "" || $phone === "" || $payment === "") {
    header("Location: checkout.php?error=1");
    exit;
}

$conn->begin_transaction();

try {

    /* 再次锁库存（防并发） */
    $stmt = $conn->prepare("
        SELECT
            ci.ItemsID,
            ci.quantity,
            p.ProductID,
            p.stock_quantity
        FROM cartitems ci
        JOIN cart c ON c.CartID = ci.CartID
        JOIN product p ON p.ProductID = ci.ProductID
        WHERE c.CustomerID = ?
        FOR UPDATE
    ");
    $stmt->bind_param("s", $customerID);
    $stmt->execute();
    $items = $stmt->get_result();

    while ($row = $items->fetch_assoc()) {
        if ($row["quantity"] > $row["stock_quantity"]) {
            throw new Exception("Stock not enough");
        }

        /* 扣库存 */
        $update = $conn->prepare("
            UPDATE product
            SET stock_quantity = stock_quantity - ?
            WHERE ProductID = ?
        ");
        $update->bind_param("is", $row["quantity"], $row["ProductID"]);
        $update->execute();
    }

    /* TODO：Insert Order / OrderItems（下一步你会做） */

    /* 清空 cart */
    $clear = $conn->prepare("
        DELETE ci FROM cartitems ci
        JOIN cart c ON c.CartID = ci.CartID
        WHERE c.CustomerID = ?
    ");
    $clear->bind_param("s", $customerID);
    $clear->execute();

    $conn->commit();

    header("Location: order_success.php");
    exit;

} catch (Exception $e) {
    $conn->rollback();
    header("Location: cart.php?stock_error=1");
    exit;
}
