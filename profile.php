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
            <p class="profile-intro">Bienvenue sur votre profil. Vous pouvez voir ici où vous en êtes dans l’histoire et reprendre rapidement votre partie.</p>

            <?php if ($user): ?>
                <div class="profile-grid">
                    <article class="profile-card">
                        <p class="profile-label">Compte</p>
                        <h2><?= e($user['username']) ?></h2>
                        <p class="profile-copy">Profil actif et connecté.</p>
                    </article>

                    <article class="profile-card">
                        <p class="profile-label">Progression</p>
                        <h2><?= e($user['current_scene']) ?></h2>
                        <p class="profile-copy">Dernière scène sauvegardée.</p>
                    </article>
                </div>
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
            <div class="profile-actions">
                <a href="scene.php?scene=<?= e($user['current_scene'] ?? 'scene_01') ?>" class="btn btn-primary">Reprendre la partie</a>
                <a href="index.php?action=logout" class="btn btn-secondary">Déconnexion</a>
                <a href="index.php" class="btn btn-secondary">Retour à l'accueil</a>
            </div>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
