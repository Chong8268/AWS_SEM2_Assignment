<?php include 'header.php'; ?>

<style>
.ms-wrap { max-width:1100px; margin:40px auto; padding:20px; }

.ms-search-box input {
  width:100%;
  padding:14px;
  border:1px solid #333;
  border-radius:10px;
  background:#111;
  color:#fff;
}

/* category buttons */
.ms-categories {
  display:flex;
  gap:14px;
  margin:20px 0;
}
.ms-cat-btn {
  padding:10px 16px;
  border-radius:8px;
  background:#181818;
  color:#fff;
  cursor:pointer;
  border:1px solid #333;
  transition:0.2s;
}
.ms-cat-btn:hover {
  background:#222;
}

/* menu card */
.ms-card {
  background:#181818;
  border-radius:14px;
  padding:20px;
  margin-bottom:18px;
}
.ms-price {
  color:#00ffa6;
  font-weight:700;
}
.ms-btn {
  padding:10px 14px;
  background:#00ffa6;
  color:#000;
  border-radius:8px;
  text-decoration:none;
  font-weight:700;
  display:inline-block;
  margin-top:10px;
}
</style>

<div class="page-content">
<div class="ms-wrap">

<h1>Search Menu</h1>

<div class="ms-search-box">
  <input type="text" placeholder="Search for food...">
</div>

<div class="ms-categories">
  <div class="ms-cat-btn">All</div>
  <div class="ms-cat-btn">Burgers</div>
  <div class="ms-cat-btn">Drinks</div>
  <div class="ms-cat-btn">Rice</div>
</div>

<div class="ms-card">
  <h3>Cheese Burger</h3>
  <div class="ms-price">RM 8.90</div>
  <p>Juicy beef patty with cheese.</p>
  <a class="ms-btn" href="product.php">View</a>
</div>

</div>
</div>

<?php include 'footer.php'; ?>
