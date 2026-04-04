<?php
declare(strict_types=1);

session_start();
require __DIR__ . '/includes/functions.php';

logoutUser();

header('Location: index.php');
exit;