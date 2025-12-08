<?php include 'header.php'; ?>

<style>
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
</style>

<div class="page-content">
<div class="pd-container">

    <div class="pd-img">
        <img src="https://images.unsplash.com/photo-1604908177522-437cfdc8f63d" alt="Product Image">
    </div>

    <div>
        <h1>Chicken Rice</h1>

        <div class="pd-price">RM 6.50</div>

        <p class="pd-desc">
            A delicious and freshly prepared chicken rice meal, served warm with flavorful roasted chicken.
        </p>

        <button class="pd-btn">Add to Cart</button>

        <button class="pd-btn pd-btn-secondary" onclick="history.back()">Back</button>
    </div>

</div>
</div>

<?php include 'footer.php'; ?>
