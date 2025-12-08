<?php include 'header.php'; ?>

<style>
.oh-wrap {
    padding: 40px;
    max-width: 1100px;
    margin: auto;
}

.oh-title {
    font-size: 2rem;
    margin-bottom: 20px;
}

.oh-table {
    width: 100%;
    border-collapse: collapse;
}

.oh-table th, .oh-table td {
    padding: 14px;
    border-bottom: 1px solid #333;
}

.oh-table th {
    background: #181818;
}

.oh-status {
    text-transform: capitalize;
    font-weight: 700;
}

.oh-btn {
    padding: 8px 14px;
    background: #00ffa6;
    color: #000;
    text-decoration: none;
    border-radius: 8px;
    font-weight: 700;
    display: inline-block;
}

.oh-btn:hover {
    background: #00d98c;
}
</style>

<div class="page-content">
<div class="oh-wrap">

    <h1 class="oh-title">Your Past Orders</h1>

    <table class="oh-table">
        <tr>
            <th>Order ID</th>
            <th>Date</th>
            <th>Total (RM)</th>
            <th>Status</th>
            <th>Action</th>
        </tr>

        <tr>
            <td>#101</td>
            <td>2025-03-10</td>
            <td>18.90</td>
            <td class="oh-status">delivered</td>
            <td><a class="oh-btn" href="order_details.php?id=101">View</a></td>
        </tr>

    </table>

</div>
</div>

<?php include 'footer.php'; ?>
