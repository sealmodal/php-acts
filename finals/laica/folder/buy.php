<?php
include 'db_connect.php';

if(!isset($_POST['book_id'])){
    header("Location: books.php");
    exit();
}

$book_id = intval($_POST['book_id']);

$query = mysqli_query($conn,"
SELECT *
FROM books
WHERE book_id='$book_id'
");

$book = mysqli_fetch_assoc($query);

if(!$book){
    die("Book not found.");
}

if($book['stock'] <= 0){
    die("Sorry! This book is currently out of stock.");
}

$discountedPrice =
$book['price'] -
($book['price'] * ($book['discount']/100));
?>

<!DOCTYPE html>

<html>

<head>

<title>Buy Book</title>

<style>

body{
    margin:0;
    font-family:Arial;
    background:#f4f6f8;
}

.container{
    width:1000px;
    margin:40px auto;
}

.product{
    background:white;
    border-radius:15px;
    box-shadow:0 4px 15px rgba(0,0,0,.15);
    display:flex;
    overflow:hidden;
}

.image{
    width:350px;
    height:500px;
    background:#e8f5e9;
    display:flex;
    justify-content:center;
    align-items:center;
    font-size:150px;
}

.details{
    flex:1;
    padding:35px;
}

.details h1{
    margin-top:0;
    color:#333;
}

.author{
    color:#777;
    margin-bottom:15px;
}

.category{
    display:inline-block;
    background:#4CAF50;
    color:white;
    padding:6px 15px;
    border-radius:20px;
    margin-bottom:15px;
}

.rating{
    color:#ffb400;
    margin-bottom:20px;
}

.old-price{
    color:red;
    text-decoration:line-through;
    font-size:18px;
}

.discount{
    color:green;
    font-weight:bold;
    margin-top:8px;
}

.final{
    font-size:32px;
    font-weight:bold;
    margin:20px 0;
}

.stock{
    margin-bottom:25px;
    font-weight:bold;
}

.quantity-box{
    display:flex;
    align-items:center;
    gap:15px;
    margin-bottom:30px;
}

.quantity-box button{
    width:40px;
    height:40px;
    border:none;
    background:#4CAF50;
    color:white;
    font-size:22px;
    cursor:pointer;
    border-radius:6px;
}

.quantity-box input{
    width:60px;
    text-align:center;
    font-size:18px;
    height:40px;
}

.summary{
    background:#f8f8f8;
    padding:15px;
    border-radius:10px;
    margin-bottom:25px;
}

.checkout{
    width:100%;
    padding:15px;
    background:#4CAF50;
    color:white;
    border:none;
    border-radius:8px;
    font-size:18px;
    cursor:pointer;
}

.checkout:hover{
    background:#388E3C;
}

</style>

</head>

<body>

<?php include 'navbar.php'; ?>

<div class="container">

<div class="product">

<div class="image">

📚

</div>

<div class="details">

<h1><?php echo $book['title']; ?></h1>

<div class="author">
by <?php echo $book['author']; ?>
</div>

<div class="category">
<?php echo $book['category']; ?>
</div>

<div class="rating">
⭐⭐⭐⭐☆
</div>

<div class="old-price">
₱<?php echo number_format($book['price'],2); ?>
</div>

<div class="discount">
🏷 <?php echo $book['discount']; ?>% OFF
</div>

<div class="final">
₱<span id="price">
<?php echo number_format($discountedPrice,2); ?>
</span>
</div>

<div class="stock">
Available Stock:
<b><?php echo $book['stock']; ?></b>
</div>

<form action="payment.php" method="POST">

<input
type="hidden"
name="book_id"
value="<?php echo $book['book_id']; ?>">

<input
type="hidden"
name="price"
value="<?php echo $discountedPrice; ?>">

<input
type="hidden"
name="discount"
value="<?php echo $book['discount']; ?>">

<div class="quantity-box">

<label>

<b>Quantity</b>

</label>

<button
type="button"
onclick="minus()">

-

</button>

<input
type="number"
name="quantity"
id="qty"
value="1"
min="1"
max="<?php echo $book['stock']; ?>"
readonly>

<button
type="button"
onclick="plus()">

+

</button>

</div>

<div class="summary">

<p>

<b>Original Price:</b>

₱<?php echo number_format($book['price'],2); ?>

</p>

<p>

<b>Discount:</b>

<?php echo $book['discount']; ?>%

</p>

<p>

<b>Price per Book:</b>

₱<span id="unitPrice">

<?php echo number_format($discountedPrice,2); ?>

</span>

</p>

<hr>

<h2>

Total:

₱<span id="total">

<?php echo number_format($discountedPrice,2); ?>

</span>

</h2>

</div>

<button
type="submit"
class="checkout">

🛒 Proceed to Checkout

</button>

</form>

</div>

</div>

</div>

<script>

let qty =
document.getElementById("qty");

let stock =
<?php echo $book['stock']; ?>;

let price =
<?php echo $discountedPrice; ?>;

function updateTotal(){

    document.getElementById("total").innerHTML =
    (qty.value * price).toFixed(2);

}

function plus(){

    if(parseInt(qty.value) < stock){

        qty.value++;

        updateTotal();

    }

}

function minus(){

    if(parseInt(qty.value) > 1){

        qty.value--;

        updateTotal();

    }

}

</script>

</body>

</html>