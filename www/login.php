<?php
session_start();

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header("Location: index.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $users = json_decode(file_get_contents('users.json'), true);

    if (isset($users[$username]) && password_verify($password, $users[$username]['password'])) {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;
        header("Location: index.php");
        exit;
    } else {
        $error = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Video Sharing App</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/login.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="login-form animated fadeIn">
            <h2 class="text-center mb-4"><i class="fas fa-sign-in-alt"></i> Log in</h2>
            <?php if ($error): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>
            <form action="login.php" method="post">
                <div class="form-group">
                    <label for="username"><i class="fas fa-user"></i> Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Username" required="required">
                </div>
                <div class="form-group">
                    <label for="password"><i class="fas fa-lock"></i> Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Password" required="required">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-sign-in-alt"></i> Log in</button>
                </div>
            </form>
            <p class="text-center">Don't have an account? <a href="register.php">Sign up here</a></p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
