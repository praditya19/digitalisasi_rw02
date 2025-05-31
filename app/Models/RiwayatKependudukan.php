<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RiwayatKependudukan extends Model
{
    use HasFactory;

    protected $table = 'riwayat_kependudukan';

    protected $fillable = [
        'warga_id',
        'tanggal_perubahan',
        'jenis_perubahan',
        'keterangan',
        'diubah_oleh',
    ];

    public function warga()
    {
        return $this->belongsTo(Warga::class);
    }
}
