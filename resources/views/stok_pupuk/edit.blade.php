<x-app-layout>
<div class="container py-4">
    <h1 class="h5 mb-3">Edit Pupuk</h1>
    <form method="post" action="{{ route('stok-pupuk.update',$pupuk->id_pupuk) }}" class="card p-3">
        @csrf
        @method('PUT')
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Kode Pupuk</label>
                <input type="text" value="{{ $pupuk->kode_pupuk }}" class="form-control" readonly>
            </div>
            <div class="col-md-8">
                <label class="form-label">Nama Pupuk</label>
                <input type="text" name="nama_pupuk" value="{{ old('nama_pupuk',$pupuk->nama_pupuk) }}" class="form-control @error('nama_pupuk') is-invalid @enderror">
                @error('nama_pupuk')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label class="form-label">Harga Beli</label>
                <input type="number" step="0.01" name="harga_beli" value="{{ old('harga_beli',$pupuk->harga_beli) }}" class="form-control @error('harga_beli') is-invalid @enderror">
                @error('harga_beli')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label class="form-label">Harga Jual</label>
                <input type="number" step="0.01" name="harga_jual" value="{{ old('harga_jual',$pupuk->harga_jual) }}" class="form-control @error('harga_jual') is-invalid @enderror">
                @error('harga_jual')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label class="form-label">Stok</label>
                <input type="number" name="stok_pupuk" value="{{ old('stok_pupuk',$pupuk->stok_pupuk) }}" class="form-control @error('stok_pupuk') is-invalid @enderror">
                @error('stok_pupuk')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="mt-3 d-flex gap-2">
            <button class="btn btn-primary"><i class="bi bi-save"></i> Update</button>
            <a href="{{ route('stok-pupuk.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
</x-app-layout>
