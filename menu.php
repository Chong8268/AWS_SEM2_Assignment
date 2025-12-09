<?php include 'header.php'; ?>

<style>
/* ------------ WRAPPER ------------ */
.menu-wrapper {
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px 40px 80px;
}

/* ------------ PAGE TITLE ------------ */
.menu-header {
    text-align: center;
    margin-bottom: 40px;
}
.menu-header h1 {
    font-size: 2.4rem;
    font-weight: 700;
}
.menu-header p {
    color: #bbb;
    font-size: 1.1rem;
    margin-top: 8px;
}

/* ------------ CATEGORY BUTTONS ------------ */
.menu-categories {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    justify-content: center;
    margin-bottom: 35px;
}
.menu-cat-btn {
    padding: 10px 18px;
    background: #181818;
    color: white;
    border-radius: 10px;
    border: 1px solid #222;
    cursor: pointer;
    transition: 0.25s;
}
.menu-cat-btn:hover {
    background: #222;
    transform: translateY(-3px);
}

/* ------------ PRODUCT GRID ------------ */
.menu-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 22px;
}

/* ------------ CARD ------------ */
.menu-card {
    background: #181818;
    padding: 18px;
    border-radius: 15px;
    transition: 0.25s;
}
.menu-card:hover {
    background: #222;
    transform: translateY(-5px);
}

.menu-card img {
    width: 100%;
    height: 170px;
    object-fit: cover;
    border-radius: 12px;
}

.menu-card h3 {
    margin: 12px 0 6px;
    font-size: 1.2rem;
}
.menu-card h3 a {
    text-decoration: none;
    color: white;
    transition: 0.2s;
}
.menu-card h3 a:hover {
    color: #00ffa6;
}

.menu-desc {
    color: #aaa;
    font-size: 0.9rem;
    height: 40px;
}

.menu-price {
    color: #00ffa6;
    font-weight: 700;
    font-size: 1.1rem;
    margin-top: 8px;
}

/* ------------ VIEW BUTTON ------------ */
.menu-btn {
    display: inline-block;
    margin-top: 12px;
    padding: 10px 14px;
    background: #00ffa6;
    color: #000;
    border-radius: 8px;
    font-weight: 700;
    text-decoration: none;
}
.menu-btn:hover {
    background: #00d98c;
}
</style>

<div class="page-content">
<div class="menu-wrapper">

    <!-- Title -->
    <div class="menu-header">
        <h1>Our Menu</h1>
        <p>Discover delicious meals freshly prepared for you.</p>
    </div>

    <!-- Category Buttons -->
    <div class="menu-categories">
        <div class="menu-cat-btn">All</div>
        <div class="menu-cat-btn">Rice</div>
        <div class="menu-cat-btn">Chicken</div>
        <div class="menu-cat-btn">Noodles</div>
        <div class="menu-cat-btn">Drinks</div>
    </div>

    <!-- Product Grid -->
    <div class="menu-grid">

        <div class="menu-card">
            <img src="https://images.unsplash.com/photo-1604908177522-437cfdc8f63d">
            <h3><a href="product.php">Chicken Rice</a></h3>
            <p class="menu-desc">Fresh steamed chicken with rice.</p>
            <p class="menu-price">RM 6.50</p>
            <a class="menu-btn" href="product.php">View Item</a>
        </div>

        <div class="menu-card">
            <img src="https://images.unsplash.com/photo-1604908177253-44a1c047bb0d">
            <h3>Fried Chicken</h3>
            <p class="menu-desc">Crispy and juicy fried chicken.</p>
            <p class="menu-price">RM 5.00</p>
            <a class="menu-btn" href="product.php">View Item</a>
        </div>

        <div class="menu-card">
            <img src="https://images.unsplash.com/photo-1543352634-69a4e07fc1bf">
            <h3>Noodle Soup</h3>
            <p class="menu-desc">Hot comforting noodle soup.</p>
            <p class="menu-price">RM 5.50</p>
            <a class="menu-btn" href="product.php">View Item</a>
        </div>

        <div class="menu-card">
            <img src="https://images.unsplash.com/photo-1571079939793-6d0e6e3a3dfe">
            <h3>Iced Lemon Tea</h3>
            <p class="menu-desc">Refreshing ice-cold lemon tea.</p>
            <p class="menu-price">RM 2.50</p>
            <a class="menu-btn" href="product.php">View Item</a>
        </div>

    </div>

</div>
</div>

<?php include 'footer.php'; ?>
