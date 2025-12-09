<?php
include "config.php";

$keyword  = isset($_POST["keyword"]) ? $_POST["keyword"] : "";
$category = isset($_POST["category"]) ? $_POST["category"] : "";

$sql = "SELECT * FROM product WHERE 1";

if ($keyword !== "") {
    $k = "%$keyword%";
    $sql .= " AND (name LIKE ? OR description LIKE ?)";
}

if ($category !== "") {
    $c = "%$category%";
    $sql .= " AND categories LIKE ?";
}

$stmt = $conn->prepare($sql);

if ($keyword !== "" && $category === "") {
    $stmt->bind_param("ss", $k, $k);

} else if ($keyword === "" && $category !== "") {
    $stmt->bind_param("s", $c);

} else if ($keyword !== "" && $category !== "") {
    $stmt->bind_param("sss", $k, $k, $c);
}

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "<p style='color:#bbb;'>No items found.</p>";
    exit;
}

while ($row = $result->fetch_assoc()) {
    echo "
    <div class='ms-card'>
        <h3>{$row['name']}</h3>
        <div class='ms-price'>RM {$row['price']}</div>
        <p>{$row['description']}</p>
        <a class='ms-btn' href='product.php?id={$row['ProductID']}'>View</a>
    </div>";
}
