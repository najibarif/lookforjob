<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use Illuminate\Support\Facades\Cache;

class PageController extends Controller
{
    public function home()
    {
        $featuredJobs = Cache::remember('featured_jobs', 3600, function () {
            return JobListing::inRandomOrder()->limit(3)->get();
        });
        return view('home', compact('featuredJobs'));
    }

    public function companies()
    {
        return view('companies');
    }

    public function about()
    {
        return view('about');
    }
}
