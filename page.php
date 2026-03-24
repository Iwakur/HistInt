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
    <style>
        :root {
            --bg: #0f0d0b;
            --panel: rgba(33, 27, 22, 0.92);
            --panel-soft: rgba(48, 40, 33, 0.88);
            --panel-light: rgba(70, 58, 48, 0.72);
            --border: rgba(201, 166, 104, 0.20);
            --border-strong: rgba(201, 166, 104, 0.40);
            --text: #f0e6d2;
            --muted: #b8a78e;
            --gold: #c9a668;
            --gold-soft: #e3c890;
            --shadow: rgba(0, 0, 0, 0.35);
        }

        * {
            box-sizing: border-box;
        }

        html, body {
            margin: 0;
            min-height: 100%;
            background:
                radial-gradient(circle at top, rgba(120, 61, 38, 0.20), transparent 30%),
                linear-gradient(180deg, #17120e, var(--bg));
            color: var(--text);
            font-family: Georgia, "Times New Roman", serif;
        }

        body {
            padding: 0;
            overflow-x: hidden;
        }

        .embers {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 0;
            overflow: hidden;
        }

        .ember {
            position: absolute;
            bottom: -24px;
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: radial-gradient(circle, #ffd18c 0%, #d87232 60%, transparent 80%);
            opacity: 0.5;
            animation: rise linear infinite;
        }

        @keyframes rise {
            0% {
                transform: translateY(0) translateX(0) scale(0.8);
                opacity: 0;
            }
            15% {
                opacity: 0.65;
            }
            100% {
                transform: translateY(-110vh) translateX(30px) scale(1.2);
                opacity: 0;
            }
        }

        .page {
            position: relative;
            z-index: 1;
            width: min(1200px, calc(100% - 2rem));
            margin: 0 auto;
            padding: 1rem 0 2rem;
        }

        .topbar {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            align-items: center;
            gap: 1rem;
            background: rgba(220, 210, 193, 0.10);
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 0.9rem 1.2rem;
            box-shadow: 0 10px 28px var(--shadow);
            backdrop-filter: blur(4px);
        }

        .nav-left,
        .nav-center,
        .nav-right {
            display: flex;
            align-items: center;
        }

        .nav-left {
            justify-content: flex-start;
        }

        .nav-center {
            justify-content: center;
        }

        .nav-right {
            justify-content: flex-end;
            gap: 0.9rem;
        }

        .nav-link,
        .nav-title {
            color: var(--text);
            text-decoration: none;
            font-size: clamp(1rem, 2vw, 1.25rem);
            letter-spacing: 0.03em;
        }

        .nav-link {
            transition: color 0.2s ease, transform 0.2s ease;
        }

        .nav-link:hover,
        .nav-link:focus-visible {
            color: var(--gold-soft);
            transform: translateY(-1px);
            outline: none;
        }

        .profile-dot {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            background: linear-gradient(180deg, rgba(201,166,104,0.85), rgba(120,90,48,0.95));
            border: 1px solid rgba(255,255,255,0.18);
            box-shadow: inset 0 1px 2px rgba(255,255,255,0.15);
        }

        .main-layout {
            display: grid;
            grid-template-columns: 1.65fr 1fr;
            gap: 1.5rem;
            margin-top: 1.6rem;
        }

        .panel {
            background: var(--panel);
            border: 1px solid var(--border);
            border-radius: 28px;
            padding: 1.5rem;
            box-shadow: 0 16px 40px var(--shadow);
            backdrop-filter: blur(4px);
            animation: fadeUp 0.7s ease;
        }

        .panel-inner {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(201, 166, 104, 0.10);
            border-radius: 22px;
            padding: 1.2rem;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(14px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .scene-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 0.6rem;
            margin-bottom: 1rem;
        }

        .meta-pill {
            padding: 0.28rem 0.7rem;
            border-radius: 999px;
            border: 1px solid rgba(201, 166, 104, 0.18);
            color: var(--muted);
            font-size: 0.82rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            background: rgba(255,255,255,0.03);
        }

        .scene-heading {
            margin-bottom: 1rem;
        }

        .scene-heading h1 {
            margin: 0;
            color: var(--gold-soft);
            font-size: clamp(2rem, 4vw, 3rem);
            line-height: 1.05;
        }

        .scene-heading p {
            margin: 0.45rem 0 0;
            color: var(--muted);
            font-style: italic;
        }

        .scene-image-box {
            background: var(--panel-light);
            border: 1px solid rgba(201, 166, 104, 0.14);
            border-radius: 20px;
            min-height: 300px;
            overflow: hidden;
            display: grid;
            place-items: center;
            margin-bottom: 1.2rem;
            position: relative;
        }

        .scene-image-box img {
            width: 100%;
            height: 100%;
            max-height: 420px;
            object-fit: cover;
            display: block;
        }

        .scene-image-placeholder {
            padding: 2rem;
            text-align: center;
            color: var(--muted);
            font-size: 1.1rem;
            letter-spacing: 0.04em;
        }

        .story-box {
            background: var(--panel-light);
            border: 1px solid rgba(201, 166, 104, 0.14);
            border-radius: 20px;
            padding: 1.2rem;
        }

        .story-box p {
            margin: 0 0 1rem;
            line-height: 1.8;
            color: var(--text);
            opacity: 0;
            transform: translateY(8px);
            animation: revealText 0.55s ease forwards;
        }

        .story-box p:last-child {
            margin-bottom: 0;
        }

        .story-box p:nth-child(1) { animation-delay: 0.10s; }
        .story-box p:nth-child(2) { animation-delay: 0.22s; }
        .story-box p:nth-child(3) { animation-delay: 0.34s; }
        .story-box p:nth-child(4) { animation-delay: 0.46s; }
        .story-box p:nth-child(5) { animation-delay: 0.58s; }
        .story-box p:nth-child(6) { animation-delay: 0.70s; }

        @keyframes revealText {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .music-box {
            margin-top: 1rem;
            padding: 0.9rem 1rem;
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(201, 166, 104, 0.12);
            border-radius: 16px;
        }

        .music-box p {
            margin: 0 0 0.65rem;
            color: var(--muted);
            font-size: 0.9rem;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        audio {
            width: 100%;
            filter: sepia(0.35) saturate(0.8) brightness(0.92);
        }

        .choices-panel {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .choices-panel-title {
            margin: 0;
            color: var(--muted);
            font-size: 0.9rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
        }

        .choice {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            min-height: 110px;
            padding: 1.2rem 1.25rem;
            border-radius: 20px;
            text-decoration: none;
            color: var(--text);
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(201, 166, 104, 0.16);
            box-shadow: 0 10px 24px rgba(0,0,0,0.18);
            transition: transform 0.22s ease, border-color 0.22s ease, background 0.22s ease;
            opacity: 0;
            transform: translateY(10px);
            animation: revealChoice 0.55s ease forwards;
        }

        .choice:nth-of-type(2) { animation-delay: 0.78s; }
        .choice:nth-of-type(3) { animation-delay: 0.90s; }
        .choice:nth-of-type(4) { animation-delay: 1.02s; }

        @keyframes revealChoice {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .choice:hover,
        .choice:focus-visible {
            transform: translateY(-4px);
            border-color: var(--border-strong);
            background: rgba(201, 166, 104, 0.10);
            outline: none;
        }

        .choice-left {
            display: flex;
            align-items: center;
            gap: 0.95rem;
        }

        .choice-badge {
            width: 2.4rem;
            height: 2.4rem;
            border-radius: 50%;
            display: grid;
            place-items: center;
            color: var(--gold-soft);
            border: 1px solid rgba(201, 166, 104, 0.28);
            background: rgba(0,0,0,0.18);
            font-weight: bold;
            flex: 0 0 auto;
        }

        .choice-text {
            font-size: 1.02rem;
            line-height: 1.5;
        }

        .choice-arrow {
            color: var(--gold-soft);
            font-size: 1.2rem;
            opacity: 0.85;
            transition: transform 0.2s ease;
        }

        .choice:hover .choice-arrow,
        .choice:focus-visible .choice-arrow {
            transform: translateX(4px);
        }

        .footer-note {
            margin-top: 1rem;
            color: var(--muted);
            font-size: 0.85rem;
            text-align: center;
        }

        @media (max-width: 900px) {
            .main-layout {
                grid-template-columns: 1fr;
            }

            .choice {
                min-height: 90px;
            }
        }

        @media (max-width: 640px) {
            .page {
                width: min(100% - 1rem, 100%);
                padding-top: 0.5rem;
            }

            .topbar {
                grid-template-columns: 1fr;
                text-align: center;
                border-radius: 20px;
            }

            .nav-left,
            .nav-center,
            .nav-right {
                justify-content: center;
            }

            .panel {
                padding: 1rem;
                border-radius: 22px;
            }

            .panel-inner {
                padding: 1rem;
                border-radius: 18px;
            }

            .scene-image-box {
                min-height: 220px;
            }

            .choice {
                padding: 1rem;
            }
        }
    </style>
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