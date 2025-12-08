<?php include 'header.php'; ?>

<style>
.cpw-wrap {
    max-width: 600px;
    margin: 40px auto;
    padding: 20px;
}

.cpw-card {
    background: #111;
    padding: 24px;
    border-radius: 12px;
}

.cpw-input {
    width: 100%;
    padding: 10px;
    margin-top: 8px;
    border-radius: 8px;
    border: 1px solid #333;
    background: #0f0f0f;
    color: #fff;
}

.cpw-btn {
    margin-top: 12px;
    padding: 10px 14px;
    border-radius: 8px;
    background: #00ffa6;
    color: #000;
    border: 0;
    font-weight: 700;
    cursor: pointer;
}
.cpw-btn:hover {
    background: #00d98c;
}

.cpw-btn-back {
    background: #444;
    color: #fff;
    margin-left: 8px;
}
.cpw-btn-back:hover {
    background: #555;
}

/* message boxes */
.cpw-msg {
    margin-top: 10px;
    padding: 8px;
    border-radius: 8px;
}
.cpw-ok { background:#062; color:#cfc; }
.cpw-err { background:#420; color:#fdd; }
</style>


<div class="page-content">
<div class="cpw-wrap">

    <div class="cpw-card">
        <h2>Change Password</h2>

        <?php if (!empty($error)): ?>
            <div class="cpw-msg cpw-err"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="cpw-msg cpw-ok"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <form method="post">

            <label>Current password (leave blank if not set)</label>
            <input class="cpw-input" type="password" name="current_password">

            <label>New password</label>
            <input class="cpw-input" type="password" name="new_password" required>

            <label>Confirm new password</label>
            <input class="cpw-input" type="password" name="confirm_password" required>

            <button class="cpw-btn" type="submit">Update Password</button>

            <button type="button"
                    class="cpw-btn cpw-btn-back"
                    onclick="location.href='cust_Profile.php'">
                Back
            </button>

        </form>
    </div>

</div>
</div>

<?php include 'footer.php'; ?>
