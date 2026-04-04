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
    $result = registerUser($username, $password);

    if ($result['success']) {
        // Auto-login after successful registration
        $login = loginUser($username, $password);
        if ($login['success']) {
            $_SESSION['message'] = 'Account created successfully!';
            header('Location: index.php');
            exit;
        }
    }
    
    $msg = $result['message'];
    $isError = true;
}

$pageTitle = 'Register';
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
                <h1>Créer un compte</h1>
                <p class="auth-intro">Crée un profil pour sauvegarder ta scène actuelle et reprendre plus facilement ton aventure.</p>

                <?php if ($msg): ?>
                    <div class="auth-alert <?= $isError ? 'error' : '' ?>" role="alert">
                        <?= e($msg) ?>
                    </div>
                <?php endif; ?>

                <form method="post" class="auth-form">
                    <div class="auth-field">
                        <label for="username">Nom d’utilisateur</label>
                        <input type="text" id="username" name="username" value="<?= e($username) ?>" autocomplete="username" required>
                        <p class="auth-help">Utilise 3 à 20 caractères avec lettres, chiffres, tiret ou underscore.</p>
                    </div>

                    <div class="auth-field">
                        <label for="password">Mot de passe</label>
                        <input type="password" id="password" name="password" autocomplete="new-password" required>
                    </div>

                    <button type="submit" class="auth-submit">S’inscrire</button>
                </form>

                <div class="auth-link-row">
                    <p>Déjà inscrit ? <a href="login.php">Se connecter</a></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
