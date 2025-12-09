<?php
include "config.php";
session_start();

/* ---------------------------------------------------
   HANDLE LOGIN SUBMIT
--------------------------------------------------- */

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $user     = $_POST["user"];
    $password = $_POST["password"];
    $remember = isset($_POST["remember"]);

    $stmt = $conn->prepare("SELECT * FROM Customer WHERE Phone = ? OR Name = ?");
    $stmt->bind_param("ss", $user, $user);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {

        $row = $result->fetch_assoc();

        if (password_verify($password, $row["password"])) {

            // valid → login
            $_SESSION["CustomerID"] = $row["CustomerID"];
            $_SESSION["Name"]       = $row["Name"];

            // If previously forced logout, remove flag
            if (isset($_SESSION["force_logout"])) {
                unset($_SESSION["force_logout"]);
            }

            // Remember Me cookie (30 days)
            if ($remember) {
                setcookie(
                    "remember_id",
                    $row["CustomerID"],
                    time() + (86400 * 30),
                    "/",
                    "",
                    false,      // HTTPS only → change to true if your environment supports HTTPS
                    true        // HttpOnly → safer
                );
            } else {
                // remove cookie
                setcookie("remember_id", "", time() - 3600, "/", "", false, true);
            }

            header("Location: index.php");
            exit;

        } else {
            $error = "Invalid password.";
        }

    } else {
        $error = "User not found.";
    }
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Login | Cafeteria Xpress</title>

<style>
    body {
        margin:0;
        background:#0f0f0f;
        color:#fff;
        font-family:Poppins;
        display:flex;
        justify-content:center;
        align-items:center;
        height:100vh;
    }

    .card {
        background:#111;
        padding:32px;
        border-radius:14px;
        width:360px;
        box-shadow:0 0 20px rgba(0,0,0,0.4);
    }

    h2 { margin-top:0; }

    input {
        width:100%;
        padding:12px;
        background:#0f0f0f;
        border:1px solid #222;
        border-radius:10px;
        color:#fff;
        margin-top:12px;
        font-size:15px;
    }

    .btn {
        width:100%;
        padding:12px;
        margin-top:18px;
        background:#00ffa6;
        color:#000;
        border:0;
        border-radius:10px;
        font-weight:700;
        cursor:pointer;
        font-size:16px;
    }

    /* Remember me */
    .remember-row {
        display:flex;
        align-items:center;
        gap:8px;
        margin-top:10px;
        font-size:14px;
        color:#ccc;
        cursor:pointer;
    }

    .remember-row input {
        width:16px;
        height:16px;
        margin:0;
        accent-color:#00ffa6;
    }

    /* Toast */
    #toast {
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        padding: 14px 24px;
        border-radius: 8px;
        font-weight: 600;
        color: #fff;
        opacity: 0;
        pointer-events: none;
        transition: opacity .4s, transform .4s;
        z-index: 9999;
        font-size: 15px;
    }

    #toast.show { opacity:1; transform:translateX(-50%) translateY(5px); }

    #toast.success { background:#00c977; }
    #toast.error   { background:#ff6b6b; }
    #toast.info    { background:#3fa9f5; }

</style>
</head>

<body>

<!-- Toast -->
<div id="toast"></div>

<script>
function showToast(type, message) {
    const t = document.getElementById("toast");
    t.className = "";
    void t.offsetWidth; 
    t.className = type + " show";
    t.textContent = message;
    setTimeout(() => t.classList.remove("show"), 3000);
}
</script>

<?php
// Toast messages
if (isset($_GET["registered"])) echo "<script>showToast('success','Registration successful! Please log in.');</script>";
if (isset($_GET["logged_out"])) echo "<script>showToast('info','You have been logged out.');</script>";
if (!empty($error))          echo "<script>showToast('error', '$error');</script>";
?>

<div class="card">
    <h2>Login</h2>

    <form method="post">

        <input name="user" placeholder="Phone or Name"
               value="<?= isset($_GET['phone']) ? htmlspecialchars($_GET['phone']) : '' ?>"
               required />

        <input name="password" type="password" placeholder="Password" required />

        <label class="remember-row">
            <input type="checkbox" name="remember">
            Remember me
        </label>

        <button class="btn">Login</button>
    </form>

    <p style="color:#bbb;margin-top:10px">
        No account? <a href="register.php" style="color:#00ffa6">Register</a>
    </p>
</div>

</body>
</html>
