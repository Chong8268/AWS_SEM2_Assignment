<?php include 'admin_header.php'; ?>

<style>
.admin-wrap {
    max-width: 600px;
    margin: 40px auto;
}

.admin-form label {
    display: block;
    margin-top: 16px;
    font-weight: 600;
}

.admin-form input,
.admin-form textarea {
    width: 100%;
    padding: 12px;
    margin-top: 6px;
    background: #111;
    border: 1px solid #333;
    border-radius: 10px;
    color: #fff;
}

.admin-form textarea {
    resize: vertical;
    min-height: 100px;
}

/* Toast */
.toast {
    position: fixed;
    top: 30px;
    right: 30px;
    padding: 14px 20px;
    border-radius: 12px;
    font-weight: 700;
    box-shadow: 0 10px 25px rgba(0,0,0,0.4);
    opacity: 0;
    transform: translateY(-20px);
    transition: 0.4s;
    z-index: 9999;
}

.toast.show {
    opacity: 1;
    transform: translateY(0);
}

.toast.success {
    background: #00ffa6;
    color: #000;
}

.toast.error {
    background: #ff5f5f;
    color: #fff;
}
</style>

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

        <button class="admin-btn" type="submit" style="margin-top:20px;">
            Add Product
        </button>
    </form>

</div>

<!-- Toast -->
<div id="toast" class="toast"></div>

<script>
function showToast(message, type) {
    const toast = document.getElementById('toast');
    toast.textContent = message;
    toast.className = 'toast show ' + type;

    setTimeout(() => {
        toast.className = 'toast';
    }, 3000);
}

<?php if (isset($_GET['success'])): ?>
    showToast('Product added successfully!', 'success');
<?php endif; ?>

<?php if (isset($_GET['error'])): ?>
    showToast('Invalid input. Please check again.', 'error');
<?php endif; ?>
</script>

<?php include 'footer.php'; ?>
