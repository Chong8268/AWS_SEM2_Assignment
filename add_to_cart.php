<?php
include "config.php";
session_start();

/* -------------------------
   必须先登录
------------------------- */
if (!isset($_SESSION["CustomerID"])) {
    header("Location: login.php");
    exit;
}

$customerID = $_SESSION["CustomerID"];

/* -------------------------
   接收参数
------------------------- */
if (!isset($_POST["product_id"], $_POST["quantity"])) {
    header("Location: menu.php");
    exit;
}

$productID = $_POST["product_id"];
$quantity  = (int)$_POST["quantity"];

if ($quantity <= 0) {
    header("Location: menu.php");
    exit;
}

/* -------------------------
   取得 / 创建 cart
------------------------- */
$stmt = $conn->prepare("
    SELECT CartID
    FROM cart
    WHERE CustomerID = ?
");
$stmt->bind_param("s", $customerID);
$stmt->execute();
$cartResult = $stmt->get_result();

if ($cartResult->num_rows === 0) {
    // 没有 cart → 创建一个
    $cartID = uniqid("CRT");
    $stmt = $conn->prepare("
        INSERT INTO cart (CartID, CustomerID, created_at)
        VALUES (?, ?, NOW())
    ");
    $stmt->bind_param("ss", $cartID, $customerID);
    $stmt->execute();
} else {
    $cartID = $cartResult->fetch_assoc()["CartID"];
}

/* -------------------------
   查「真实可用库存」
   stock_quantity - cart中已有数量
------------------------- */
$stmt = $conn->prepare("
    SELECT
        p.stock_quantity - IFNULL(SUM(ci.quantity), 0) AS available,
        p.price
    FROM product p
    LEFT JOIN cartitems ci
        ON p.ProductID = ci.ProductID
    LEFT JOIN cart c
        ON ci.CartID = c.CartID
        AND c.CustomerID = ?
    WHERE p.ProductID = ?
    GROUP BY p.ProductID
");
$stmt->bind_param("ss", $customerID, $productID);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();

if (!$product) {
    header("Location: menu.php");
    exit;
}

$availableStock = (int)$product["available"];
$unitPrice      = $product["price"];

/* -------------------------
   库存不足 → 拦截
------------------------- */
if ($quantity > $availableStock) {
    header("Location: product.php?product_id=$productID&stock_error=1");
    exit;
}

/* -------------------------
   加入 / 更新 cartitems
------------------------- */
$stmt = $conn->prepare("
    INSERT INTO cartitems (CartID, ProductID, quantity, unit_price)
    VALUES (?, ?, ?, ?)
    ON DUPLICATE KEY UPDATE
        quantity = quantity + VALUES(quantity)
");
$stmt->bind_param(
    "ssid",
    $cartID,
    $productID,
    $quantity,
    $unitPrice
);
$stmt->execute();

/* -------------------------
   成功 → 回到 cart
------------------------- */
header("Location: cart.php?added=1");
exit;
