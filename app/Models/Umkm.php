<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Umkm extends Model
{
    use HasFactory;

    protected $table = 'umkm';

    protected $fillable = [
        'kode',
        'nama_umkm',
        'jenis_usaha',
        'nomor_nib',
        'pemilik',
        'alamat',
        'nomor_hp',
    ];
}
