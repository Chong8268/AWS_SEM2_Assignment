<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include necessary files
include 'config.php';
include 'admin_header.php';
?>

<style>
    .payment-wrap {
        max-width: 100%;
        padding: 20px 40px;
        color: #fff;
    }
    .payment-title {
        font-size: 28px;
        margin-bottom: 30px;
        color: #fff;
    }
    .info-box {
        background: #22c55e;
        color: white;
        padding: 10px 20px;
        margin-bottom: 20px;
        border-radius: 6px;
    }
    .error-box {
        background: #ef4444;
        color: white;
        padding: 20px;
        margin: 20px 0;
        border-radius: 8px;
    }
    .table-container {
        overflow-x: auto;
        width: 100%;
        background: #1a1a1a;
        border-radius: 8px;
        padding: 20px;
    }
    .payment-table {
        width: 100%;
        min-width: 1200px;
        border-collapse: collapse;
    }
    .payment-table th {
        background: #2a2a2a;
        color: #22c55e;
        padding: 15px;
        text-align: left;
        font-weight: 600;
        border-bottom: 2px solid #333;
    }
    .payment-table td {
        padding: 15px;
        border-bottom: 1px solid #333;
        color: #ddd;
    }
    .payment-table tr:hover {
        background: #252525;
    }
    .amount-positive {
        color: #22c55e;
        font-weight: 600;
    }
    .amount-negative {
        color: #ef4444;
        font-weight: 600;
    }
    .badge {
        padding: 4px 12px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
    }
    .badge-payment {
        background: #22c55e;
        color: #fff;
    }
    .badge-refund {
        background: #ef4444;
        color: #fff;
    }
    .badge-completed {
        background: #22c55e;
        color: #fff;
    }
    .badge-pending {
        background: #f59e0b;
        color: #fff;
    }
    .badge-failed {
        background: #ef4444;
        color: #fff;
    }
</style>

<div class="payment-wrap">
    <h1 class="payment-title">Payment History</h1>
    
    <?php
    // Check if table exists
    $tableCheck = mysqli_query($conn, "SHOW TABLES LIKE 'paymenthistory'");
    
    if (mysqli_num_rows($tableCheck) == 0) {
        echo '<div class="error-box">';
        echo '<h2>Table Not Found</h2>';
        echo '<p>The <code>paymenthistory</code> table does not exist in the database.</p>';
        echo '<p>Please run the SQL script to create the table first.</p>';
        echo '</div>';
        exit;
    }
    
    // Fetch all payment history records
    $query = "SELECT 
                HistoryID,
                PaymentID,
                OrderID,
                amount,
                method,
                transaction_type,
                account_last4,
                status,
                remark,
                transaction_date
              FROM paymenthistory
              ORDER BY transaction_date DESC";
              
    $result = mysqli_query($conn, $query);
    
    if (!$result) {
        echo '<div class="error-box">';
        echo '<h2>Database Error</h2>';
        echo '<p>' . mysqli_error($conn) . '</p>';
        echo '</div>';
        exit;
    }
    
    $recordCount = mysqli_num_rows($result);
    echo '<div class="info-box">Found ' . $recordCount . ' payment record(s)</div>';
    ?>
    
    <div class="table-container">
        <table class="payment-table">
            <thead>
                <tr>
                    <th>History ID</th>
                    <th>Payment ID</th>
                    <th>Order ID</th>
                    <th>Amount (RM)</th>
                    <th>Method</th>
                    <th>Type</th>
                    <th>Account</th>
                    <th>Status</th>
                    <th>Date & Time</th>
                    <th>Remark</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($recordCount > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['HistoryID']); ?></td>
                            <td>
                                <?php echo !empty($row['PaymentID']) ? htmlspecialchars($row['PaymentID']) : '<span style="color: #666;">—</span>'; ?>
                            </td>
                            <td><strong>#<?php echo htmlspecialchars($row['OrderID']); ?></strong></td>
                            <td class="<?php echo ($row['transaction_type'] === 'REFUND') ? 'amount-negative' : 'amount-positive'; ?>">
                                <?php 
                                echo ($row['transaction_type'] === 'REFUND' ? '-' : '+');
                                echo number_format($row['amount'], 2); 
                                ?>
                            </td>
                            <td style="text-transform: capitalize;">
                                <?php echo htmlspecialchars($row['method']); ?>
                            </td>
                            <td>
                                <span class="badge badge-<?php echo strtolower($row['transaction_type']); ?>">
                                    <?php echo htmlspecialchars($row['transaction_type']); ?>
                                </span>
                            </td>
                            <td style="font-family: monospace;">
                                <?php echo !empty($row['account_last4']) ? '****' . htmlspecialchars($row['account_last4']) : '<span style="color: #666;">—</span>'; ?>
                            </td>
                            <td>
                                <span class="badge badge-<?php echo strtolower($row['status']); ?>">
                                    <?php echo htmlspecialchars(ucfirst($row['status'])); ?>
                                </span>
                            </td>
                            <td style="font-size: 13px;">
                                <?php echo date('M d, Y - H:i:s', strtotime($row['transaction_date'])); ?>
                            </td>
                            <td>
                                <?php echo !empty($row['remark']) ? htmlspecialchars($row['remark']) : '<span style="color: #666;">—</span>'; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="10" style="text-align: center; padding: 40px; color: #999;">
                            No payment history records found. Make a payment to see records here.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php mysqli_close($conn); ?>

</body>
</html>
