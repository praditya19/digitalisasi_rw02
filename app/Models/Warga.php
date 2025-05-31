<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warga extends Model
{
    use HasFactory;

    protected $table = 'warga';

    protected $fillable = [
        'nomor_keluarga',
        'nama_lengkap',
        'email',
        'nomor_hp',
        'rt',
        'jenis_kelamin',
        'status_rumah',
        'pendidikan',
        'pekerjaan',
        'jenis_warga',
        'status_keluarga',
        'kepala_keluarga_id',
        'domisili',
        'tanggal_lahir',
        'anggota_keluarga',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'anggota_keluarga' => 'array',
    ];

    public function anggotaKeluarga()
    {
        return $this->hasMany(Warga::class, 'kepala_keluarga_id');
    }

    public function kepalaKeluarga()
    {
        return $this->belongsTo(Warga::class, 'kepala_keluarga_id');
    }

    public function scopeKepalaKeluarga($query)
    {
        return $query->where('jenis_warga', 'kepala_keluarga');
    }

    public function scopeAnggotaKeluarga($query)
    {
        return $query->where('jenis_warga', 'anggota_keluarga');
    }
}