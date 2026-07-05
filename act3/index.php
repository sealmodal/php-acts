<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

if (!isset($_SESSION['alert'])) {
    $_SESSION['alert'] = null;
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['videos'])) {
    $_SESSION['videos'] = array();
}

require 'functions.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Rental System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Parkinsans" rel="stylesheet" />
    <link rel="stylesheet" href="style.css">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php include 'menu.php'; ?>

        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    <?php
                    $page = $_GET['page'] ?? 'home';
                    switch ($page) {
                        case 'add':
                            include 'add.php';
                            break;
                        case 'edit':
                            include 'edit.php';
                            break;
                        case 'delete':
                            include 'delete.php';
                            break;
                        case 'view':
                            include 'view.php';
                            break;
                        case 'view_single':
                            include 'view_single.php';
                            break;
                        default:
                            echo '<div class="alert alert-info">Welcome to the Video Rental System!</div>';
                            break;
                    }
                    ?>
                </div>
            </section>

            <footer class="main-footer">
                <strong>Copyright &copy; 2026</strong>
                <span>All rights reserved.</span>
            </footer>
        </div>
    </div>
</body>

</html>