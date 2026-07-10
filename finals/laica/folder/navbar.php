<div class="navbar">

    <div class="logo">
        📚 Book Store
    </div>

    <div class="links">

        <a href="books.php">Books</a>

        <a href="orders.php">My Orders</a>

        <a href="admin_orders.php">Admin</a>

    </div>

</div>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

.navbar{

    width:100%;
    height:70px;

    background:#4CAF50;

    display:flex;
    justify-content:space-between;
    align-items:center;

    padding:0 40px;

    box-shadow:0 3px 10px rgba(0,0,0,.2);

    margin-bottom:30px;

}

.logo{

    color:white;
    font-size:28px;
    font-weight:bold;

}

.links a{

    color:white;
    text-decoration:none;

    margin-left:25px;

    font-size:18px;

    transition:.3s;

}

.links a:hover{

    color:#dfffe0;

}

</style>