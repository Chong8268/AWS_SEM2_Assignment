<!doctype html>
<html>
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Staff Login | Cafeteria Xpress</title>
<style>
 body{margin:0;font-family:Poppins;background:#0f0f0f;color:#fff;display:flex;align-items:center;justify-content:center;height:100vh}
 .card{background:#181818;padding:28px;border-radius:12px;width:380px}
 input{width:100%;padding:12px;margin:8px 0;border-radius:8px;border:1px solid #333;background:#0f0f0f;color:#fff}
 .btn{width:100%;padding:12px;border-radius:10px;border:0;background:#00ffa6;color:#000;font-weight:700;cursor:pointer}
</style>
</head>
<body>
  <div class="card">
    <h2>Staff Login</h2>
    <form action="staff_login.php" method="post">
      <input name="staffid_or_name" placeholder="StaffID or Name" required>
      <input name="password" type="password" placeholder="Password" required>
      <button class="btn" type="submit">Login</button>
    </form>
    <p style="color:#999;margin-top:8px;font-size:13px">Role: kitchen or delivery</p>
  </div>
</body>
</html>
