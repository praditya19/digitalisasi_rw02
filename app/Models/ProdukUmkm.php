<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukUmkm extends Model
{
    use HasFactory;

    protected $table = 'produk_umkm';

    protected $fillable = [
        'nama_produk',
        'deskripsi',
        'stok',
        'harga',
        'umkm_id',
    ];

    public function umkm()
    {
        return $this->belongsTo(Umkm::class, 'umkm_id');
    }

    public function transaksi()
    {
        return $this->hasMany(TransaksiUmkm::class, 'produk_umkm_id');
    }
}
