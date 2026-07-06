<?php
include 'db_connect.php';

// Inventory Report
$inventory = mysqli_query($conn,
"SELECT * FROM books");

// Sales Report
$sales = mysqli_query($conn,
"SELECT * FROM orders");

// Customer Report
$customers = mysqli_query($conn,
"SELECT * FROM customers");

// Payment Report
$payments = mysqli_query($conn,
"SELECT * FROM payments");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reports</title>
</head>

<body>

<h2>Inventory Report</h2>

<table border="1">

<tr>
    <th>Book ID</th>
    <th>Title</th>
    <th>Stock</th>
</tr>

<?php

while($row = mysqli_fetch_assoc($inventory)){

?>

<tr>

<td><?php echo $row['book_id']; ?></td>
<td><?php echo $row['title']; ?></td>
<td><?php echo $row['stock']; ?></td>

</tr>

<?php

}

?>

</table>

</body>
</html>