<?php include 'header.php'; ?>

<style>
.menu-container {
    padding: 40px 50px;
    max-width: 1300px;
    margin: 0 auto;
}

/* title */
.menu-title {
    font-size: 2rem;
    margin-bottom: 20px;
}

/* grid layout */
.menu-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 20px;
}

/* menu card */
.menu-card {
    background: #181818;
    padding: 20px;
    border-radius: 15px;
    transition: 0.3s;
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

.menu-card h3 a {
    color: #fff;
    text-decoration: none;
    transition: .2s;
}
.menu-card h3 a:hover {
    color: #00ffa6;
}

.menu-price {
    color: #00ffa6;
    font-weight: 700;
}
</style>

<div class="page-content">
<div class="menu-container">

    <h1 class="menu-title">Our Menu</h1>

    <div class="menu-grid">

        <div class="menu-card">
            <img src="https://images.unsplash.com/photo-1604908177522-437cfdc8f63d">
            <h3><a href="product.php">Chicken Rice</a></h3>
            <p class="menu-price">RM 6.50</p>
        </div>

        <div class="menu-card">
            <img src="https://images.unsplash.com/photo-1604908177253-44a1c047bb0d">
            <h3>Fried Chicken</h3>
            <p class="menu-price">RM 5.00</p>
        </div>

        <div class="menu-card">
            <img src="https://images.unsplash.com/photo-1543352634-69a4e07fc1bf">
            <h3>Noodle Soup</h3>
            <p class="menu-price">RM 5.50</p>
        </div>

        <div class="menu-card">
            <img src="https://images.unsplash.com/photo-1571079939793-6d0e6e3a3dfe">
            <h3>Iced Lemon Tea</h3>
            <p class="menu-price">RM 2.50</p>
        </div>

    </div>

</div>
</div>

<?php include 'footer.php'; ?>
