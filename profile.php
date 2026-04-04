<?php
require_once __DIR__ . '/includes/functions.php';
requireLogin();

// Load the connected user before rendering the page.
$user = currentUser();

$pageTitle = 'HistInt - Profil';
$showNavigation = true;
$sceneJavaScript = false;

require __DIR__ . '/includes/header.php';
?>

<section class="profile-page">
    <div class="panel">
        <div class="panel-inner">
            <h1>Votre profil</h1>
            <p>Bienvenue sur votre profil ! Ici, vous pouvez voir votre progression dans l'histoire et gérer vos paramètres.</p>
            <?php if ($user): ?>
                <p>Username: <?= e($user['username']) ?></p>
                <p>Current Scene: <?= e($user['current_scene']) ?></p>
            <?php else: ?>
                <p>Aucun utilisateur connecté.</p>
            <?php endif; ?>
            <?php if ($user && $user['username'] == 'admin'){ 
             echo    "<h2>Données de la scène actuelle (admin)</h2>"; 
            echo "<pre>";
            print_r($user);
            echo "</pre>"; 
              }
?>
                <a href="index.php?action=logout" class="btn btn-secondary">Logout</a>             
            <a href="index.php" class="btn btn-secondary">Retour à l'accueil</a>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
