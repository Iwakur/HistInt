<?php
declare(strict_types=1);

require __DIR__ . '/includes/functions.php';

// Only log out if user is logged in, then redirect
if (currentUser()) {
    logoutUser();
}

// If user not logged in, redirect to home
header('Location: index.php');
exit;