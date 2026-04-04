<?php
declare(strict_types=1);

session_start();
require __DIR__ . '/includes/functions.php';

$msg = '';
$isError = false;
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
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
    <link rel="stylesheet" href="assets/css/base/auth_style.css">
</head>
<body class="auth-page">
    <div class="auth-shell">
        <div class="auth-card">
            <div class="auth-card-inner">
                <p class="auth-kicker">HistInt</p>
                <h1>Connexion</h1>
                <p class="auth-intro">Retrouve ta progression et reprends l’histoire là où Kael s’est arrêté.</p>

                <?php if ($msg): ?>
                    <div class="auth-alert <?= $isError ? 'error' : '' ?>" role="alert">
                        <?= e($msg) ?>
                    </div>
                <?php endif; ?>

                <form method="post" class="auth-form">
                    <div class="auth-field">
                        <label for="username">Nom d’utilisateur</label>
                        <input type="text" id="username" name="username" value="<?= e($username) ?>" autocomplete="username" required>
                    </div>

                    <div class="auth-field">
                        <label for="password">Mot de passe</label>
                        <input type="password" id="password" name="password" autocomplete="current-password" required>
                    </div>

                    <button type="submit" class="auth-submit">Se connecter</button>
                </form>

                <div class="auth-link-row">
                    <p>Pas encore de compte ? <a href="register.php">Créer un compte</a></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
