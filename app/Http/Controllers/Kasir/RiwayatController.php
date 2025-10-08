<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penjualan;
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        // Batasi hanya transaksi user kasir sendiri? Desain menyebut riwayat umum: tampilkan semua penjualan.
        $query = Penjualan::query()->with('user');
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function($w) use ($q){
                $w->where('kode_penjualan','ILIKE','%'.$q.'%')
                  ->orWhereHas('user', fn($u)=>$u->where('name','ILIKE','%'.$q.'%'));
            });
        }
        if ($request->filled('dari')) {
            $query->whereDate('created_at','>=',$request->dari);
        }
        if ($request->filled('sampai')) {
            $query->whereDate('created_at','<=',$request->sampai);
        }
        $penjualan = $query->latest()->paginate(12)->withQueryString();
        $totalNominal = (clone $query)->sum('total_harga');
        $totalTransaksi = (clone $query)->count();
        return view('kasir.riwayat.index', compact('penjualan','totalNominal','totalTransaksi'));
    }

    public function show(Penjualan $penjualan)
    {
        $penjualan->load(['user','detail.pupuk']);
        return view('kasir.riwayat.show', compact('penjualan'));
    }
}
