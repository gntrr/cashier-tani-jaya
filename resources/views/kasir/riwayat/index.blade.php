<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 container mx-auto py-4">
        <div class="text-zinc-400 text-xs mb-6">Home > Riwayat</div>
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-4 sm:p-5 flex flex-col gap-4 bg-slate-50/60 border-b border-slate-200">
                <form method="GET" class="flex flex-wrap items-end gap-4">
                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-medium text-slate-500">Cari</label>
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="No.Transaksi / Kasir" class="w-56 rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm" />
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-medium text-slate-500">Dari</label>
                        <input type="date" name="dari" value="{{ request('dari') }}" class="w-44 rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm" />
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-medium text-slate-500">Sampai</label>
                        <input type="date" name="sampai" value="{{ request('sampai') }}" class="w-44 rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm" />
                    </div>
                    <div class="flex items-center gap-3 pt-5">
                        <button class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-4 py-2 text-sm font-medium text-white hover:bg-emerald-700 active:bg-emerald-800">Terapkan</button>
                        <a href="{{ route('kasir.riwayat.index') }}" class="text-sm text-slate-600 hover:text-slate-800">Reset</a>
                    </div>
                </form>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 sticky top-0 z-10">
                        <tr class="text-left text-slate-600 border-b border-slate-200">
                            <th class="px-4 py-3">No</th>
                            <th class="px-4 py-3">Tanggal</th>
                            <th class="px-4 py-3">No.Transaksi</th>
                            <th class="px-4 py-3">Nama Pupuk (Ringkas)</th>
                            <th class="px-4 py-3 text-right">Jumlah</th>
                            <th class="px-4 py-3 text-right">Total Harga</th>
                            <th class="px-4 py-3 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($penjualan as $i => $row)
                            <tr class="hover:bg-slate-50 cursor-pointer" onclick="window.location='{{ route('kasir.riwayat.show',$row->id_penjualan) }}'">
                                <td class="px-4 py-3 text-slate-500">{{ $penjualan->firstItem() + $i }}</td>
                                <td class="px-4 py-3 text-slate-700">{{ $row->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-4 py-3 font-medium text-slate-700">{{ $row->kode_penjualan }}</td>
                                <td class="px-4 py-3 text-slate-600 truncate max-w-[180px]">@php
                                    $names = $row->detail()->with('pupuk')->limit(3)->get()->map(fn($d)=>$d->pupuk?->nama_pupuk)->filter()->values();
                                    echo e($names->join(', '));
                                    if($row->detail()->count() > 3) echo ' ...';
                                @endphp</td>
                                <td class="px-4 py-3 text-right text-slate-700">{{ $row->total_item }}</td>
                                <td class="px-4 py-3 text-right text-slate-700">{{ number_format($row->total_harga,0,',','.') }}</td>
                                <td class="px-4 py-3 text-center"><span class="px-2 py-1 text-[11px] rounded-full bg-emerald-100 text-emerald-700">Sukses</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-10 text-center text-slate-500">Tidak ada data.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4 sm:p-5 border-t border-slate-200 flex flex-col gap-4">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    @if ($penjualan->total())
                        <p class="text-xs text-slate-500">Menampilkan <span class="font-semibold">{{ $penjualan->firstItem() }}</span>–<span class="font-semibold">{{ $penjualan->lastItem() }}</span> dari <span class="font-semibold">{{ $penjualan->total() }}</span> data</p>
                    @else
                        <p class="text-xs text-slate-500">Tidak ada data untuk ditampilkan</p>
                    @endif
                    <div>{{ $penjualan->onEachSide(1)->links() }}</div>
                </div>
                <div class="flex flex-col sm:flex-row gap-4 sm:items-center sm:justify-end text-sm">
                    <div class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 flex items-center gap-2">
                        <span class="text-xs text-slate-500">Total Transaksi:</span>
                        <span class="font-semibold text-slate-700">{{ $totalTransaksi }}</span>
                    </div>
                    <div class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 flex items-center gap-2">
                        <span class="text-xs text-slate-500">Total Nominal:</span>
                        <span class="font-semibold text-slate-700">Rp {{ number_format($totalNominal,0,',','.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
