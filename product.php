<?php
include 'header.php';
include 'config.php';

// 获取传递的 ProductID
$product_id = isset($_GET['id']) ? $_GET['id'] : null;

if ($product_id) {
    // 查询该产品信息
    $stmt = $conn->prepare("SELECT * FROM Product WHERE ProductID = ?");
    $stmt->bind_param("s", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $product = $result->fetch_assoc();
    } else {
        echo "Product not found.";
        exit;
    }
} else {
    echo "Invalid product ID.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details | Cafeteria Xpress</title>

    <!-- Add your CSS styles here -->
    <style>
        /* Product Page Styles */
        .pd-container {
            padding: 40px 50px;
            max-width: 1200px;
            margin: auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
        }

        .pd-img img {
            width: 100%;
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

<!-- PAGE WRAPPER -->
<div class="page-content">
    <div class="pd-container">

        <!-- Product Image -->
        <div class="pd-img">
            <img src="<?= $product['ImageURL']; ?>" alt="<?= $product['name']; ?>">
        </div>

        <!-- Product Details -->
        <div>
            <h1><?= $product['name']; ?></h1>

            <!-- Price -->
            <div class="pd-price">RM <?= number_format($product['price'], 2); ?></div>

            <!-- Description -->
            <p class="pd-desc"><?= $product['description']; ?></p>

            <!-- Add to Cart Button -->
            <button class="pd-btn">Add to Cart</button>

            <!-- Back Button -->
            <button class="pd-btn pd-btn-secondary" onclick="history.back()">Back</button>
        </div>

    </div>
</div>

<?php include 'footer.php'; ?>

</body>
</html>
