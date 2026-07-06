<?php

include 'db_connect.php';

$getReceipt = mysqli_query($conn,

"SELECT *

FROM payments

ORDER BY payment_id DESC

LIMIT 1");

$data = mysqli_fetch_assoc($getReceipt);

?>

<!DOCTYPE html>

<html>

<head>

<title>

Receipt

</title>

<style>

body{

font-family:Arial;

width:500px;

margin:auto;

margin-top:40px;

}

.receipt{

border:1px solid gray;

padding:20px;

}

</style>

</head>

<body>

<div class="receipt">

<h2>

BOOKSTORE RECEIPT

</h2>

<hr>

<p>

Payment ID :

<?php

echo $data['payment_id'];

?>

</p>

<p>

Order ID :

<?php

echo $data['order_id'];

?>

</p>

<p>

Payment Method :

<?php

echo $data['payment_method'];

?>

</p>

<p>

Amount :

₱<?php

echo number_format($data['amount'],2);

?>

</p>

<p>

Payment Status :

<?php

echo $data['payment_status'];

?>

</p>

<p>

Date :

<?php

echo $data['payment_date'];

?>

</p>

<hr>

<h3>

Payment Successful!

</h3>

</div>

</body>

</html>