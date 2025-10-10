<!-- Sidebar -->
<aside id="sidebar"
    class="fixed top-14 lg:top-0 left-0 h-[calc(100vh-3.5rem)] lg:h-screen w-56 bg-white border-r border-slate-200 z-40 transform transition-transform duration-300 -translate-x-full">
    @php
        use Illuminate\Support\Facades\Auth;
        $isAdmin = \App\Helpers\RoleHelper::isAdmin(Auth::user());
    @endphp

    <!-- Active Indicator -->
    {{-- @if (request()->routeIs('dashboard'))
        <div class="w-1.5 h-10 absolute left-0 bg-slate-700 rounded-tr-[10px] rounded-br-[10px]"
            style="top: {{ $isAdmin ? '70px' : '76px' }}"></div>
    @endif --}}

    <!-- Navigation Menu -->
    <!-- Navigation Menu -->
    <!-- Sidebar Header -->
    <div class="py-4 lg:py-3 flex items-center justify-center px-3 border-b border-slate-200 mb-3">
        <div class="text-green-600 text-lg font-bold font-['Archivo_Black'] tracking-wide">UD TANI JAYA</div>
    </div>
    <nav class="px-2">
        @php
            // helper kecil buat render heroicons (outline) dengan warna ikut state
            $icon = function (string $name, bool $active = false) {
                $cls = ($active ? 'text-slate-700' : 'text-zinc-400') . ' w-5 h-5 shrink-0';
                switch ($name) {
                    case 'home':
                        return <<<SVG
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                            <path d="M11.47 3.841a.75.75 0 0 1 1.06 0l8.69 8.69a.75.75 0 1 0 1.06-1.061l-8.689-8.69a2.25 2.25 0 0 0-3.182 0l-8.69 8.69a.75.75 0 1 0 1.061 1.06l8.69-8.689Z" />
                            <path d="m12 5.432 8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 0 1-.75-.75v-4.5a.75.75 0 0 0-.75-.75h-3a.75.75 0 0 0-.75.75V21a.75.75 0 0 1-.75.75H5.625a1.875 1.875 0 0 1-1.875-1.875v-6.198a2.29 2.29 0 0 0 .091-.086L12 5.432Z" />
                          </svg>
                        SVG;
                    case 'archive':
                        return <<<SVG
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                            <path d="M3.375 3C2.339 3 1.5 3.84 1.5 4.875v.75c0 1.036.84 1.875 1.875 1.875h17.25c1.035 0 1.875-.84 1.875-1.875v-.75C22.5 3.839 21.66 3 20.625 3H3.375Z" />
                            <path fill-rule="evenodd" d="m3.087 9 .54 9.176A3 3 0 0 0 6.62 21h10.757a3 3 0 0 0 2.995-2.824L20.913 9H3.087Zm6.163 3.75A.75.75 0 0 1 10 12h4a.75.75 0 0 1 0 1.5h-4a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd" />
                          </svg>
                        SVG;
                    case 'truck':
                        return <<<SVG
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                            <path d="M3.375 4.5C2.339 4.5 1.5 5.34 1.5 6.375V13.5h12V6.375c0-1.036-.84-1.875-1.875-1.875h-8.25ZM13.5 15h-12v2.625c0 1.035.84 1.875 1.875 1.875h.375a3 3 0 1 1 6 0h3a.75.75 0 0 0 .75-.75V15Z" />
                            <path d="M8.25 19.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0ZM15.75 6.75a.75.75 0 0 0-.75.75v11.25c0 .087.015.17.042.248a3 3 0 0 1 5.958.464c.853-.175 1.522-.935 1.464-1.883a18.659 18.659 0 0 0-3.732-10.104 1.837 1.837 0 0 0-1.47-.725H15.75Z" />
                            <path d="M19.5 19.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0Z" />
                          </svg>
                        SVG;
                    case 'users':
                        return <<<SVG
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                            <path d="M4.5 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM14.25 8.625a3.375 3.375 0 1 1 6.75 0 3.375 3.375 0 0 1-6.75 0ZM1.5 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.63 13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.122ZM17.25 19.128l-.001.144a2.25 2.25 0 0 1-.233.96 10.088 10.088 0 0 0 5.06-1.01.75.75 0 0 0 .42-.643 4.875 4.875 0 0 0-6.957-4.611 8.586 8.586 0 0 1 1.71 5.157v.003Z" />
                          </svg>
                        SVG;
                    case 'banknotes':
                        return <<<SVG
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                            <path d="M12 7.5a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5Z" />
                            <path fill-rule="evenodd" d="M1.5 4.875C1.5 3.839 2.34 3 3.375 3h17.25c1.035 0 1.875.84 1.875 1.875v9.75c0 1.036-.84 1.875-1.875 1.875H3.375A1.875 1.875 0 0 1 1.5 14.625v-9.75ZM8.25 9.75a3.75 3.75 0 1 1 7.5 0 3.75 3.75 0 0 1-7.5 0ZM18.75 9a.75.75 0 0 0-.75.75v.008c0 .414.336.75.75.75h.008a.75.75 0 0 0 .75-.75V9.75a.75.75 0 0 0-.75-.75h-.008ZM4.5 9.75A.75.75 0 0 1 5.25 9h.008a.75.75 0 0 1 .75.75v.008a.75.75 0 0 1-.75.75H5.25a.75.75 0 0 1-.75-.75V9.75Z" clip-rule="evenodd" />
                            <path d="M2.25 18a.75.75 0 0 0 0 1.5c5.4 0 10.63.722 15.6 2.075 1.19.324 2.4-.558 2.4-1.82V18.75a.75.75 0 0 0-.75-.75H2.25Z" />
                          </svg>
                        SVG;
                    case 'cart':
                        return <<<SVG
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                            <path d="M2.25 2.25a.75.75 0 0 0 0 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 0 0-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 0 0 0-1.5H5.378A2.25 2.25 0 0 1 7.5 15h11.218a.75.75 0 0 0 .674-.421 60.358 60.358 0 0 0 2.96-7.228.75.75 0 0 0-.525-.965A60.864 60.864 0 0 0 5.68 4.509l-.232-.867A1.875 1.875 0 0 0 3.636 2.25H2.25ZM3.75 20.25a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0ZM16.5 20.25a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0Z" />
                          </svg>
                        SVG;
                    case 'chart':
                        return <<<SVG
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                            <path fill-rule="evenodd" d="M2.25 2.25a.75.75 0 0 0 0 1.5H3v10.5a3 3 0 0 0 3 3h1.21l-1.172 3.513a.75.75 0 0 0 1.424.474l.329-.987h8.418l.33.987a.75.75 0 0 0 1.422-.474l-1.17-3.513H18a3 3 0 0 0 3-3V3.75h.75a.75.75 0 0 0 0-1.5H2.25Zm6.54 15h6.42l.5 1.5H8.29l.5-1.5Zm8.085-8.995a.75.75 0 1 0-.75-1.299 12.81 12.81 0 0 0-3.558 3.05L11.03 8.47a.75.75 0 0 0-1.06 0l-3 3a.75.75 0 1 0 1.06 1.06l2.47-2.47 1.617 1.618a.75.75 0 0 0 1.146-.102 11.312 11.312 0 0 1 3.612-3.321Z" clip-rule="evenodd" />
                          </svg>
                        SVG;
                    case 'cog':
                        return <<<SVG
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                            <path fill-rule="evenodd" d="M11.078 2.25c-.917 0-1.699.663-1.85 1.567L9.05 4.889c-.02.12-.115.26-.297.348a7.493 7.493 0 0 0-.986.57c-.166.115-.334.126-.45.083L6.3 5.508a1.875 1.875 0 0 0-2.282.819l-.922 1.597a1.875 1.875 0 0 0 .432 2.385l.84.692c.095.078.17.229.154.43a7.598 7.598 0 0 0 0 1.139c.015.2-.059.352-.153.43l-.841.692a1.875 1.875 0 0 0-.432 2.385l.922 1.597a1.875 1.875 0 0 0 2.282.818l1.019-.382c.115-.043.283-.031.45.082.312.214.641.405.985.57.182.088.277.228.297.35l.178 1.071c.151.904.933 1.567 1.85 1.567h1.844c.916 0 1.699-.663 1.85-1.567l.178-1.072c.02-.12.114-.26.297-.349.344-.165.673-.356.985-.57.167-.114.335-.125.45-.082l1.02.382a1.875 1.875 0 0 0 2.28-.819l.923-1.597a1.875 1.875 0 0 0-.432-2.385l-.84-.692c-.095-.078-.17-.229-.154-.43a7.614 7.614 0 0 0 0-1.139c-.016-.2.059-.352.153-.43l.84-.692c.708-.582.891-1.59.433-2.385l-.922-1.597a1.875 1.875 0 0 0-2.282-.818l-1.02.382c-.114.043-.282.031-.449-.083a7.49 7.49 0 0 0-.985-.57c-.183-.087-.277-.227-.297-.348l-.179-1.072a1.875 1.875 0 0 0-1.85-1.567h-1.843ZM12 15.75a3.75 3.75 0 1 0 0-7.5 3.75 3.75 0 0 0 0 7.5Z" clip-rule="evenodd" />
                          </svg>
                        SVG;
                    default:
                        return '';
                }
            };

            // top-level
            $menusTop = [
                [
                    'label' => 'Dashboard',
                    'href' => route('dashboard'),
                    'icon' => 'home',
                    'active' => request()->routeIs('dashboard'),
                ],
            ];

            // grup: Kelola data (header non-link)
            $kelolaItems = [
                [
                    'label' => 'Stok Pupuk',
                    'href' => route('stok-pupuk.index'),
                    'icon' => 'archive',
                    'active' => request()->is('stok-pupuk*'),
                ],
                [
                    'label' => 'Pemasok',
                    'href' => route('pemasok.index'),
                    'icon' => 'truck',
                    'active' => request()->is('pemasok*'),
                ],
                [
                    'label' => 'Users',
                    'href' => route('users.index'),
                    'icon' => 'users',
                    'active' => request()->is('users*'),
                ],
            ];

            // grup: Transaksi (header non-link)
            $transaksiItems = [
                [
                    'label' => 'Penjualan',
                    'href' => route('penjualan.index'),
                    'icon' => 'banknotes',
                    'active' => request()->is('penjualan*'),
                ],
                [
                    'label' => 'Pembelian',
                    'href' => route('pembelian.index'),
                    'icon' => 'cart',
                    'active' => request()->is('pembelian*'),
                ],
            ];

            // others
            $others = [
                [
                    'label' => 'Laporan',
                    'href' => route('laporan.index'),
                    'icon' => 'chart',
                    'active' => request()->is('laporan*'),
                ],
                [
                    'label' => 'Setting',
                    'href' => route('settings.index'),
                    'icon' => 'cog',
                    'active' => request()->is('users.*'),
                ],
            ];

            if(!$isAdmin){
                // Override others for kasir
                $others = [
                    [
                        'label' => 'Riwayat',
                        'href' => route('kasir.riwayat.index'),
                        'icon' => 'chart',
                        'active' => request()->is('riwayat*'),
                    ],
                    [
                        'label' => 'Setting',
                        'href' => route('profile.edit'),
                        'icon' => 'cog',
                        'active' => request()->routeIs('profile.edit'),
                    ],
                ];
            }
        @endphp

        {{-- TOP --}}
        <ul class="space-y-1">
            @foreach ($menusTop as $m)
                <li>
                    <a href="{{ $m['href'] }}"
                        class="group relative flex items-center gap-3 px-4 py-2.5 rounded-r-full overflow-hidden
                  {{ $m['active'] ? 'bg-slate-100 text-slate-700' : 'text-zinc-400 hover:bg-slate-50' }}">
                        <span
                            class="absolute left-0 top-0 h-full w-1.5 {{ $m['active'] ? 'bg-slate-700' : 'bg-transparent group-hover:bg-slate-300' }}"></span>
                        {!! $icon($m['icon'], $m['active']) !!}
                        <span class="text-sm font-medium truncate">{{ $m['label'] }}</span>
                    </a>
                </li>
            @endforeach
        </ul>

        @if ($isAdmin)
            {{-- HEADER: Kelola data --}}
            <div class="mt-4 mb-1 px-4 text-[11px] font-semibold tracking-wide text-slate-400 uppercase select-none">
                Kelola data</div>
            <ul class="space-y-1">
                @foreach ($kelolaItems as $m)
                    <li>
                        <a href="{{ $m['href'] }}"
                            class="group relative flex items-center gap-3 pr-4 pl-9 py-2.5 rounded-r-full overflow-hidden
                    {{ $m['active'] ? 'bg-slate-100 text-slate-700' : 'text-zinc-400 hover:bg-slate-50' }}">
                            <span
                                class="absolute left-0 top-0 h-full w-1.5 {{ $m['active'] ? 'bg-slate-700' : 'bg-transparent group-hover:bg-slate-300' }}"></span>
                            {!! $icon($m['icon'], $m['active']) !!}
                            <span class="text-sm font-medium truncate">{{ $m['label'] }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>

            {{-- HEADER: Transaksi --}}
            <div class="mt-4 mb-1 px-4 text-[11px] font-semibold tracking-wide text-slate-400 uppercase select-none">
                Transaksi</div>
            <ul class="space-y-1">
                @foreach ($transaksiItems as $m)
                    <li>
                        <a href="{{ $m['href'] }}"
                            class="group relative flex items-center gap-3 pr-4 pl-9 py-2.5 rounded-r-full overflow-hidden
                    {{ $m['active'] ? 'bg-slate-100 text-slate-700' : 'text-zinc-400 hover:bg-slate-50' }}">
                            <span
                                class="absolute left-0 top-0 h-full w-1.5 {{ $m['active'] ? 'bg-slate-700' : 'bg-transparent group-hover:bg-slate-300' }}"></span>
                            {!! $icon($m['icon'], $m['active']) !!}
                            <span class="text-sm font-medium truncate">{{ $m['label'] }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif

        {{-- OTHERS --}}
        <ul class="space-y-1 mt-4">
            @foreach ($others as $m)
                <li>
                    <a href="{{ $m['href'] }}"
                        class="group relative flex items-center gap-3 px-4 py-2.5 rounded-r-full overflow-hidden
                  {{ $m['active'] ? 'bg-slate-100 text-slate-700' : 'text-zinc-400 hover:bg-slate-50' }}">
                        <span
                            class="absolute left-0 top-0 h-full w-1.5 {{ $m['active'] ? 'bg-slate-700' : 'bg-transparent group-hover:bg-slate-300' }}"></span>
                        {!! $icon($m['icon'], $m['active']) !!}
                        <span class="text-sm font-medium truncate">{{ $m['label'] }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </nav>

</aside>

<!-- Backdrop (untuk mobile/tablet) -->
<div id="sidebar-backdrop" class="fixed top-14 left-0 right-0 bottom-0 lg:inset-0 bg-black/30 z-30 hidden"></div>
