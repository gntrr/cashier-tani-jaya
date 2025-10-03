<!-- Navigation Bar -->
<nav id="navbar" class="fixed top-0 left-0 right-0 py-3 lg:py-2 bg-white border-b border-slate-200 z-50 transition-[left] duration-300">
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
