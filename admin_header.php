<?php
session_start();
include 'config.php';

if (!isset($_SESSION['StaffID'])) {
    header("Location: admin_login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin | Cafeteria Xpress</title>

<style>

* {
    box-sizing: border-box;
}

body {
    margin: 0;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", "Roboto", "Helvetica Neue", Arial, sans-serif;
    background: #0a0a0a;
    color: #e5e5e5;
    line-height: 1.6;
}

.admin-wrap {
    max-width: 1200px;
    margin: 0 auto;
    padding: 100px 32px 60px;
}

@media (max-width: 768px) {
    .admin-wrap {
        padding: 100px 20px 40px;
    }
}

.admin-nav {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 40px;
    background: rgba(18, 18, 18, 0.95);
    backdrop-filter: blur(12px);
    border-bottom: 1px solid rgba(34, 197, 94, 0.2);
    position: fixed;
    width: 100%;
    top: 0;
    z-index: 1000;
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.4);
}

.admin-logo {
    font-size: 1.5rem;
    font-weight: 700;
    color: #22c55e;
    text-decoration: none;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
    cursor: pointer;
}

.admin-logo:hover {
    color: #16a34a;
    transform: translateY(-1px);
}

.admin-nav ul {
    list-style: none;
    display: flex;
    gap: 32px;
    padding: 0;
    margin: 0;
    align-items: center;
}

.admin-nav ul li a {
    color: #d1d5db;
    text-decoration: none;
    transition: all 0.3s ease;
    font-size: 0.95rem;
    font-weight: 500;
    position: relative;
    padding: 4px 0;
}

.admin-nav ul li a::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 0;
    height: 2px;
    background: #22c55e;
    transition: width 0.3s ease;
}

.admin-nav ul li a:hover {
    color: #22c55e;
}

.admin-nav ul li a:hover::after {
    width: 100%;
}

.admin-logout {
    background: #dc2626;
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    color: #fff;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    border: 1px solid transparent;
}

.admin-logout:hover {
    background: #b91c1c;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(220, 38, 38, 0.4);
}

@media (max-width: 768px) {
    .admin-nav {
        padding: 12px 20px;
        flex-wrap: wrap;
        gap: 12px;
    }
    
    .admin-nav ul {
        gap: 16px;
        font-size: 0.85rem;
    }
}

.admin-form label {
    display: block;
    color: #9ca3af;
    margin-top: 20px;
    margin-bottom: 8px;
    font-size: 0.9rem;
    font-weight: 500;
}

.admin-form input,
.admin-form textarea,
.admin-form select {
    width: 100%;
    padding: 12px 16px;
    border-radius: 8px;
    border: 1px solid #374151;
    background: #1f2937;
    color: #e5e5e5;
    margin-bottom: 12px;
    resize: vertical;
    font-family: inherit;
    font-size: 0.95rem;
    transition: all 0.3s ease;
}

.admin-form input:focus,
.admin-form textarea:focus,
.admin-form select:focus {
    outline: none;
    border-color: #22c55e;
    box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.1);
}

.admin-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 24px;
    margin-top: 32px;
}

.admin-card {
    background: linear-gradient(145deg, #1a1a1a, #0f0f0f);
    padding: 32px;
    border-radius: 16px;
    text-align: center;
    border: 1px solid rgba(34, 197, 94, 0.2);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
    transition: all 0.3s ease;
}

.admin-card:hover {
    transform: translateY(-4px);
    border-color: rgba(34, 197, 94, 0.5);
    box-shadow: 0 12px 32px rgba(0, 0, 0, 0.5), 0 0 20px rgba(34, 197, 94, 0.15);
}

.admin-stat {
    font-size: 2.5rem;
    font-weight: 800;
    color: #22c55e;
    margin-bottom: 8px;
    line-height: 1;
}

.admin-card div {
    font-size: 1rem;
    color: #9ca3af;
    font-weight: 500;
}

.admin-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 24px;
    background: #1a1a1a;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.3);
}

.admin-table th,
.admin-table td {
    padding: 16px;
    text-align: left;
    border-bottom: 1px solid #2d2d2d;
}

.admin-table th {
    background: #0f0f0f;
    color: #22c55e;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 0.5px;
}

.admin-table tr:hover {
    background: #222;
}

.admin-table tr:last-child td {
    border-bottom: none;
}

.admin-btn-sm {
    padding: 10px 18px;
    background: #22c55e;
    color: #000;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    display: inline-block;
    border: none;
    cursor: pointer;
}

.admin-btn-sm:hover {
    background: #16a34a;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(34, 197, 94, 0.4);
}

.admin-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 12px 24px;
    font-weight: 600;
    font-size: 1rem;
    color: #000;
    background: #22c55e;
    text-decoration: none;
    cursor: pointer;
    border-radius: 8px;
    transition: all 0.3s ease;
    border: none;
}

.admin-btn:hover {
    background: #16a34a;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(34, 197, 94, 0.4);
}

.status {
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
    text-transform: capitalize;
    display: inline-block;
}

.status.pending { 
    background: #fbbf24; 
    color: #000; 
}

.status.preparing { 
    background: #3b82f6; 
    color: #fff; 
}

.status.completed { 
    background: #22c55e; 
    color: #000; 
}

.status.cancelled { 
    background: #ef4444; 
    color: #fff; 
}

.text-center {
    text-align: center;
}

.mt-4 {
    margin-top: 32px;
}

.mb-4 {
    margin-bottom: 32px;
}

h1, h2, h3 {
    color: #f3f4f6;
    font-weight: 700;
}

h1 {
    font-size: 2rem;
    margin-bottom: 24px;
}

h2 {
    font-size: 1.5rem;
    margin-bottom: 20px;
}

</style>

</head>

<body>

<nav class="admin-nav">
    <a href="admin.php" class="admin-logo">ADMIN PANEL</a>

    <ul>
        <li><a href="admin_orders.php">Orders</a></li>
        <li><a href="admin_products.php">Products</a></li>
        <li><a href="admin_delivery_status.php">Delivery</a></li>
    </ul>

    <a class="admin-logout" href="admin_logout.php">Logout</a>
</nav>
