<?php
include 'db_connect.php';

$order_id = $_POST['order_id'];
$payment_method = $_POST['payment_method'];

$getOrder = mysqli_query($conn,

"SELECT * FROM orders

WHERE order_id='$order_id'");

$order = mysqli_fetch_assoc($getOrder);

if(isset($_POST['payNow'])){

    $order_id = $_POST['order_id'];
    $payment_method = $_POST['payment_method'];
    $payment_details = $_POST['payment_details'];
    $amount = $_POST['amount'];

    mysqli_query($conn,

    "INSERT INTO payments

    (order_id,payment_method,payment_details,amount,payment_status)

    VALUES

    ('$order_id',
    '$payment_method',
    '$payment_details',
    '$amount',
    'Paid')");

    mysqli_query($conn,

    "UPDATE orders

    SET order_status='Confirmed'

    WHERE order_id='$order_id'");

    header("Location: receipt.php");

    exit();

}

?>

<!DOCTYPE html>
<html>

<head>

<title>Payment Details</title>

<style>

body{
font-family:Arial;
background:#f5f5f5;
padding:30px;
}

.container{
width:500px;
margin:auto;
background:white;
padding:20px;
border-radius:10px;
box-shadow:0 0 10px rgba(0,0,0,.15);
}

input,button{
width:100%;
padding:10px;
margin-top:10px;
}

button{
background:#4CAF50;
color:white;
border:none;
cursor:pointer;
}

</style>

</head>

<body>

<div class="container">

<h2>

<?php echo $payment_method; ?>

Payment

</h2>

<form method="POST">

<input
type="hidden"
name="order_id"
value="<?php echo $order_id; ?>">

<input
type="hidden"
name="payment_method"
value="<?php echo $payment_method; ?>">

<input
type="hidden"
name="amount"
value="<?php echo $order['total_amount']; ?>">

<?php

if($payment_method=="GCash"){

?>

<label>GCash Number</label>

<input
type="text"
name="payment_details"
placeholder="09XXXXXXXXX"
required>

<?php

}

elseif($payment_method=="Maya"){

?>

<label>Maya Number</label>

<input
type="text"
name="payment_details"
placeholder="09XXXXXXXXX"
required>

<?php

}

elseif($payment_method=="Credit Card" || $payment_method=="Debit Card"){

?>

<label>Card Number</label>

<input
type="text"
name="payment_details"
placeholder="XXXX XXXX XXXX XXXX"
required>

<?php

}

else{

?>

<label>Payment Details</label>

<input
type="text"
name="payment_details"
value="Cash on Delivery"
readonly>

<?php

}

?>

<button
type="submit"
name="payNow">

Pay Now

</button>

</form>

</div>

</body>

</html>