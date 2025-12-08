<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cafeteria Delivery Platform</title>

    <!-- GLOBAL STYLE (only universal styles, no page-specific CSS) -->
    <style>
        body {
            margin: 0;
            font-family: "Poppins", sans-serif;
            background-color: #0f0f0f;
            color: #fff;
        }

        /* NAVBAR */
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 2px;
            background: rgba(0, 0, 0, 0.8);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 10;
            backdrop-filter: blur(10px);
        }

        nav .logo {
            font-size: 1.7rem;
            font-weight: 700;
            color: #00ffa6;
        }

        nav ul {
            list-style: none;
            display: flex;
            gap: 30px;
            flex-wrap: wrap;
        }

        nav ul li a {
            color: #fff;
            text-decoration: none;
            font-size: 1rem;
            transition: 0.3s;
        }

        nav ul li a:hover {
            color: #00ffa6;
        }

        /* Sticky Footer Layout */
        .page-wrapper {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .page-content {
            flex: 1; /* Push footer down */
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

<!-- NAVBAR -->
<nav>
    <a class="logo" href="index.php">CAFETERIA XPRESS</a>

    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="menu.php">Menu</a></li>
        <li><a href="menu_searh.php">Order</a></li>
        <li><a href="login.php">Login</a></li>
    </ul>
</nav>

<!-- WRAPPER (prevents content covered by navbar) -->
<div class="page-wrapper" style="padding-top: 120px;">

