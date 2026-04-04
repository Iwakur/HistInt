<?php
declare(strict_types=1);



function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function loadScene(string $sceneId): array
{
    $sceneId = basename($sceneId);
    $file = __DIR__ . '/../content/' . $sceneId . '.json';

    if (!is_file($file)) {
        http_response_code(404);
        die('Scene not found.');
    }

    $json = file_get_contents($file);

    if ($json === false) {
        http_response_code(500);
        die('Invalid JSON.');
    }

    $data = json_decode($json, true);

    if (!is_array($data)) {
        http_response_code(500);
        die('Invalid JSON.');
    }

    return $data;
}
