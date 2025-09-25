<x-app-layout>
<div class="container py-4">
    <h1 class="h5 mb-3">Detail Pembelian {{ $pembelian->kode_pembelian }}</h1>
    <div class="mb-3">
        <a href="{{ route('pembelian.index') }}" class="btn btn-sm btn-secondary">Kembali</a>
        <form action="{{ route('pembelian.destroy',$pembelian->id_pembelian) }}" method="post" class="d-inline" onsubmit="return confirm('Hapus transaksi ini?')">
            @csrf @method('DELETE')
            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i> Hapus</button>
        </form>
    </div>
    <div class="row g-3 mb-3">
        <div class="col-md-3"><div class="p-2 border rounded small">Pemasok:<br><strong>{{ $pembelian->pemasok?->nama_pemasok }}</strong></div></div>
        <div class="col-md-3"><div class="p-2 border rounded small">User:<br><strong>{{ $pembelian->user?->name }}</strong></div></div>
        <div class="col-md-3"><div class="p-2 border rounded small">Tanggal:<br><strong>{{ $pembelian->created_at->format('d/m/Y H:i') }}</strong></div></div>
        <div class="col-md-3"><div class="p-2 border rounded small">Total Item:<br><strong>{{ $pembelian->total_item }}</strong></div></div>
    </div>
    <div class="card mb-3">
        <div class="table-responsive">
            <table class="table table-sm mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Pupuk</th>
                        <th class="text-end">Harga Beli</th>
                        <th class="text-end">Qty</th>
                        <th class="text-end">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pembelian->detail as $d)
                    <tr>
                        <td>{{ $d->pupuk?->nama_pupuk }}</td>
                        <td class="text-end">{{ number_format($d->harga_beli,0,',','.') }}</td>
                        <td class="text-end">{{ $d->jumlah }}</td>
                        <td class="text-end">{{ number_format($d->subtotal,0,',','.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="row g-3">
        <div class="col-md-3"><div class="p-2 border rounded small">Total Bayar:<br><strong>Rp {{ number_format($pembelian->bayar,0,',','.') }}</strong></div></div>
    </div>
</div>
</x-app-layout>