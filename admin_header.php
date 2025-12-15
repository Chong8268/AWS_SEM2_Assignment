<?php
session_start();
include 'config.php';

if (!isset($_SESSION['StaffID'])) {
    header("Location: admin_login.php");
    exit;
}

// admin_header.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin | Cafeteria Xpress</title>

<style>

/* ================================
   ADMIN GLOBAL STYLES
================================ */
body {
    margin: 0;
    font-family: "Poppins", sans-serif;
    background: #0f0f0f;
    color: #fff;
}

/* Wrapper for admin pages */
.admin-wrap {
    max-width: 1100px;
    margin: 0 auto;
    padding: 130px 40px 60px;
}

/* ================================
   ADMIN NAVBAR
================================ */
.admin-nav {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 18px 40px;
    background: #000;
    position: fixed;
    width: 100%;
    top: 0;
    z-index: 50;
}

.admin-logo {
    font-size: 1.6rem;
    font-weight: 700;
    color: #00ffa6;
}

.admin-nav ul {
    list-style: none;
    display: flex;
    gap: 28px;
    padding: 0;
    margin: 0;
}

.admin-nav ul li a {
    color: #fff;
    text-decoration: none;
    transition: 0.3s;
    font-size: 1rem;
}

.admin-nav ul li a:hover {
    color: #00ffa6;
}

.admin-logout {
    background: #ff4d4d;
    padding: 8px 14px;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    color: #fff;
}
.admin-logout:hover {
    background: #ff1a1a;
}




/* ================================
   ADMIN FORM
================================ */
.admin-form label {
    display: block;
    color: #bbb;
    margin-top: 16px;
    margin-bottom: 6px;
    font-size: 14px;
}

.admin-form input,
.admin-form textarea,
.admin-form select {
    width: 100%;
    padding: 12px;
    border-radius: 8px;
    border: 1px solid #333;
    background: #181818;
    color: #fff;
    margin-bottom: 10px;
    resize: vertical;
}

/* ================================
   ADMIN CARD + GRID (Dashboard style)
================================ */
.admin-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}

.admin-card {
    background: #181818;
    padding: 26px;
    border-radius: 14px;
    text-align: center;
}

.admin-stat {
    font-size: 32px;
    font-weight: bold;
    color: #00ffa6;
    margin-bottom: 10px;
}

/* Sticky Footer Layout */
html, body {
    height: 100%;
}

body {
    display: flex;
    flex-direction: column;
}

.admin-page {
    flex: 1; /* push footer down */
}

/* ADMIN LAYOUT */
.admin-wrap {
    padding: 40px;
    max-width: 1100px;
    margin: 0 auto;
}

/* TABLE */
.admin-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.admin-table th,
.admin-table td {
    padding: 14px;
    border-bottom: 1px solid #333;
}

.admin-table th {
    background: #181818;
}

/* BUTTONS */
.admin-btn-sm {
    padding: 8px 14px;
    background: #00ffa6;
    color: #000;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 700;
}

.admin-btn-sm:hover {
    background: #00d986;
}

/* STATUS TAGS */
.status {
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    text-transform: capitalize;
}

.status.pending { background:#ffaa00; color:#000; }
.status.preparing { background:#0099ff; color:#fff; }
.status.completed { background:#00ffa6; color:#000; }
.status.cancelled { background:#ff4444; color:#fff; }

/* ===== ADMIN DASHBOARD ENHANCEMENT ===== */

.admin-wrap {
    max-width: 1100px;
    margin: 60px auto;
    padding: 0 20px;
}

/* GRID */
.admin-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 26px;
}

/* CARD BASE */
.admin-card {
    background: linear-gradient(145deg, #1a1a1a, #111);
    border-radius: 16px;
    padding: 26px;
    text-align: center;

    border: 1px solid rgba(0, 255, 166, 0.15);
    box-shadow:
        0 12px 30px rgba(0,0,0,.5),
        inset 0 0 0 rgba(0,255,166,0);

    transition: all .25s ease;
}

/* CARD HOVER */
.admin-card:hover {
    transform: translateY(-4px);
    border-color: rgba(0, 255, 166, 0.6);
    box-shadow:
        0 16px 40px rgba(0,0,0,.65),
        0 0 18px rgba(0,255,166,.25);
}

/* STAT NUMBER */
.admin-stat {
    font-size: 2.4rem;
    font-weight: 800;
    color: #00ffa6;
    margin-bottom: 6px;
}

/* CARD TEXT */
.admin-card div {
    font-size: 1rem;
    color: #ddd;
}

/* BUTTON CARD */
.admin-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1rem;
    color: #00ffa6;
    text-decoration: none;
    cursor: pointer;
}

.admin-btn:hover {
    color: #000;
    background: #00ffa6;
}

</style>

</head>

<body>

<!-- ================================
     ADMIN NAVBAR
================================ -->
<nav class="admin-nav">
    <div class="admin-logo">ADMIN PANEL</div>

    <ul>
        <li><a href="admin_orders.php">Orders</a></li>
        <li><a href="admin_products.php">Products</a></li>
        <li><a href="admin_delivery_status.php">Delivery</a></li>
    </ul>

    <a class="admin-logout" href="admin_logout.php">Logout</a>
</nav>
