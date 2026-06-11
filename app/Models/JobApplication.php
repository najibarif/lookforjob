<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{

    protected $fillable = [
        'user_id',
        'job_id',
        'job_title',
        'company_name',
        'job_url',
        'cv_snapshot',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
