<?php
include 'header.php';
include 'config.php';

if (!isset($_SESSION["CustomerID"])) {
    header("Location: login.php");
    exit;
}

$customerID = $_SESSION["CustomerID"];

/* ===== 取 Customer 资料（自动填） ===== */
$custStmt = $conn->prepare("
    SELECT Name, Phone, Address
    FROM customer
    WHERE CustomerID = ?
");
$custStmt->bind_param("s", $customerID);
$custStmt->execute();
$customer = $custStmt->get_result()->fetch_assoc();

/* ===== 取 Cart Items + 锁库存前检查 ===== */
$stmt = $conn->prepare("
    SELECT
        ci.ItemsID,
        ci.quantity,
        ci.unit_price,
        p.ProductID,
        p.name,
        p.stock_quantity
    FROM cartitems ci
    JOIN cart c ON c.CartID = ci.CartID
    JOIN product p ON p.ProductID = ci.ProductID
    WHERE c.CustomerID = ?
");
$stmt->bind_param("s", $customerID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: cart.php");
    exit;
}

$items = [];
$subtotal = 0;

while ($row = $result->fetch_assoc()) {
    if ($row["quantity"] > $row["stock_quantity"]) {
        header("Location: cart.php?stock_error=1");
        exit;
    }
    $items[] = $row;
    $subtotal += $row["quantity"] * $row["unit_price"];
}
?>

<style>
/* ===== Checkout Layout ===== */
.checkout-wrap {
    max-width: 720px;
    margin: auto;
    padding: 40px 30px 60px;
}

/* Title */
.checkout-wrap h2 {
    font-size: 2.2rem;
    margin-bottom: 24px;
    text-align: center;
    letter-spacing: 0.5px;
}

/* ===== Card Base ===== */
.order-summary,
.checkout-form {
    background: linear-gradient(180deg, #181818, #141414);
    border: 1px solid #222;
    border-radius: 16px;
    padding: 22px;
    margin-bottom: 24px;
    box-shadow: 0 12px 30px rgba(0,0,0,0.45);
}

/* ===== Order Summary ===== */
.order-summary h3 {
    margin: 0 0 14px;
    font-size: 1.2rem;
    color: #00ffa6;
}

.order-item {
    display: flex;
    justify-content: space-between;
    padding: 6px 0;
    font-size: 0.95rem;
    color: #ddd;
}

.order-summary hr {
    border: none;
    border-top: 1px dashed #333;
    margin: 14px 0;
}

.order-summary strong {
    font-size: 1.15rem;
    color: #fff;
}

/* ===== Form ===== */
.form-group {
    margin-bottom: 18px;
}

.form-group label {
    display: block;
    margin-bottom: 6px;
    font-size: 0.9rem;
    color: #aaa;
}

/* Inputs */
.form-group input,
.form-group textarea {
    width: 100%;
    padding: 14px 14px;
    background: #0f0f0f;
    border: 1px solid #333;
    border-radius: 10px;
    color: #fff;
    font-size: 0.95rem;
    transition: 0.25s;
}

.form-group textarea {
    resize: vertical;
    min-height: 90px;
}

.form-group input:focus,
.form-group textarea:focus {
    outline: none;
    border-color: #00ffa6;
    box-shadow: 0 0 0 2px rgba(0,255,166,0.15);
}

/* ===== Payment Method ===== */
.payment-group {
    margin-top: 10px;
}

.payment-option {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 14px;
    background: #111;
    border: 1px solid #333;
    border-radius: 10px;
    margin-bottom: 10px;
    cursor: pointer;
    transition: 0.25s;
}

.payment-option:hover {
    background: #161616;
}

.payment-option input {
    accent-color: #00ffa6;
    transform: scale(1.15);
}

/* ===== Place Order Button ===== */
.checkout-btn {
    width: 100%;
    margin-top: 20px;
    padding: 15px 0;
    background: linear-gradient(135deg, #00ffa6, #00d98c);
    border: none;
    border-radius: 12px;
    font-weight: 700;
    font-size: 1.05rem;
    color: #000;
    cursor: pointer;
    transition: 0.25s;
    box-shadow: 0 8px 22px rgba(0,255,166,0.35);
}

.checkout-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 30px rgba(0,255,166,0.5);
}

</style>

<div class="page-content">
<div class="checkout-wrap">

<h2>Checkout</h2>

<div class="order-summary">
    <h3>Order Summary</h3>
    <?php foreach ($items as $item): ?>
        <div class="order-item">
            <?= htmlspecialchars($item["name"]) ?>
            × <?= $item["quantity"] ?>
            — RM <?= number_format($item["unit_price"], 2) ?>
        </div>
    <?php endforeach; ?>
    <hr>
    <strong>Subtotal: RM <?= number_format($subtotal, 2) ?></strong>
</div>

<form method="post" action="checkout_process.php" class="checkout-form">


    <div class="form-group">
        <label>Full Name *</label>
        <input type="text"
               name="full_name"
               required
               value="<?= htmlspecialchars($customer["Name"] ?? "") ?>">
    </div>

    <div class="form-group">
        <label>Phone *</label>
        <input type="text"
               name="phone"
               required
               pattern="[0-9+\- ]{8,20}"
               value="<?= htmlspecialchars($customer["Phone"] ?? "") ?>">
    </div>

    <div class="form-group">
        <label>Delivery Address *</label>
        <textarea name="address"
                  required
                  minlength="10"><?= htmlspecialchars($customer["Address"] ?? "") ?></textarea>
    </div>

    <div class="form-group">
        <label>Notes (optional)</label>
        <textarea name="notes"></textarea>
    </div>

    <div class="form-group">
    <label>Payment Method *</label>

    <div class="payment-group">
        <label class="payment-option">
            <input type="radio" name="payment_method" value="COD" required>
            Cash on Delivery
        </label>

        <label class="payment-option">
            <input type="radio" name="payment_method" value="Card" required>
            Credit / Debit Card
        </label>
    </div>
</div>


    <button class="checkout-btn">Place Order</button>

</form>

</div>
</div>

<?php include 'footer.php'; ?>
