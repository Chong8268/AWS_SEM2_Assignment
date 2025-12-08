<?php include 'header.php'; ?>
<style>
.page-home .hero {
    padding: 150px 50px 100px;
    display: grid;
    grid-template-columns: 1fr 1fr;
    align-items: center;
    gap: 30px;
}

.page-home .hero-text h1 {
    font-size: 3.2rem;
    font-weight: 700;
    line-height: 1.2;
}

.page-home .hero-text p {
    margin-top: 15px;
    font-size: 1.2rem;
    color: #bbbbbb;
}

.page-home .cta-btn {
    margin-top: 25px;
    padding: 14px 30px;
    background: #00ffa6;
    color: #000;
    font-weight: 700;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: .3s;
    font-size: 1.1rem;
}
.page-home .cta-btn:hover {
    background: #00d98c;
}

.page-home .hero-img img {
    width: 100%;
    border-radius: 20px;
    box-shadow: 0 0 25px rgba(0,255,166,0.4);
}

.page-home .categories {
    padding: 40px 50px;
}

.page-home .categories h2 {
    font-size: 2rem;
    margin-bottom: 25px;
}

.page-home .cat-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 20px;
}

.page-home .cat-card {
    background: #181818;
    padding: 25px;
    border-radius: 15px;
    text-align: center;
    transition: .3s;
    cursor: pointer;
}

.page-home .cat-card:hover {
    transform: translateY(-5px);
    background: #222;
}

.page-home .cat-card h3 {
    margin-top: 15px;
    color: #00ffa6;
}
</style>


<!-- PAGE WRAPPER -->
<div class="page-content page-home">

    <!-- HERO -->
    <section class="hero">
        <div class="hero-text">
            <h1>Fast, Fresh & Delivered<br>Right to You</h1>
            <p>Order your favourite meals from the campus cafeteria<br>
               and get them delivered in minutes.</p>

            <a href="menu_searh.php">
                <button class="cta-btn">Order Now</button>
            </a>
        </div>

        <div class="hero-img">
            <img src="https://images.unsplash.com/photo-1600891964599-f61ba0e24092" alt="Food Image">
        </div>
    </section>

    <!-- CATEGORY SECTION -->
    <section class="categories">
        <h2>Popular Categories</h2>
        <div class="cat-grid">
            <div class="cat-card"><h3>⛩ Rice & Meals</h3></div>
            <div class="cat-card"><h3>🍗 Chicken</h3></div>
            <div class="cat-card"><h3>🍝 Noodles</h3></div>
            <div class="cat-card"><h3>🥤 Drinks</h3></div>
            <div class="cat-card"><h3>🍰 Desserts</h3></div>
        </div>
    </section>

<?php include 'footer.php'; ?>
