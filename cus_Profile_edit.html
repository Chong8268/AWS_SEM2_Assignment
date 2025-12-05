<?php
session_start();
include 'config.php';
if (!isset($_SESSION['customer_id'])) { header('Location: login.php'); exit(); }
$cid = intval($_SESSION['customer_id']);
$stmt = $conn->prepare("SELECT CustomerID, Name, Phone, Address FROM Customer WHERE CustomerID = :cid LIMIT 1");
$stmt->execute([':cid'=>$cid]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$user) { echo "User not found."; exit(); }
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Edit Profile</title>
<style>
 body{margin:0;font-family:Poppins;background:#0f0f0f;color:#fff}
 .wrap{max-width:700px;margin:60px auto;padding:20px}
 .card{background:#111;padding:20px;border-radius:12px}
 input,textarea{width:100%;padding:10px;margin-top:8px;border-radius:8px;border:1px solid #333;background:#0f0f0f;color:#fff}
 .btn{margin-top:14px;padding:10px 14px;border-radius:8px;background:#00ffa6;color:#000;border:0;font-weight:700;cursor:pointer}
</style>
</head>
<body>
<div class="wrap">
  <div class="card">
    <h2>Edit Profile</h2>

    <form action="profile_update.php" method="post">
      <label>Name</label>
      <input name="name" value="<?= htmlspecialchars($user['Name']) ?>" required>

      <label>Phone</label>
      <input name="phone" value="<?= htmlspecialchars($user['Phone']) ?>" required>

      <label>Address</label>
      <textarea name="address" rows="4"><?= htmlspecialchars($user['Address']) ?></textarea>

      <button class="btn" type="submit">Save Changes</button>
      <a href="profile.php"><button type="button" class="btn" style="background:#444;color:#fff;margin-left:8px">Cancel</button></a>
    </form>
  </div>
</div>
</body>
</html>
