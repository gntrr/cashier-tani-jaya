<x-app-layout>
<div class="container py-4">
    <h1 class="h4 mb-3">Pembelian</h1>
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
        <div class="col-md-2">
            <input type="text" name="pemasok" value="{{ request('pemasok') }}" class="form-control" placeholder="Pemasok">
        </div>
        <div class="col-md-2">
            <input type="text" name="pupuk" value="{{ request('pupuk') }}" class="form-control" placeholder="Pupuk">
        </div>
        <div class="col-md-2 d-grid d-md-block">
            <button class="btn btn-primary"><i class="bi bi-search"></i> Filter</button>
            <a href="{{ route('pembelian.index') }}" class="btn btn-secondary ms-md-2 mt-2 mt-md-0"><i class="bi bi-arrow-counterclockwise"></i> Reset</a>
        </div>
    </form>
    <div class="row mb-3 g-3">
        <div class="col-md-3">
            <div class="p-3 bg-light rounded border">
                <div class="small text-muted">Total Nominal</div>
                <div class="fw-semibold">Rp {{ number_format($totalNominal,0,',','.') }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="p-3 bg-light rounded border">
                <div class="small text-muted">Total Transaksi</div>
                <div class="fw-semibold">{{ $totalTransaksi }}</div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="table-responsive">
            <table class="table table-sm table-striped align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Kode</th>
                        <th>Pemasok</th>
                        <th class="text-end">Item</th>
                        <th class="text-end">Bayar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pembelian as $row)
                        <tr>
                            <td>{{ $row->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $row->kode_pembelian }}</td>
                            <td>{{ $row->pemasok?->nama_pemasok }}</td>
                            <td class="text-end">{{ $row->total_item }}</td>
                            <td class="text-end">{{ number_format($row->bayar,0,',','.') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted">Tidak ada data</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer py-2">
            {{ $pembelian->links() }}
        </div>
    </div>
</div>
</x-app-layout>