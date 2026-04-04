<?php
declare(strict_types=1);

session_start();
require __DIR__ . '/includes/functions.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $result = registerUser($username, $password);
    $message = $result['message'];

    if ($result['success']) {
        $login = loginUser($username, $password);

        if ($login['success']) {
            header('Location: index.php');
            exit;
        }
    }
}

$pageTitle = 'Register';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle) ?></title>
</head>
<body>
    <h1>Create account</h1>

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

        <button type="submit">Register</button>
    </form>

    <p><a href="login.php">Already have an account?</a></p>
</body>
</html>