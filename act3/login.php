<?php
session_start();

// Check if the user is already logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header('Location: index.php');
    exit;
}

$login_error = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hardcoded credentials
    if ($username == 'shnnamons' && $password == 'monmamon') {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        header('Location: index.php');
        exit;
    } else {
        $login_error = 'Incorrect username or password.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Video Rental System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Parkinsans" rel="stylesheet" />
    <link rel="stylesheet" href="style.css">
</head>

<body class="login-page">

    <div class="login-box">
        <div class="login-logo">
            <a href="#"><b>Video</b>Rental System</a>
        </div>

        <div class="card login-card">
            <div class="card-body">
                <p class="login-box-msg">Sign in to start your session</p>

                <?php if (!empty($login_error)): ?>
                    <div class="alert alert-danger text-center"><?php echo $login_error; ?></div>
                <?php endif; ?>

                <form action="login.php" method="POST">
                    <div class="form-group login-group">
                        <label for="username">Username</label>
                        <div class="input-wrapper">
                            <input type="text" id="username" name="username" class="form-control" placeholder="Username"
                                required>
                            <i class="fas fa-user input-icon"></i>
                        </div>
                    </div>

                    <div class="form-group login-group">
                        <label for="password">Password</label>
                        <div class="input-wrapper">
                            <input type="password" id="password" name="password" class="form-control"
                                placeholder="Password" required>
                            <i class="fas fa-lock input-icon"></i>
                        </div>
                    </div>

                    <div class="login-actions">
                        <div class="remember-me">
                            <input type="checkbox" id="remember">
                            <label encoding="UTF-8" for="remember">Remember Me</label>
                        </div>
                        <button type="submit" class="btn btn-info btn-block">Sign In</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>