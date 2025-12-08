<?php include 'header.php'; ?>

<style>
.login-page {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px;
}

.login-page .card {
    background: #111;
    padding: 28px;
    border-radius: 12px;
    width: 360px;
}

.login-page input {
    width: 100%;
    padding: 10px;
    margin: 8px 0;
    border-radius: 8px;
    border: 1px solid #222;
    background: #0f0f0f;
    color: #fff;
}

.login-page .btn {
    width: 100%;
    padding: 12px;
    border-radius: 10px;
    border: 0;
    background: #00ffa6;
    color: #000;
    font-weight: 700;
    cursor: pointer;
}

.login-page a {
    color: #00ffa6;
}
</style>

<div class="page-contain login-page">

    <div class="card">
        <h2>Login</h2>

        <form action="login.php" method="post">
            <input name="phone" placeholder="Phone number / Username / Email" required />
            <input name="password" type="password" placeholder="Password" required />
            <button class="btn" type="submit">Login</button>
        </form>

        <p style="margin-top:10px;color:#bbb">
            No account? <a href="register.php">Register</a>
        </p>
    </div>

</div>

<?php include 'footer.php'; ?>
