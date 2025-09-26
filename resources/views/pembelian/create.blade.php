<x-app-layout>
<div class="container py-4">
    <h1 class="h5 mb-3">Transaksi Pembelian Baru</h1>
    @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
    <form method="post" action="{{ route('pembelian.store') }}" class="card p-3">
        @csrf
        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <label class="form-label">Pemasok</label>
                <select name="pemasok_id" class="form-select" required>
                    <option value="">-- pilih --</option>
                    @foreach($pemasok as $ps)
                        <option value="{{ $ps->id_pemasok }}">{{ $ps->nama_pemasok }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Bayar</label>
                <input type="number" step="0.01" name="bayar" class="form-control" required>
            </div>
        </div>

        <div id="items-wrapper">
            <div class="row g-2 align-items-end item-row mb-2">
                <div class="col-md-5">
                    <label class="form-label">Pupuk</label>
                    <select name="item_pupuk_id[]" class="form-select">
                        <option value="">-- pilih --</option>
                        @foreach($pupuk as $p)
                            <option value="{{ $p->id_pupuk }}" data-harga="{{ $p->harga_beli }}">{{ $p->nama_pupuk }} (Stok: {{ $p->stok_pupuk }}) (Harga Beli: {{ number_format($p->harga_beli,0,',','.') }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Jumlah</label>
                    <input type="number" name="item_jumlah[]" class="form-control" min="1" value="1">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Harga Beli (opsional)</label>
                    <input type="number" step="0.01" name="item_harga_beli[]" class="form-control" placeholder="Auto dari master">
                </div>
                <div class="col-md-2 d-grid">
                    <button type="button" class="btn btn-danger btn-remove-item d-none"><i class="bi bi-x"></i></button>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <button type="button" id="btn-add-item" class="btn btn-sm btn-secondary"><i class="bi bi-plus"></i> Tambah Baris</button>
        </div>
        <div>
            <button class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
            <a href="{{ route('pembelian.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
</x-app-layout>
@push('scripts')
<script>
    const wrapper = document.getElementById('items-wrapper');
    document.getElementById('btn-add-item').addEventListener('click', () => {
        const first = wrapper.querySelector('.item-row');
        const clone = first.cloneNode(true);
        clone.querySelectorAll('input').forEach(i=>{i.value = i.name.includes('item_jumlah')?1:''});
        clone.querySelectorAll('select').forEach(s=>{s.selectedIndex=0});
        clone.querySelector('.btn-remove-item').classList.remove('d-none');
        wrapper.appendChild(clone);
    });
    wrapper.addEventListener('click', e => {
        if (e.target.closest('.btn-remove-item')) {
            const rows = wrapper.querySelectorAll('.item-row');
            if (rows.length > 1) e.target.closest('.item-row').remove();
        }
    });
</script>
@endpush