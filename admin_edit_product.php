<?php
include 'admin_header.php';
include 'config.php';

if (!isset($_GET['id'])) {
    header("Location: admin_products.php");
    exit;
}

$productId = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM product WHERE ProductID = ?");
$stmt->bind_param("s", $productId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: admin_products.php");
    exit;
}

$product = $result->fetch_assoc();
?>

<div class="admin-wrap">

    <h1>Edit Product</h1>

    <form action="admin_edit_product_process.php" method="post" class="admin-form">

        <input type="hidden" name="ProductID" value="<?= $product['ProductID'] ?>">

        <label>Product Name</label>
        <input name="name" value="<?= htmlspecialchars($product['name']) ?>" required>

        <label>Description</label>
        <textarea name="description"><?= htmlspecialchars($product['description']) ?></textarea>

        <label>Price (RM)</label>
        <input type="number" step="0.01" name="price"
               value="<?= $product['price'] ?>" required>

        <label>Stock Quantity</label>
        <input type="number" name="stock_quantity"
               value="<?= $product['stock_quantity'] ?>" required>

        <label>Category</label>
        <input name="categories"
               value="<?= htmlspecialchars($product['categories']) ?>">

        <label>Status</label>
        <select name="status">
            <option value="ACTIVE" <?= $product['status'] === 'ACTIVE' ? 'selected' : '' ?>>
                ACTIVE
            </option>
            <option value="INACTIVE" <?= $product['status'] === 'INACTIVE' ? 'selected' : '' ?>>
                INACTIVE
            </option>
        </select>

        <button class="admin-btn" type="submit">Update Product</button>
        <a href="admin_products.php" class="admin-btn-sm">Cancel</a>

    </form>

</div>

<div id="toast" class="toast"></div>

<script>
function showToast(msg, type) {
    const t = document.getElementById('toast');
    t.textContent = msg;
    t.className = 'toast show ' + type;
    setTimeout(() => t.className = 'toast', 3000);
}

<?php if (isset($_GET['success'])): ?>
    showToast('Product updated successfully!', 'success');
<?php endif; ?>

<?php if (isset($_GET['error'])): ?>
    showToast('Failed to update product.', 'error');
<?php endif; ?>
</script>

<?php include 'footer.php'; ?>
