<?php include 'header.php'; ?>

<style>
.ds-wrap {
    padding: 40px;
    max-width: 1000px;
    margin: auto;
}

.ds-title {
    font-size: 2rem;
    margin-bottom: 20px;
}

.ds-table {
    width: 100%;
    border-collapse: collapse;
}

.ds-table th,
.ds-table td {
    padding: 14px;
    border-bottom: 1px solid #333;
}

.ds-table th {
    background: #181818;
}

/* action button */
.ds-btn {
    padding: 8px 14px;
    background: #00ffa6;
    color: #000;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 700;
    transition: .2s;
}
.ds-btn:hover {
    background: #00d98c;
}
</style>

<div class="page-content">
<div class="ds-wrap">

    <h1 class="ds-title">Delivery Management</h1>

    <table class="ds-table">
        <tr>
            <th>ID</th>
            <th>Order</th>
            <th>Address</th>
            <th>Phone</th>
            <th>Status</th>
            <th>Action</th>
        </tr>

        <?php foreach ($deliveries as $d): ?>
        <tr>
            <td><?= $d['DeliveryID'] ?></td>
            <td>#<?= $d['orderID'] ?></td>
            <td><?= htmlspecialchars($d['Address']) ?></td>
            <td><?= htmlspecialchars($d['Phone']) ?></td>
            <td><?= htmlspecialchars($d['status']) ?></td>

            <td>
                <a class="ds-btn" href="admin_delivery_update.php?id=<?= $d['DeliveryID'] ?>">Update</a>
            </td>
        </tr>
        <?php endforeach; ?>

    </table>

</div>
</div>

<?php include 'footer.php'; ?>
