<?php
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Suppress deprecation warnings on Vercel
error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

putenv('APP_SERVICES_CACHE=/tmp/services.php');
putenv('APP_PACKAGES_CACHE=/tmp/packages.php');
putenv('APP_CONFIG_CACHE=/tmp/config.php');
putenv('APP_ROUTES_CACHE=/tmp/routes-v7.php');
putenv('APP_EVENTS_CACHE=/tmp/events.php');

// Vercel serverless environment uses read-only filesystem except /tmp
$storagePath = '/tmp/storage';
if (!is_dir($storagePath)) {
    mkdir($storagePath . '/framework/views', 0777, true);
    mkdir($storagePath . '/framework/cache/data', 0777, true);
    mkdir($storagePath . '/framework/sessions', 0777, true);
    mkdir($storagePath . '/logs', 0777, true);
    mkdir($storagePath . '/app/public', 0777, true);
}

// Copy the dummy sqlite db if using sqlite and it doesn't exist
if (env('DB_CONNECTION') === 'sqlite' && !file_exists('/tmp/database.sqlite')) {
    touch('/tmp/database.sqlite');
}

$app->useStoragePath($storagePath);

$app->handleRequest(Request::capture());
