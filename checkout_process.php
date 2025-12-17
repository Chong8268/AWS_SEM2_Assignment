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

if ($paymentMethod === "Card") {
    $cardName = trim($_POST["card_name"] ?? "");
    $cardNumber = trim(str_replace(' ', '', $_POST["card_number"] ?? ""));
    $cardExpiry = trim($_POST["card_expiry"] ?? "");
    $cardCVV = trim($_POST["card_cvv"] ?? "");
    
    if (strlen($cardName) < 3) {
        die("Invalid cardholder name.");
    }
    
    if (!preg_match('/^\d{16}$/', $cardNumber)) {
        die("Invalid card number.");
    }
    
    if (!preg_match('/^\d{2}\/\d{2}$/', $cardExpiry)) {
        die("Invalid expiry date format.");
    }
    
    list($month, $year) = explode('/', $cardExpiry);
    $expiryDate = new DateTime("20$year-$month-01");
    $now = new DateTime();
    
    if ($expiryDate < $now) {
        die("Card has expired.");
    }
    
    if (!preg_match('/^\d{3,4}$/', $cardCVV)) {
        die("Invalid CVV.");
    }
} elseif ($paymentMethod === "Online Banking") {
    $bankName = trim($_POST["bank_name"] ?? "");
    $accountName = trim($_POST["account_name"] ?? "");
    $accountNumber = trim(str_replace(' ', '', $_POST["account_number"] ?? ""));
    
    if ($bankName === "") {
        die("Please select a bank.");
    }
    
    if (strlen($accountName) < 3) {
        die("Invalid account holder name.");
    }
    
    if (!preg_match('/^\d{8,20}$/', $accountNumber)) {
        die("Invalid account number. Must be 8-20 digits.");
    }
    
    $allowedBanks = ['Maybank', 'CIMB Bank', 'Public Bank', 'RHB Bank', 'Hong Leong Bank', 'AmBank', 'Bank Islam', 'Affin Bank'];
    if (!in_array($bankName, $allowedBanks)) {
        die("Invalid bank selection.");
    }
}

function genID($prefix) {
    return $prefix . bin2hex(random_bytes(8)) . time();
}

$orderID    = genID("ORD_");
$paymentID  = genID("PAY_");
$deliveryID = genID("DEL_");
$itemID     = genID("ITEM_");


$conn->begin_transaction();

try {

    $stmt = $conn->prepare("SELECT CartID FROM cart WHERE CustomerID = ?");
    $stmt->bind_param("s", $customerID);
    $stmt->execute();
    $cart = $stmt->get_result()->fetch_assoc();

    if (!$cart) {
        throw new Exception("Cart not found");
    }

    $cartID = $cart["CartID"];

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

    $stmt = $conn->prepare("
        INSERT INTO `order`
        (OrderID, CustomerID, order_date, total_amount, status)
        VALUES (?, ?, NOW(), ?, 'PENDING')
    ");
    $stmt->bind_param("ssd", $orderID, $customerID, $total);
    $stmt->execute();

    $historyID = genID("HIS");

    $stmt = $conn->prepare("
        INSERT INTO orderhistory
        (HistoryID, OrderID, status, changed_by_staff, changed_at, remark)
        VALUES (?, ?, 'PENDING', NULL, NOW(), 'Order placed by customer')
    ");
    $stmt->bind_param("ss", $historyID, $orderID);
    $stmt->execute();


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

    $stmt = $conn->prepare("
        INSERT INTO deliveryinfo
        (DeliveryID, OrderID, receiver_name, receiver_phone, address, status)
        VALUES (?, ?, ?, ?, ?, 'PENDING')
    ");
    $stmt->bind_param("sssss", $deliveryID, $orderID, $fullName, $phone, $address);
    $stmt->execute();

    if ($paymentMethod === "Card") {
        $last4 = substr($cardNumber, -4);
        
        $stmt = $conn->prepare("
            INSERT INTO payment
            (PaymentID, OrderID, amount, method, account_last4)
            VALUES (?, ?, ?, 'Card', ?)
        ");
        $stmt->bind_param("ssds", $paymentID, $orderID, $total, $last4);
    } elseif ($paymentMethod === "Online Banking") {
        $last4 = substr($accountNumber, -4);
        
        $stmt = $conn->prepare("
            INSERT INTO payment
            (PaymentID, OrderID, amount, method, account_last4)
            VALUES (?, ?, ?, ?, ?)
        ");
        $paymentMethodWithBank = "Online Banking - " . $bankName;
        $stmt->bind_param("ssdss", $paymentID, $orderID, $total, $paymentMethodWithBank, $last4);
    } else {
        $stmt = $conn->prepare("
            INSERT INTO payment
            (PaymentID, OrderID, amount, method)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->bind_param("ssds", $paymentID, $orderID, $total, $paymentMethod);
    }
    $stmt->execute();

    if ($paymentMethod !== "COD") {
        $historyPaymentID = genID("PHIST_");
        $paymentRemark = "Payment received via " . $paymentMethod;
        
        $stmt = $conn->prepare("
            INSERT INTO paymenthistory
            (HistoryID, PaymentID, OrderID, transaction_type, amount, method, account_last4, status, remark)
            VALUES (?, ?, ?, 'PAYMENT', ?, ?, ?, 'SUCCESS', ?)
        ");
        
        if ($paymentMethod === "Card") {
            $stmt->bind_param("sssdsss", $historyPaymentID, $paymentID, $orderID, $total, $paymentMethod, $last4, $paymentRemark);
        } elseif ($paymentMethod === "Online Banking") {
            $stmt->bind_param("sssdsss", $historyPaymentID, $paymentID, $orderID, $total, $paymentMethodWithBank, $last4, $paymentRemark);
        }
        
        $stmt->execute();
    }

    $stmt = $conn->prepare("DELETE FROM cartitems WHERE CartID = ?");
    $stmt->bind_param("s", $cartID);
    $stmt->execute();

    $conn->commit();

    header("Location: my_orders.php?success=1");
    exit;

} catch (Exception $e) {
    $conn->rollback();
    header("Location: checkout.php?error=" . urlencode($e->getMessage()));
    exit;
}
