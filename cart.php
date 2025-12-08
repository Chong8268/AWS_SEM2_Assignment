<?php include 'header.php'; ?>

<style>
.cart-wrap {
    padding: 40px;
    max-width: 1100px;
    margin: auto;
}

.cart-title {
    font-size: 2rem;
    margin-bottom: 20px;
}

/* cart item */
.cart-item {
    display: flex;
    gap: 18px;
    padding: 18px;
    background: #181818;
    border-radius: 12px;
    margin-bottom: 12px;
}

.cart-thumb {
    width: 140px;
    height: 100px;
    background: #222;
    border-radius: 10px;
    flex-shrink: 0;
}

.cart-meta {
    flex: 1;
}

.cart-meta h4 {
    margin: 0 0 6px;
}

.cart-qty {
    display: flex;
    gap: 8px;
    align-items: center;
    margin-top: 8px;
}

/* buttons */
.cart-btn {
    padding: 10px 16px;
    border-radius: 8px;
    background: #00ffa6;
    color: #000;
    border: 0;
    font-weight: 700;
    cursor: pointer;
    transition: .2s;
}
.cart-btn:hover {
    background: #00d98c;
}

.cart-btn-remove {
    background: #ff6b6b;
    color: #fff;
}
.cart-btn-remove:hover {
    background: #ff5454;
}

/* summary box */
.cart-summary {
    background: #111;
    padding: 18px;
    border-radius: 12px;
    margin-top: 16px;
    text-align: right;
}
</style>


<div class="page-content">
<div class="cart-wrap">

    <h2 class="cart-title">My Cart</h2>

    <!-- Example Item -->
    <div class="cart-item">
        <div class="cart-thumb"></div>

        <div class="cart-meta">
            <h4>Chicken Rice — RM 6.50</h4>

            <div class="cart-qty">
                <button class="cart-btn">-</button>
                <div>1</div>
                <button class="cart-btn">+</button>

                <button class="cart-btn cart-btn-remove">Remove</button>
            </div>
        </div>
    </div>

    <div class="cart-summary">
        <div style="margin-bottom:8px">Subtotal: RM 11.50</div>

        <button class="cart-btn" onclick="location.href='checkout.php'">
            Proceed to Checkout
        </button>
    </div>

</div>
</div>

<?php include 'footer.php'; ?>
