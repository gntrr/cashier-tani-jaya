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
                <option value="1" @selected(request('role')==='1')>Admin</option>
                <option value="0" @selected(request('role')==='0')>Kasir</option>
            </select>
        </div>
        <div class="col-md-3 d-grid d-md-block">
            <button class="btn btn-primary"><i class="bi bi-search"></i> Filter</button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary ms-md-2 mt-2 mt-md-0"><i class="bi bi-arrow-counterclockwise"></i> Reset</a>
        </div>
    </form>
    <div class="card">
        <div class="table-responsive">
            <table class="table table-sm table-striped align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Terdaftar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $row)
                        <tr>
                            <td>{{ $row->name }}</td>
                            <td>{{ $row->email }}</td>
                            <td>
                                @if($row->role==1)
                                    <span class="badge text-bg-primary">Admin</span>
                                @else
                                    <span class="badge text-bg-secondary">Kasir</span>
                                @endif
                            </td>
                            <td>{{ $row->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted">Tidak ada data</td></tr>
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