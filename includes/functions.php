<?php
declare(strict_types=1);

/**
 * Safe output (escape HTML)
 */
function e(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

/**
 * Load a scene from JSON
 */
function loadScene(string $sceneId): array {
    $sceneId = basename($sceneId);
    $file = __DIR__ . '/../content/' . $sceneId . '.json';

    if (!file_exists($file)) {
        http_response_code(404);
        die('Scene not found.');
    }

    $data = json_decode(file_get_contents($file), true);

    if (!$data) {
        http_response_code(500);
        die('Invalid JSON.');
    }

    return $data;
}