<?php
session_start();
require_once 'inc/User.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = new User();
    $userId = $user->login($_POST['username'], $_POST['password']);
    if ($userId) {
        $_SESSION['user_id'] = $userId;
        $_SESSION['username'] = $_POST['username'];
        header('Location: chat.php');
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="auth-container">
        <h2>Login</h2>
        <form method="POST" class="auth-form">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <p class="error-message"><?= isset($error) ? htmlspecialchars($error) : '' ?></p>
        <p>Don't have an account? <a href="register.php">Register here</a>.</p>
    </div>
</body>
</html>
