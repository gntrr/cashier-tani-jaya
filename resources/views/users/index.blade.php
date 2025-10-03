<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 container mx-auto py-4">
        <!-- Breadcrumb -->
        <div class="text-zinc-400 text-xs mb-6">Home > Kelola data > Users</div>

        {{-- Card container --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            {{-- Header --}}
            <div
                class="p-4 sm:p-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between bg-slate-50/60 border-b border-slate-200">

                <form method="GET" class="flex flex-wrap items-center gap-2">
                    <div class="relative">
                        <input type="text" name="q" value="{{ $q ?? '' }}" placeholder="Cari Users"
                            class="peer w-64 rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm" />
                        <span
                            class="pointer-events-none absolute right-3 top-2.5 text-slate-400 peer-focus:text-emerald-500">
                            <!-- search icon -->
                            <svg viewBox="0 0 24 24" class="w-5 h-5" fill="none" stroke="currentColor">
                                <circle cx="11" cy="11" r="7" stroke-width="1.8" />
                                <path d="M21 21l-4-4" stroke-width="1.8" stroke-linecap="round" />
                            </svg>
                        </span>
                    </div>

                    <select name="per_page"
                        class="rounded-xl border-slate-300 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                        @foreach ([10, 15, 25, 50] as $n)
                            <option value="{{ $n }}" @selected(($perPage ?? 10) === $n)>{{ $n }}/hal
                            </option>
                        @endforeach
                    </select>

                    <input type="hidden" name="sort" value="{{ $sort ?? 'name' }}">
                    <input type="hidden" name="dir" value="{{ $dir ?? 'asc' }}">
                    <button
                        class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-3 py-2 text-sm font-medium text-white hover:bg-emerald-700 active:bg-emerald-800">
                        Terapkan
                    </button>

                </form>
                {{-- example: tombol tambah --}}
                <a href="{{ route('users.create') }}"
                    class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-3 py-2 text-sm font-medium text-white hover:bg-emerald-700">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M12 5v14M5 12h14" stroke-width="1.8" stroke-linecap="round" />
                    </svg>
                    Tambah
                </a>
            </div>

            {{-- Table wrapper (buat rounded ke-keep di header, pakai overflow-x-auto di luar table) --}}
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 sticky top-0 z-10">
                        <tr class="text-left text-slate-600 border-b border-slate-200">
                            <th class="px-4 py-3">#</th>
                            <th class="px-4 py-3 text-center">Nama</th>
                            <th class="px-4 py-3 text-center">Email</th>
                            <th class="px-4 py-3 text-center">Role</th>
                            <th class="px-4 py-3 text-center">Status</th>
                            <th class="px-4 py-3 text-center">Terdaftar</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($items as $i => $row)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-3 text-slate-500">{{ $items->firstItem() + $i }}</td>
                                <td class="px-4 py-3 font-medium text-slate-700">{{ $row->name }}</td>
                                <td class="px-4 py-3 text-slate-700">{{ $row->email }}</td>
                                <td class="px-4 py-3 text-center">
                                    @if ($row->role === 1)
                                        <span
                                            class="inline-flex items-center gap-1 rounded-full bg-emerald-100/60 px-2 py-1 text-xs font-medium text-emerald-700">
                                            Admin
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1 rounded-full bg-blue-100/60 px-2 py-1 text-xs font-medium text-blue-700">
                                            Kasir
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center">{{ $row->is_active ? 'Aktif' : 'Tidak Aktif' }}</td>
                                <td class="px-4 py-3 text-center">{{ $row->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-4 py-3 text-center">
                                    <div class="inline-flex gap-2">
                                        <a href="{{ route('users.edit', $row->id) }}"
                                            class="px-2 py-1 rounded-lg border border-slate-200 text-slate-700 hover:bg-slate-50">Edit</a>
                                        <form action="{{ route('users.destroy', $row->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus item ini?')">
                                            @csrf @method('DELETE')
                                            <button
                                                class="px-2 py-1 rounded-lg text-red-600 hover:bg-red-50">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-10 text-center text-slate-500">
                                    Belum ada data. <a href="{{ route('users.create') }}"
                                        class="text-emerald-600 hover:underline">Tambah sekarang</a>.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Footer: pagination --}}
            <div
                class="p-4 sm:p-5 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-3">
                <p class="text-xs text-slate-500">
                    Menampilkan <span class="font-semibold">{{ $items->firstItem() }}</span>–<span
                        class="font-semibold">{{ $items->lastItem() }}</span>
                    dari <span class="font-semibold">{{ $items->total() }}</span> data
                </p>
                <div>
                    {{ $items->onEachSide(1)->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
