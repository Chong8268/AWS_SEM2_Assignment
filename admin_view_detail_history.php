<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'config.php';
include 'admin_header.php';

$orderID = isset($_GET['id']) ? trim($_GET['id']) : '';

if (empty($orderID)) {
    echo "<div class='admin-wrap' style='max-width: 1200px; margin: 40px auto; padding: 20px;'>";
    echo "<div style='background: #ff4444; color: white; padding: 20px; border-radius: 8px;'>";
    echo "<h3>Invalid Order ID</h3>";
    echo "<p>Please provide a valid ID parameter.</p>";
    echo "<a href='admin_order_history.php' class='admin-btn-sm' style='background: #10b981; display: inline-block; margin-top: 15px;'>← Back to Order History</a>";
    echo "</div></div>";
    echo "</body></html>";
    exit;
}

$query = "SELECT HistoryID, OrderID, status, changed_by_staff, changed_at, remark 
          FROM orderhistory 
          WHERE OrderID = ?
          ORDER BY changed_at DESC";

$stmt = mysqli_prepare($conn, $query);
if (!$stmt) {
    echo "<div class='admin-wrap' style='max-width: 1200px; margin: 40px auto; padding: 20px;'>";
    echo "<div style='background: #ff4444; color: white; padding: 20px; border-radius: 8px;'>";
    echo "<h3>Database Error</h3>";
    echo "<p>Failed to prepare query: " . htmlspecialchars(mysqli_error($conn)) . "</p>";
    echo "</div></div>";
    echo "</body></html>";
    exit;
}

mysqli_stmt_bind_param($stmt, "s", $orderID);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$histories = [];
while ($row = mysqli_fetch_assoc($result)) {
    $histories[] = $row;
}

if (empty($histories)) {
    echo "<div class='admin-wrap' style='max-width: 1200px; margin: 40px auto; padding: 20px;'>";
    echo "<div style='background: #333; color: white; padding: 30px; border-radius: 8px; text-align: center;'>";
    echo "<h2 style='color: #fff; margin-bottom: 15px;'>Order History Not Found</h2>";
    echo "<p style='color: #aaa;'>No history records found for Order ID: " . htmlspecialchars($orderID) . "</p>";
    echo "<a href='admin_order_history.php' class='admin-btn-sm' style='background: #10b981; margin-top: 20px; display: inline-block;'>← Back to Order History</a>";
    echo "</div></div>";
    echo "</body></html>";
    exit;
}
?>

<div class="admin-wrap" style="max-width: 1200px; margin: 40px auto; padding: 20px;">
    <div style="margin-bottom: 25px;">
        <a href="admin_order_history.php" class="admin-btn-sm" style="background: #444; display: inline-block; padding: 10px 20px; text-decoration: none; border-radius: 6px; color: #fff;">
            ← Back to Order History
        </a>
    </div>

    <h1 style="color: #fff; margin-bottom: 10px; font-size: 32px; font-weight: 600;">
        Order History Timeline
    </h1>
    <p style="color: #10b981; font-size: 18px; margin-bottom: 30px;">
        Order ID: #<?php echo htmlspecialchars($orderID); ?>
    </p>

    <?php foreach ($histories as $index => $history): ?>
    <div style="background: #1a1a1a; border-radius: 10px; padding: 30px; border: 1px solid #333; margin-bottom: 20px; position: relative;">
        
        <div style="position: absolute; left: -10px; top: 30px; background: #10b981; color: white; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 16px; border: 3px solid #0d0d0d;">
            <?php echo count($histories) - $index; ?>
        </div>

        <div style="padding-left: 40px;">
            
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 15px;">
                <div>
                    <div style="color: #888; font-size: 12px; margin-bottom: 5px;">History ID</div>
                    <div style="color: #fff; font-size: 16px; font-weight: 600;">
                        #<?php echo htmlspecialchars($history['HistoryID']); ?>
                    </div>
                </div>
                
                <div>
                    <?php
                    $status = strtolower($history['status']);
                    $statusClass = 'status ';
                    if ($status === 'pending') {
                        $statusClass .= 'pending';
                    } elseif ($status === 'processing' || $status === 'preparing') {
                        $statusClass .= 'preparing';
                    } elseif ($status === 'completed') {
                        $statusClass .= 'completed';
                    } elseif ($status === 'cancelled') {
                        $statusClass .= 'cancelled';
                    }
                    ?>
                    <span class="<?php echo $statusClass; ?>" style="font-size: 16px; padding: 8px 16px; display: inline-block;">
                        <?php echo strtoupper(htmlspecialchars($history['status'])); ?>
                    </span>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 20px;">
                
            <div>
                    <div style="color: #888; font-size: 12px; margin-bottom: 5px;">Changed By</div>
                    <div style="color: #fff; font-size: 16px;">
                        <?php 
                        if (empty($history['changed_by_staff']) || is_null($history['changed_by_staff'])) {
                            echo '<span style="color: #888; font-style: italic;">Customer (Self-Service)</span>';
                        } else {
                            echo htmlspecialchars($history['changed_by_staff']);
                        }
                        ?>
                    </div>
                </div>

                <div>
                    <div style="color: #888; font-size: 12px; margin-bottom: 5px;">Changed At</div>
                    <div style="color: #fff; font-size: 16px;">
                        <?php echo date('F d, Y - h:i:s A', strtotime($history['changed_at'])); ?>
                    </div>
                </div>
                
            </div>

            <?php if (!empty($history['remark']) && !is_null($history['remark'])): ?>
            <div>
                <div style="color: #888; font-size: 12px; margin-bottom: 8px;">Remark</div>
                <div style="color: #ddd; font-size: 14px; line-height: 1.6; white-space: pre-wrap; word-wrap: break-word; background: #0d0d0d; padding: 15px; border-radius: 6px; border: 1px solid #2a2a2a;">
                    <?php echo nl2br(htmlspecialchars($history['remark'])); ?>
                </div>
            </div>
            <?php endif; ?>

        </div>
    </div>
    <?php endforeach; ?>

</div>

<?php
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>

</body>
</html>
