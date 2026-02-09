<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendidikan extends Model
{
    use HasFactory;

    protected $table = 'pendidikan';

    protected $fillable = [
        'user_id',
        'institusi',
        'jenjang',
        'jurusan',
        'lokasi',
        'tanggal_mulai',
        'tanggal_akhir',
        'ipk',
        'deskripsi',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_akhir' => 'date',
        'ipk' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 