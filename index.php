<?php
// AUTO LOGIN BEFORE ANY OUTPUT
session_start();
include "config.php";

$autoLogin = false;

if (!isset($_SESSION["CustomerID"]) && isset($_COOKIE["remember_id"])) {

    $cid = $_COOKIE["remember_id"];

    $stmt = $conn->prepare("SELECT CustomerID, Name FROM Customer WHERE CustomerID = ?");
    $stmt->bind_param("s", $cid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($u = $result->fetch_assoc()) {
        $_SESSION["CustomerID"] = $u["CustomerID"];
        $_SESSION["Name"] = $u["Name"];
        $autoLogin = true;
    }
}
?>
<?php include 'header.php'; ?>

<!-- Toast (will NOT affect layout) -->
<div id="toast"></div>

<style>
#toast {
    position: fixed;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
    padding: 12px 22px;
    background: #00c977;
    color: #fff;
    border-radius: 8px;
    font-weight: 600;
    opacity: 0;
    transition: opacity .35s ease, transform .35s ease;
    z-index: 9999;
    pointer-events: none;
}
#toast.show {
    opacity: 1;
    transform: translateX(-50%) translateY(6px);
}
</style>

<script>
function showToast(msg) {
    const t = document.getElementById("toast");
    t.textContent = msg;
    t.classList.add("show");
    setTimeout(() => t.classList.remove("show"), 3000);
}
</script>

<?php
if ($autoLogin) {
    echo "<script>showToast('Welcome back, " . htmlspecialchars($_SESSION['Name']) . "!');</script>";
}
?>
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

<div class="page-content page-home">
    <section class="hero">
        <div class="hero-text">
            <h1>Fast, Fresh & Delivered<br>Right to You</h1>
            <p>Order your favourite meals from the campus cafeteria<br>
               and get them delivered in minutes.</p>

            <a href="menu_search.php">
                <button class="cta-btn">Order Now</button>
            </a>
        </div>

        <div class="hero-img">
            <img src="https://images.unsplash.com/photo-1600891964599-f61ba0e24092" alt="Food Image">
        </div>
    </section>

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