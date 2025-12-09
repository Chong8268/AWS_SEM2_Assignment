<?php include 'header.php'; ?>
<?php include 'config.php'; ?>
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

<!-- Search Bar -->
<div class="ms-search-box">
  <input id="searchInput" type="text" placeholder="Search for food...">
</div>

<!-- Categories -->
<div class="ms-categories">
  <div class="ms-cat-btn" data-cat="">All</div>
  <div class="ms-cat-btn" data-cat="Burgers">Burgers</div>
  <div class="ms-cat-btn" data-cat="Drinks">Drinks</div>
  <div class="ms-cat-btn" data-cat="Rice">Rice</div>
  <div class="ms-cat-btn" data-cat="Noodles">Noodles</div>
  <div class="ms-cat-btn" data-cat="Chicken">Chicken</div>
</div>

<!-- Results -->
<div id="results"></div>

</div>
</div>

<script>
function loadResults() {
    let keyword = document.getElementById("searchInput").value;

    // If user is typing → auto switch to ALL
    if (keyword.length > 0) {
        document.querySelectorAll(".ms-cat-btn").forEach(btn => btn.classList.remove("active"));
        document.querySelector('.ms-cat-btn[data-cat=""]').classList.add("active");
    }

    let activeBtn = document.querySelector(".ms-cat-btn.active");
    let category = activeBtn ? activeBtn.dataset.cat : "";

    let formData = new FormData();
    formData.append("keyword", keyword);
    formData.append("category", category);

    fetch("search_api.php", { method: "POST", body: formData })
    .then(res => res.text())
    .then(data => {
        document.getElementById("results").innerHTML = data;
    });
}

// Live search
document.getElementById("searchInput").addEventListener("input", loadResults);

// Category click
document.querySelectorAll(".ms-cat-btn").forEach(btn => {
    btn.addEventListener("click", function() {

        // If user clicks category → clear search box
        document.getElementById("searchInput").value = "";

        document.querySelectorAll(".ms-cat-btn").forEach(b => b.classList.remove("active"));
        this.classList.add("active");

        loadResults();
    });
});

// Initial load
loadResults();
</script>

<?php include 'footer.php'; ?>
