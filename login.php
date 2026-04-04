<?php
declare(strict_types=1);

session_start();
require __DIR__ . '/includes/functions.php';

$msg = '';
$isError = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $result = loginUser($username, $password);
    
    if ($result['success']) {
        $_SESSION['message'] = 'Welcome back!';
        header('Location: index.php');
        exit;
    }
    
    $msg = $result['message'];
    $isError = true;
}

$pageTitle = 'Login';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle) ?></title>
    <style>
        body { font-family: Georgia, serif; max-width: 600px; margin: 50px auto; color: #f0e6d2; background: #0d0a08; }
        .container { background: rgba(28, 22, 17, 0.88); padding: 2rem; border-radius: 12px; }
        h1 { color: #e3c890; }
        label { display: block; margin-bottom: 0.3rem; font-weight: bold; }
        input { width: 100%; padding: 0.6rem; margin-bottom: 1.2rem; background: rgba(255, 255, 255, 0.1); border: 1px solid #c9a668; color: #f0e6d2; border-radius: 6px; }
        button { background: #c9a668; color: #1b140d; padding: 0.8rem 2rem; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; width: 100%; }
        button:hover { opacity: 0.9; }
        .message { padding: 1rem; margin-bottom: 1rem; border-radius: 6px; }
        .error { background: rgba(200, 50, 50, 0.2); color: #ff9999; }
        .register { margin-top: 1rem; text-align: center; }
        .register a { color: #e3c890; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Login</h1>

        <?php if ($msg): ?>
            <div class="message <?= $isError ? 'error' : '' ?>">
                <?= e($msg) ?>
            </div>
        <?php endif; ?>

        <form method="post">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Log in</button>
        </form>

        <div class="register">
            <p>Don't have an account? <a href="register.php">Create one</a></p>
        </div>
    </div>
</body>
</html>