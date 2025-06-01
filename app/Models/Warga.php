<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warga extends Model
{
    use HasFactory;

    protected $table = 'warga';

    public const JENIS_WARGA_KEPALA = 'Kepala Keluarga';
    public const JENIS_WARGA_ANGGOTA = 'Anggota Keluarga';

    protected $fillable = [
        'nomor_keluarga',
        'nik',
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
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'Anggota Keluarga' => 'array',
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
        return $query->where('jenis_warga', self::JENIS_WARGA_KEPALA);
    }

    public function scopeAnggotaKeluarga($query)
    {
        return $query->where('jenis_warga', self::JENIS_WARGA_ANGGOTA);
    }
}