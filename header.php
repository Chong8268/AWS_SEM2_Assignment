<?php
// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once "config.php";

/* --------------------------------
   AUTO LOGIN（你原本的）
-------------------------------- */
if (
    !isset($_SESSION["CustomerID"]) &&
    isset($_COOKIE["remember_user"]) &&
    !isset($_SESSION["force_logout"])
) {
    $_SESSION["CustomerID"] = $_COOKIE["remember_user"];
}

if (isset($_SESSION["CustomerID"]) && isset($_SESSION["force_logout"])) {
    unset($_SESSION["force_logout"]);
}

/* --------------------------------
   🔹 计算 Cart Item 数量（新增）
-------------------------------- */
$cartCount = 0;

if (isset($_SESSION["CustomerID"])) {
    $stmt = $conn->prepare("
        SELECT SUM(ci.quantity) AS total
        FROM cartitems ci
        JOIN cart c ON c.CartID = ci.CartID
        WHERE c.CustomerID = ?
    ");
    $stmt->bind_param("s", $_SESSION["CustomerID"]);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    $cartCount = $row["total"] ?? 0;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cafeteria Delivery Platform</title>

    <style>
        body {
            margin: 0;
            font-family: "Poppins", sans-serif;
            background-color: #0f0f0f;
            color: #fff;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 25px;
            background: rgba(0, 0, 0, 0.85);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 10;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid #111;
        }

        nav .logo {
            font-size: 1.7rem;
            font-weight: 700;
            color: #00ffa6;
            text-decoration: none;
        }

        nav ul {
            list-style: none;
            display: flex;
            gap: 30px;
            margin: 0;
            align-items: center;
        }

        nav ul li a {
            color: #fff;
            text-decoration: none;
            font-size: 1rem;
            transition: .3s;
        }

        nav ul li a:hover {
            color: #00ffa6;
        }

        /* 🔹 Cart badge（新增） */
        .cart-link {
            position: relative;
        }

        .cart-badge {
            position: absolute;
            top: -6px;
            right: -10px;
            background: #00ffa6;
            color: #000;
            font-size: 12px;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 999px;
            min-width: 18px;
            text-align: center;
        }

        .page-wrapper {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .page-content {
            flex: 1;
        }

        .site-footer {
            background: #111;
            padding: 40px;
            text-align: center;
            color: #777;
            margin-top: auto;
        }
    </style>
</head>

<body>

<nav>
    <a class="logo" href="index.php">CAFETERIA XPRESS</a>

    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="menu.php">Menu</a></li>
        <li><a href="menu_search.php">Search</a></li>
        

        <?php if (isset($_SESSION["CustomerID"])): ?>
            <!-- 🔹 Cart Button -->
            <li>
                <a href="cart.php" class="cart-link">
                    Cart
                    <?php if ($cartCount > 0): ?>
                        <span class="cart-badge"><?= $cartCount ?></span>
                    <?php endif; ?>
                </a>
            </li>
        <?php endif; ?>
        <li><a href="my_orders.php">My Orders</a></li>

            <?php if (isset($_SESSION["CustomerID"])): ?>
            <li>
                <a href="logout.php" style="color:#ff6b6b;font-weight:600;">
                    Logout
                </a>
            </li>
        <?php else: ?>
            <li>
                <a href="login.php" style="color:#00ffa6;font-weight:600;">
                    Login
                </a>
            </li>
        <?php endif; ?>
    </ul>
</nav>

<div class="page-wrapper" style="padding-top: 120px;">
