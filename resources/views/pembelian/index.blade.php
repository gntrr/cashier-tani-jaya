<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 container mx-auto py-4">
        <!-- Breadcrumb -->
        <div class="text-zinc-400 text-xs mb-6">Home > Transaksi > Pembelian</div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <!-- Header / Filter -->
            <div class="p-4 sm:p-5 bg-slate-50/60 border-b border-slate-200">
                <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                    <form method="GET" class="flex flex-wrap items-end gap-4 md:gap-6 grow">
                        <div class="flex flex-col gap-1">
                            <label class="text-xs font-medium text-slate-500">Tanggal Dari</label>
                            <input type="date" name="dari" value="{{ request('dari') }}" class="w-44 rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm" />
                        </div>
                        <div class="flex flex-col gap-1">
                            <label class="text-xs font-medium text-slate-500">Tanggal Sampai</label>
                            <input type="date" name="sampai" value="{{ request('sampai') }}" class="w-44 rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm" />
                        </div>
                        <div class="flex items-center gap-3 pt-5 md:pt-0">
                            <button class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-4 py-2 text-sm font-medium text-white hover:bg-emerald-700 active:bg-emerald-800">Terapkan</button>
                            <a href="{{ route('pembelian.index') }}" class="text-sm text-slate-600 hover:text-slate-800">Reset</a>
                        </div>
                    </form>
                    <a href="{{ route('pembelian.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-3 py-2 text-sm font-medium text-white hover:bg-emerald-700 md:self-end">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M12 5v14M5 12h14" stroke-width="1.8" stroke-linecap="round"/></svg>
                        Transaksi Baru
                    </a>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 sticky top-0 z-10">
                        <tr class="text-left text-slate-600 border-b border-slate-200">
                            <th class="px-4 py-3">#</th>
                            <th class="px-4 py-3">Tanggal</th>
                            <th class="px-4 py-3">Kode</th>
                            <th class="px-4 py-3">User</th>
                            <th class="px-4 py-3">Pemasok</th>
                            <th class="px-4 py-3 text-right">Item</th>
                            <th class="px-4 py-3 text-right">Bayar</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($pembelian as $i => $row)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-3 text-slate-500">{{ $pembelian->firstItem() + $i }}</td>
                                <td class="px-4 py-3 text-slate-700">{{ $row->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-4 py-3 font-medium text-slate-700">{{ $row->kode_pembelian }}</td>
                                <td class="px-4 py-3 text-slate-700">{{ $row->user?->name }}</td>
                                <td class="px-4 py-3 text-slate-700">{{ $row->pemasok?->nama_pemasok }}</td>
                                <td class="px-4 py-3 text-right text-slate-700">{{ $row->total_item }}</td>
                                <td class="px-4 py-3 text-right text-slate-700">{{ number_format($row->bayar,0,',','.') }}</td>
                                <td class="px-4 py-3 text-center">
                                    <div class="inline-flex gap-2">
                                        <a href="{{ route('pembelian.edit', $row->id_pembelian) }}" class="px-2 py-1 rounded-lg border border-slate-200 text-slate-700 hover:bg-slate-50">Edit</a>
                                        <form action="{{ route('pembelian.destroy', $row->id_pembelian) }}" method="POST" onsubmit="return confirm('Hapus transaksi ini?')">
                                            @csrf @method('DELETE')
                                            <button class="px-2 py-1 rounded-lg text-red-600 hover:bg-red-50">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-10 text-center text-slate-500">Tidak ada data.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Footer -->
            <div class="p-4 sm:p-5 border-t border-slate-200 flex flex-col gap-4">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    @if ($pembelian->total())
                        <p class="text-xs text-slate-500">Menampilkan <span class="font-semibold">{{ $pembelian->firstItem() }}</span>–<span class="font-semibold">{{ $pembelian->lastItem() }}</span> dari <span class="font-semibold">{{ $pembelian->total() }}</span> data</p>
                    @else
                        <p class="text-xs text-slate-500">Tidak ada data untuk ditampilkan</p>
                    @endif
                    <div>
                        {{ $pembelian->onEachSide(1)->links() }}
                    </div>
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