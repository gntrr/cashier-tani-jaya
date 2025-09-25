<x-app-layout>
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="d-flex flex-wrap gap-3 justify-content-between align-items-end">
                    <div>
                        <h3 class="mb-1">Dashboard</h3>
                        <div class="text-muted small">Ringkasan penjualan</div>
                    </div>
                    <form method="get" class="row g-2 align-items-end">
                        <div class="col-auto">
                            <label class="form-label mb-1">Tahun</label>
                            <select name="tahun" class="form-select form-select-sm">
                                @for($y=now()->year;$y>=now()->year-5;$y--)
                                    <option value="{{ $y }}" @selected($y==$filterYear)>{{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-auto">
                            <label class="form-label mb-1">Bulan</label>
                            <select name="bulan" class="form-select form-select-sm">
                                <option value="">Semua</option>
                                @for($m=1;$m<=12;$m++)
                                    <option value="{{ $m }}" @selected($filterMonth==$m)>{{ str_pad($m,2,'0',STR_PAD_LEFT) }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-sm btn-primary"><i class="bi bi-filter"></i> Terapkan</button>
                            <a href="{{ route('dashboard') }}" class="btn btn-sm btn-secondary">Reset</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="app-content">
            <div class="container-fluid">
                <div class="row g-3 mb-3">
                    <div class="col-sm-6 col-lg-3">
                        <div class="info-box">
                            <span class="info-box-icon text-bg-primary"><i class="bi bi-cash-stack"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Penjualan</span>
                                <span class="info-box-number">Rp {{ number_format($totalPenjualan,0,',','.') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="info-box">
                            <span class="info-box-icon text-bg-danger"><i class="bi bi-basket"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Modal (HPP)</span>
                                <span class="info-box-number">Rp {{ number_format($totalModal,0,',','.') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="info-box">
                            <span class="info-box-icon text-bg-info"><i class="bi bi-cash"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Profit</span>
                                <span class="info-box-number">Rp {{ number_format($profit,0,',','.') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="info-box">
                            <span class="info-box-icon text-bg-success"><i class="bi bi-receipt"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Jumlah Transaksi</span>
                                <span class="info-box-number">{{ $totalTransaksi }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="info-box">
                            <span class="info-box-icon text-bg-warning"><i class="bi bi-graph-up"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Rata2 / Transaksi</span>
                                <span class="info-box-number">Rp {{ number_format($avgPerTransaksi,0,',','.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-lg-8">
                        <div class="card mb-3">
                            <div class="card-header">Grafik Harian @if($filterMonth) ({{ str_pad($filterMonth,2,'0',STR_PAD_LEFT) }}/{{ $filterYear }}) @else (30 Hari Terakhir) @endif</div>
                            <div class="card-body">
                                <canvas id="chartDaily" height="160"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card mb-3">
                            <div class="card-header">Rekap Bulanan ({{ $filterYear }})</div>
                            <div class="card-body">
                                <canvas id="chartMonthly" height="260"></canvas>
                            </div>
                        </div>
                        @env('local')
                        <div class="card">
                            <div class="card-header">Debug Data (Local Only)</div>
                            <div class="card-body small">
                                <strong>Daily:</strong>
                                <pre class="mb-2">{{ json_encode(array_combine($dailyLabels,$dailyData), JSON_PRETTY_PRINT) }}</pre>
                                <strong>Monthly:</strong>
                                <pre class="mb-0">{{ json_encode(array_combine($monthlyLabels,$monthlyData), JSON_PRETTY_PRINT) }}</pre>
                            </div>
                        </div>
                        @endenv
                    </div>
                </div>
            </div>
        </div>
    </main>
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const dailyCtx = document.getElementById('chartDaily');
        const monthlyCtx = document.getElementById('chartMonthly');
        const dailyChart = new Chart(dailyCtx,{type:'line',data:{labels:@json($dailyLabels),datasets:[{label:'Penjualan',data:@json($dailyData),borderColor:'#0d6efd',backgroundColor:'rgba(13,110,253,.15)',fill:true,tension:.25}]},options:{scales:{y:{beginAtZero:true}}}});
        const monthlyChart = new Chart(monthlyCtx,{type:'bar',data:{labels:@json($monthlyLabels),datasets:[{label:'Total',data:@json($monthlyData),backgroundColor:'#198754'}]},options:{scales:{y:{beginAtZero:true}}}});
    </script>
    @endpush
</x-app-layout>
