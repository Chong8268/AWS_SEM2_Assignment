<?php
session_start();
include 'config.php';

if (!isset($_SESSION["CustomerID"])) {
    header("Location: login.php");
    exit;
}

$customerID = $_SESSION["CustomerID"];

/* 取全部订单 */
$stmt = $conn->prepare("
    SELECT OrderID, order_date, total_amount, status
    FROM `order`
    WHERE CustomerID = ?
    ORDER BY order_date DESC
");
$stmt->bind_param("s", $customerID);
$stmt->execute();
$result = $stmt->get_result();
?>

<?php include 'header.php'; ?>

<style>
.all-history-wrap {
    max-width: 1100px;
    margin: 60px auto;
    padding: 0 20px;
}

.all-history-title {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 30px;
}

/* order card */
.history-card {
    background: linear-gradient(145deg, #161616, #111);
    border-radius: 14px;
    padding: 22px 26px;
    margin-bottom: 18px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 14px 30px rgba(0,0,0,.35);
    transition: .25s;
}

.history-card:hover {
    transform: translateY(-3px);
}

/* left */
.history-info h4 {
    margin: 0 0 6px;
    font-size: 1.05rem;
}

.history-info p {
    margin: 2px 0;
    color: #aaa;
    font-size: .9rem;
}

/* status badge */
.history-status {
    display: inline-block;
    margin-top: 6px;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: .75rem;
    font-weight: 800;
    letter-spacing: .4px;
}

.status-pending { background:#ffd86b; color:#000; }
.status-confirmed { background:#00ffa6; color:#000; }
.status-preparing { background:#4dabff; color:#000; }
.status-completed { background:#2ecc71; color:#000; }
.status-cancelled { background:#ff6b6b; color:#fff; }

/* right */
.history-actions {
    text-align: right;
}

.history-total {
    font-size: 1.1rem;
    font-weight: 700;
    margin-bottom: 10px;
}

.history-btn {
    display: inline-block;
    padding: 8px 16px;
    border-radius: 8px;
    font-weight: 700;
    font-size: .85rem;
    text-decoration: none;
    background: #222;
    color: #00ffa6;
    transition: .2s;
}

.history-btn:hover {
    background: #00ffa6;
    color: #000;
}

/* empty */
.empty-msg {
    color: #aaa;
    font-size: 1rem;
    margin-top: 40px;
    text-align: center;
}
</style>

<div class="page-content">
<div class="container">

<div class="all-history-wrap">
    <div class="all-history-title">All Order History</div>

    <?php if ($result->num_rows === 0): ?>
        <div class="empty-msg">You have no past orders.</div>
    <?php endif; ?>

    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="history-card">

            <div class="history-info">
                <h4>Order #<?= htmlspecialchars($row['OrderID']) ?></h4>
                <p><?= date("d M Y, H:i", strtotime($row['order_date'])) ?></p>

                <span class="history-status status-<?= strtolower($row['status']) ?>">
                    <?= strtoupper($row['status']) ?>
                </span>
            </div>

            <div class="history-actions">
                <div class="history-total">
                    RM <?= number_format($row['total_amount'], 2) ?>
                </div>

                <a class="history-btn"
                   href="order_history.php?order_id=<?= urlencode($row['OrderID']) ?>">
                    View
                </a>
            </div>

        </div>
    <?php endwhile; ?>

</div>

</div>
</div>

<?php include 'footer.php'; ?>
