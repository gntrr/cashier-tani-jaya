<x-app-layout>
<div class="container py-4">
    <h1 class="h5 mb-4">Edit Pemasok</h1>
    <form method="post" action="{{ route('pemasok.update',$pemasok->id_pemasok) }}" class="card p-3">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Kode Pemasok</label>
            <input type="text" value="{{ $pemasok->kode_pemasok }}" class="form-control" readonly>
        </div>
        <div class="mb-3">
            <label class="form-label">Nama Pemasok</label>
            <input type="text" name="nama_pemasok" value="{{ old('nama_pemasok',$pemasok->nama_pemasok) }}" class="form-control @error('nama_pemasok') is-invalid @enderror">
            @error('nama_pemasok')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Telepon</label>
            <input type="text" name="telepon_pemasok" value="{{ old('telepon_pemasok',$pemasok->telepon_pemasok) }}" class="form-control @error('telepon_pemasok') is-invalid @enderror">
            @error('telepon_pemasok')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea name="alamat_pemasok" rows="3" class="form-control @error('alamat_pemasok') is-invalid @enderror">{{ old('alamat_pemasok',$pemasok->alamat_pemasok) }}</textarea>
            @error('alamat_pemasok')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-primary"><i class="bi bi-save"></i> Update</button>
            <a href="{{ route('pemasok.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
</x-app-layout>
