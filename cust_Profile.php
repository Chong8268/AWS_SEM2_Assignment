<?php include 'header.php'; ?>

<style>
.cp-wrap {
    max-width: 900px;
    margin: 40px auto;
    padding: 20px;
}

.cp-card {
    background: #111;
    padding: 24px;
    border-radius: 12px;
}

.cp-row {
    display: flex;
    gap: 18px;
    align-items: center;
    margin-top: 12px;
}

.cp-label {
    color: #bbb;
    font-size: 14px;
}

.cp-value {
    color: #fff;
    font-weight: 600;
}

.cp-btn {
    margin-top: 18px;
    padding: 10px 14px;
    border-radius: 8px;
    background: #00ffa6;
    color: #000;
    border: 0;
    font-weight: 700;
    cursor: pointer;
    margin-right: 12px;
}
.cp-btn:hover {
    background: #00d98c;
}
</style>

<div class="page-content">
<div class="cp-wrap">

    <div class="cp-card">
        <h2>Your Profile</h2>

        <div class="cp-row">
            <div style="flex:1;">
                <div class="cp-label">Name</div>
                <div class="cp-value">John Doe</div>
            </div>
        </div>

        <div class="cp-row">
            <div style="flex:1;">
                <div class="cp-label">Phone</div>
                <div class="cp-value">010-0000 000</div>
            </div>
        </div>

        <div class="cp-row">
            <div style="flex:1;">
                <div class="cp-label">Address</div>
                <div class="cp-value">123 Campus Road</div>
            </div>
        </div>

        <div style="margin-top:18px;">
            <button class="cp-btn" onclick="location.href='cus_Profile_edit.php'">Edit Profile</button>
            <button class="cp-btn" onclick="location.href='cus_ChangePass.php'">Change Password</button>
        </div>
    </div>

</div>
</div>

<?php include 'footer.php'; ?>
