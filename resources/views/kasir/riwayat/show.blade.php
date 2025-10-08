<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 container mx-auto py-4">
        <div class="text-zinc-400 text-xs mb-6"><a href="{{ route('kasir.riwayat.index') }}" class="hover:underline">Home > Riwayat</a> > Detail</div>
        <div class="flex flex-col gap-6">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-5">
                    <div>
                        <h1 class="text-xl font-semibold text-slate-800">Transaksi {{ $penjualan->kode_penjualan }}</h1>
                        <p class="text-xs text-slate-500 mt-1">Tanggal: {{ $penjualan->created_at->format('d/m/Y H:i') }} • Kasir: {{ $penjualan->user?->name }}</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-medium">Sukses</span>
                    </div>
                </div>
                <div class="overflow-x-auto rounded-xl border border-slate-200">
                    <table class="min-w-full text-sm">
                        <thead class="bg-slate-50">
                            <tr class="text-left text-slate-600 border-b border-slate-200">
                                <th class="px-4 py-2">#</th>
                                <th class="px-4 py-2">Kode</th>
                                <th class="px-4 py-2">Nama Pupuk</th>
                                <th class="px-4 py-2 text-right">Harga</th>
                                <th class="px-4 py-2 text-center">Qty</th>
                                <th class="px-4 py-2 text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($penjualan->detail as $i=>$d)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-4 py-2 text-slate-500">{{ $i+1 }}</td>
                                    <td class="px-4 py-2 text-slate-700">{{ $d->pupuk?->kode_pupuk }}</td>
                                    <td class="px-4 py-2 text-slate-700">{{ $d->pupuk?->nama_pupuk }}</td>
                                    <td class="px-4 py-2 text-right text-slate-700">{{ number_format($d->harga_jual,0,',','.') }}</td>
                                    <td class="px-4 py-2 text-center text-slate-700">{{ $d->jumlah }}</td>
                                    <td class="px-4 py-2 text-right text-slate-700">{{ number_format($d->subtotal,0,',','.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 flex flex-col">
                        <span class="text-xs text-slate-500">Total Item</span>
                        <span class="text-lg font-semibold text-slate-700">{{ $penjualan->total_item }}</span>
                    </div>
                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 flex flex-col">
                        <span class="text-xs text-slate-500">Total Harga</span>
                        <span class="text-lg font-semibold text-slate-700">Rp {{ number_format($penjualan->total_harga,0,',','.') }}</span>
                    </div>
                    <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 flex flex-col">
                        <span class="text-xs text-slate-500">Bayar / Kembali</span>
                        <span class="text-lg font-semibold text-slate-700">Rp {{ number_format($penjualan->bayar,0,',','.') }} <span class="text-xs font-normal text-slate-500">(Kembali Rp {{ number_format($penjualan->kembalian,0,',','.') }})</span></span>
                    </div>
                </div>
                <div class="mt-8">
                    <a href="{{ route('kasir.riwayat.index') }}" class="inline-flex items-center gap-2 text-sm text-indigo-600 hover:text-indigo-700">&larr; Kembali</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
