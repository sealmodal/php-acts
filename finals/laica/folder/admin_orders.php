<?php
include 'db_connect.php';

/* ======================================================
   UPDATE ORDER STATUS
====================================================== */

if(isset($_POST['updateOrder'])){

    $order_id = $_POST['order_id'];

    $getOrder = mysqli_query($conn,"
    SELECT *
    FROM orders
    WHERE order_id='$order_id'
    ");

    $order = mysqli_fetch_assoc($getOrder);

    $currentStatus = $order['order_status'];

    $nextStatus = $currentStatus;

    $courier = $order['courier'];
    $tracking = $order['tracking_number'];
    $delivery = $order['estimated_delivery'];

    $couriers = [

        "J&T Express",
        "LBC Express",
        "Ninja Van",
        "Flash Express",
        "SPX Express"

    ];

    if($currentStatus=="Pending"){

        $nextStatus="Confirmed";

    }

    elseif($currentStatus=="Confirmed"){

        $nextStatus="Shipped";

        $courier =
        $couriers[array_rand($couriers)];

        if($courier=="J&T Express"){

            $tracking="JTX".rand(100000000,999999999);

        }

        elseif($courier=="LBC Express"){

            $tracking="LBC".rand(100000000,999999999);

        }

        elseif($courier=="Ninja Van"){

            $tracking="NV".rand(100000000,999999999);

        }

        elseif($courier=="Flash Express"){

            $tracking="FL".rand(100000000,999999999);

        }

        else{

            $tracking="SPX".rand(100000000,999999999);

        }

        $delivery =
        date("Y-m-d",strtotime("+3 days"));

    }

    elseif($currentStatus=="Shipped"){

        $nextStatus="Delivered";

    }

    mysqli_query($conn,"
    UPDATE orders
    SET
    order_status='$nextStatus',
    courier='$courier',
    tracking_number='$tracking',
    estimated_delivery='$delivery'
    WHERE order_id='$order_id'
    ");

    header("Location: admin_orders.php");
    exit();

}

/* ======================================================
   SEARCH + FILTER
====================================================== */

$search = "";

$statusFilter = "";

if(isset($_GET['search'])){

    $search =
    mysqli_real_escape_string($conn,$_GET['search']);

}

if(isset($_GET['status'])){

    $statusFilter =
    mysqli_real_escape_string($conn,$_GET['status']);

}

/* ======================================================
   DASHBOARD COUNTS
====================================================== */

$totalOrders =
mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) total
FROM orders
"))['total'];

$pending =
mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) total
FROM orders
WHERE order_status='Pending'
"))['total'];

$confirmed =
mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) total
FROM orders
WHERE order_status='Confirmed'
"))['total'];

$shipped =
mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) total
FROM orders
WHERE order_status='Shipped'
"))['total'];

$delivered =
mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) total
FROM orders
WHERE order_status='Delivered'
"))['total'];

$cancelled =
mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) total
FROM orders
WHERE order_status='Cancelled'
"))['total'];

$booksSold =
mysqli_fetch_assoc(mysqli_query($conn,"
SELECT IFNULL(SUM(quantity),0) total
FROM orders
WHERE order_status='Delivered'
"))['total'];

$totalRevenue =
mysqli_fetch_assoc(mysqli_query($conn,"
SELECT IFNULL(SUM(total_amount),0) total
FROM orders
WHERE order_status='Delivered'
"))['total'];

/* ======================================================
   LOAD ORDERS
====================================================== */

$sql="

SELECT

orders.*,

books.title,

payments.payment_method

FROM orders

INNER JOIN books

ON orders.book_id=books.book_id

LEFT JOIN payments

ON orders.order_id=payments.order_id

WHERE 1=1

";

if($search!=""){

$sql.="

AND

(

orders.order_id LIKE '%$search%'

OR

books.title LIKE '%$search%'

)

";

}

if($statusFilter!="" && $statusFilter!="All"){

$sql.="

AND

orders.order_status='$statusFilter'

";

}

$sql.="

ORDER BY order_date DESC

";

$query=mysqli_query($conn,$sql);

?>

<!DOCTYPE html>

<html>

<head>

<title>Admin Order Management</title>

<style>

body{

margin:0;
font-family:Arial;
background:#f4f6f8;

}

.container{

width:95%;
max-width:1400px;
margin:30px auto;

}

h1{

text-align:center;
color:#333;
margin-bottom:25px;

}

/* ===========================
   Dashboard Cards
=========================== */

.dashboard{

display:grid;
grid-template-columns:repeat(auto-fit,minmax(170px,1fr));
gap:15px;
margin-bottom:30px;

}

.card{

background:white;
padding:20px;
border-radius:12px;
box-shadow:0 4px 12px rgba(0,0,0,.12);
text-align:center;

}

.card h2{

margin:0;
font-size:32px;
color:#4CAF50;

}

.card p{

margin-top:10px;
font-weight:bold;
color:#555;

}

/* ===========================
   Search + Filter
=========================== */

.toolbar{

display:flex;
justify-content:space-between;
align-items:center;
gap:15px;
margin-bottom:25px;
flex-wrap:wrap;

}

.search-box{

display:flex;
gap:10px;
flex:1;

}

.search-box input{

flex:1;
padding:12px;
border:1px solid #ccc;
border-radius:8px;
font-size:15px;

}

.search-box select{

padding:12px;
border:1px solid #ccc;
border-radius:8px;

}

.search-box button{

padding:12px 20px;
background:#4CAF50;
color:white;
border:none;
border-radius:8px;
cursor:pointer;

}

.search-box button:hover{

background:#388E3C;

}

/* ===========================
   Table
=========================== */

table{

width:100%;
border-collapse:collapse;
background:white;
box-shadow:0 4px 12px rgba(0,0,0,.12);

}

th{

background:#4CAF50;
color:white;
padding:14px;

}

td{

padding:12px;
border-bottom:1px solid #eee;
text-align:center;

}

tr:hover{

background:#fafafa;

}

.status{

font-weight:bold;

}

.pending{

color:#d68910;

}

.confirmed{

color:#27ae60;

}

.shipped{

color:#2980b9;

}

.delivered{

color:#16a085;

}

.cancelled{

color:#e74c3c;

}

button{

background:#4CAF50;
color:white;
border:none;
padding:10px 18px;
border-radius:6px;
cursor:pointer;

}

button:hover{

background:#388E3C;

}

.completed{

font-weight:bold;
color:#4CAF50;

}

.summary{

margin-top:30px;
background:white;
padding:20px;
border-radius:12px;
box-shadow:0 4px 12px rgba(0,0,0,.12);

}

.summary h2{

margin-top:0;

}

</style>

</head>

<body>

<?php include 'navbar.php'; ?>

<div class="container">

<h1>📦 Admin Order Management</h1>

<!-- ===========================
     Dashboard
=========================== -->

<div class="dashboard">

<div class="card">
<h2><?php echo $totalOrders; ?></h2>
<p>Total Orders</p>
</div>

<div class="card">
<h2><?php echo $booksSold; ?></h2>
<p>Books Sold</p>
</div>

<div class="card">
<h2>₱<?php echo number_format($totalRevenue,2); ?></h2>
<p>Total Revenue</p>
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
     Search + Filter
=========================== -->

<form method="GET" class="toolbar">

<div class="search-box">

<input
type="text"
name="search"
placeholder="Search Order ID or Book Title..."
value="<?php echo $search; ?>">

<select name="status">

<option value="All">All Status</option>

<option value="Pending"
<?php if($statusFilter=="Pending") echo "selected"; ?>>
Pending
</option>

<option value="Confirmed"
<?php if($statusFilter=="Confirmed") echo "selected"; ?>>
Confirmed
</option>

<option value="Shipped"
<?php if($statusFilter=="Shipped") echo "selected"; ?>>
Shipped
</option>

<option value="Delivered"
<?php if($statusFilter=="Delivered") echo "selected"; ?>>
Delivered
</option>

<option value="Cancelled"
<?php if($statusFilter=="Cancelled") echo "selected"; ?>>
Cancelled
</option>

</select>

<button type="submit">

🔍 Search

</button>

</div>

</form>

<table>

<tr>

<th>Order ID</th>

<th>Book</th>

<th>Qty</th>

<th>Payment</th>

<th>Total</th>

<th>Status</th>

<th>Courier</th>

<th>Tracking No.</th>

<th>Delivery Date</th>

<th>Action</th>

</tr>

<?php

if(mysqli_num_rows($query)==0){

?>

<tr>

<td colspan="10">

No orders found.

</td>

</tr>

<?php

}

while($row=mysqli_fetch_assoc($query)){

?>

<tr>

<form method="POST">

<td>

#<?php echo $row['order_id']; ?>

<input
type="hidden"
name="order_id"
value="<?php echo $row['order_id']; ?>">

</td>

<td>

<?php echo $row['title']; ?>

</td>

<td>

<?php echo $row['quantity']; ?>

</td>

<td>

<?php

if(!empty($row['payment_method'])){

echo $row['payment_method'];

}

else{

echo "-";

}

?>

</td>

<td>

₱<?php echo number_format($row['total_amount'],2); ?>

</td>

<td class="status">

<?php

if($row['order_status']=="Pending"){

echo "<span class='pending'>🟡 Pending</span>";

}

elseif($row['order_status']=="Confirmed"){

echo "<span class='confirmed'>🟢 Confirmed</span>";

}

elseif($row['order_status']=="Shipped"){

echo "<span class='shipped'>🚚 Shipped</span>";

}

elseif($row['order_status']=="Delivered"){

echo "<span class='delivered'>✅ Delivered</span>";

}

else{

echo "<span class='cancelled'>❌ Cancelled</span>";

}

?>

</td>

<td>

<?php

echo !empty($row['courier'])
? $row['courier']
: "-";

?>

</td>

<td>

<?php

echo !empty($row['tracking_number'])
? $row['tracking_number']
: "-";

?>

</td>

<td>

<?php

echo !empty($row['estimated_delivery'])
? date("M d, Y",strtotime($row['estimated_delivery']))
: "-";

?>

</td>

<td>

<?php

if($row['order_status']=="Pending"){

?>

<button
type="submit"
name="updateOrder">

✔ Confirm

</button>

<?php

}

elseif($row['order_status']=="Confirmed"){

?>

<button
type="submit"
name="updateOrder">

🚚 Ship

</button>

<?php

}

elseif($row['order_status']=="Shipped"){

?>

<button
type="submit"
name="updateOrder">

📦 Deliver

</button>

<?php

}

elseif($row['order_status']=="Delivered"){

?>

<span class="completed">

Completed

</span>

<?php

}

else{

?>

<span style="color:red;font-weight:bold;">

Cancelled

</span>

<?php

}

?>

</td>

</form>

</tr>

<?php

}

?>

</table>

<div class="summary">

<h2>📊 Order Summary</h2>

<p>

<b>Total Orders:</b>

<?php echo $totalOrders; ?>

</p>

<p>

<b>Books Sold:</b>

<?php echo $booksSold; ?>

</p>

<p>

<b>Pending Orders:</b>

<?php echo $pending; ?>

</p>

<p>

<b>Confirmed Orders:</b>

<?php echo $confirmed; ?>

</p>

<p>

<b>Shipped Orders:</b>

<?php echo $shipped; ?>

</p>

<p>

<b>Delivered Orders:</b>

<?php echo $delivered; ?>

</p>

<p>

<b>Cancelled Orders:</b>

<?php echo $cancelled; ?>

</p>

<hr>

<h2 style="color:#4CAF50;">

💰 Total Revenue

</h2>

<h1 style="color:#4CAF50;">

₱<?php echo number_format($totalRevenue,2); ?>

</h1>

<p style="color:#777;">

Revenue is calculated from all <b>Delivered</b> orders.

</p>

</div>

</div>

</body>

</html>