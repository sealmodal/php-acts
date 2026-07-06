<?php

include 'db_connect.php';

$message = "";


$getOrder = mysqli_query($conn,
"SELECT * FROM orders
WHERE order_status='Pending'
ORDER BY order_id DESC
LIMIT 1");

$order = mysqli_fetch_assoc($getOrder);

$order_id = $order['order_id'];
$amount = $order['total_amount'];

if(isset($_POST['confirmPayment'])){

    $payment_method = $_POST['payment_method'];

    if(empty($payment_method)){

        $message = "Please select a payment method.";

    }

    else{

        $insert = "INSERT INTO payments
        (order_id,payment_method,amount,payment_status)

        VALUES

        ('$order_id',
        '$payment_method',
        '$amount',
        'Paid')";

        mysqli_query($conn,$insert);

        $update = "UPDATE orders

        SET order_status='Paid'

        WHERE order_id='$order_id'";

        mysqli_query($conn,$update);

        header("Location: receipt.php");

        exit();

    }

}

?>

<!DOCTYPE html>

<html>

<head>

<title>Payment</title>

<style>

body{

font-family:Arial;

width:500px;

margin:auto;

margin-top:40px;

}

select,button{

width:100%;

padding:10px;

margin-top:10px;

}

.box{

border:1px solid gray;

padding:20px;

}

</style>

</head>

<body>

<div class="box">

<h2>Checkout Payment</h2>

<p>

<b>Order ID:</b>

<?php echo $order_id; ?>

</p>

<p>

<b>Total Amount:</b>

₱<?php echo number_format($amount,2); ?>

</p>

<form method="POST">

<label>

Payment Method

</label>

<select name="payment_method" required>

<option value="">

Select Payment Method

</option>

<option>

GCash

</option>

<option>

Maya

</option>

<option>

GoTyme Bank

</option>

<option>

BPI Online

</option>

<option>

BDO Online

</option>

<option>

UnionBank Online

</option>

<option>

Cash on Delivery

</option>

<option>

Credit Card

</option>

<option>

Debit Card

</option>

</select>

<br>

<button

type="submit"

name="confirmPayment">

Confirm Payment

</button>

</form>

<br>

<?php

echo $message;

?>

</div>

</body>

</html>