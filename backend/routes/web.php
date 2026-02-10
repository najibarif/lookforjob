<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Artisan;

Route::get('/', function () {
    return view('welcome');
});

// Temporary secret route to trigger scraping in production with nice UI
Route::get('/scrape-now', function () {
    Artisan::call('scrape:comprehensive --limit=50');
    $output = Artisan::output();
    return view('scrape_status', ['output' => $output]);
});
