<?php
include 'db_connect.php';

$search = "";

if(isset($_GET['search'])){
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $books = mysqli_query($conn,
    "SELECT * FROM books
    WHERE title LIKE '%$search%'
    OR author LIKE '%$search%'
    OR category LIKE '%$search%'");
}
else{
    $books = mysqli_query($conn,"SELECT * FROM books");
}
?>

<!DOCTYPE html>
<html>

<head>

<title>Book Store</title>

<style>

body{
    font-family:Arial, Helvetica, sans-serif;
    background:#f4f6f8;
    margin:0;
}

.container{
    width:95%;
    margin:auto;
}

.page-title{
    text-align:center;
    margin:30px 0;
    color:#333;
}

.search-box{
    width:100%;
    display:flex;
    justify-content:center;
    margin-bottom:35px;
}

.search-box form{
    display:flex;
    width:60%;
}

.search-box input{

    width:100%;
    padding:12px;
    border:1px solid #ccc;
    border-radius:8px 0 0 8px;
    font-size:16px;

}

.search-box button{

    width:150px;
    border:none;
    background:#4CAF50;
    color:white;
    border-radius:0 8px 8px 0;
    cursor:pointer;
    font-size:16px;

}

.search-box button:hover{

    background:#388E3C;

}

.books{

    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
    gap:25px;

}

.card{

    background:white;
    border-radius:15px;
    overflow:hidden;
    box-shadow:0 4px 15px rgba(0,0,0,.12);
    transition:.3s;

}

.card:hover{

    transform:translateY(-6px);

}

.cover{

    height:220px;
    background:#e8f5e9;
    display:flex;
    justify-content:center;
    align-items:center;
    font-size:90px;

}

.info{

    padding:20px;

}

.title{

    font-size:22px;
    font-weight:bold;
    margin-bottom:10px;
    color:#222;

}

.author{

    color:#666;
    margin-bottom:8px;

}

.category{

    display:inline-block;
    background:#4CAF50;
    color:white;
    padding:5px 12px;
    border-radius:20px;
    font-size:13px;
    margin-bottom:12px;

}

.rating{

    color:#ffb400;
    margin:12px 0;

}

.old-price{

    color:red;
    text-decoration:line-through;

}

.discount{

    color:#2E7D32;
    font-weight:bold;
    margin-top:5px;

}

.final{

    font-size:22px;
    color:#222;
    font-weight:bold;
    margin:15px 0;

}

.stock{

    margin-bottom:15px;
    font-weight:bold;

}

.instock{

    color:green;

}

.lowstock{

    color:#d68910;

}

.outstock{

    color:red;

}

.buy-btn{

    width:100%;
    padding:12px;
    border:none;
    border-radius:8px;
    background:#4CAF50;
    color:white;
    font-size:16px;
    cursor:pointer;

}

.buy-btn:hover{

    background:#2E7D32;

}

.disabled{

    width:100%;
    padding:12px;
    border:none;
    border-radius:8px;
    background:red;
    color:white;
    cursor:not-allowed;

}

</style>

</head>

<body>

<?php include 'navbar.php'; ?>

<div class="container">

<h1 class="page-title">📚 Welcome to Book Store</h1>

<div class="search-box">

<form method="GET">

<input
type="text"
name="search"
placeholder="Search books, author or category..."
value="<?php echo htmlspecialchars($search); ?>">

<button>

🔍 Search

</button>

</form>

</div>

<div class="books">

<?php

while($row=mysqli_fetch_assoc($books)){

$finalPrice=$row['price']-
($row['price']*($row['discount']/100));

?>

<div class="card">

<div class="cover">

📚

</div>

<div class="info">

<div class="title">

<?php echo $row['title']; ?>

</div>

<div class="author">

by <?php echo $row['author']; ?>

</div>

<div class="category">

<?php echo $row['category']; ?>

</div>

<div class="rating">

⭐⭐⭐⭐☆

</div>

<div class="old-price">

₱<?php echo number_format($row['price'],2); ?>

</div>

<div class="discount">

🏷 <?php echo $row['discount']; ?>% OFF

</div>

<div class="final">

₱<?php echo number_format($finalPrice,2); ?>

</div>

<div class="stock">

<?php

if($row['stock']>5){

echo "<span class='instock'>🟢 In Stock (".$row['stock'].")</span>";

}

elseif($row['stock']>0){

echo "<span class='lowstock'>🟡 Low Stock (".$row['stock'].")</span>";

}

else{

echo "<span class='outstock'>🔴 Out of Stock</span>";

}

?>

</div>

<?php

if($row['stock']>0){

?>

<form action="buy.php" method="POST">

<input
type="hidden"
name="book_id"
value="<?php echo $row['book_id']; ?>">

<button class="buy-btn">

🛒 Buy Now

</button>

</form>

<?php

}else{

?>

<button class="disabled">

Out of Stock

</button>

<?php

}

?>

</div>

</div>

<?php

}

?>

</div>

</div>

</body>

</html>