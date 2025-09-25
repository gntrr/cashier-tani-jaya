<x-app-layout>
<div class="container py-4">
    <h1 class="h4 mb-3">Stok Pupuk</h1>
    <form method="get" class="row g-2 mb-3">
        <div class="col-md-3">
            <input type="text" name="kode" value="{{ request('kode') }}" class="form-control" placeholder="Kode Pupuk">
        </div>
        <div class="col-md-3">
            <input type="text" name="nama" value="{{ request('nama') }}" class="form-control" placeholder="Nama Pupuk">
        </div>
        <div class="col-md-3 d-grid d-md-block">
            <button class="btn btn-primary"><i class="bi bi-search"></i> Filter</button>
            <a href="{{ route('stok-pupuk.index') }}" class="btn btn-secondary ms-md-2 mt-2 mt-md-0"><i class="bi bi-arrow-counterclockwise"></i> Reset</a>
        </div>
    </form>
    <div class="d-flex justify-content-between mb-2">
        <div></div>
        <a href="{{ route('stok-pupuk.create') }}" class="btn btn-sm btn-primary"><i class="bi bi-plus"></i> Tambah</a>
    </div>
    <div class="card">
        <div class="table-responsive">
            <table class="table table-sm table-striped align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th class="text-end">Harga Beli</th>
                        <th class="text-end">Harga Jual</th>
                        <th class="text-end">Stok</th>
                        <th class="text-center" style="width:110px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pupuk as $row)
                        <tr>
                            <td>{{ $row->kode_pupuk }}</td>
                            <td>{{ $row->nama_pupuk }}</td>
                            <td class="text-end">{{ number_format($row->harga_beli,0,',','.') }}</td>
                            <td class="text-end">{{ number_format($row->harga_jual,0,',','.') }}</td>
                            <td class="text-end">{{ $row->stok_pupuk }}</td>
                            <td class="text-center">
                                <a href="{{ route('stok-pupuk.edit',$row->id_pupuk) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('stok-pupuk.destroy',$row->id_pupuk) }}" method="post" class="d-inline" onsubmit="return confirm('Hapus data?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(isset($pupuk))
            <div class="card-footer py-2">
                {{ $pupuk->links() }}
            </div>
        @endif
    </div>
</div>
</x-app-layout>