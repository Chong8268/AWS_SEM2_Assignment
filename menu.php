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
        <div class="menu-cat-btn" onclick="filterProducts('')">All</div>
        <div class="menu-cat-btn" onclick="filterProducts('Meals')">Meals</div>
        <div class="menu-cat-btn" onclick="filterProducts('Noodles')">Noodles</div>
        <div class="menu-cat-btn" onclick="filterProducts('Chicken')">Chicken</div>
        <div class="menu-cat-btn" onclick="filterProducts('Burgers')">Burgers</div>
        <div class="menu-cat-btn" onclick="filterProducts('Salads')">Salads</div>
        <div class="menu-cat-btn" onclick="filterProducts('Drinks')">Drinks</div>
        <div class="menu-cat-btn" onclick="filterProducts('Desserts')">Desserts</div>
    </div>

    <!-- Product Grid -->
    <div class="menu-grid" id="menuGrid">
        <?php
        include 'config.php';

        // Get category from GET variable (defaults to all if no category selected)
        $category = isset($_GET['category']) ? $_GET['category'] : '';

        // Query products based on selected category or all if no category selected
        if ($category) {
            $sql = "SELECT * FROM product 
                    WHERE categories = ? 
                    AND status = 'ACTIVE'";
        } else {
            $sql = "SELECT * FROM product 
                    WHERE status = 'ACTIVE'";
        }


        $stmt = $conn->prepare($sql);
        if ($category) {
            $stmt->bind_param("s", $category);
        }
        $stmt->execute();
        $result = $stmt->get_result();

        
        while ($row = $result->fetch_assoc()) {
            // 格式化价格为两位小数
            $price = number_format($row['price'], 2);
            
            // 构建商品卡片
            echo '
            <div class="menu-card">
                <!-- 使用商品的图片URL -->
                <img src="' . (empty($row['ImageURL']) ? 'default-image.jpg' : $row['ImageURL']) . '" alt="' . $row['name'] . '">
                <h3><a href="product.php?id=' . $row['ProductID'] . '">' . $row['name'] . '</a></h3>
                <p class="menu-desc">' . $row['description'] . '</p>
                <p class="menu-price">RM ' . $price . '</p>
                <a class="menu-btn" href="product.php?id=' . $row['ProductID'] . '">View Item</a>
            </div>';
        }

        ?>
    </div>

</div>
</div>

<script>
    // Function to filter products by category
    function filterProducts(category) {
        let url = window.location.href;
        if (category) {
            if (url.indexOf('?') > -1) {
                window.location.href = url + '&category=' + category;
            } else {
                window.location.href = url + '?category=' + category;
            }
        } else {
            window.location.href = url.split('?')[0];  // reset to all
        }
    }
</script>

<?php include 'footer.php'; ?>
