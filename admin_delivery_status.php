<?php
include 'admin_header.php';
include 'config.php';

/* =======================
   FETCH DELIVERY + ORDER STATUS + PAYMENT METHOD
   ======================= */
$sql = "
    SELECT 
        d.DeliveryID,
        d.OrderID,
        d.status AS delivery_status,
        d.receiver_name,
        d.receiver_phone,
        d.address,
        p.method as payment_method
    FROM deliveryinfo d
    LEFT JOIN payment p ON p.OrderID = d.OrderID
    WHERE d.status NOT IN ('COMPLETED', 'CANCELLED')
    ORDER BY d.DeliveryID DESC
";

$result = $conn->query($sql);

$deliveries = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $deliveries[] = $row;
    }
}
?>

<div class="admin-page">
<div class="admin-wrap">

    <h1>Delivery Management</h1>

    <table class="admin-table">
        <tr>
            <th>Delivery ID</th>
            <th>Order ID</th>
            <th>Receiver</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Payment Method</th>
            <th>Delivery Status</th>
            <th>Action</th>
        </tr>

        <?php if (empty($deliveries)): ?>
            <tr>
                <td colspan="8" style="text-align:center; color:#888;">
                    No delivery records found.
                </td>
            </tr>
        <?php else: ?>
            <?php foreach ($deliveries as $d): ?>
            <?php $isCOD = (strtoupper($d['payment_method']) === 'COD'); ?>
            <tr>
                <td><?= $d['DeliveryID'] ?></td>
                <td>#<?= $d['OrderID'] ?></td>
                <td><?= htmlspecialchars($d['receiver_name']) ?></td>
                <td><?= htmlspecialchars($d['receiver_phone']) ?></td>
                <td><?= htmlspecialchars($d['address']) ?></td>
                <td>
                    <?php if ($isCOD): ?>
                        <span class="status-badge pending">COD</span>
                    <?php else: ?>
                        <span class="status-badge completed"><?= htmlspecialchars($d['payment_method']) ?></span>
                    <?php endif; ?>
                </td>
                <td><?= $d['delivery_status'] ?></td>

                <td>
                <?php if ($_SESSION['Role'] === 'RIDER'): ?>

                    <?php if ($d['delivery_status'] === 'READY_TO_PICKUP'): ?>
                        <form method="post"
                              action="admin_delivery_update.php"
                              style="display:inline;">
                            <input type="hidden" name="delivery_id"
                                   value="<?= $d['DeliveryID'] ?>">
                            <input type="hidden" name="action" value="pickup">
                            <button class="admin-btn-sm">
                                Pickup
                            </button>
                        </form>

                    <?php elseif ($d['delivery_status'] === 'DELIVERING'): ?>
                        <form method="post"
                              action="admin_delivery_update.php"
                              style="display:inline;">
                            <input type="hidden" name="delivery_id"
                                   value="<?= $d['DeliveryID'] ?>">
                            <input type="hidden" name="action" value="arrive">
                            <button class="admin-btn-sm">
                                Arrived
                            </button>
                        </form>

                    <?php elseif ($d['delivery_status'] === 'ARRIVE' && $isCOD): ?>
                        <form method="post"
                              action="admin_delivery_update.php"
                              style="display:inline;">
                            <input type="hidden" name="delivery_id"
                                   value="<?= $d['DeliveryID'] ?>">
                            <input type="hidden" name="action" value="complete">
                            <button class="admin-btn-sm" style="background: #10b981;">
                                Confirm Payment
                            </button>
                        </form>

                    <?php else: ?>
                        <span style="color:#888;">Waiting...</span>
                    <?php endif; ?>

                <?php else: ?>
                    <span style="color:#888;">View only</span>
                <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>

</div>
</div>

<?php include 'footer.php'; ?>
