<?php
session_start();
include 'config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $login = trim($_POST['staffid_or_name']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("
        SELECT StaffID, Name, Role, Password
        FROM staff
        WHERE StaffID = ? OR Name = ?
        LIMIT 1
    ");
    $stmt->bind_param("ss", $login, $login);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $staff = $result->fetch_assoc();

        if (!password_verify($password, $staff['Password'])) {
            $error = 'Invalid password.';
        } else {

            session_regenerate_id(true);
            $_SESSION['StaffID'] = $staff['StaffID'];
            $_SESSION['StaffName'] = $staff['Name'];
            $_SESSION['Role'] = $staff['Role'];

            if ($staff['Role'] === 'ADMIN') {
                header("Location: admin.php");
                exit;
            }

            if ($staff['Role'] === 'RIDER') {
                header("Location: admin_delivery_status.php");
                exit;
            }

            session_destroy();
            $error = 'Access denied.';
        }
    } else {
        $error = 'Invalid login.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Staff Login | Cafeteria Xpress</title>

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
.error {
    margin-top: 12px;
    color: #ff6b6b;
    font-size: 14px;
}
.info {
    margin-top: 12px;
    font-size: 13px;
    color: #aaa;
}
</style>
</head>

<body>
<div class="admin-login-card">
    <h2>Staff Login</h2>

    <form method="post">
        <input name="staffid_or_name" placeholder="StaffID or Name" required>
        <input type="password" name="password" placeholder="Password" required>
        <button class="admin-btn" type="submit">Login</button>
    </form>

    <?php if ($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <p class="info">
        • Login using StaffID or Staff Name<br>
        • ADMIN → Dashboard<br>
        • RIDER → Delivery Panel
    </p>
</div>
</body>
</html>
