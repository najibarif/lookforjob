<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Education extends Model
{
    protected $table = 'pendidikans'; // sesuaikan nama tabel di database

    protected $primaryKey = 'id_pendidikan';

    protected $fillable = [
        'id_user',
        'institusi',
        'jenjang',
        'jurusan',
        'lokasi',
        'tanggal_mulai',
        'tanggal_selesai',
        'ipk',
        'deskripsi',
    ];

    // Jika kolom primary key bukan auto-increment integer standar, sesuaikan tipe primary key
    public $incrementing = true;
    protected $keyType = 'int';

    // Jika kamu ingin otomatis timestamps, pastikan kolom created_at dan updated_at ada
    public $timestamps = true;
}
