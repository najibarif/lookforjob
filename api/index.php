<?php
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

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
