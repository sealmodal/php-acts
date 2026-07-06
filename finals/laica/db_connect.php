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