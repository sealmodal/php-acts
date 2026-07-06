<?php
session_start();

if (!isset($_SESSION['orders'])) {
    $_SESSION['orders'] = [
        ['id' => 1, 'order_id' => 'ORD-2026-006', 'customer_name' => 'Hailey Bieber', 'order_date' => '2026-06-30', 'items' => 5, 'total' => 2500.00, 'status' => 'Pending'],
        ['id' => 2, 'order_id' => 'ORD-2026-005', 'customer_name' => 'Selena Gomez', 'order_date' => '2026-06-30', 'items' => 5, 'total' => 2500.00, 'status' => 'Processing'],
        ['id' => 3, 'order_id' => 'ORD-2026-004', 'customer_name' => 'Michelle Meyer', 'order_date' => '2026-06-30', 'items' => 5, 'total' => 2500.00, 'status' => 'Delivered'],
        ['id' => 4, 'order_id' => 'ORD-2026-003', 'customer_name' => 'Kaye Anne', 'order_date' => '2026-06-30', 'items' => 5, 'total' => 2500.00, 'status' => 'Shipped'],
        ['id' => 5, 'order_id' => 'ORD-2026-002', 'customer_name' => 'Marie Swift', 'order_date' => '2026-06-30', 'items' => 5, 'total' => 2500.00, 'status' => 'Cancelled'],
        ['id' => 6, 'order_id' => 'ORD-2026-001', 'customer_name' => 'Elsa Anna', 'order_date' => '2026-06-30', 'items' => 5, 'total' => 2500.00, 'status' => 'Cancelled'],
    ];
}

if(isset($_POST['update_status'])) {
    $id = $_POST['id'];
    $new_status = $_POST['status'];
    
    foreach ($_SESSION['orders'] as &$order) {
        if ($order['id'] == $id) {
            $order['status'] = $new_status;
        }
    }
    header("Location: admin_orders.php"); 
    exit();
}

$statusFilter = isset($_GET['status']) ? $_GET['status'] : '';
$orders = $_SESSION['orders'];

if($statusFilter != '') {
    $orders = array_filter($orders, function($order) use ($statusFilter) {
        return $order['status'] == $statusFilter;
    });
}

$totalOrders = count($orders);

include("header_admin.php"); 
?>

<h1 class="page-title">Orders</h1>
<p class="page-subtitle">Manage and track customer orders.</p>

<div class="summary-card">
    <div class="summary-number"><?php echo $totalOrders; ?></div>
    <div class="summary-label">Total Orders</div>
</div>

<div class="filters">
    <a href="admin_orders.php" class="filter-btn <?= $statusFilter == '' ? 'active' : ''; ?>">All Orders</a>
    <a href="admin_orders.php?status=Pending" class="filter-btn <?= $statusFilter == 'Pending' ? 'active' : ''; ?>">Pending</a>
    <a href="admin_orders.php?status=Processing" class="filter-btn <?= $statusFilter == 'Processing' ? 'active' : ''; ?>">Processing</a>
    <a href="admin_orders.php?status=Shipped" class="filter-btn <?= $statusFilter == 'Shipped' ? 'active' : ''; ?>">Shipped</a>
    <a href="admin_orders.php?status=Delivered" class="filter-btn <?= $statusFilter == 'Delivered' ? 'active' : ''; ?>">Delivered</a>
    <a href="admin_orders.php?status=Cancelled" class="filter-btn <?= $statusFilter == 'Cancelled' ? 'active' : ''; ?>">Cancelled</a>
</div>

<div class="table-wrapper">
    <table class="orders-table">
        <thead>
            <tr>
                <th>ORDER ID</th><th>CUSTOMER</th><th>DATE</th><th>ITEMS</th><th>TOTAL</th><th>STATUS</th><th>UPDATE</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($orders as $order): ?>
            <tr>
                <td><?= $order['order_id']; ?></td>
                <td><?= $order['customer_name']; ?></td>
                <td><?= $order['order_date']; ?></td>
                <td><?= $order['items']; ?></td>
                <td>₱<?= number_format($order['total'], 2); ?></td>
                <td><span class="badge <?= strtolower($order['status']); ?>"><?= strtoupper($order['status']); ?></span></td>
                <td>
                    <form method="POST" class="update-form">
                        <input type="hidden" name="id" value="<?= $order['id']; ?>">
                        <select name="status">
                            <option value="Pending" <?= $order['status']=='Pending' ? 'selected' : ''; ?>>Pending</option>
                            <option value="Processing" <?= $order['status']=='Processing' ? 'selected' : ''; ?>>Processing</option>
                            <option value="Shipped" <?= $order['status']=='Shipped' ? 'selected' : ''; ?>>Shipped</option>
                            <option value="Delivered" <?= $order['status']=='Delivered' ? 'selected' : ''; ?>>Delivered</option>
                            <option value="Cancelled" <?= $order['status']=='Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                        </select>
                        <button type="submit" name="update_status" class="save-btn">Save</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include("footer_admin.php"); ?>