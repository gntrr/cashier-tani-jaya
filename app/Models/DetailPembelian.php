<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailPembelian extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'detail_pembelian';
    protected $primaryKey = 'id_detail_pembelian';

    protected $fillable = [
        'pupuk_id_pupuk','pembelian_id_pembelian','harga_beli','jumlah','subtotal'
    ];

    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class, 'pembelian_id_pembelian', 'id_pembelian');
    }

    public function pupuk()
    {
        return $this->belongsTo(Pupuk::class, 'pupuk_id_pupuk', 'id_pupuk');
    }
}
