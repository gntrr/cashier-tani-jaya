<x-app-layout>
    <div class="px-4 sm:px-6 lg:px-8 container mx-auto py-4">
        <div class="bg-slate-50/70 rounded-2xl p-3 sm:p-4">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

                {{-- Header --}}
                <div class="p-4 sm:p-5 flex items-center justify-between bg-slate-50/70 border-b border-slate-200">
                    <h1 class="text-lg font-semibold text-slate-800">Tambah Users</h1>
                    <a href="{{ route('users.index') }}"
                        class="inline-flex items-center rounded-full bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-800">
                        Kembali
                    </a>
                </div>

                <form action="{{ route('users.store') }}" method="POST" class="p-4 sm:p-5">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5">
                        {{-- Nama --}}
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Nama</label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                class="w-full rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                            @error('name')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                class="w-full rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                            @error('email')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Pilih Role --}}
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Role</label>
                            <select name="role"
                                class="w-full rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                                <option value="0" {{ old('role') == 0 ? 'selected' : '' }}>Admin</option>
                                <option value="1" {{ old('role') == 1 ? 'selected' : '' }}>Kasir</option>
                            </select>
                            @error('role')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Password</label>
                            <div class="relative">
                                <input type="password" id="password" name="password"
                                    class="w-full rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm pr-10">
                                <button type="button" data-toggle="password"
                                    class="absolute inset-y-0 right-0 px-3 flex items-center text-slate-400 hover:text-slate-600"
                                    aria-label="Tampilkan/sembunyikan password">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7-10-7-10-7Z" stroke-width="1.8" />
                                        <circle cx="12" cy="12" r="3" stroke-width="1.8" />
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Konfirmasi Password --}}
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Konfirmasi Password</label>
                            <div class="relative">
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    class="w-full rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm pr-10">
                                <button type="button" data-toggle="password_confirmation"
                                    class="absolute inset-y-0 right-0 px-3 flex items-center text-slate-400 hover:text-slate-600"
                                    aria-label="Tampilkan/sembunyikan konfirmasi password">
                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7-10-7-10-7Z" stroke-width="1.8" />
                                        <circle cx="12" cy="12" r="3" stroke-width="1.8" />
                                    </svg>
                                </button>
                            </div>
                            @error('password_confirmation')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- is_active -->
                        <div>
                            <input type="hidden" name="is_active" value="0"> {{-- biar unchecked tetap kirim 0 --}}

                            <label for="is_active" class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                            <div class="relative mt-1">
                                <select name="is_active"
                                    class="w-full rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                                    <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Aktif
                                    </option>
                                    <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Nonaktif
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 flex items-center justify-end gap-2">
                        <a href="{{ route('users.index') }}"
                            class="rounded-full px-4 py-2 text-sm font-medium text-slate-700 border border-slate-200 hover:bg-slate-50">
                            Batal
                        </a>
                        <button type="submit"
                            class="rounded-full bg-emerald-600 px-4 py-2 text-sm font-medium text-white hover:bg-emerald-700">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Tiny script: show/hide password + label toggle --}}
    <script>
        (function() {
            // Show/hide password
            document.querySelectorAll('button[data-toggle]').forEach(btn => {
                btn.addEventListener('click', () => {
                    const id = btn.getAttribute('data-toggle');
                    const input = document.getElementById(id);
                    if (!input) return;
                    input.type = input.type === 'password' ? 'text' : 'password';
                });
            });

            // Toggle label Aktif/Nonaktif (opsional, purely visual)
            const toggle = document.querySelector('input[name="is_active"][type="checkbox"]');
            const label = document.querySelector('[data-toggle-label]');
            if (toggle && label) {
                const sync = () => label.textContent = toggle.checked ? 'Aktif' : 'Nonaktif';
                toggle.addEventListener('change', sync);
                sync();
            }
        })();
    </script>
</x-app-layout>
