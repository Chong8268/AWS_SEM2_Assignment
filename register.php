<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Register | Cafeteria Xpress</title>

  <style>
    body {
      margin:0;
      font-family:Poppins,system-ui;
      background:#0f0f0f;
      color:#fff;
      display:flex;
      align-items:center;
      justify-content:center;
      height:100vh;
    }

    .reg-card {
      background:#111;
      padding:28px;
      border-radius:12px;
      width:380px;
    }

    .reg-input, .reg-textarea {
      width:100%;
      padding:10px;
      margin:8px 0;
      border-radius:8px;
      border:1px solid #222;
      background:#0f0f0f;
      color:#fff;
    }

    .reg-btn {
      width:100%;
      padding:12px;
      border-radius:10px;
      border:0;
      background:#00ffa6;
      color:#000;
      font-weight:700;
      cursor:pointer;
      margin-top: 6px;
    }

    a { color:#00ffa6; }
  </style>
</head>

<body>

  <div class="reg-card">
    <h2>Register</h2>

    <form action="register.php" method="post">
      <input class="reg-input" name="name" placeholder="Full name" required />
      <input class="reg-input" name="phone" placeholder="Phone number" required />
      <input class="reg-input" name="password" type="password" placeholder="Password" required />
      <input class="reg-input" name="confirm_password" type="password" placeholder="Confirm password" required />

      <textarea class="reg-textarea" name="address" placeholder="Delivery address (optional)" rows="3"></textarea>

      <button class="reg-btn" type="submit">Create account</button>
    </form>

    <p style="margin-top:10px;color:#bbb">
      Already have an account?
      <a href="login.php">Login</a>
    </p>
  </div>

</body>
</html>
