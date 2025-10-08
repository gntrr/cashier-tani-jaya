<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 11px; margin: 15px; }
        h1,h2,h3,h4 { margin:0; padding:0; }
        .header { text-align:center; margin-bottom:15px; }
        .header h2 { font-size:16px; font-weight:700; }
        .meta { margin-bottom:12px; font-size:11px; }
        .meta table { border:none; width:100%; }
        .meta td { padding:2px 4px; border:none; vertical-align:top; }
        table.report { width:100%; border-collapse:collapse; }
        table.report th, table.report td { border:1px solid #000; padding:5px 6px; }
        table.report th { background:#f2f2f2; font-weight:600; font-size:11px; }
        .text-right { text-align:right; }
        .text-center { text-align:center; }
        .sign { margin-top:40px; width:100%; font-size:11px; }
        .sign td { border:none; text-align:right; padding:4px; }
        .nowrap { white-space:nowrap; }
    </style>
</head>
<body>
    <div class="header">
        <h2>UD TANI JAYA</h2>
        <h3 style="margin-top:4px; font-size:13px;">LAPORAN PENJUALAN PUPUK NON-SUBSIDI</h3>
    </div>

    @php
        $first = $rows->first();
        $printedAt = now();
        $monthName = isset($month) && $month ? \Carbon\Carbon::create(null,$month)->locale('id')->translatedFormat('F') : 'Semua Bulan';
    @endphp

    <div class="meta">
        <table>
            <tr><td style="width:110px;">Periode</td><td>: {{ $monthName }} / {{ $year }}</td></tr>
            <tr><td>Dicetak</td><td>: {{ $printedAt->format('d M Y H:i') }}</td></tr>
            <tr><td>Admin</td><td>: {{ auth()->user()->name ?? '-' }}</td></tr>
        </table>
    </div>

    <table class="report">
        <thead>
            <tr>
                <th style="width:140px;" class="text-center">Bulan / Tahun</th>
                <th style="width:140px;" class="text-center">Total Penjualan</th>
                <th style="width:140px;" class="text-center">Total Pembelian</th>
                <th style="width:140px;" class="text-center">Laba / Rugi</th>
                <th class="text-center">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @php
                $purchaseMap = \App\Models\Pembelian::selectRaw("TO_CHAR(created_at,'YYYY-MM') as ym, COALESCE(SUM(bayar),0) as total")
                    ->whereYear('created_at',$year)
                    ->when(isset($month) && $month, fn($q) => $q->whereMonth('created_at',$month))
                    ->groupBy('ym')->pluck('total','ym');
                $salesMap = $rows->groupBy(fn($r) => $r->created_at->format('Y-m'))->map(fn($c) => $c->sum('total_harga'));
                $loopMonths = isset($month) && $month ? [$month] : range(1,12);
                $printedAny = false;
            @endphp
            @foreach($loopMonths as $m)
                @php
                    $ym = $year.'-'.str_pad($m,2,'0',STR_PAD_LEFT);
                    $totalPenj = $salesMap[$ym] ?? 0;
                    $totalPemb = $purchaseMap[$ym] ?? 0;
                    $profit = $totalPenj - $totalPemb;
                    if($totalPenj==0 && $totalPemb==0) continue; // skip totally empty
                    $printedAny = true;
                @endphp
                <tr>
                    <td class="text-center">{{ \Carbon\Carbon::parse($ym.'-01')->translatedFormat('F') }} / {{ $year }}</td>
                    <td class="text-right">{{ number_format($totalPenj,0,',','.') }}</td>
                    <td class="text-right">{{ number_format($totalPemb,0,',','.') }}</td>
                    <td class="text-right">{{ number_format($profit,0,',','.') }}</td>
                    <td class="text-center">{{ $profit >= 0 ? 'Laba' : 'Rugi' }}</td>
                </tr>
            @endforeach
            @if(!$printedAny)
                <tr><td colspan="5" class="text-center">Tidak ada data</td></tr>
            @endif
        </tbody>
    </table>

    <table class="sign">
        <tr>
            <td>{{ config('app.name') }}, {{ $printedAt->translatedFormat('d F Y') }}</td>
        </tr>
        <tr><td style="padding-top:50px;">( ................................ )</td></tr>
    </table>
</body>
</html>
