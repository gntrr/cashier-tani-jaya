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
    <div class="d-flex justify-content-end gap-2 mb-2">
        <a href="{{ route('laporan.penjualan.pdf',['tahun'=>$filterYear,'bulan'=>$filterMonth]) }}" class="btn btn-sm btn-danger"><i class="bi bi-file-earmark-pdf"></i> Unduh PDF Penjualan</a>
        <a href="{{ route('laporan.pembelian.pdf',['tahun'=>$filterYear,'bulan'=>$filterMonth]) }}" class="btn btn-sm btn-danger"><i class="bi bi-file-earmark-pdf"></i> Unduh PDF Pembelian</a>
    </div>
    <div class="card mb-4">
        <div class="card-header">Detail Penjualan</div>
        <div class="table-responsive">
            <table class="table table-sm table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Kode</th>
                        <th>User</th>
                        <th class="text-end">Item</th>
                        <th class="text-end">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($listPenjualan as $p)
                    <tr>
                        <td>{{ \Illuminate\Support\Carbon::parse($p->created_at)->format('d/m/Y H:i') }}</td>
                        <td>{{ $p->kode_penjualan }}</td>
                        <td>{{ $p->user_name }}</td>
                        <td class="text-end">{{ $p->total_item }}</td>
                        <td class="text-end">{{ number_format($p->total_harga,0,',','.') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center text-muted">Tidak ada data</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header">Detail Pembelian</div>
        <div class="table-responsive">
            <table class="table table-sm table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Kode</th>
                        <th>User</th>
                        <th>Pemasok</th>
                        <th class="text-end">Item</th>
                        <th class="text-end">Bayar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($listPembelian as $b)
                    <tr>
                        <td>{{ \Illuminate\Support\Carbon::parse($b->created_at)->format('d/m/Y H:i') }}</td>
                        <td>{{ $b->kode_pembelian }}</td>
                        <td>{{ $b->user_name }}</td>
                        <td>{{ $b->pemasok_name }}</td>
                        <td class="text-end">{{ $b->total_item }}</td>
                        <td class="text-end">{{ number_format($b->bayar,0,',','.') }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center text-muted">Tidak ada data</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
</x-app-layout>