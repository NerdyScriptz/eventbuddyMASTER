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
    $confirm_password = $_POST['confirm_password'];

    if ($password === $confirm_password) {
        $users = json_decode(file_get_contents('users.json'), true);

        if (!isset($users[$username])) {
            $users[$username] = [
                'password' => password_hash($password, PASSWORD_DEFAULT)
            ];
            file_put_contents('users.json', json_encode($users));

            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $username;
            header("Location: index.php");
            exit;
        } else {
            $error = "Username already taken!";
        }
    } else {
        $error = "Passwords do not match!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Video Sharing App</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/register.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container d-flex align-items-center justify-content-center min-vh-100">
        <div class="register-form animated fadeIn">
            <h2 class="text-center mb-4"><i class="fas fa-user-plus"></i> Register</h2>
            <?php if ($error): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>
            <form action="register.php" method="post">
                <div class="form-group">
                    <label for="username"><i class="fas fa-user"></i> Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Username" required="required">
                </div>
                <div class="form-group">
                    <label for="password"><i class="fas fa-lock"></i> Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Password" required="required">
                </div>
                <div class="form-group">
                    <label for="confirm_password"><i class="fas fa-lock"></i> Confirm Password</label>
                    <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" required="required">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-user-plus"></i> Register</button>
                </div>
            </form>
            <p class="text-center">Already have an account? <a href="login.php">Log in here</a></p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
