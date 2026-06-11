<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobListing extends Model
{
    use HasFactory;

    protected $fillable = [
        'source',
        'external_id',
        'keyword',
        'location',
        'title',
        'company',
        'location_text',
        'company_url',
        'url',
        'description',
        'date_posted',
        'is_remote',
        'payload',
    ];

    protected $casts = [
        'is_remote' => 'boolean',
        'payload' => 'array',
    ];
}
