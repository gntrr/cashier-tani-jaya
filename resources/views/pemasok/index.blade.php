<x-app-layout>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Pemasok</h1>
        <a href="{{ route('pemasok.create') }}" class="btn btn-sm btn-primary"><i class="bi bi-plus-lg"></i> Tambah</a>
    </div>
    <form method="get" class="row g-2 mb-3">
        <div class="col-md-3">
            <input type="text" name="kode" value="{{ request('kode') }}" class="form-control" placeholder="Kode">
        </div>
        <div class="col-md-3">
            <input type="text" name="nama" value="{{ request('nama') }}" class="form-control" placeholder="Nama">
        </div>
        <div class="col-md-3 d-grid d-md-block">
            <button class="btn btn-primary"><i class="bi bi-search"></i> Filter</button>
            <a href="{{ route('pemasok.index') }}" class="btn btn-secondary ms-md-2 mt-2 mt-md-0"><i class="bi bi-arrow-counterclockwise"></i> Reset</a>
        </div>
    </form>
    <div class="card">
        <div class="table-responsive">
            <table class="table table-sm table-striped align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Telepon</th>
                        <th>Alamat</th>
                        <th style="width:110px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pemasok as $row)
                        <tr>
                            <td>{{ $row->kode_pemasok }}</td>
                            <td>{{ $row->nama_pemasok }}</td>
                            <td>{{ $row->telepon_pemasok }}</td>
                            <td>{{ Str::limit($row->alamat_pemasok, 40) }}</td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('pemasok.edit',$row->id_pemasok) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                                    <form method="post" action="{{ route('pemasok.destroy',$row->id_pemasok) }}" onsubmit="return confirm('Hapus pemasok ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted">Tidak ada data</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer py-2">
            {{ $pemasok->links() }}
        </div>
    </div>
</div>
</x-app-layout>