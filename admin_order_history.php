<?php
// Include necessary files
include 'config.php';
include 'admin_header.php';

// Fetch all order history records, sorted by changed_at (newest first)
$query = "SELECT HistoryID, OrderID, status, changed_by_staff, changed_at, remark 
          FROM orderhistory 
          ORDER BY changed_at DESC";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Database query failed: " . mysqli_error($conn));
}
?>

<!-- Redesigned layout with full-width container and better column sizing -->
<div class="admin-wrap" style="max-width: 100%; padding: 20px 40px;">
    <h1 style="color: #fff; margin-bottom: 30px; font-size: 28px;">Order History</h1>
    
    <div style="overflow-x: auto; width: 100%; background: #1a1a1a; border-radius: 8px; padding: 20px;">
        <table class="admin-table" style="width: 100%; min-width: 1100px;">
            <thead>
                <tr>
                    <th style="width: 80px;">History ID</th>
                    <th style="width: 150px;">Order ID</th>
                    <th style="width: 110px;">Status</th>
                    <th style="width: 130px;">Changed By</th>
                    <th style="width: 140px;">Changed At</th>
                    <th>Remark</th>
                    <th style="width: 100px; text-align: center;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['HistoryID']); ?></td>
                            <td><strong>#<?php echo htmlspecialchars($row['OrderID']); ?></strong></td>
                            <td>
                                <?php
                                $status = strtolower($row['status']);
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
                                <span class="<?php echo $statusClass; ?>">
                                    <?php echo htmlspecialchars($row['status']); ?>
                                </span>
                            </td>
                            <td>
                                <!-- Handle NULL changed_by_staff values -->
                                <?php 
                                if (empty($row['changed_by_staff']) || is_null($row['changed_by_staff'])) {
                                    echo '<span style="color: #888; font-style: italic;">Customer</span>';
                                } else {
                                    echo htmlspecialchars($row['changed_by_staff']);
                                }
                                ?>
                            </td>
                            <td style="color: #bbb; font-size: 13px;">
                                <?php echo date('M d, Y - H:i', strtotime($row['changed_at'])); ?>
                            </td>
                            <td>
                                <!-- Remark with proper wrapping and no width constraint -->
                                <div style="white-space: normal; word-wrap: break-word; line-height: 1.5; padding: 8px 0;">
                                    <?php 
                                    if (!empty($row['remark']) && !is_null($row['remark'])) {
                                        echo htmlspecialchars($row['remark']);
                                    } else {
                                        echo '<span style="color: #666;">—</span>';
                                    }
                                    ?>
                                </div>
                            </td>
                            <td style="text-align: center;">
                                <!-- Pass OrderID instead of HistoryID to show all history for that order -->
                                <a href="admin_view_detail_history.php?id=<?php echo urlencode($row['OrderID']); ?>" 
                                   class="admin-btn-sm" style="display: inline-block; min-width: 70px;">
                                    View
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 40px; color: #999;">
                            No order history records found.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
mysqli_close($conn);
?>
