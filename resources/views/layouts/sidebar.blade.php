<aside class="app-sidebar bg-light shadow" data-bs-theme="light">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
        <!--begin::Brand Link-->
        <a href="./index.html" class="brand-link">
            <!--begin::Brand Image-->
            {{-- <img src="./assets/img/AdminLTELogo.png" alt="AdminLTE Logo"
                class="brand-image opacity-75 shadow" /> --}}
            <!--end::Brand Image-->
            <!--begin::Brand Text-->
            <span class="brand-text fw-light">Kasir TJ</span>
            <!--end::Brand Text-->
        </a>
        <!--end::Brand Link-->
    </div>
    <!--end::Sidebar Brand-->
    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            @php
                use Illuminate\Support\Facades\Auth;
                $kelolaOpen = request()->is('stok-pupuk*') || request()->is('pemasok*');
                $transaksiOpen = request()->is('penjualan*') || request()->is('pembelian*');
            @endphp
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation" aria-label="Main navigation" data-accordion="false" id="navigation">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                @if(\App\Helpers\RoleHelper::isAdmin(Auth::user()))
                <li class="nav-item {{ $kelolaOpen ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $kelolaOpen ? 'active' : '' }}">
                        <i class="nav-icon bi bi-archive"></i>
                        <p>Kelola Data <i class="nav-arrow bi bi-chevron-right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('stok-pupuk.index') }}" class="nav-link {{ request()->is('stok-pupuk*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Stok Pupuk</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('pemasok.index') }}" class="nav-link {{ request()->is('pemasok*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Pemasok</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{ $transaksiOpen ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $transaksiOpen ? 'active' : '' }}">
                        <i class="nav-icon bi bi-cash-coin"></i>
                        <p>Transaksi <i class="nav-arrow bi bi-chevron-right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('penjualan.index') }}" class="nav-link {{ request()->is('penjualan*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Penjualan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('pembelian.index') }}" class="nav-link {{ request()->is('pembelian*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Pembelian</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('laporan.index') }}" class="nav-link {{ request()->is('laporan*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-graph-up"></i>
                        <p>Laporan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('users.index') }}" class="nav-link {{ request()->is('users*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-people"></i>
                        <p>Users</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('settings.index') }}" class="nav-link {{ request()->is('settings*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-gear"></i>
                        <p>Pengaturan</p>
                    </a>
                </li>
                @endif
            </ul>
        </nav>
    </div>
    <!--end::Sidebar Wrapper-->
</aside>
