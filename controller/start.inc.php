<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    $isSecure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (isset($_SERVER['SERVER_PORT']) && (int) $_SERVER['SERVER_PORT'] === 443);

    ini_set('session.use_strict_mode', '1');
    ini_set('session.use_only_cookies', '1');
    ini_set('session.cookie_httponly', '1');

    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'domain' => '',
        'secure' => $isSecure,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);

    session_start();
}

if (!headers_sent()) {
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: SAMEORIGIN');
    header('Referrer-Policy: same-origin');
    header('Permissions-Policy: camera=(), microphone=(), geolocation=()');
}

// Include necessary file
include_once 'user.class.php';
include_once 'model.class.php';
include_once 'utility.class.php';

// database access parameters
$errors = [];
$db_host = getenv('CRSM_DB_HOST') ?: 'localhost';
$db_user = getenv('CRSM_DB_USER') ?: 'root';
$db_pass = getenv('CRSM_DB_PASS') ?: '';
$db_name = getenv('CRSM_DB_NAME') ?: '@core_crsm_%01@';

// connect to database
try {
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    if (defined('PDO::MYSQL_ATTR_INIT_COMMAND')) {
        $options[PDO::MYSQL_ATTR_INIT_COMMAND] = 'SET NAMES utf8mb4';
    }

    if (defined('PDO::MYSQL_ATTR_USE_BUFFERED_QUERY')) {
        $options[PDO::MYSQL_ATTR_USE_BUFFERED_QUERY] = true;
    }

    $db_conn = new PDO("mysql:host={$db_host};dbname={$db_name};charset=utf8mb4", $db_user, $db_pass, $options);
} catch (PDOException $e) {
    error_log('Database connection failed: ' . $e->getMessage());
    $errors[] = 'Database connection failed. Please contact support.';
    http_response_code(500);
    exit('Service temporarily unavailable.');
}

// make use of database with users
$user = new User($db_conn);
$model = new Model($db_conn);
$utility = new Utility();
