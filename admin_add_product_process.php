<?php
session_start();
include 'config.php';

if (!isset($_SESSION['StaffID']) || $_SESSION['Role'] !== 'ADMIN') {
    header("Location: admin_login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: admin_AddProduct.php");
    exit;
}

$name        = trim($_POST['name']);
$description = trim($_POST['description']);
$price       = floatval($_POST['price']);
$stock       = intval($_POST['stock_quantity']);
$categories  = trim($_POST['categories']);
if ($name === '' || $price <= 0 || $stock < 0) {
    header("Location: admin_AddProduct.php?error=invalid");
    exit;
}

$productId = 'PROD_' . uniqid();

$stmt = $conn->prepare("
    INSERT INTO product
    (ProductID, name, description, price, stock_quantity, categories, status)
    VALUES (?, ?, ?, ?, ?, ?, 'ACTIVE')
");

$stmt->bind_param(
    "sssdis",
    $productId,
    $name,
    $description,
    $price,
    $stock,
    $categories
);

$stmt->execute();

header("Location: admin_products.php?success=1");
exit;
