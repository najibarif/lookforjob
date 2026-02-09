<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScrapedJob extends Model
{
    use HasFactory;

    protected $table = 'scraped_jobs';

    protected $fillable = [
        'position',
        'company',
        'location',
        'date',
        'salary',
        'jobUrl',
        'companyLogo',
        'agoTime',
        'keyword',
        'source',
    ];
}