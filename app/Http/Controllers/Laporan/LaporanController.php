<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\Pembelian;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->integer('tahun', now()->year);
        $month = $request->integer('bulan'); // optional

        $penjualanQuery = Penjualan::query()->whereYear('created_at', $year);
        $pembelianQuery = Pembelian::query()->whereYear('created_at', $year);
        if ($month) {
            $penjualanQuery->whereMonth('created_at', $month);
            $pembelianQuery->whereMonth('created_at', $month);
        }

        $totalPenjualan = (clone $penjualanQuery)->sum('total_harga');
        $totalPembelian = (clone $pembelianQuery)->sum('bayar');
        $countPenjualan = (clone $penjualanQuery)->count();
        $countPembelian = (clone $pembelianQuery)->count();

        // Series per bulan (penjualan)
        $seriesPenjualan = Penjualan::selectRaw('EXTRACT(MONTH FROM created_at) AS m, COALESCE(SUM(total_harga),0) as total')
            ->whereYear('created_at', $year)
            ->groupBy('m')
            ->orderBy('m')
            ->pluck('total','m');

        $seriesPembelian = Pembelian::selectRaw('EXTRACT(MONTH FROM created_at) AS m, COALESCE(SUM(bayar),0) as total')
            ->whereYear('created_at', $year)
            ->groupBy('m')
            ->orderBy('m')
            ->pluck('total','m');

        return view('laporan.index', [
            'filterYear' => $year,
            'filterMonth' => $month,
            'totalPenjualan' => $totalPenjualan,
            'totalPembelian' => $totalPembelian,
            'countPenjualan' => $countPenjualan,
            'countPembelian' => $countPembelian,
            'seriesPenjualan' => $seriesPenjualan,
            'seriesPembelian' => $seriesPembelian,
        ]);
    }
}
