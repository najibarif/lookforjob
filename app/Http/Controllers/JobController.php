<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\JobScraper;

class JobController extends Controller
{
    public function getJobs(Request $request, JobScraper $scraper)
    {
        $request->validate([
            'keyword' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        $keyword = $request->query('keyword');
        $location = $request->query('location');
        $refresh = $request->boolean('refresh', false);

        try {
            $jobs = $scraper->scrapeIndeed($keyword, $location, $refresh);

            return response()->json(['data' => $jobs]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
