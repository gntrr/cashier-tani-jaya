<x-app-layout>
<div class="container py-4">
    <h1 class="h4 mb-3">Laporan</h1>
    <form method="get" class="row g-2 mb-4">
        <div class="col-md-2">
            <select name="tahun" class="form-select">
                @for($y = now()->year; $y >= now()->year-5; $y--)
                    <option value="{{ $y }}" @selected($y == $filterYear)>{{ $y }}</option>
                @endfor
            </select>
        </div>
        <div class="col-md-2">
            <select name="bulan" class="form-select">
                <option value="">Semua Bulan</option>
                @for($m=1;$m<=12;$m++)
                    <option value="{{ $m }}" @selected($m == $filterMonth)>{{ str_pad($m,2,'0',STR_PAD_LEFT) }}</option>
                @endfor
            </select>
        </div>
        <div class="col-md-3 d-grid d-md-block">
            <button class="btn btn-primary"><i class="bi bi-search"></i> Tampilkan</button>
            <a href="{{ route('laporan.index') }}" class="btn btn-secondary ms-md-2 mt-2 mt-md-0">Reset</a>
        </div>
    </form>
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="p-3 rounded border bg-light">
                <div class="small text-muted">Total Penjualan</div>
                <div class="fw-semibold">Rp {{ number_format($totalPenjualan,0,',','.') }}</div>
                <div class="small text-muted">Transaksi: {{ $countPenjualan }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="p-3 rounded border bg-light">
                <div class="small text-muted">Total Pembelian</div>
                <div class="fw-semibold">Rp {{ number_format($totalPembelian,0,',','.') }}</div>
                <div class="small text-muted">Transaksi: {{ $countPembelian }}</div>
            </div>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header">Series Penjualan ({{ $filterYear }})</div>
        <div class="card-body">
            <pre class="small mb-0">{{ json_encode($seriesPenjualan, JSON_PRETTY_PRINT) }}</pre>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header">Series Pembelian ({{ $filterYear }})</div>
        <div class="card-body">
            <pre class="small mb-0">{{ json_encode($seriesPembelian, JSON_PRETTY_PRINT) }}</pre>
        </div>
    </div>
</div>
</x-app-layout>