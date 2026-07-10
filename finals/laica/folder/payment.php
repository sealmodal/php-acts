<?php
include 'db_connect.php';

// ---------------------------
// Get Book Information
// ---------------------------

if(!isset($_POST['book_id'])){
    header("Location: books.php");
    exit();
}

$book_id = $_POST['book_id'];
$quantity = $_POST['quantity'];

$query = mysqli_query($conn,
"SELECT * FROM books
WHERE book_id='$book_id'");

$book = mysqli_fetch_assoc($query);

if(!$book){
    die("Book not found.");
}

if($quantity > $book['stock']){
    die("Not enough stock available.");
}

$original_price = $book['price'];
$discount = $book['discount'];

$final_price =
$original_price -
($original_price * ($discount/100));

$total_amount =
$final_price * $quantity;


// ---------------------------
// Process Payment
// ---------------------------

if(isset($_POST['payNow'])){

    $payment_method = $_POST['payment_method'];
    $payment_details = $_POST['payment_details'];

    // Create Order

    mysqli_query($conn,"
    INSERT INTO orders
    (
        book_id,
        quantity,
        original_price,
        discount,
        total_amount,
        order_status
    )

    VALUES
    (
        '$book_id',
        '$quantity',
        '$original_price',
        '$discount',
        '$total_amount',
        'Confirmed'
    )
    ");

    $order_id = mysqli_insert_id($conn);

    // Save Payment

    mysqli_query($conn,"
    INSERT INTO payments
    (
        order_id,
        payment_method,
        payment_details,
        amount,
        payment_status
    )

    VALUES
    (
        '$order_id',
        '$payment_method',
        '$payment_details',
        '$total_amount',
        'Paid'
    )
    ");

    // Update Stock

    $newStock =
    $book['stock'] - $quantity;

    mysqli_query($conn,"
    UPDATE books
    SET stock='$newStock'
    WHERE book_id='$book_id'
    ");

    header("Location: receipt.php?order_id=".$order_id);
    exit();

}

?>

<!DOCTYPE html>

<html>

<head>

<title>Checkout</title>

<style>

body{

    margin:0;
    font-family:Arial;
    background:#f4f6f8;

}

.container{

    width:650px;
    margin:40px auto;

    background:white;

    border-radius:15px;

    box-shadow:0 5px 15px rgba(0,0,0,.15);

    overflow:hidden;

}

.header{

    background:#4CAF50;

    color:white;

    padding:20px;

    text-align:center;

    font-size:26px;

}

.content{

    padding:30px;

}

.summary{

    background:#f8f8f8;

    padding:20px;

    border-radius:10px;

    margin-bottom:25px;

}

.summary p{

    margin:8px 0;

}

label{

    font-weight:bold;

}

select,
input{

    width:100%;

    padding:12px;

    margin-top:8px;
    margin-bottom:20px;

    border:1px solid #ccc;

    border-radius:8px;

    font-size:15px;

}

button{

    width:100%;

    padding:15px;

    background:#4CAF50;

    color:white;

    border:none;

    border-radius:8px;

    font-size:18px;

    cursor:pointer;

}

button:hover{

    background:#388E3C;

}

</style>

</head>

<body>

<?php include 'navbar.php'; ?>

<div class="container">

<div class="header">

💳 Checkout

</div>

<div class="content">

<div class="summary">

<h2>Order Summary</h2>

<p>

<b>Book:</b>

<?php echo $book['title']; ?>

</p>

<p>

<b>Author:</b>

<?php echo $book['author']; ?>

</p>

<p>

<b>Quantity:</b>

<?php echo $quantity; ?>

</p>

<p>

<b>Discount:</b>

<?php echo $discount; ?>%

</p>

<p>

<b>Total Amount:</b>

₱<?php echo number_format($total_amount,2); ?>

</p>

</div>

<form method="POST">

<input
type="hidden"
name="book_id"
value="<?php echo $book_id; ?>">

<input
type="hidden"
name="quantity"
value="<?php echo $quantity; ?>">
<label>Payment Method</label>

<select
name="payment_method"
id="payment_method"
required
onchange="changeField()">

<option value="">Select Payment Method</option>

<option value="GCash">GCash</option>

<option value="Maya">Maya</option>

<option value="GrabPay">GrabPay</option>

<option value="BPI Online">BPI Online</option>

<option value="BDO Online">BDO Online</option>

<option value="Credit Card">Credit Card</option>

<option value="Debit Card">Debit Card</option>

<option value="Cash on Delivery">Cash on Delivery</option>

</select>

<div id="dynamicField"></div>

<button
type="submit"
name="payNow">

💳 Pay Now

</button>

</form>

</div>

</div>

<script>

function changeField(){

    let method =
    document.getElementById("payment_method").value;

    let field =
    document.getElementById("dynamicField");

    if(method=="GCash"){

        field.innerHTML=
        '<label>GCash Number</label><input type="text" name="payment_details" placeholder="09XXXXXXXXX" required>';

    }

    else if(method=="Maya"){

        field.innerHTML=
        '<label>Maya Number</label><input type="text" name="payment_details" placeholder="09XXXXXXXXX" required>';

    }

    else if(method=="GrabPay"){

        field.innerHTML=
        '<label>GrabPay Number</label><input type="text" name="payment_details" placeholder="09XXXXXXXXX" required>';

    }

    else if(method=="Credit Card"){

        field.innerHTML=
        '<label>Card Number</label><input type="text" name="payment_details" placeholder="1234 5678 9012 3456" required>';

    }

    else if(method=="Debit Card"){

        field.innerHTML=
        '<label>Debit Card Number</label><input type="text" name="payment_details" placeholder="1234 5678 9012 3456" required>';

    }

    else if(method=="BPI Online"){

        field.innerHTML=
        '<label>BPI Account Number</label><input type="text" name="payment_details" placeholder="BPI Account Number" required>';

    }

    else if(method=="BDO Online"){

        field.innerHTML=
        '<label>BDO Account Number</label><input type="text" name="payment_details" placeholder="BDO Account Number" required>';

    }

    else if(method=="Cash on Delivery"){

        field.innerHTML=
        '<label>Payment Details</label><input type="text" name="payment_details" value="Cash on Delivery" readonly>';

    }

    else{

        field.innerHTML="";

    }

}

</script>

</body>

</html>