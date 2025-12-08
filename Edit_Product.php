<?php include 'admin_header.php'; ?>

<div class="admin-page">
<div class="admin-wrap">

    <h1>Edit Product</h1>

    <form action="admin_edit_product_process.php" method="post" class="admin-form">

        <input type="hidden" name="id" value="<?= $p['ProductID'] ?>">

        <label>Product Name</label>
        <input name="name"
               value="<?= htmlspecialchars($p['name']) ?>"
               required>

        <label>Description</label>
        <textarea name="description"><?= htmlspecialchars($p['description']) ?></textarea>

        <label>Price (RM)</label>
        <input type="number" step="0.01" name="price" 
               value="<?= $p['price'] ?>" required>

        <label>Stock Quantity</label>
        <input type="number" name="stock_quantity" 
               value="<?= $p['stock_quantity'] ?>" required>

        <label>Category</label>
        <input name="categories"
               value="<?= htmlspecialchars($p['categories']) ?>">

        <button class="admin-btn" type="submit">Save Changes</button>
    </form>

</div>
</div>

<?php include 'footer.php'; ?>
