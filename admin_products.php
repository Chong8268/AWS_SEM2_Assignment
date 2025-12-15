<?php include 'admin_header.php'; 
$result = $conn->query("
    SELECT *
    FROM product
    ORDER BY name
");

$products = $result->fetch_all(MYSQLI_ASSOC);
?>

<div class="admin-page">
<div class="admin-wrap">

    <h1>Product Management</h1>

    <a href="admin_addproduct.php"
       class="admin-btn-sm"
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
            <th>Status</th>
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
                <span class="status <?= strtolower($p['status']) ?>">
                    <?= $p['status'] ?>
                </span>
            </td>

            <td>
                <a class="admin-btn-sm"
                   href="admin_edit_product.php?id=<?= $p['ProductID'] ?>">
                   Edit
                </a>

                <form method="post"
                      action="admin_toggle_product_status.php"
                      style="display:inline;"
                      onsubmit="return confirm('Confirm change product status?');">
                    <input type="hidden" name="product_id" value="<?= $p['ProductID'] ?>">
                    <input type="hidden" name="current_status" value="<?= $p['status'] ?>">

                    <?php if ($p['status'] === 'ACTIVE'): ?>
                        <button class="admin-btn-danger">Deactivate</button>
                    <?php else: ?>
                        <button class="admin-btn-sm">Activate</button>
                    <?php endif; ?>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

</div>
</div>

<?php include 'footer.php'; ?>
