<?php include 'header.php'; ?>

<style>
.co-wrap {
    padding: 40px;
    max-width: 900px;
    margin: auto;
}

.co-card {
    background: #111;
    padding: 24px;
    border-radius: 12px;
}

.co-field {
    margin-bottom: 14px;
}

.co-label {
    display: block;
    color: #bbb;
    margin-bottom: 6px;
}

.co-input, .co-textarea {
    width: 100%;
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #222;
    background: #0f0f0f;
    color: #fff;
}

.co-btn {
    background: #00ffa6;
    color: #000;
    padding: 12px 18px;
    border: 0;
    border-radius: 10px;
    font-weight: 700;
    cursor: pointer;
}
.co-btn:hover {
    background: #00d98c;
}
</style>

<div class="page-content">
<div class="co-wrap">

    <div class="co-card">
        <h2>Checkout</h2>

        <form action="order_success.php" method="post">
            
            <div class="co-field">
                <label class="co-label">Full name</label>
                <input class="co-input" name="name" required />
            </div>

            <div class="co-field">
                <label class="co-label">Phone</label>
                <input class="co-input" name="phone" required />
            </div>

            <div class="co-field">
                <label class="co-label">Delivery Address</label>
                <textarea class="co-textarea" name="address" rows="3" required></textarea>
            </div>

            <div class="co-field">
                <label class="co-label">Notes (optional)</label>
                <textarea class="co-textarea" name="notes" rows="2"></textarea>
            </div>

            <div style="text-align:right;">
                <button class="co-btn" type="submit">Place Order</button>
            </div>

        </form>
    </div>

</div>
</div>

<?php include 'footer.php'; ?>
