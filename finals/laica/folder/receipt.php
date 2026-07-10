<?php
include 'db_connect.php';

if(!isset($_GET['order_id'])){

    die("Receipt not found.");

}

$order_id = $_GET['order_id'];

$query = mysqli_query($conn,"

SELECT

orders.*,
books.title,
books.author,

payments.payment_method,
payments.payment_details,
payments.amount

FROM orders

INNER JOIN books
ON orders.book_id=books.book_id

INNER JOIN payments
ON orders.order_id=payments.order_id

WHERE orders.order_id='$order_id'

");

$data=mysqli_fetch_assoc($query);

if(!$data){

    die("Receipt not found.");

}

?>

<!DOCTYPE html>

<html>

<head>

<title>Receipt</title>

<style>

body{

    margin:0;
    font-family:Arial;
    background:#f4f6f8;

}

.container{

    width:700px;

    margin:40px auto;

}

.receipt{

    background:white;

    border-radius:15px;

    overflow:hidden;

    box-shadow:0 5px 15px rgba(0,0,0,.15);

}

.header{

    background:#4CAF50;

    color:white;

    text-align:center;

    padding:25px;

}

.header h1{

    margin:0;

}

.content{

    padding:30px;

}

table{

    width:100%;

    border-collapse:collapse;

}

td{

    padding:12px;

    border-bottom:1px solid #ddd;

}

.label{

    font-weight:bold;

    width:220px;

}

.total{

    font-size:22px;

    color:#4CAF50;

    font-weight:bold;

}

.buttons{

    display:flex;

    gap:15px;

    margin-top:30px;

}

button{

    flex:1;

    padding:15px;

    border:none;

    border-radius:8px;

    cursor:pointer;

    font-size:16px;

}

.print{

    background:#4CAF50;

    color:white;

}

.orders{

    background:#2196F3;

    color:white;

}

button:hover{

    opacity:.9;

}

.footer{

    text-align:center;

    padding:20px;

    color:#777;

}

</style>

</head>

<body>

<?php include 'navbar.php'; ?>

<div class="container">

<div class="receipt">

<div class="header">

<h1>🧾 Payment Receipt</h1>

<p>Thank you for your purchase!</p>

</div>

<div class="content">

<table>

<tr>

<td class="label">

Receipt No.

</td>

<td>

RCP-<?php echo str_pad($data['order_id'],6,"0",STR_PAD_LEFT); ?>

</td>

</tr>

<tr>

<td class="label">

Order ID

</td>

<td>

<?php echo $data['order_id']; ?>

</td>

</tr>

<tr>

<td class="label">

Book

</td>

<td>

<?php echo $data['title']; ?>

</td>

</tr>

<tr>

<td class="label">

Author

</td>

<td>

<?php echo $data['author']; ?>

</td>

</tr>

<tr>

<td class="label">

Quantity

</td>

<td>

<?php echo $data['quantity']; ?>

</td>

</tr>

<tr>

<td class="label">

Payment Method

</td>

<td>

<?php echo $data['payment_method']; ?>

</td>

</tr>

<tr>

<td class="label">

Payment Details

</td>

<td>

<?php echo $data['payment_details']; ?>

</td>

</tr>

<tr>

<td class="label">

Status

</td>

<td>

✅ Paid

</td>

</tr>

<tr>

<td class="label">

Total Paid

</td>

<td class="total">

₱<?php echo number_format($data['amount'],2); ?>

</td>

</tr>

</table>

<div class="buttons">

<button

class="print"

onclick="window.print()">

🖨 Print Receipt

</button>

<button

class="orders"

onclick="location.href='orders.php'">

📦 My Orders

</button>

</div>

</div>

<div class="footer">

Book Store Management System

</div>

</div>

</div>

</body>

</html>