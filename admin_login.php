<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Admin Login | Cafeteria Xpress</title>

<style>
    body {
        margin: 0;
        font-family: Poppins, system-ui;
        background: #0f0f0f;
        color: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .admin-login-card {
        background: #181818;
        padding: 32px;
        border-radius: 16px;
        width: 380px;
        box-shadow: 0 0 16px rgba(0,255,166,0.15);
    }

    input {
        width: 100%;
        padding: 12px;
        margin-top: 10px;
        background: #0f0f0f;
        border: 1px solid #333;
        border-radius: 10px;
        color: #fff;
    }

    .admin-btn {
        width: 100%;
        padding: 12px;
        margin-top: 16px;
        background: #00ffa6;
        border: 0;
        border-radius: 10px;
        font-weight: 700;
        color: #000;
        cursor: pointer;
    }

    .admin-btn:hover {
        background: #00d988;
    }

    .info {
        margin-top: 12px;
        font-size: 13px;
        color: #aaa;
        line-height: 1.4;
    }
</style>
</head>

<body>

<div class="admin-login-card">
    <h2>Admin Login</h2>

    <form action="admin_login.php" method="post">
        <input name="staffid_or_name" placeholder="StaffID or Name" required>
        <input type="password" name="password" placeholder="Password" required>
        <button class="admin-btn" type="submit">Login</button>
    </form>

    <p class="info">
        • Login using StaffID or Staff Name<br>
        • For assignment demonstration only
    </p>
</div>

</body>
</html>
