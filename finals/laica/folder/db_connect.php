<div style="background:#4CAF50;padding:15px;">
    <a href="books.php" style="color:white;text-decoration:none;margin-right:20px;">Books</a>

    <a href="orders.php" style="color:white;text-decoration:none;margin-right:20px;">My Orders</a>

    <a href="admin_orders.php" style="color:white;text-decoration:none;">Admin Orders</a>
</div>

<?php

$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "bookstore_db"
);

if(!$conn){
    die("Connection Failed");
}

?>