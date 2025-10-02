<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pupuk extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pupuk';
    protected $primaryKey = 'id_pupuk';
    public $incrementing = true;

    protected $fillable = [
        'kode_pupuk','nama_pupuk','harga_beli','harga_jual','stok_pupuk', 'satuan_kg'
    ];

    protected $casts = [
        // 'harga_beli' => 'decimal:2',
        // 'harga_jual' => 'decimal:2',
        // 'stok_pupuk' => 'integer',
        'satuan_kg' => 'float',
    ];
}
