<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiUmkm extends Model
{
    use HasFactory;

    protected $table = 'transaksi_umkm';

    protected $fillable = [
        'produk_umkm_id',
        'jumlah',
        'total_harga',
        'status',
    ];

    public function produk()
    {
        return $this->belongsTo(ProdukUmkm::class, 'produk_umkm_id');
    }
}
