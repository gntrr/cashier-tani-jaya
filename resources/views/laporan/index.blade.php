<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 container mx-auto py-4">
        <div class="text-zinc-400 text-xs mb-6">Home > Laporan</div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mb-6">
            <div class="p-4 sm:p-5 flex flex-col gap-4 md:flex-row md:items-end md:justify-between bg-slate-50/60 border-b border-slate-200">
                <form method="GET" class="flex flex-wrap items-end gap-4 md:gap-6 grow">
                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-medium text-slate-500">Tahun</label>
                        <select name="tahun" class="w-32 rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                            @for($y = now()->year; $y >= now()->year-5; $y--)
                                <option value="{{ $y }}" @selected($y == $filterYear)>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-medium text-slate-500">Bulan</label>
                        <select name="bulan" class="w-40 rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                            <option value="">Semua Bulan</option>
                            @for($m=1;$m<=12;$m++)
                                <option value="{{ $m }}" @selected($m == $filterMonth)>{{ str_pad($m,2,'0',STR_PAD_LEFT) }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-medium text-slate-500">Cari Bulan</label>
                        <div class="relative">
                            <input type="text" name="q" value="{{ $q }}" placeholder="Cari Data" class="peer w-48 rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm pl-9" />
                            <span class="pointer-events-none absolute left-3 top-2.5 text-slate-400 peer-focus:text-emerald-500">
                                <svg viewBox="0 0 24 24" class="w-5 h-5" fill="none" stroke="currentColor"><circle cx="11" cy="11" r="7" stroke-width="1.8"/><path d="M21 21l-4-4" stroke-width="1.8" stroke-linecap="round"/></svg>
                            </span>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 pt-5 md:pt-0">
                        <button class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-4 py-2 text-sm font-medium text-white hover:bg-emerald-700">Terapkan</button>
                        <a href="{{ route('laporan.index') }}" class="text-sm text-slate-600 hover:text-slate-800">Reset</a>
                    </div>
                </form>
                <div class="flex flex-wrap gap-2 md:flex-col md:items-end">
                    <a href="{{ route('laporan.penjualan.pdf',['tahun'=>$filterYear,'bulan'=>$filterMonth]) }}" class="px-3 py-2 rounded-xl border border-emerald-200 text-sm font-medium text-emerald-600 hover:bg-emerald-50">Export/Print</a>
                    {{-- Tombol PDF Pembelian disembunyikan sesuai permintaan
                    <a href="{{ route('laporan.pembelian.pdf',['tahun'=>$filterYear,'bulan'=>$filterMonth]) }}" class="px-3 py-2 rounded-xl border border-red-200 text-sm font-medium text-red-600 hover:bg-red-50">PDF Pembelian</a>
                    --}}
                </div>
            </div>
            <!-- Summary Row -->
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-white">
                        <tr class="text-left text-slate-600 border-b border-slate-200">
                            <th class="px-4 py-3">Tahun</th>
                            <th class="px-4 py-3">Total Penjualan</th>
                            <th class="px-4 py-3">Total Pembelian</th>
                            <th class="px-4 py-3">Laba / Rugi</th>
                            <th class="px-4 py-3">Margin (%)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b border-slate-100 bg-slate-50/50">
                            <td class="px-4 py-3 font-medium text-slate-700">{{ $filterYear }}</td>
                            <td class="px-4 py-3 text-slate-700">Rp {{ number_format($totalPenjualan,0,',','.') }}</td>
                            <td class="px-4 py-3 text-slate-700">Rp {{ number_format($totalPembelian,0,',','.') }}</td>
                            <td class="px-4 py-3 {{ $overallProfit>=0 ? 'text-emerald-600' : 'text-red-600' }}">Rp {{ number_format($overallProfit,0,',','.') }} {{ $overallProfit>=0 ? '(Laba)' : '(Rugi)' }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ number_format($overallMargin,2,',','.') }}%</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Monthly Breakdown Table -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 sticky top-0 z-10">
                        <tr class="text-left text-slate-600 border-b border-slate-200">
                            <th class="px-4 py-3">Bulan</th>
                            <th class="px-4 py-3">Tahun</th>
                            <th class="px-4 py-3">Total Penjualan</th>
                            <th class="px-4 py-3">Total Pembelian</th>
                            <th class="px-4 py-3">Laba / Rugi</th>
                            <th class="px-4 py-3">Margin (%)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($monthlySummary as $row)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-3 text-slate-700">{{ $row['bulan_nama'] }}</td>
                                <td class="px-4 py-3 text-slate-700">{{ $row['tahun'] }}</td>
                                <td class="px-4 py-3 text-slate-700">Rp {{ number_format($row['total_penjualan'],0,',','.') }}</td>
                                <td class="px-4 py-3 text-slate-700">Rp {{ number_format($row['total_pembelian'],0,',','.') }}</td>
                                <td class="px-4 py-3 {{ $row['profit']>=0 ? 'text-emerald-600' : 'text-red-600' }}">Rp {{ number_format($row['profit'],0,',','.') }} {{ $row['profit']>=0 ? '(Laba)' : '(Rugi)' }}</td>
                                <td class="px-4 py-3 text-slate-700">{{ number_format($row['margin'],2,',','.') }}%</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-10 text-center text-slate-500">Tidak ada data.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4 sm:p-5 border-t border-slate-200 text-xs text-slate-500 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <p>Total baris: <span class="font-semibold">{{ count($monthlySummary) }}</span></p>
                <p>Transaksi Penjualan: <span class="font-semibold">{{ $countPenjualan }}</span> | Transaksi Pembelian: <span class="font-semibold">{{ $countPembelian }}</span></p>
            </div>
        </div>
    </div>
</x-app-layout>