<?php
declare(strict_types=1);

require_once __DIR__ . '/db.php';

/** ===== SECURITY & UTILITY ===== */

/**
 * HTML escape output to prevent XSS attacks
 * @param string $value Value to escape
 * @return string HTML-escaped string
 */
function e(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

/**
 * Ensure session is active before auth operations
 * @return void
 */
function ensureSessionStarted(): void {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

/** ===== USER QUERIES ===== */

/**
 * Find user by username
 * @param string $username
 * @return array|null User data or null if not found
 */
function findUserByUsername(string $username): ?array {
    $stmt = db()->prepare('SELECT * FROM users WHERE username = :username LIMIT 1');
    $stmt->execute(['username' => $username]);
    return $stmt->fetch() ?: null;
}

/**
 * Find user by ID
 * @param int $id
 * @return array|null User data or null if not found
 */
function findUserById(int $id): ?array {
    $stmt = db()->prepare('SELECT * FROM users WHERE id = :id LIMIT 1');
    $stmt->execute(['id' => $id]);
    return $stmt->fetch() ?: null;
}

/** ===== AUTHENTICATION ===== */

/**
 * Register new user with validation
 * @param string $username
 * @param string $password
 * @return array Status array with success boolean and message
 */
function registerUser(string $username, string $password): array {
    $username = trim($username);

    // Validate required fields
    if ($username === '' || $password === '') {
        return ['success' => false, 'message' => 'Username and password are required.'];
    }

    // Validate username format: alphanumeric, dash, underscore, 3-20 chars
    if (!preg_match('/^[a-zA-Z0-9_-]{3,20}$/', $username)) {
        return ['success' => false, 'message' => 'Username must be 3-20 characters (letters, numbers, _, -)'];
    }

    // Check if username exists
    if (findUserByUsername($username)) {
        return ['success' => false, 'message' => 'Username already exists.'];
    }

    // Hash password and insert user
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = db()->prepare('INSERT INTO users (username, password_hash, current_scene) VALUES (:username, :password_hash, :current_scene)');
    $stmt->execute([
        'username' => $username,
        'password_hash' => $hash,
        'current_scene' => 'scene_01',
    ]);

    return ['success' => true, 'message' => 'Account created successfully.'];
}

/**
 * Login user with credentials
 * @param string $username
 * @param string $password
 * @return array Status array with success boolean and message
 */
function loginUser(string $username, string $password): array {
    ensureSessionStarted();

    $user = findUserByUsername(trim($username));
    if (!$user) {
        return ['success' => false, 'message' => 'User not found.'];
    }

    if (!password_verify($password, $user['password_hash'])) {
        return ['success' => false, 'message' => 'Wrong password.'];
    }

    // Regenerate session to prevent fixation attacks
    session_regenerate_id(true);
    $_SESSION['user_id'] = (int)$user['id'];

    return ['success' => true, 'message' => 'Login successful.'];
}

/**
 * Get currently logged-in user
 * @return array|null User data or null if not logged in
 */
function currentUser(): ?array {
    ensureSessionStarted();
    return isset($_SESSION['user_id']) ? findUserById((int)$_SESSION['user_id']) : null;
}

/**
 * Require user to be logged in, redirect if not
 * @return void
 */
function requireLogin(): void {
    ensureSessionStarted();
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }
}

/**
 * Logout current user and destroy session
 * @return void Redirects to home after logout
 */
function logoutUser(): void {
    ensureSessionStarted();
    $_SESSION = []; // Clear session data
    
    // Destroy session cookie
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(), '',
            time() - 42000,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );
    }
    
    session_destroy(); // Destroy server-side session
    header('Location: index.php');
    exit;
}

/** ===== SCENE MANAGEMENT ===== */

/**
 * Update user's current scene progress
 * @param int $userId
 * @param string $sceneId
 * @return void
 */
function updateCurrentScene(int $userId, string $sceneId): void {
    $stmt = db()->prepare('UPDATE users SET current_scene = :scene WHERE id = :id');
    $stmt->execute(['scene' => $sceneId, 'id' => $userId]);
}

/**
 * Load scene data from JSON file
 * @param string $sceneId Scene filename (without extension)
 * @return array Decoded scene data
 * @throws Exception on file not found or invalid JSON
 */
function loadScene(string $sceneId): array {
    $sceneId = basename($sceneId); // Prevent directory traversal
    $file = __DIR__ . '/../content/' . $sceneId . '.json';

    if (!file_exists($file)) {
        http_response_code(404);
        die('Scene not found.');
    }

    $data = json_decode(file_get_contents($file), true);
    if (!is_array($data)) {
        http_response_code(500);
        die('Invalid scene JSON.');
    }

    return $data;
}
