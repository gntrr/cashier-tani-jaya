<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pembelian extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pembelian';
    protected $primaryKey = 'id_pembelian';

    protected $fillable = [
        'user_id','pemasok_id_pemasok','kode_pembelian','total_item','bayar', 'tanggal_beli', 'status'
    ];

    public function pemasok()
    {
        return $this->belongsTo(Pemasok::class, 'pemasok_id_pemasok', 'id_pemasok');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function detail()
    {
        return $this->hasMany(DetailPembelian::class, 'pembelian_id_pembelian', 'id_pembelian');
    }
}
