<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use Illuminate\Support\Facades\DB;
use App\Helpers\RoleHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $year = (int)($request->get('tahun', now()->year));
        $month = $request->get('bulan', now()->month);
        $user = Auth::user();

        $penjualanQuery = Penjualan::query()->whereYear('created_at', $year);
        if (RoleHelper::isKasir($user)) {
            $penjualanQuery->where('user_id', $user->id);
        }
        if ($month) {
            $penjualanQuery->whereMonth('created_at', $month);
        }

        // Total penjualan (gross)
        $totalPenjualan = (clone $penjualanQuery)->sum('total_harga');
        $totalTransaksi = (clone $penjualanQuery)->count();

        // Total modal (HPP) dihitung dari penjumlahan (detail_penjualan.jumlah * pupuk.harga_beli)
        $hppQuery = DB::table('detail_penjualan as dp')
            ->join('penjualan as p', 'p.id_penjualan', '=', 'dp.penjualan_id_penjualan')
            ->join('pupuk as pu', 'pu.id_pupuk', '=', 'dp.pupuk_id_pupuk')
            ->whereYear('p.created_at', $year);
        if (RoleHelper::isKasir($user)) {
            $hppQuery->where('p.user_id', $user->id);
        }
        if ($month) {
            $hppQuery->whereMonth('p.created_at', $month);
        }
        $totalModal = $hppQuery->selectRaw('COALESCE(SUM(dp.jumlah * pu.harga_beli),0) as modal')->value('modal');

        $profit = $totalPenjualan - $totalModal;
        $avgPerTransaksi = $totalTransaksi > 0 ? $totalPenjualan / $totalTransaksi : 0;

        // Daily revenue (only if month selected) else last 30 days rolling
        if ($month) {
            $daily = Penjualan::selectRaw('DATE(created_at) as tanggal, COALESCE(SUM(total_harga),0) as total')
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->when(RoleHelper::isKasir($user), fn($q) => $q->where('user_id', $user->id))
                ->groupBy('tanggal')
                ->orderBy('tanggal')
                ->get();
        } else {
            $start = now()->subDays(29)->startOfDay();
            $daily = Penjualan::selectRaw('DATE(created_at) as tanggal, COALESCE(SUM(total_harga),0) as total')
                ->where('created_at', '>=', $start)
                ->when(RoleHelper::isKasir($user), fn($q) => $q->where('user_id', $user->id))
                ->groupBy('tanggal')
                ->orderBy('tanggal')
                ->get();
        }

        // Monthly revenue for the year
        $monthly = Penjualan::selectRaw('EXTRACT(MONTH FROM created_at) as bulan, COALESCE(SUM(total_harga),0) as total')
            ->whereYear('created_at', $year)
            ->when(RoleHelper::isKasir($user), fn($q) => $q->where('user_id', $user->id))
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        // Prepare arrays for chart
        $dailyLabels = $daily->pluck('tanggal')->map(fn($d) => Carbon::parse($d)->format('d-m'))->toArray();
        $dailyData = $daily->pluck('total')->toArray();
        $monthlyLabels = $monthly->pluck('bulan')->map(fn($b) => str_pad($b, 2, '0', STR_PAD_LEFT))->toArray();
        $monthlyData = $monthly->pluck('total')->toArray();

        // dd(
        //     $year, $month,
        //     $totalPenjualan, $totalModal, $profit, $totalTransaksi, $avgPerTransaksi,
        //     $dailyLabels, $dailyData, $monthlyLabels, $monthlyData
        // );
        return view('dashboard', [
            'filterYear' => $year,
            'filterMonth' => $month,
            'totalPenjualan' => $totalPenjualan,
            'totalModal' => $totalModal,
            'profit' => $profit,
            'totalTransaksi' => $totalTransaksi,
            'avgPerTransaksi' => $avgPerTransaksi,
        ]);
    }

    public function chartData(Request $request)
    {
        $user = Auth::user();

        // Bulanan (tahun berjalan)
        $monthly = DB::table('penjualan')
            ->selectRaw('EXTRACT(MONTH FROM created_at)::int as m, COALESCE(SUM(total_harga),0) as total')
            ->when($user && !\App\Helpers\RoleHelper::isAdmin($user), fn($q) => $q->where('user_id', $user->id))
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
            ->when($user && !\App\Helpers\RoleHelper::isAdmin($user), fn($q) => $q->where('user_id', $user->id))
            ->whereYear('created_at', '>=', now()->year - 4)
            ->groupBy('y')->orderBy('y')
            ->pluck('total', 'y')->all();

        $labelsYear = [];
        $dataYear = [];
        for ($y = now()->year - 4; $y <= now()->year; $y++) {
            $labelsYear[] = $y;
            $dataYear[]   = (float)($yearly[$y] ?? 0);
        }

        return response()->json([
            'monthly' => ['labels' => $labelsMonth, 'data' => $dataMonth],
            'yearly'  => ['labels' => $labelsYear,  'data' => $dataYear],
        ]);
    }
}
