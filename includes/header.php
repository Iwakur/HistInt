<?php if (!isset($pageTitle)) $pageTitle = 'Les Ombres de Valdremor'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle) ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="page_style.css">

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
                <a class="nav-link" href="scene.php?scene=scene_01&start=new" title="Restart Story">↻</a>
            </div>

            <div class="nav-center">
                <a class="nav-title" href="about.php">About</a>
            </div>

            <div class="nav-right">
                <a class="nav-link" href="profile.php">Profile</a>
                <div class="profile-dot" aria-hidden="true"></div>
            </div>
        </header>
    <?php endif; ?>
    