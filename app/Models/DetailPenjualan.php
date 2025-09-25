<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailPenjualan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'detail_penjualan';
    protected $primaryKey = 'id_detail_penjualan';

    protected $fillable = [
        'pupuk_id_pupuk','penjualan_id_penjualan','harga_jual','jumlah','subtotal'
    ];

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'penjualan_id_penjualan', 'id_penjualan');
    }

    public function pupuk()
    {
        return $this->belongsTo(Pupuk::class, 'pupuk_id_pupuk', 'id_pupuk');
    }
}
