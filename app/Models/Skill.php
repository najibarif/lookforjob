<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    // Nama tabel (jika tidak sesuai konvensi Laravel)
    protected $table = 'skills';

    // Kolom yang bisa diisi secara massal
    protected $fillable = [
        'id_user',          // foreign key
        'nama_skill',       // nama skill
        'level',            // level (Beginner, Intermediate, etc)
        'deskripsi',        // opsional
        'sertifikasi_path', // path file sertifikat (jika ada)
    ];

    // Relasi: satu skill dimiliki oleh satu user
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // (Opsional) casting timestamp sebagai Carbon
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
