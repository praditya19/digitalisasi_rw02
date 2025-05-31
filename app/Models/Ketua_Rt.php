<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ketua_Rt extends Model
{
    protected $table = 'ketua_rt';
    protected $fillable = [
        'nama',
        'email',
        'nomor_hp',
        'password',
        'rt',
        'sk_ketua_rt',
        'role',
    ];
}
