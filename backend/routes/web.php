<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Artisan;

Route::get('/', function () {
    return view('welcome');
});

// Step 1: Show the interactive "Searching" UI
Route::get('/scrape-now', function () {
    return view('scraping_progress');
});

// Step 2: The internal endpoint that actually runs the command
Route::get('/api/internal-scrape', function () {
    Artisan::call('scrape:comprehensive --limit=50');
    $output = Artisan::output();
    return view('scrape_status', ['output' => $output]);
});
