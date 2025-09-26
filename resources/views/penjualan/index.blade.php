<x-app-layout>
<div class="container py-4">
    <h1 class="h4 mb-3">Penjualan</h1>
    <form method="get" class="row g-2 mb-3">
        <div class="col-md-2">
            <input type="text" name="kode" value="{{ request('kode') }}" class="form-control" placeholder="Kode">
        </div>
        <div class="col-md-2">
            <input type="date" name="dari" value="{{ request('dari') }}" class="form-control" placeholder="Dari">
        </div>
        <div class="col-md-2">
            <input type="date" name="sampai" value="{{ request('sampai') }}" class="form-control" placeholder="Sampai">
        </div>
        <div class="col-md-3 d-grid d-md-block">
            <button class="btn btn-primary"><i class="bi bi-search"></i> Filter</button>
            <a href="{{ route('penjualan.index') }}" class="btn btn-secondary ms-md-2 mt-2 mt-md-0"><i class="bi bi-arrow-counterclockwise"></i> Reset</a>
        </div>
        <div class="col-md-3 text-md-end">
            <div class="small text-muted">Total Nominal</div>
            <div class="fw-semibold">Rp {{ number_format($totalNominal,0,',','.') }}</div>
            <div class="small text-muted">Transaksi: {{ $totalTransaksi }}</div>
        </div>
    </form>
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div></div>
        <a href="{{ route('penjualan.create') }}" class="btn btn-success"><i class="bi bi-plus-lg"></i> Transaksi Baru</a>
    </div>
    <div class="card">
        <div class="table-responsive">
            <table class="table table-sm table-striped align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Kode</th>
                        <th>User</th>
                        <th class="text-end">Item</th>
                        <th class="text-end">Total</th>
                        <th class="text-end">Bayar</th>
                        <th class="text-end">Kembali</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($penjualan as $row)
                        <tr>
                            <td>{{ $row->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $row->kode_penjualan }}</td>
                            <td>{{ $row->user?->name }}</td>
                            <td class="text-end">{{ $row->total_item }}</td>
                            <td class="text-end">{{ number_format($row->total_harga,0,',','.') }}</td>
                            <td class="text-end">{{ number_format($row->bayar,0,',','.') }}</td>
                            <td class="text-end">{{ number_format($row->kembalian,0,',','.') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-muted">Tidak ada data</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer py-2">
            {{ $penjualan->links() }}
        </div>
    </div>
</div>
</x-app-layout>