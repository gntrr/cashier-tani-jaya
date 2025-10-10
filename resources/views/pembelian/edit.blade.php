<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 container mx-auto py-4">
        <div class="text-zinc-400 text-xs mb-6">Home > Transaksi > Pembelian > Edit</div>
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-4 sm:p-5 border-b border-slate-200 bg-slate-50/60 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <h1 class="text-base font-semibold text-slate-700">Edit Pembelian <span class="text-emerald-600">{{ $pembelian->kode_pembelian }}</span></h1>
                <div class="flex gap-2">
                    {{-- <a href="{{ route('pembelian.show', $pembelian->id_pembelian) }}" class="px-3 py-2 rounded-xl border border-slate-200 text-sm font-medium text-slate-700 hover:bg-slate-50">Detail</a> --}}
                    <a href="{{ route('pembelian.index') }}" class="px-3 py-2 rounded-xl border border-slate-200 text-sm font-medium text-slate-700 hover:bg-slate-50">Kembali</a>
                </div>
            </div>
            <form method="POST" action="{{ route('pembelian.update', $pembelian->id_pembelian) }}" class="p-4 sm:p-5 space-y-6">
                @csrf
                @method('PUT')
                @if(session('error'))
                    <div class="rounded-xl bg-red-50 border border-red-200 text-red-700 px-4 py-2 text-sm">{{ session('error') }}</div>
                @endif
                <div class="grid md:grid-cols-2 gap-5">
                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-medium text-slate-500">Pemasok</label>
                        <select name="pemasok_id" required class="rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                            <option value="">-- pilih --</option>
                            @foreach($pemasok as $ps)
                                <option value="{{ $ps->id_pemasok }}" @selected($pembelian->pemasok_id_pemasok == $ps->id_pemasok)>{{ $ps->nama_pemasok }}</option>
                            @endforeach
                        </select>
                        @error('pemasok_id')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-medium text-slate-500">Total Bayar (Terhitung otomatis)</label>
                        <input type="number" step="0.01" name="bayar" value="{{ old('bayar', $pembelian->bayar) }}" required readonly class="rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm" />
                        @error('bayar')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-medium text-slate-500">Tanggal Beli</label>
                        <input type="date" name="tanggal_beli" value="{{ old('tanggal_beli', $pembelian->tanggal_beli) }}" required class="rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm" />
                        @error('tanggal_beli')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-medium text-slate-500">Status</label>
                        <select name="status" required class="rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                            <option value="lunas" @selected($pembelian->status == 'lunas')>Lunas</option>
                            <option value="tertunda" @selected($pembelian->status == 'tertunda')>Tertunda</option>
                        </select>
                        @error('status')<p class="text-xs text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div>
                    <h2 class="text-sm font-semibold text-slate-700 mb-3">Detail Item</h2>
                    <div id="items-wrapper" class="space-y-3">
                        @foreach($pembelian->detail as $d)
                        <div class="item-row grid md:grid-cols-12 gap-3 p-3 rounded-xl border border-slate-200 bg-slate-50/40">
                            <div class="md:col-span-5 flex flex-col gap-1">
                                <label class="text-xs font-medium text-slate-500">Pupuk</label>
                                <select name="item_pupuk_id[]" class="rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                                    <option value="">-- pilih --</option>
                                    @foreach($pupuk as $p)
                                        <option value="{{ $p->id_pupuk }}" @selected($d->pupuk_id_pupuk == $p->id_pupuk) data-harga="{{ $p->harga_beli }}">{{ $p->nama_pupuk }} (Stok: {{ $p->stok_pupuk }}) (Hb: {{ number_format($p->harga_beli,0,',','.') }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="md:col-span-2 flex flex-col gap-1">
                                <label class="text-xs font-medium text-slate-500">Jumlah</label>
                                <input type="number" name="item_jumlah[]" value="{{ $d->jumlah }}" min="1" class="rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm" />
                            </div>
                            <div class="md:col-span-3 flex flex-col gap-1">
                                <label class="text-xs font-medium text-slate-500">Harga Beli (Opsional)</label>
                                <input type="number" step="0.01" name="item_harga_beli[]" value="{{ $d->harga_beli }}" class="rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm" />
                            </div>
                            <div class="md:col-span-2 flex items-end">
                                <button type="button" class="btn-remove-item w-full rounded-xl border border-red-200 text-red-600 text-sm py-2 hover:bg-red-50">Hapus</button>
                            </div>
                        </div>
                        @endforeach
                        @if(!$pembelian->detail->count())
                        <div class="text-sm text-slate-500">Tidak ada detail.</div>
                        @endif
                    </div>
                    <div class="mt-3">
                        <button type="button" id="btn-add-item" class="rounded-xl border border-slate-200 px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">+ Tambah Baris</button>
                    </div>
                    @error('item_pupuk_id')<p class="text-xs text-red-600 mt-2">{{ $message }}</p>@enderror
                </div>
                <div class="flex gap-3">
                    <button class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-5 py-2 text-sm font-medium text-white hover:bg-emerald-700">Update</button>
                    <a href="{{ route('pembelian.show', $pembelian->id_pembelian) }}" class="rounded-xl border border-slate-200 px-5 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Batal</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const wrapper = document.querySelector('#items-wrapper');
            const addBtn = document.querySelector('#btn-add-item');
            const bayarInput = document.querySelector('input[name="bayar"]');

            // Tambah baris baru
            addBtn.addEventListener('click', () => {
                const first = wrapper.querySelector('.item-row');
                const clone = first.cloneNode(true);

                // reset semua input & select
                clone.querySelectorAll('input').forEach(input => {
                    if (input.name.includes('item_jumlah')) input.value = 1;
                    else input.value = '';
                });
                clone.querySelectorAll('select').forEach(select => select.selectedIndex = 0);
                clone.querySelector('.btn-remove-item').classList.remove('hidden');
                wrapper.appendChild(clone);
                updateTotal();
            });

            // Hapus baris
            wrapper.addEventListener('click', e => {
                if (e.target.classList.contains('btn-remove-item')) {
                    const rows = wrapper.querySelectorAll('.item-row');
                    if (rows.length > 1) e.target.closest('.item-row').remove();
                    updateTotal();
                }
            });

            // Tangani perubahan di semua select & input
            wrapper.addEventListener('input', handleChange);
            wrapper.addEventListener('change', handleChange);

            function handleChange(e) {
                const target = e.target;
                const row = target.closest('.item-row');
                if (!row) return;

                // Jika select pupuk berubah, isi harga otomatis
                if (target.tagName === 'SELECT') {
                    const harga = parseFloat(target.options[target.selectedIndex]?.dataset?.harga || 0);
                    const hargaInput = row.querySelector('input[name^="item_harga_beli"]');
                    if (hargaInput) hargaInput.value = harga > 0 ? harga : '';
                }

                // Setiap kali ada perubahan qty atau pupuk, hitung ulang total
                if (target.name.includes('item_jumlah') || target.tagName === 'SELECT') {
                    updateTotal();
                }
            }

            // Hitung total seluruh baris
            function updateTotal() {
                let total = 0;
                wrapper.querySelectorAll('.item-row').forEach(row => {
                    const qty = parseFloat(row.querySelector('input[name^="item_jumlah"]')?.value || 0);
                    const harga = parseFloat(row.querySelector('input[name^="item_harga_beli"]')?.value ||
                        0);
                    total += qty * harga;
                });
                if (bayarInput) bayarInput.value = total ? total.toFixed(2) : '';
            }

            // Jalankan awal
            updateTotal();
        });
    </script>
</x-app-layout>