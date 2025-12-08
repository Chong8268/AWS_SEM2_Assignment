<?php include 'admin_header.php'; ?>

<div class="admin-wrap">

    <h1>Add Product</h1>

    <form action="admin_add_product_process.php" method="post" class="admin-form">

        <label>Product Name</label>
        <input name="name" placeholder="Name" required>

        <label>Description</label>
        <textarea name="description" placeholder="Description"></textarea>

        <label>Price (RM)</label>
        <input type="number" step="0.01" name="price" placeholder="Price" required>

        <label>Stock Quantity</label>
        <input type="number" name="stock_quantity" placeholder="Stock Quantity" required>

        <label>Category</label>
        <input name="categories" placeholder="Category (e.g., Burgers)">

        <button class="admin-btn" type="submit">Add Product</button>
    </form>

</div>

<?php include 'footer.php'; ?>
