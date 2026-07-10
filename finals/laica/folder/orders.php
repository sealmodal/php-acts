<?php
include 'db_connect.php';

$statusFilter = "";

if(isset($_GET['status'])){
    $statusFilter = $_GET['status'];
}

$sql = "
SELECT
orders.*,
books.title,
payments.payment_method

FROM orders

INNER JOIN books
ON orders.book_id = books.book_id

LEFT JOIN payments
ON orders.order_id = payments.order_id
";

if($statusFilter != "" && $statusFilter != "All"){

    $sql .= " WHERE orders.order_status='$statusFilter'";

}

$sql .= " ORDER BY orders.order_date DESC";

$query = mysqli_query($conn,$sql);

/* --------------------------
   Dashboard Counts
---------------------------*/

$totalOrders = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) AS total
FROM orders
"))['total'];

$pending = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) AS total
FROM orders
WHERE order_status='Pending'
"))['total'];

$confirmed = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) AS total
FROM orders
WHERE order_status='Confirmed'
"))['total'];

$shipped = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) AS total
FROM orders
WHERE order_status='Shipped'
"))['total'];

$delivered = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) AS total
FROM orders
WHERE order_status='Delivered'
"))['total'];

$cancelled = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) AS total
FROM orders
WHERE order_status='Cancelled'
"))['total'];
?>

<!DOCTYPE html>

<html>

<head>

<title>My Orders</title>

<style>

body{

    margin:0;
    font-family:Arial;
    background:#f4f6f8;

}

.container{

    width:95%;
    max-width:1200px;
    margin:30px auto;

}

h1{

    text-align:center;
    margin-bottom:25px;
    color:#333;

}

/* Dashboard Cards */

.dashboard{

    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(150px,1fr));
    gap:15px;
    margin-bottom:30px;

}

.card{

    background:white;
    border-radius:12px;
    padding:20px;
    text-align:center;
    box-shadow:0 4px 12px rgba(0,0,0,.12);

}

.card h2{

    margin:0;
    color:#4CAF50;
    font-size:32px;

}

.card p{

    margin-top:10px;
    color:#555;
    font-weight:bold;

}

/* Filter Buttons */

.filters{

    display:flex;
    flex-wrap:wrap;
    gap:10px;
    justify-content:center;
    margin-bottom:30px;

}

.filters a{

    text-decoration:none;
    background:white;
    color:#4CAF50;
    border:2px solid #4CAF50;
    padding:10px 18px;
    border-radius:30px;
    transition:.3s;
    font-weight:bold;

}

.filters a:hover{

    background:#4CAF50;
    color:white;

}

/* Order Card */

.order{

    background:white;
    border-radius:15px;
    padding:25px;
    margin-bottom:25px;
    box-shadow:0 5px 15px rgba(0,0,0,.12);

}

.order h2{

    margin-top:0;
    color:#333;

}

.info{

    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:10px;
    margin-bottom:20px;

}

.info p{

    margin:5px 0;

}

.status-badge{

    display:inline-block;
    padding:8px 15px;
    border-radius:30px;
    color:white;
    font-weight:bold;

}

.pending{
    background:#f39c12;
}

.confirmed{
    background:#27ae60;
}

.shipped{
    background:#2980b9;
}

.delivered{
    background:#16a085;
}

.cancelled{
    background:#e74c3c;
}

.progress{

    margin-top:20px;
    line-height:34px;
    font-size:16px;

}

.done{

    color:#27ae60;
    font-weight:bold;

}

.current{

    color:#f39c12;
    font-weight:bold;

}

.waiting{

    color:#999;

}

.shipinfo{

    margin-top:20px;
    background:#f8f8f8;
    border-radius:10px;
    padding:15px;

}

.receipt-btn{

    display:inline-block;
    margin-top:20px;
    text-decoration:none;
    background:#4CAF50;
    color:white;
    padding:12px 18px;
    border-radius:8px;
    font-weight:bold;

}

.receipt-btn:hover{

    background:#388E3C;

}

</style>

</head>

<body>

<?php include 'navbar.php'; ?>

<div class="container">

<h1>📦 My Orders</h1>

<!-- ===========================
     Dashboard Cards
=========================== -->

<div class="dashboard">

<div class="card">
<h2><?php echo $totalOrders; ?></h2>
<p>Total Orders</p>
</div>

<div class="card">
<h2><?php echo $pending; ?></h2>
<p>🟡 Pending</p>
</div>

<div class="card">
<h2><?php echo $confirmed; ?></h2>
<p>🟢 Confirmed</p>
</div>

<div class="card">
<h2><?php echo $shipped; ?></h2>
<p>🚚 Shipped</p>
</div>

<div class="card">
<h2><?php echo $delivered; ?></h2>
<p>✅ Delivered</p>
</div>

<div class="card">
<h2><?php echo $cancelled; ?></h2>
<p>❌ Cancelled</p>
</div>

</div>

<!-- ===========================
     Filter Buttons
=========================== -->

<div class="filters">

<a href="orders.php">All</a>

<a href="orders.php?status=Pending">
🟡 Pending
</a>

<a href="orders.php?status=Confirmed">
🟢 Confirmed
</a>

<a href="orders.php?status=Shipped">
🚚 Shipped
</a>

<a href="orders.php?status=Delivered">
✅ Delivered
</a>

<a href="orders.php?status=Cancelled">
❌ Cancelled
</a>

</div>

<!-- ===========================
     Orders List
=========================== -->

<?php

if(mysqli_num_rows($query)==0){

?>

<div class="order">

<h2 style="text-align:center;color:#999;">

No orders found.

</h2>

<p style="text-align:center;">

You currently have no orders under this category.

</p>

</div>

<?php

}

while($row=mysqli_fetch_assoc($query)){

?>

<div class="order">

<h2>

<?php echo $row['title']; ?>

</h2>

<div class="info">

<p>

<b>Order ID:</b>

#<?php echo $row['order_id']; ?>

</p>

<p>

<b>Quantity:</b>

<?php echo $row['quantity']; ?>

</p>

<p>

<b>Total Paid:</b>

₱<?php echo number_format($row['total_amount'],2); ?>

</p>

<p>

<b>Order Date:</b>

<?php echo date("F d, Y",strtotime($row['order_date'])); ?>

</p>

<p>

<b>Payment Method:</b>

<?php

echo !empty($row['payment_method'])
? $row['payment_method']
: "N/A";

?>

</p>

<p>

<b>Status:</b>

<?php

$status = $row['order_status'];

if($status=="Pending"){

    echo "<span class='status-badge pending'>🟡 Pending</span>";

}
elseif($status=="Confirmed"){

    echo "<span class='status-badge confirmed'>🟢 Confirmed</span>";

}
elseif($status=="Shipped"){

    echo "<span class='status-badge shipped'>🚚 Shipped</span>";

}
elseif($status=="Delivered"){

    echo "<span class='status-badge delivered'>✅ Delivered</span>";

}
else{

    echo "<span class='status-badge cancelled'>❌ Cancelled</span>";

}

?>

</p>

</div>

<!-- ===========================
     Order Progress
=========================== -->

<div class="progress">

<?php

if($status=="Pending"){

?>

<div class="current">🟡 Pending</div>
<div class="waiting">│</div>
<div class="waiting">○ Confirmed</div>
<div class="waiting">│</div>
<div class="waiting">○ Shipped</div>
<div class="waiting">│</div>
<div class="waiting">○ Delivered</div>

<?php

}

elseif($status=="Confirmed"){

?>

<div class="done">✓ Pending</div>
<div class="waiting">│</div>
<div class="current">🟢 Confirmed</div>
<div class="waiting">│</div>
<div class="waiting">○ Shipped</div>
<div class="waiting">│</div>
<div class="waiting">○ Delivered</div>

<?php

}

elseif($status=="Shipped"){

?>

<div class="done">✓ Pending</div>
<div class="waiting">│</div>
<div class="done">✓ Confirmed</div>
<div class="waiting">│</div>
<div class="current">🚚 Shipped</div>
<div class="waiting">│</div>
<div class="waiting">○ Delivered</div>

<div class="shipinfo">

<h3>🚚 Shipping Information</h3>

<p>

<b>Courier:</b>

<?php echo $row['courier']; ?>

</p>

<p>

<b>Tracking Number:</b>

<?php echo $row['tracking_number']; ?>

</p>

<p>

<b>Estimated Delivery:</b>

<?php echo $row['estimated_delivery']; ?>

</p>

</div>

<?php

}

elseif($status=="Delivered"){

?>

<div class="done">✓ Pending</div>
<div class="waiting">│</div>
<div class="done">✓ Confirmed</div>
<div class="waiting">│</div>
<div class="done">✓ Shipped</div>
<div class="waiting">│</div>
<div class="done">✅ Delivered</div>

<div class="shipinfo">

<h3>📦 Delivery Information</h3>

<p>

<b>Courier:</b>

<?php echo $row['courier']; ?>

</p>

<p>

<b>Tracking Number:</b>

<?php echo $row['tracking_number']; ?>

</p>

<p style="color:green;font-weight:bold;">

✔ Your order has been delivered successfully.

</p>

</div>

<?php

}

else{

?>

<div style="color:#e74c3c;font-weight:bold;font-size:18px;">

❌ This order has been cancelled.

</div>

<?php

}

?>

</div>

<a
class="receipt-btn"
href="receipt.php?order_id=<?php echo $row['order_id']; ?>">

🧾 View Receipt

</a>

</div>

<?php

}

?>

</div>

</body>

</html>