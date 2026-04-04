<?php
declare(strict_types=1);

session_start();
require __DIR__ . '/includes/functions.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $result = loginUser($username, $password);
    $message = $result['message'];

    if ($result['success']) {
        header('Location: index.php');
        exit;
    }
}

$pageTitle = 'Login';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle) ?></title>
</head>
<body>
    <h1>Login</h1>

    <?php if ($message !== ''): ?>
        <p><?= e($message) ?></p>
    <?php endif; ?>

    <form method="post">
        <label>
            Username
            <input type="text" name="username" required>
        </label>
        <br><br>

        <label>
            Password
            <input type="password" name="password" required>
        </label>
        <br><br>

        <button type="submit">Log in</button>
    </form>

    <p><a href="register.php">Create an account</a></p>
</body>
</html>