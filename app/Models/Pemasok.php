<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pemasok extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pemasok';
    protected $primaryKey = 'id_pemasok';

    protected $fillable = [
        'kode_pemasok','nama_pemasok','alamat_pemasok','telepon_pemasok'
    ];
}
