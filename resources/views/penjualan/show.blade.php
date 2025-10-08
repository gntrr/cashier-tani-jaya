<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 container mx-auto py-4">
        <div class="text-zinc-400 text-xs mb-6">Home > Transaksi > Penjualan > Detail</div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 border-b border-slate-200 bg-slate-50/60">
                <h1 class="text-base font-semibold text-slate-700">Detail Penjualan <span class="text-emerald-600">{{ $penjualan->kode_penjualan }}</span></h1>
                <div class="flex gap-2">
                    <a href="{{ route('penjualan.index') }}" class="px-3 py-2 rounded-xl border border-slate-200 text-sm font-medium text-slate-700 hover:bg-slate-50">Kembali</a>
                    <form action="{{ route('penjualan.destroy',$penjualan->id_penjualan) }}" method="POST" onsubmit="return confirm('Hapus transaksi ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="px-3 py-2 rounded-xl text-sm font-medium text-red-600 hover:bg-red-50">Hapus</button>
                    </form>
                </div>
            </div>

            <!-- Summary -->
            <div class="p-4 sm:p-5 grid grid-cols-1 md:grid-cols-4 gap-4 border-b border-slate-200 bg-white">
                <div class="flex flex-col gap-1 p-3 rounded-xl border border-slate-200 bg-slate-50/60">
                    <span class="text-[11px] uppercase tracking-wide text-slate-500">Kasir</span>
                    <span class="font-semibold text-slate-700">{{ $penjualan->user?->name }}</span>
                </div>
                <div class="flex flex-col gap-1 p-3 rounded-xl border border-slate-200 bg-slate-50/60">
                    <span class="text-[11px] uppercase tracking-wide text-slate-500">Tanggal</span>
                    <span class="font-semibold text-slate-700">{{ $penjualan->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <div class="flex flex-col gap-1 p-3 rounded-xl border border-slate-200 bg-slate-50/60">
                    <span class="text-[11px] uppercase tracking-wide text-slate-500">Total Item</span>
                    <span class="font-semibold text-slate-700">{{ $penjualan->total_item }}</span>
                </div>
                <div class="flex flex-col gap-1 p-3 rounded-xl border border-slate-200 bg-slate-50/60">
                    <span class="text-[11px] uppercase tracking-wide text-slate-500">Total Harga</span>
                    <span class="font-semibold text-emerald-600">Rp {{ number_format($penjualan->total_harga,0,',','.') }}</span>
                </div>
            </div>

            <!-- Detail items -->
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 sticky top-0 z-10">
                        <tr class="text-left text-slate-600 border-b border-slate-200">
                            <th class="px-4 py-3">Pupuk</th>
                            <th class="px-4 py-3 text-right">Harga</th>
                            <th class="px-4 py-3 text-right">Qty</th>
                            <th class="px-4 py-3 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($penjualan->detail as $d)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-3 text-slate-700">{{ $d->pupuk?->nama_pupuk }}</td>
                                <td class="px-4 py-3 text-right text-slate-700">{{ number_format($d->harga_jual,0,',','.') }}</td>
                                <td class="px-4 py-3 text-right text-slate-700">{{ $d->jumlah }}</td>
                                <td class="px-4 py-3 text-right text-slate-700">{{ number_format($d->subtotal,0,',','.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Footer totals -->
            <div class="p-4 sm:p-5 border-t border-slate-200 bg-slate-50/60 flex flex-col sm:flex-row gap-4 sm:items-center sm:justify-end">
                <div class="flex items-center gap-2 bg-white border border-slate-200 rounded-xl px-4 py-2">
                    <span class="text-xs text-slate-500">Bayar</span>
                    <span class="font-semibold text-slate-700">Rp {{ number_format($penjualan->bayar,0,',','.') }}</span>
                </div>
                <div class="flex items-center gap-2 bg-white border border-slate-200 rounded-xl px-4 py-2">
                    <span class="text-xs text-slate-500">Kembalian</span>
                    <span class="font-semibold text-slate-700">Rp {{ number_format($penjualan->kembalian,0,',','.') }}</span>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>