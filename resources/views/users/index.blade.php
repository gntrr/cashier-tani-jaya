<x-app-layout>
<div class="container py-4">
    <h1 class="h4 mb-3">Users</h1>
    <form method="get" class="row g-2 mb-3">
        <div class="col-md-3">
            <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Nama / Email">
        </div>
        <div class="col-md-2">
            <select name="role" class="form-select">
                <option value="">Semua Role</option>
                <option value="1" @selected(request('role')==='1')>Kasir</option>
                <option value="0" @selected(request('role')==='0')>Admin</option>
            </select>
        </div>
        <div class="col-md-3 d-grid d-md-block">
            <button class="btn btn-primary"><i class="bi bi-search"></i> Filter</button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary ms-md-2 mt-2 mt-md-0"><i class="bi bi-arrow-counterclockwise"></i> Reset</a>
        </div>
    </form>
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div></div>
        <a href="{{ route('users.create') }}" class="btn btn-success"><i class="bi bi-plus-lg"></i> Tambah</a>
    </div>
    <div class="card">
        <div class="table-responsive">
            <table class="table table-sm table-striped align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Terdaftar</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $row)
                        <tr>
                            <td>{{ $row->name }}</td>
                            <td>{{ $row->email }}</td>
                            <td>
                                @if($row->role==1)
                                    <span class="badge text-bg-primary">Kasir</span>
                                @else
                                    <span class="badge text-bg-secondary">Admin</span>
                                @endif
                            </td>
                            <td>{{ $row->created_at->format('d/m/Y H:i') }}</td>
                            <td class="text-end">
                                <a href="{{ route('users.edit',$row) }}" class="btn btn-sm btn-primary"><i class="bi bi-pencil-square"></i> Edit</a>
                                @if(auth()->id() !== $row->id)
                                <form action="{{ route('users.destroy',$row) }}" method="post" class="d-inline" onsubmit="return confirm('Hapus user ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i> Hapus</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted">Tidak ada data</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer py-2">
            {{ $users->links() }}
        </div>
    </div>
</div>
</x-app-layout>