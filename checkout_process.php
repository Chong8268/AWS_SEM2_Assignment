<?php
session_start();
include 'config.php';

if (!isset($_SESSION["CustomerID"])) {
    die("Unauthorized");
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Invalid request");
}

$customerID = $_SESSION["CustomerID"];

$fullName = trim($_POST["full_name"] ?? "");
$phone = trim($_POST["phone"] ?? "");
$address = trim($_POST["address"] ?? "");
$paymentMethod = trim($_POST["payment_method"] ?? "");
$notes = trim($_POST["notes"] ?? "");

if ($fullName === "" || $phone === "" || $address === "" || $paymentMethod === "") {
    die("Invalid checkout data.");
}

/* ---------- 生成唯一 ID ---------- */
function genID($prefix) {
    return $prefix . bin2hex(random_bytes(8)) . time();
}

$orderID    = genID("ORD_");
$paymentID  = genID("PAY_");
$deliveryID = genID("DEL_");
$itemID     = genID("ITEM_");


$conn->begin_transaction();

try {

    /* ---------- 1️⃣ 找 cart ---------- */
    $stmt = $conn->prepare("SELECT CartID FROM cart WHERE CustomerID = ?");
    $stmt->bind_param("s", $customerID);
    $stmt->execute();
    $cart = $stmt->get_result()->fetch_assoc();

    if (!$cart) {
        throw new Exception("Cart not found");
    }

    $cartID = $cart["CartID"];

    /* ---------- 2️⃣ 拿 cart items（并锁库存） ---------- */
    $stmt = $conn->prepare("
        SELECT ci.ProductID, ci.quantity, ci.unit_price, p.stock_quantity
        FROM cartitems ci
        JOIN product p ON ci.ProductID = p.ProductID
        WHERE ci.CartID = ?
        FOR UPDATE
    ");
    $stmt->bind_param("s", $cartID);
    $stmt->execute();
    $items = $stmt->get_result();

    if ($items->num_rows === 0) {
        throw new Exception("Cart empty");
    }

    $total = 0;
    $cartData = [];

    while ($row = $items->fetch_assoc()) {
        if ($row["quantity"] > $row["stock_quantity"]) {
            throw new Exception("Insufficient stock");
        }

        $total += $row["quantity"] * $row["unit_price"];
        $cartData[] = $row;
    }

    /* ---------- 3️⃣ Insert order ---------- */
    $stmt = $conn->prepare("
        INSERT INTO `order`
        (OrderID, CustomerID, order_date, total_amount, status)
        VALUES (?, ?, NOW(), ?, 'PENDING')
    ");
    $stmt->bind_param("ssd", $orderID, $customerID, $total);
    $stmt->execute();

    // 下单后写入订单历史
    $historyID = genID("HIS");

    $stmt = $conn->prepare("
        INSERT INTO orderhistory
        (HistoryID, OrderID, status, changed_by_staff, changed_at, remark)
        VALUES (?, ?, 'PENDING', NULL, NOW(), 'Order placed by customer')
    ");
    $stmt->bind_param("ss", $historyID, $orderID);
    $stmt->execute();


    /* ---------- 4️⃣ Insert order items + 扣库存 ---------- */
    foreach ($cartData as $item) {

        $itemID = genID("ITEM");

        $stmt = $conn->prepare("
            INSERT INTO orderitems
            (ItemID, OrderID, ProductID, quantity, unit_price)
            VALUES (?, ?, ?, ?, ?)
        ");
        $stmt->bind_param(
            "sssii",
            $itemID,
            $orderID,
            $item["ProductID"],
            $item["quantity"],
            $item["unit_price"]
        );
        $stmt->execute();

        $stmt = $conn->prepare("
            UPDATE product
            SET stock_quantity = stock_quantity - ?
            WHERE ProductID = ?
        ");
        $stmt->bind_param("is", $item["quantity"], $item["ProductID"]);
        $stmt->execute();
    }

    /* ---------- 5️⃣ delivery info ---------- */
    $stmt = $conn->prepare("
        INSERT INTO deliveryinfo
        (DeliveryID, OrderID, receiver_name, receiver_phone, address, status)
        VALUES (?, ?, ?, ?, ?, 'PENDING')
    ");
    $stmt->bind_param("sssss", $deliveryID, $orderID, $fullName, $phone, $address);
    $stmt->execute();

    /* ---------- 6️⃣ payment ---------- */
    $stmt = $conn->prepare("
        INSERT INTO payment
        (PaymentID, OrderID, amount, method)
        VALUES (?, ?, ?, ?)
    ");
    $stmt->bind_param("ssds", $paymentID, $orderID, $total, $paymentMethod);
    $stmt->execute();

    /* ---------- 7️⃣ 清空 cart ---------- */
    $stmt = $conn->prepare("DELETE FROM cartitems WHERE CartID = ?");
    $stmt->bind_param("s", $cartID);
    $stmt->execute();

    $conn->commit();

    header("Location: my_orders.php?success=1");
    exit;

} catch (Exception $e) {
    $conn->rollback();
    die("Checkout failed: " . $e->getMessage());
}
