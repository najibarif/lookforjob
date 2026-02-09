<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengalaman extends Model
{
    use HasFactory;

    protected $table = 'pengalaman';

    protected $fillable = [
        'user_id',
        'institusi',
        'posisi',
        'lokasi',
        'tanggal_mulai',
        'tanggal_akhir',
        'deskripsi',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_akhir' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 