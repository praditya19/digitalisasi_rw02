<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Warga extends Model
{
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
    ];

    public function anggotaKeluarga(): HasMany
    {
        return $this->hasMany(Warga::class, 'kepala_keluarga_id');
    }

    public function kepalaKeluarga(): BelongsTo
    {
        return $this->belongsTo(Warga::class, 'kepala_keluarga_id');
    }
}
