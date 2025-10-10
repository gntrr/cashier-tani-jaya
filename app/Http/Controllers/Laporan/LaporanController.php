<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\Pembelian;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Dompdf\Dompdf;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->integer('tahun', now()->year);
        $month = $request->integer('bulan'); // optional
        $q = trim((string)$request->get('q',''));

        $penjualanQuery = Penjualan::query()->whereYear('penjualan.created_at', $year)->with('user');
        $pembelianQuery = Pembelian::query()->whereYear('pembelian.tanggal_beli', $year)->with(['user','pemasok'])->where('status', 'lunas');
        if ($month) {
            $penjualanQuery->whereMonth('penjualan.created_at', $month);
            $pembelianQuery->whereMonth('pembelian.tanggal_beli', $month);
        }

        $totalPenjualan = (clone $penjualanQuery)->sum('total_harga');
        $totalPembelian = (clone $pembelianQuery)->sum('bayar');
        $countPenjualan = (clone $penjualanQuery)->count();
        $countPembelian = (clone $pembelianQuery)->count();

        // Fetch latest 200 rows for tables
        $listPenjualan = (clone $penjualanQuery)
            ->leftJoin('users','users.id','=','penjualan.user_id')
            ->select('penjualan.*', DB::raw('users.name as user_name'))
            ->orderByDesc('penjualan.created_at')
            ->limit(200)
            ->get();

        $listPembelian = (clone $pembelianQuery)
            ->leftJoin('users','users.id','=','pembelian.user_id')
            ->leftJoin('pemasok','pemasok.id_pemasok','=','pembelian.pemasok_id_pemasok')
            ->select('pembelian.*', DB::raw('users.name as user_name'), DB::raw('pemasok.nama_pemasok as pemasok_name'))
            ->orderByDesc('pembelian.tanggal_beli')
            ->limit(200)
            ->get();

        $listPenjualan = (clone $penjualanQuery)
            ->select(['penjualan.*'])
            ->addSelect(DB::raw('users.name as user_name'))
            ->leftJoin('users','users.id','=','penjualan.user_id')
            ->orderByDesc('penjualan.created_at')
            ->limit(200)
            ->get();

        $listPembelian = (clone $pembelianQuery)
            ->select(['pembelian.*'])
            ->addSelect(DB::raw('users.name as user_name'))
            ->addSelect(DB::raw('pemasok.nama_pemasok as pemasok_name'))
            ->leftJoin('users','users.id','=','pembelian.user_id')
            ->leftJoin('pemasok','pemasok.id_pemasok','=','pembelian.pemasok_id_pemasok')
            ->orderByDesc('pembelian.tanggal_beli')
            ->limit(200)
            ->get();

        // ===========================
        // Monthly Summary (Penjualan & Pembelian)
        // ===========================
        $salesMonthly = Penjualan::selectRaw('EXTRACT(MONTH FROM created_at)::int as m, COALESCE(SUM(total_harga),0) as total')
            ->whereYear('created_at',$year)
            ->when($month, fn($qr) => $qr->whereMonth('created_at',$month))
            ->groupBy('m')->pluck('total','m');
        $purchaseMonthly = Pembelian::selectRaw('EXTRACT(MONTH FROM tanggal_beli)::int as m, COALESCE(SUM(bayar),0) as total')
            ->whereYear('tanggal_beli',$year)
            ->when($month, fn($qr) => $qr->whereMonth('tanggal_beli',$month))
            ->groupBy('m')->pluck('total','m');
        $monthNames = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];
        $monthlySummary = [];
        $loopMonths = $month ? [$month] : range(1,12);
        foreach ($loopMonths as $m) {
            $penj = (float)($salesMonthly[$m] ?? 0);
            $pemb = (float)($purchaseMonthly[$m] ?? 0);
            $profit = $penj - $pemb; // sederhana: laba kotor berdasarkan pembelian vs penjualan
            $margin = $penj > 0 ? ($profit / $penj * 100) : 0;
            $row = [
                'bulan_num' => $m,
                'bulan_nama' => $monthNames[$m],
                'tahun' => $year,
                'total_penjualan' => $penj,
                'total_pembelian' => $pemb,
                'profit' => $profit,
                'margin' => $margin,
            ];
            // Filter q (cari pada nama bulan atau angka atau tahun)
            if ($q !== '') {
                $needle = mb_strtolower($q);
                $hay = mb_strtolower($row['bulan_nama'].' '.$row['tahun'].' '.$row['bulan_num']);
                if (strpos($hay,$needle) === false) continue;
            }
            $monthlySummary[] = $row;
        }

        $overallProfit = $totalPenjualan - $totalPembelian;
        $overallMargin = $totalPenjualan > 0 ? ($overallProfit / $totalPenjualan * 100) : 0;

        return view('laporan.index', [
            'filterYear' => $year,
            'filterMonth' => $month,
            'q' => $q,
            'totalPenjualan' => $totalPenjualan,
            'totalPembelian' => $totalPembelian,
            'overallProfit' => $overallProfit,
            'overallMargin' => $overallMargin,
            'countPenjualan' => $countPenjualan,
            'countPembelian' => $countPembelian,
            'listPenjualan' => $listPenjualan,
            'listPembelian' => $listPembelian,
            'monthlySummary' => $monthlySummary,
        ]);
    }

    public function penjualanPdf(Request $request)
    {
        $year = $request->integer('tahun', now()->year);
        $month = $request->integer('bulan');
    $q = Penjualan::query()->with('user')->whereYear('penjualan.created_at',$year);
    if ($month) $q->whereMonth('penjualan.created_at',$month);
    $rows = $q->orderBy('penjualan.created_at')->get();
        $title = 'Laporan Penjualan '.($month?sprintf('%02d/',$month):'').$year;
    $html = view('laporan.penjualan_pdf', compact('rows','title','year','month'))->render();
    $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4','portrait');
        $dompdf->render();
        return response($dompdf->output())
            ->header('Content-Type','application/pdf')
            ->header('Content-Disposition','attachment; filename=\"laporan-penjualan-'.$year.($month?('-'.str_pad($month,2,'0',STR_PAD_LEFT)):'').'.pdf\"');
    }

    public function pembelianPdf(Request $request)
    {
        $year = $request->integer('tahun', now()->year);
        $month = $request->integer('bulan');
    $q = Pembelian::query()->with(['user','pemasok'])->whereYear('pembelian.created_at',$year);
    if ($month) $q->whereMonth('pembelian.created_at',$month);
    $rows = $q->orderBy('pembelian.created_at')->get();
        $title = 'Laporan Pembelian '.($month?sprintf('%02d/',$month):'').$year;
    $html = view('laporan.pembelian_pdf', compact('rows','title','year','month'))->render();
    $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4','portrait');
        $dompdf->render();
        return response($dompdf->output())
            ->header('Content-Type','application/pdf')
            ->header('Content-Disposition','attachment; filename=\"laporan-pembelian-'.$year.($month?('-'.str_pad($month,2,'0',STR_PAD_LEFT)):'').'.pdf\"');
    }
}
