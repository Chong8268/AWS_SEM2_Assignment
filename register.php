<?php
include "config.php";

$message = "";
$errors = [];

$name = "";
$phone = "";
$address = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Keep original user input
    $name = trim($_POST["name"]);
    $phone = trim($_POST["phone"]);
    $password = $_POST["password"];
    $confirm = $_POST["confirm_password"];
    $address = trim($_POST["address"]);

    // ================================
    // VALIDATION (MARKET-GRADE LEVEL)
    // ================================

    // 1. Name validation
    if (strlen($name) < 3 || strlen($name) > 50 || 
        !preg_match("/^[A-Za-z .'-]+$/", $name)) {
        $errors[] = "Invalid name. Only letters allowed, 3–50 characters.";
    }

    // 2. Phone validation (10–11 digits)
    if (!preg_match("/^[0-9]{10,11}$/", $phone)) {
        $errors[] = "Invalid phone number. Must be 10–11 digits.";
         $phone = "";
    }

    // Check duplicate phone
    $checkPhone = $conn->prepare("SELECT * FROM Customer WHERE Phone = ?");
    $checkPhone->bind_param("s", $phone);
    $checkPhone->execute();
    $resultPhone = $checkPhone->get_result();

    if ($resultPhone->num_rows > 0) {
        $errors[] = "Phone number already registered.";
    }

    // 3. Password strength
    if (strlen($password) < 8 ||
        !preg_match("/[A-Z]/", $password) ||
        !preg_match("/[a-z]/", $password) ||
        !preg_match("/[0-9]/", $password) ||
        !preg_match("/[\W]/", $password)) {
        $errors[] = "Password must be 8+ chars, include upper, lower, number, and symbol.";
    }

    // Prevent password = name
    if (strtolower($password) === strtolower($name)) {
        $errors[] = "Password cannot be the same as your name.";
    }

    // 4. Confirm password
    if ($password !== $confirm) {
        $errors[] = "Passwords do not match.";
    }

    // 5. Address optional
    if (!empty($address) && strlen($address) > 255) {
        $errors[] = "Address too long.";
    }

    // If validation failed
    if (count($errors) > 0) {
        $message = implode("<br>", $errors);
    } 
    else 
    {
        // Create new ID C00001
        $result = $conn->query("SELECT CustomerID FROM Customer ORDER BY CustomerID DESC LIMIT 1");
        $newID = "C00001";

        if ($result->num_rows > 0) {
            $lastID = $result->fetch_assoc()["CustomerID"];
            $num = intval(substr($lastID, 1)) + 1;
            $newID = "C" . str_pad($num, 5, "0", STR_PAD_LEFT);
        }

        $hashed = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare(
            "INSERT INTO Customer (CustomerID, Name, Phone, Address, password)
             VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("sssss", $newID, $name, $phone, $address, $hashed);

        if ($stmt->execute()) {
            header("Location: login.php?registered=1&phone=" . urlencode($phone));
            exit;
        } else {
            $errors[] = "Database error: " . $conn->error;
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Register | Cafeteria Xpress</title>
<style>
  body{
    margin:0;background:#0f0f0f;color:#fff;font-family:Poppins;
    display:flex;justify-content:center;align-items:center;height:100vh
  }
  .card{background:#111;padding:28px;border-radius:12px;width:380px}
  input,textarea{
    width:100%;padding:10px;margin:8px 0;border-radius:8px;
    border:1px solid #222;background:#0f0f0f;color:#fff
  }
  .btn{
    width:100%;padding:12px;border-radius:10px;border:0;
    background:#00ffa6;color:#000;font-weight:700;cursor:pointer
  }
  .msg{margin-bottom:12px;color:#ff6b6b;font-size:14px;line-height:1.4}
</style>
</head>

<body>
<div class="card">
  <h2>Register</h2>

  <?php if (!empty($message)): ?>
      <div class="msg"><?= $message ?></div>
  <?php endif; ?>

  <form action="" method="post">
    <input name="name" placeholder="Full name"
           value="<?= htmlspecialchars($name) ?>" required />

    <input name="phone" placeholder="Phone number"
           value="<?= htmlspecialchars($phone) ?>" required />

    <input name="password" type="password" placeholder="Password" required />

    <input name="confirm_password" type="password" placeholder="Confirm password" required />

    <textarea name="address" placeholder="Delivery address (optional)"><?= htmlspecialchars($address) ?></textarea>
    
    <button class="btn" type="submit">Create Account</button>
  </form>

  <p style="color:#bbb;margin-top:10px">
     Already have an account? 
     <a href="login.php" style="color:#00ffa6">Login</a>
  </p>
</div>
</body>
</html>
