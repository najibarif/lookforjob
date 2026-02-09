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
        'description',
        'requirements',
        'employment_type',
        'experience_level',
        'date',
        'salary',
        'jobUrl',
        'companyLogo',
        'agoTime',
        'keyword',
        'category',
        'is_remote',
        'source',
    ];

    protected $casts = [
        'is_remote' => 'boolean',
        'date' => 'datetime',
    ];
}