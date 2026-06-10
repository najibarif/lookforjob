<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;

    protected $table = 'pengalamans';

    protected $fillable = [
        'id_user',
        'institusi',
        'posisi',
        'lokasi',
        'tanggal_mulai',
        'tanggal_akhir',
        'deskripsi',
    ];
}