<?php
declare(strict_types=1);

$sceneId = $_GET['scene'] ?? 'scene_01';
$sceneId = basename($sceneId);

$file = __DIR__ . '/content/' . $sceneId . '.json';

if (!file_exists($file)) {
    http_response_code(404);
    die('Scene not found.');
}

$json = file_get_contents($file);
$data = json_decode($json, true);

if (!$data || !isset($data['title'], $data['text'], $data['choices'])) {
    http_response_code(500);
    die('Invalid scene data.');
}

function e(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

$title = $data['title'] ?? 'Untitled Scene';
$subtitle = $data['subtitle'] ?? '';
$act = $data['act'] ?? '';
$location = $data['location'] ?? '';
$character = $data['character'] ?? '';
$image = $data['image'] ?? '';
$music = $data['music'] ?? '';
$textBlocks = $data['text'] ?? [];
$choices = $data['choices'] ?? [];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title) ?> | Les Ombres de Valdremor</title>
    <link rel="stylesheet" href="page_style.css">
</head>
<body>
    <div class="embers" id="embers"></div>

    <main class="page">
        <header class="topbar">
            <div class="nav-left">
                <a class="nav-link" href="index.php">Return</a>
            </div>

            <div class="nav-center">
                <a class="nav-title" href="about.php">About</a>
            </div>

            <div class="nav-right">
                <a class="nav-link" href="profile.php">Profile</a>
                <div class="profile-dot" aria-hidden="true"></div>
            </div>
        </header>

        <section class="main-layout">
            <article class="panel">
                <div class="panel-inner">
                    <div class="scene-meta">
                        <?php if ($act !== ''): ?>
                            <span class="meta-pill"><?= e($act) ?></span>
                        <?php endif; ?>

                        <?php if ($location !== ''): ?>
                            <span class="meta-pill"><?= e($location) ?></span>
                        <?php endif; ?>

                        <?php if ($character !== ''): ?>
                            <span class="meta-pill"><?= e($character) ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="scene-heading">
                        <h1><?= e($title) ?></h1>
                        <?php if ($subtitle !== ''): ?>
                            <p><?= e($subtitle) ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="scene-image-box">
                        <?php if ($image !== ''): ?>
                            <img src="<?= e($image) ?>" alt="<?= e($title) ?>">
                        <?php else: ?>
                            <div class="scene-image-placeholder">
                                No scene image
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="story-box">
                        <?php foreach ($textBlocks as $paragraph): ?>
                            <p><?= e((string)$paragraph) ?></p>
                        <?php endforeach; ?>
                    </div>

                    <?php if ($music !== ''): ?>
                        <div class="music-box">
                            <p>Scene music</p>
                            <audio controls loop>
                                <source src="<?= e($music) ?>">
                                Your browser does not support audio.
                            </audio>
                        </div>
                    <?php endif; ?>
                </div>
            </article>

            <aside class="panel">
                <div class="panel-inner choices-panel">
                    <h2 class="choices-panel-title">Choices</h2>

                    <?php foreach ($choices as $choice): ?>
                        <a class="choice" href="scene.php?scene=<?= urlencode($choice['target']) ?>">
                            <div class="choice-left">
                                <span class="choice-badge"><?= e($choice['label'] ?? '?') ?></span>
                                <span class="choice-text"><?= e($choice['text'] ?? 'Untitled choice') ?></span>
                            </div>
                            <span class="choice-arrow">→</span>
                        </a>
                    <?php endforeach; ?>

                    <p class="footer-note">Les Ombres de Valdremor • prototype narratif</p>
                </div>
            </aside>
        </section>
    </main>

    <script>
        const emberContainer = document.getElementById('embers');
        const emberCount = 24;

        for (let i = 0; i < emberCount; i++) {
            const ember = document.createElement('span');
            ember.className = 'ember';
            ember.style.left = Math.random() * 100 + 'vw';
            ember.style.animationDuration = (7 + Math.random() * 8) + 's';
            ember.style.animationDelay = (Math.random() * 6) + 's';
            ember.style.opacity = (0.22 + Math.random() * 0.5).toFixed(2);
            ember.style.transform = `scale(${0.7 + Math.random() * 0.9})`;
            emberContainer.appendChild(ember);
        }

        const imageBox = document.querySelector('.scene-image-box img');
        if (imageBox) {
            imageBox.addEventListener('mousemove', (event) => {
                const rect = imageBox.getBoundingClientRect();
                const x = (event.clientX - rect.left) / rect.width;
                const y = (event.clientY - rect.top) / rect.height;

                const rotateY = (x - 0.5) * 4;
                const rotateX = (0.5 - y) * 4;

                imageBox.style.transform = `scale(1.02) rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
                imageBox.style.transition = 'transform 0.12s ease';
            });

            imageBox.addEventListener('mouseleave', () => {
                imageBox.style.transform = 'scale(1) rotateX(0deg) rotateY(0deg)';
                imageBox.style.transition = 'transform 0.25s ease';
            });
        }
    </script>
</body>
</html>