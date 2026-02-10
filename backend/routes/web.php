<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Artisan;

Route::get('/', function () {
    return view('welcome');
});

// Temporary secret route to trigger scraping in production
Route::get('/scrape-now', function () {
    Artisan::call('scrape:comprehensive --limit=20');
    return "Scraping completed! Check /api/jobs again.";
});
