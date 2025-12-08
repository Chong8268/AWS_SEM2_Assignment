<?php
$host = "localhost";
$user = "root"; // XAMPP 默认
$pass = "";     // 默认空
$dbname = "cafeteria";  // 你刚刚创建的 DB 名字

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("❌ Database connection failed: " . $conn->connect_error);
}
?>
