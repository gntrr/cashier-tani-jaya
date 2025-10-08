<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\Pupuk;
use App\Models\DetailPenjualan;
use App\Models\Pembelian;
use Illuminate\Support\Facades\DB;
use App\Helpers\RoleHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $year = (int)($request->get('tahun', now()->year));
        $rawMonth = $request->get('bulan');
        if ($rawMonth === null || $rawMonth === '' || $rawMonth === 'all' || $rawMonth === '0') {
            $month = null; // no month filter (YTD)
        } elseif (is_string($rawMonth) && ctype_digit($rawMonth)) {
            $m = (int)$rawMonth;
            $month = ($m >= 1 && $m <= 12) ? $m : null;
        } elseif (is_int($rawMonth)) {
            $month = ($rawMonth >= 1 && $rawMonth <= 12) ? $rawMonth : null;
        } else {
            $month = null; // any other invalid input -> ignore month filter
        }
        $user = Auth::user();

        $penjualanQuery = Penjualan::query()->whereYear('created_at', $year);
        // if (RoleHelper::isKasir($user)) {
        //     $penjualanQuery->where('user_id', $user->id);
        // }
        if (!is_null($month)) {
            $penjualanQuery->whereMonth('created_at', $month);
        }

        // Total penjualan (gross)
        $totalPenjualan = (clone $penjualanQuery)->sum('total_harga');
        $totalTransaksi = (clone $penjualanQuery)->count();

        // =============================
        // DATA PEMBELIAN (Previously not included -> October data missing)
        // =============================
        $pembelianQuery = Pembelian::query()->whereYear('created_at', $year);
        if (!is_null($month)) {
            $pembelianQuery->whereMonth('created_at', $month);
        }
        $totalPembelian = (clone $pembelianQuery)->sum('bayar'); // total uang dikeluarkan untuk pembelian (cash out)
        $totalPembelianTransaksi = (clone $pembelianQuery)->count();

        // Total modal (HPP) dihitung dari penjumlahan (detail_penjualan.jumlah * pupuk.harga_beli)
        $hppQuery = DB::table('detail_penjualan as dp')
            ->join('penjualan as p', 'p.id_penjualan', '=', 'dp.penjualan_id_penjualan')
            ->join('pupuk as pu', 'pu.id_pupuk', '=', 'dp.pupuk_id_pupuk')
            ->whereYear('p.created_at', $year);
        // if (RoleHelper::isKasir($user)) {
        //     $hppQuery->where('p.user_id', $user->id);
        // }
        if (!is_null($month)) {
            $hppQuery->whereMonth('p.created_at', $month);
        }
        $totalModal = $hppQuery->selectRaw('COALESCE(SUM(dp.jumlah * pu.harga_beli),0) as modal')->value('modal');

    $profit = $totalPenjualan - $totalModal; // tetap memakai HPP untuk margin kotor
    $avgPerTransaksi = $totalTransaksi > 0 ? $totalPenjualan / $totalTransaksi : 0;

        // Daily revenue (only if month selected) else last 30 days rolling
        if (!is_null($month)) {
            $daily = Penjualan::selectRaw('DATE(created_at) as tanggal, COALESCE(SUM(total_harga),0) as total')
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                // ->when(RoleHelper::isKasir($user), fn($q) => $q->where('user_id', $user->id))
                ->groupBy('tanggal')
                ->orderBy('tanggal')
                ->get();
        } else {
            $start = now()->subDays(29)->startOfDay();
            $daily = Penjualan::selectRaw('DATE(created_at) as tanggal, COALESCE(SUM(total_harga),0) as total')
                ->where('created_at', '>=', $start)
                // ->when(RoleHelper::isKasir($user), fn($q) => $q->where('user_id', $user->id))
                ->groupBy('tanggal')
                ->orderBy('tanggal')
                ->get();
        }

        // Monthly revenue for the year
        $monthly = Penjualan::selectRaw('EXTRACT(MONTH FROM created_at) as bulan, COALESCE(SUM(total_harga),0) as total')
            ->whereYear('created_at', $year)
            // ->when(RoleHelper::isKasir($user), fn($q) => $q->where('user_id', $user->id))
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        // Prepare arrays for chart
    $dailyLabels = ($daily ?? collect())->pluck('tanggal')->map(fn($d) => Carbon::parse($d)->format('d-m'))->toArray();
    $dailyData = ($daily ?? collect())->pluck('total')->map(fn($v) => (float)$v)->toArray();
    $monthlyLabels = ($monthly ?? collect())->pluck('bulan')->map(fn($b) => str_pad($b, 2, '0', STR_PAD_LEFT))->toArray();
    $monthlyData = ($monthly ?? collect())->pluck('total')->map(fn($v) => (float)$v)->toArray();

        // dd(
        //     $year, $month,
        //     $totalPenjualan, $totalModal, $profit, $totalTransaksi, $avgPerTransaksi,
        //     $dailyLabels, $dailyData, $monthlyLabels, $monthlyData
        // );
        return view('dashboard', [
            'filterYear' => $year,
            'filterMonth' => $month,
            'totalPenjualan' => $totalPenjualan,
            // totalPembelian: uang keluar untuk pembelian (menjawab kebutuhan kartu "Total Pembelian")
            'totalPembelian' => $totalPembelian,
            // totalModal: HPP (dipertahankan untuk perhitungan profit)
            'totalModal' => $totalModal,
            'profit' => $profit,
            'totalTransaksi' => $totalTransaksi,
            'totalPembelianTransaksi' => $totalPembelianTransaksi,
            'avgPerTransaksi' => $avgPerTransaksi,
        ]);
    }

    public function chartData(Request $request)
    {
        $user = Auth::user();

        // Bulanan (tahun berjalan)
        $monthly = DB::table('penjualan')
            ->selectRaw('EXTRACT(MONTH FROM created_at)::int as m, COALESCE(SUM(total_harga),0) as total')
            // ->when($user && !\App\Helpers\RoleHelper::isAdmin($user), fn($q) => $q->where('user_id', $user->id))
            ->whereYear('created_at', now()->year)
            ->groupBy('m')->orderBy('m')
            ->pluck('total', 'm')->all();

        $labelsMonth = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $dataMonth = [];
        for ($i = 1; $i <= 12; $i++) {
            $dataMonth[] = (float)($monthly[$i] ?? 0);
        }

        // Tahunan (5 tahun terakhir)
        $yearly = DB::table('penjualan')
            ->selectRaw('EXTRACT(YEAR FROM created_at)::int as y, COALESCE(SUM(total_harga),0) as total')
            // ->when($user && !\App\Helpers\RoleHelper::isAdmin($user), fn($q) => $q->where('user_id', $user->id))
            ->whereYear('created_at', '>=', now()->year - 4)
            ->groupBy('y')->orderBy('y')
            ->pluck('total', 'y')->all();

        $labelsYear = [];
        $dataYear = [];
        for ($y = now()->year - 4; $y <= now()->year; $y++) {
            $labelsYear[] = $y;
            $dataYear[]   = (float)($yearly[$y] ?? 0);
        }

        // Top products (by quantity) for current year, limit top 8
        $topProductsRows = DB::table('detail_penjualan as dp')
            ->join('penjualan as p', 'p.id_penjualan', '=', 'dp.penjualan_id_penjualan')
            ->join('pupuk as pu', 'pu.id_pupuk', '=', 'dp.pupuk_id_pupuk')
            // ->when($user && !\App\Helpers\RoleHelper::isAdmin($user), fn($q) => $q->where('p.user_id', $user->id))
            ->whereYear('p.created_at', now()->year)
            ->selectRaw('pu.nama_pupuk as nama, COALESCE(SUM(dp.jumlah),0) as qty')
            ->groupBy('pu.nama_pupuk')
            ->orderByDesc('qty')
            ->limit(8)
            ->get();

        $topLabels = $topProductsRows->pluck('nama')->toArray();
        $topData   = $topProductsRows->pluck('qty')->map(fn($v) => (float)$v)->toArray();

        return response()->json([
            'monthly' => ['labels' => $labelsMonth, 'data' => $dataMonth],
            'yearly'  => ['labels' => $labelsYear,  'data' => $dataYear],
            'topProducts' => ['labels' => $topLabels, 'data' => $topData],
        ]);
    }

    // ============== KASIR SUPPORT (AJAX) ==============
    public function searchPupuk(Request $request)
    {
        $q = $request->get('q');
        $rows = Pupuk::query()
            ->when($q, fn($qr) => $qr->where(function($w) use ($q){
                $w->where('nama_pupuk','ILIKE','%'.$q.'%')
                  ->orWhere('kode_pupuk','ILIKE','%'.$q.'%');
            }))
            ->orderBy('nama_pupuk')
            ->limit(30)
            ->get(['id_pupuk','nama_pupuk','kode_pupuk','harga_jual','stok_pupuk']);
        return response()->json($rows);
    }

    public function quickStorePenjualan(Request $request)
    {
        $request->validate([
            'bayar' => 'required|numeric|min:0',
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|exists:pupuk,id_pupuk',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.harga' => 'required|numeric|min:0'
        ]);
        DB::beginTransaction();
        try {
            $user = $request->user();
            $today = now()->format('Ymd');
            $seq = Penjualan::whereDate('created_at', now()->toDateString())->count() + 1;
            $kode = 'PJ'.$today.str_pad($seq,4,'0',STR_PAD_LEFT);
            $total_item = 0; $total_harga = 0; $detailRows = [];
            foreach ($request->items as $row) {
                $pupuk = Pupuk::lockForUpdate()->findOrFail($row['id']);
                $qty = (int)$row['qty'];
                if ($pupuk->stok_pupuk < $qty) {
                    throw new \Exception("Stok pupuk {$pupuk->nama_pupuk} tidak cukup");
                }
                $harga = (float)$row['harga'];
                $subtotal = $harga * $qty;
                $total_item += $qty; $total_harga += $subtotal;
                $detailRows[] = [
                    'pupuk_id_pupuk' => $pupuk->id_pupuk,
                    'harga_jual' => $harga,
                    'jumlah' => $qty,
                    'subtotal' => $subtotal,
                ];
                $pupuk->decrement('stok_pupuk', $qty);
            }
            if ($request->bayar < $total_harga) {
                throw new \Exception('Pembayaran kurang dari total penjualan');
            }
            $penjualan = Penjualan::create([
                'user_id' => $user->id,
                'kode_penjualan' => $kode,
                'total_item' => $total_item,
                'total_harga' => $total_harga,
                'bayar' => $request->bayar,
                'kembalian' => $request->bayar - $total_harga,
            ]);
            foreach ($detailRows as $d) {
                $d['penjualan_id_penjualan'] = $penjualan->id_penjualan;
                DetailPenjualan::create($d);
            }
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Transaksi tersimpan',
                'kode' => $penjualan->kode_penjualan,
                'total' => $penjualan->total_harga,
                'kembalian' => $penjualan->kembalian,
                'show_url' => route('kasir.riwayat.show', $penjualan->id_penjualan),
                'receipt_url' => route('penjualan.receipt', $penjualan->id_penjualan)
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['success'=>false,'message'=>$e->getMessage()],422);
        }
    }
}
