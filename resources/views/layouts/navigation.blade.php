{{-- <!-- Navigation Bar -->
<nav class="w-full h-14 fixed top-0 left-0 bg-white border-b border-slate-200 z-40">
    <div class="px-4 h-full flex items-center justify-between">
        <!-- Left: Hamburger Menu and Page Title -->
        <div class="flex items-center space-x-4">
            <!-- Hamburger Button -->
            <button id="sidebar-toggle" class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-md">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
            
            <!-- Page Title -->
            @php
                $pageTitle = 'Dashboard';
                if(request()->is('stok-pupuk*')) {
                    $pageTitle = 'Stok Pupuk';
                } elseif(request()->is('pemasok*')) {
                    $pageTitle = 'Pemasok';
                } elseif(request()->is('penjualan*')) {
                    $pageTitle = 'Penjualan';
                } elseif(request()->is('pembelian*')) {
                    $pageTitle = 'Pembelian';
                } elseif(request()->is('laporan*')) {
                    $pageTitle = 'Laporan';
                } elseif(request()->is('users*')) {
                    $pageTitle = 'Users';
                } elseif(request()->is('settings*')) {
                    $pageTitle = 'Settings';
                }
            @endphp
            <div class="text-slate-700 text-lg font-semibold font-['Inter']">{{ $pageTitle }}</div>
        </div>

        <!-- Center: Empty space -->
        <div></div>

        <!-- Right: User Menu -->
        <div class="flex items-center space-x-4">
            <!-- Notification Icon -->
            <div class="w-7 h-7">
                <svg class="w-full h-full text-zinc-400" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                </svg>
            </div>

            <!-- User Role -->
            @php
                $role = '';
                if (Auth::user()->role == 0) {
                    $role = 'Admin';
                } elseif (Auth::user()->role == 1) {
                    $role = 'Users';
                } else {
                    $role = 'Owner';
                }
            @endphp
            <div class="text-black/40 text-lg font-medium font-inter">{{ $role }}</div>

            <!-- User Avatar with Dropdown -->
            <div class="relative group">
                <div class="w-14 h-14 bg-stone-300 rounded-full overflow-hidden cursor-pointer">
                    <img src="{{ asset('adminlte/assets/img/user2-160x160.jpg') }}" 
                         class="w-full h-full object-cover" 
                         alt="User Avatar" />
                </div>
                
                <!-- Dropdown Menu -->
                <div class="absolute right-0 top-16 w-48 bg-white rounded-lg shadow-lg border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                    <div class="py-2">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil Saya</a>
                        <div class="border-t border-gray-100"></div>
                        <form method="POST" action="{{ route('logout') }}" class="block">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100" onclick="return confirm('Apakah Anda yakin ingin keluar?')">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav> --}}

<!-- Navigation Bar -->
<nav id="navbar" class="fixed top-0 left-0 right-0 h-14 bg-white border-b border-slate-200 z-50 transition-[left] duration-300">
  <div class="h-full px-4 flex items-center justify-between">
    {{-- Left: Hamburger + Page Title --}}
    <div class="flex items-center gap-3">
      {{-- Hamburger (visible ≤ sm, optional visible all) --}}
      <button id="sidebar-toggle"
              class="inline-flex items-center justify-center p-2 rounded-md text-slate-600 hover:text-slate-900 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-300">
        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
        <span class="sr-only">Toggle sidebar</span>
      </button>

      {{-- Dynamic page title --}}
      @php
        $pageTitle = 'Dashboard';
        if (request()->is('kelola*')) $pageTitle = 'Kelola Data';
        elseif (request()->is('stok-pupuk*')) $pageTitle = 'Stok Pupuk';
        elseif (request()->is('pemasok*')) $pageTitle = 'Pemasok';
        elseif (request()->is('transaksi*')) $pageTitle = 'Transaksi';
        elseif (request()->is('penjualan*')) $pageTitle = 'Penjualan';
        elseif (request()->is('pembelian*')) $pageTitle = 'Pembelian';
        elseif (request()->is('laporan*')) $pageTitle = 'Laporan';
        elseif (request()->is('users*')) $pageTitle = 'Users';
        elseif (request()->is('setting*')) $pageTitle = 'Setting';
      @endphp
      <span class="text-sm font-medium text-slate-700">{{ $pageTitle }}</span>
    </div>

    {{-- Right: profile/dropdown (biarkan punyamu, ini contoh aman z-index) --}}
    <div class="relative z-50">
      @auth
        <x-dropdown align="right" width="48">
          <x-slot name="trigger">
            <button class="flex items-center text-sm font-medium text-slate-700 hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-300">
              <div class="w-8 h-8 bg-stone-300 rounded-full overflow-hidden">
                <img src="{{ asset('adminlte/assets/img/user2-160x160.jpg') }}" alt="User Avatar" class="w-full h-full object-cover">
              </div>
              <p class="ml-2 hidden md:inline-block">{{ Auth::user()->name }}</p>
              <svg class="ml-2 h-4 w-4 fill-current" viewBox="0 0 20 20">
                <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
              </svg>
            </button>
          </x-slot>

          <x-slot name="content">
            {{-- Profile Name and Role --}}
            <div class="px-4 py-3 border-b border-gray-100">
              <div class="font-medium text-sm text-gray-700">{{ Auth::user()->name }}</div>
              @php
                $role = '';
                if (Auth::user()->role == 0) {
                    $role = 'Admin';
                } elseif (Auth::user()->role == 1) {
                    $role = 'Users';
                } else {
                    $role = 'Owner';
                }
              @endphp
              <div class="text-xs text-gray-500">{{ $role }}</div>
            </div>
            <!-- Profile Link -->
            <x-dropdown-link :href="route('profile.edit')">
              {{ __('Profil Saya') }}
            </x-dropdown-link>

            <div class="border-t border-gray-100"></div>

            <!-- Logout Form -->
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <x-dropdown-link :href="route('logout')"
                               onclick="event.preventDefault(); this.closest('form').submit();">
                {{ __('Logout') }}
              </x-dropdown-link>
            </form>
          </x-slot>
        </x-dropdown>
      @endauth
    </div>
  </div>
</nav>
