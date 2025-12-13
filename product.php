<?php
include 'header.php';
include 'config.php';

if (!isset($_SESSION["CustomerID"])) {
    header("Location: login.php");
    exit;
}

$productID = isset($_GET['id']) ? $_GET['id'] : null;

if ($productID) {
    $stmt = $conn->prepare("SELECT * FROM product WHERE ProductID = ?");
    $stmt->bind_param("s", $productID);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    $stock = (int)$product["stock_quantity"];
    // 查当前用户购物车中，这个商品已经有多少
    $cartQty = 0;

    if (isset($_SESSION['CustomerID'])) {
        $stmt = $conn->prepare("
            SELECT SUM(ci.quantity) AS total
            FROM cartitems ci
            JOIN cart c ON c.CartID = ci.CartID
            WHERE c.CustomerID = ? AND ci.ProductID = ?
        ");
        $stmt->bind_param("ss", $_SESSION['CustomerID'], $product['ProductID']);
        $stmt->execute();
        $rowQty = $stmt->get_result()->fetch_assoc();
        $cartQty = (int)($rowQty['total'] ?? 0);
    }

    $availableStock = max(0, $product['stock_quantity'] - $cartQty);

    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <style>
        /* Product Page Styles */
        .pd-container {
            padding: 40px 50px;
            max-width: 1200px;
            margin: auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            align-items: flex-start;
        }

        .pd-img {
            display: flex;
            justify-content: center; /* Center the image horizontally */
        }
        .pd-img img {
            max-width: 90%;
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0,255,166,0.3);
        }

        .pd-price {
            color: #00ffa6;
            font-size: 1.8rem;
            font-weight: 700;
            margin-top: 10px;
        }

        .pd-desc {
            margin-top: 20px;
            color: #bbb;
            line-height: 1.6;
        }

        /* buttons */
        .pd-btn {
            padding: 14px 30px;
            background: #00ffa6;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 700;
            font-size: 1.1rem;
            color: #000;
            margin-top: 20px;
            display: inline-block;
        }

        .pd-btn:hover {
            background: #00d98c;
        }

        .pd-btn-secondary {
            background: #181818;
            color: #fff;
            border: 1px solid #333;
        }

        .pd-btn-secondary:hover {
            background: #222;
        }

        .pd-btn-secondary {
            background: #181818;
            color: #fff;
            border: 1px solid #333;
        }
    </style>
</head>
<body>

<div class="pd-container">
    <div class="pd-img">
        <img src="<?= $product['ImageURL'] ?>" alt="<?= $product['name'] ?>">
    </div>

    <div>
        <h1><?= $product['name'] ?></h1>
        <div class="pd-price">RM <?= number_format($product['price'], 2) ?></div>
        <p class="pd-desc"><?= $product['description'] ?></p>

        <!-- Add to Cart Form -->
        <form method="POST" action="add_to_cart.php">
            <input type="hidden" name="product_id" value="<?= $product['ProductID'] ?>">
            <label>Quantity: </label>
            <input type="number" name="quantity" value="1" min="1" max="<?= $availableStock ?>"
    <?= $availableStock <= 0 ? 'disabled' : '' ?> required>
            <?php if ($availableStock > 0): ?>
                <button class="pd-btn">Add to Cart</button>
            <?php else: ?>
                <button class="pd-btn pd-btn-secondary" disabled>
                    Out of Stock
                </button>
            <?php endif; ?>

        </form>

        <button class="pd-btn pd-btn-secondary" onclick="history.back()">Back</button>
    </div>
</div>

</body>
</html>

<?php include 'footer.php'; ?>
