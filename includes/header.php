<?php
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle) ?></title>
    <link rel="stylesheet" href="assets/css/base/index_style.css">
    <link rel="stylesheet" href="assets/css/base/scene_style.css">
    <link rel="icon" href="assets/specials/favicon.png" type="image/png">
    <script src="assets/js/main.js"></script>

</head>
<body>
    <div class="embers" id="embers"></div>

    <?php if (isset($showNavigation) && $showNavigation): ?>
    <main class="page">
        <header class="topbar">
            <div class="nav-left">
                <?php if (isset($previousScene) && $previousScene): ?>
                    <a class="nav-link" href="scene.php?scene=<?= urlencode($previousScene) ?>&from_back=1">← Back</a>
                <?php else: ?>
                    <a class="nav-link" href="index.php">Return</a>
                <?php endif; ?>
            </div>

            <div class="nav-center">
                <a class="nav-title" href="index.php">About</a>
            </div>

            <div class="nav-right">
                <a class="nav-link" href="profile.php">Profile</a>
                <div class="profile-dot" aria-hidden="true"></div>
            </div>
        </header>
    <?php endif; ?>
