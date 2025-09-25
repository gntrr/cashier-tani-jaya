<x-app-layout>
<div class="container py-4">
    <h1 class="h5 mb-4">Tambah Pemasok</h1>
    <form method="post" action="{{ route('pemasok.store') }}" class="card p-3">
        @csrf
        <div class="mb-3">
            <label class="form-label">Kode Pemasok</label>
            <input type="text" name="kode_pemasok" value="{{ old('kode_pemasok') }}" class="form-control @error('kode_pemasok') is-invalid @enderror">
            @error('kode_pemasok')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Nama Pemasok</label>
            <input type="text" name="nama_pemasok" value="{{ old('nama_pemasok') }}" class="form-control @error('nama_pemasok') is-invalid @enderror">
            @error('nama_pemasok')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Telepon</label>
            <input type="text" name="telepon_pemasok" value="{{ old('telepon_pemasok') }}" class="form-control @error('telepon_pemasok') is-invalid @enderror">
            @error('telepon_pemasok')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea name="alamat_pemasok" rows="3" class="form-control @error('alamat_pemasok') is-invalid @enderror">{{ old('alamat_pemasok') }}</textarea>
            @error('alamat_pemasok')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
            <a href="{{ route('pemasok.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
</x-app-layout>
