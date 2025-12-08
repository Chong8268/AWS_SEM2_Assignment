<?php include 'admin_header.php'; ?>

<div class="admin-page">
<div class="admin-wrap">

    <h1>Product Management</h1>

    <a href="admin_addproduct.php" class="admin-btn-sm" 
       style="display:inline-block; margin-bottom:20px;">
       + Add Product
    </a>

    <table class="admin-table">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Price (RM)</th>
            <th>Stock</th>
            <th>Category</th>
            <th>Action</th>
        </tr>

        <?php foreach ($products as $p): ?>
        <tr>
            <td><?= $p['ProductID'] ?></td>
            <td><?= htmlspecialchars($p['name']) ?></td>
            <td><?= number_format($p['price'], 2) ?></td>
            <td><?= $p['stock_quantity'] ?></td>
            <td><?= htmlspecialchars($p['categories']) ?></td>

            <td>
                <a class="admin-btn-sm" 
                   href="admin_edit_product.php?id=<?= $p['ProductID'] ?>">Edit</a>

                <a class="admin-btn-danger" 
                   href="admin_delete_product.php?id=<?= $p['ProductID'] ?>"
                   onclick="return confirm('Delete this product?');">
                   Delete
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

</div>
</div>

<?php include 'footer.php'; ?>
