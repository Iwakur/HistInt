<?php
$page = $_GET['page'] ?? 'castles';

/* Safety check so people cannot request random files */
$page = basename($page);

$file = __DIR__ . "/data/$page.json";

if (!file_exists($file)) {
    http_response_code(404);
    die("Page not found.");
}

$json = file_get_contents($file);
$data = json_decode($json, true);

if (!$data) {
    die("Invalid JSON data.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($data['title']) ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <nav class="navbar">
        <a href="index.php">Home</a>
        <h1><?= htmlspecialchars($data['title']) ?></h1>
        <a href="profile.php">Profile</a>
    </nav>

    <main class="page-layout">
        <section class="main-content">
            <img src="<?= htmlspecialchars($data['image']) ?>" alt="<?= htmlspecialchars($data['title']) ?>">

            <h2><?= htmlspecialchars($data['subtitle']) ?></h2>
            <p class="intro"><?= htmlspecialchars($data['intro']) ?></p>

            <?php foreach ($data['content'] as $paragraph): ?>
                <p><?= htmlspecialchars($paragraph) ?></p>
            <?php endforeach; ?>
        </section>

        <aside class="side-panel">
            <h3>Facts</h3>
            <ul>
                <?php foreach ($data['facts'] as $fact): ?>
                    <li><?= htmlspecialchars($fact) ?></li>
                <?php endforeach; ?>
            </ul>
        </aside>
    </main>

</body>
</html>