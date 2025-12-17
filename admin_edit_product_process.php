<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: admin_products.php");
    exit;
}

$productId = trim($_POST['ProductID'] ?? '');
$name = trim($_POST['name'] ?? '');
$description = trim($_POST['description'] ?? '');
$price = floatval($_POST['price'] ?? 0);
$stock = intval($_POST['stock_quantity'] ?? 0);
$category = trim($_POST['categories'] ?? '');
$status = $_POST['status'] ?? 'ACTIVE';

if (
    $productId === '' ||
    $name === '' ||
    $price <= 0 ||
    $stock < 0 ||
    !in_array($status, ['ACTIVE','INACTIVE'])
) {
    header("Location: admin_edit_product.php?id=$productId&error=1");
    exit;
}

$stmt = $conn->prepare("
    UPDATE product
    SET name = ?, description = ?, price = ?, stock_quantity = ?, categories = ?, status = ?
    WHERE ProductID = ?
");

$stmt->bind_param(
    "ssdisss",
    $name,
    $description,
    $price,
    $stock,
    $category,
    $status,
    $productId
);

if ($stmt->execute()) {
    header("Location: admin_edit_product.php?id=$productId&success=1");
} else {
    header("Location: admin_edit_product.php?id=$productId&error=1");
}
exit;
