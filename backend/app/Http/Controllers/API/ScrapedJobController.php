<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ScrapedJob;
use Illuminate\Http\Request;

class ScrapedJobController extends Controller
{
    // List semua job hasil scraping
    public function index(Request $request)
    {
        $query = ScrapedJob::query();
        // Optional: filter by keyword, location, company, dsb
        if ($request->has('keyword')) {
            $query->where('keyword', 'like', '%' . $request->keyword . '%');
        }
        if ($request->has('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }
        if ($request->has('company')) {
            $query->where('company', 'like', '%' . $request->company . '%');
        }
        $jobs = $query->orderByDesc('date')->paginate(20);
        return response()->json($jobs);
    }

    // Detail job berdasarkan id
    public function show($id)
    {
        $job = ScrapedJob::findOrFail($id);
        return response()->json($job);
    }
}