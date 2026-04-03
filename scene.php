<?php
declare(strict_types=1);

// Start session for tracking scene history
session_start();

// Clear history if starting a new story
if (isset($_GET['start']) && $_GET['start'] === 'new') {
    $_SESSION['scene_history'] = [];
}

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

// Initialize scene history if not exists
if (!isset($_SESSION['scene_history'])) {
    $_SESSION['scene_history'] = [];
}

// Handle navigation: if coming from a back action, trim history to current position
if (isset($_GET['from_back']) && $_GET['from_back'] === '1') {
    // Remove scenes after current position if going back
    $currentIndex = array_search($sceneId, $_SESSION['scene_history']);
    if ($currentIndex !== false) {
        $_SESSION['scene_history'] = array_slice($_SESSION['scene_history'], 0, $currentIndex + 1);
    }
} else {
    // Add current scene to history (avoid duplicates at the end)
    $lastScene = end($_SESSION['scene_history']);
    if ($lastScene !== $sceneId) {
        $_SESSION['scene_history'][] = $sceneId;
    }
}

// Get previous scene for back button
$previousScene = null;
$historyCount = count($_SESSION['scene_history']);
if ($historyCount > 1) {
    $currentIndex = array_search($sceneId, $_SESSION['scene_history']);
    if ($currentIndex > 0) {
        $previousScene = $_SESSION['scene_history'][$currentIndex - 1];
    }
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

$pageTitle = $title . ' | Les Ombres de Valdremor';
$showNavigation = true;
$sceneJavaScript = true;

require __DIR__ . '/includes/header.php';
?>

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

<?php require __DIR__ . '/includes/footer.php'; ?>