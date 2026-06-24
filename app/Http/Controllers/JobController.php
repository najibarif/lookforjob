<?php

namespace App\Http\Controllers;

use App\Services\Jobs\JobAggregator;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function getJobs(Request $request, JobAggregator $aggregator)
    {
        $request->validate([
            'keyword' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        $keyword = $request->query('keyword');
        $location = $request->query('location');
        $refresh = $request->boolean('refresh', false);

        try {
            $jobs = $aggregator->fetchAndStore($keyword, $location, $refresh);

            return response()->json(['data' => $jobs]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
