<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="{{ route('dashboard') }}">
            <span class="align-middle">Toko Lia</span>
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('dashboard') }}">
                    <i class="align-middle" data-feather="home"></i> <span class="align-middle">Dashboard</span>
                </a>
            </li>

            <li class="sidebar-header">
                Data Master
            </li>

            <li
                class="sidebar-item {{ request()->routeIs(['indexCategory', 'createCategory', 'editCategory']) ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('indexCategory') }}">
                    <i class="align-middle" data-feather="box"></i> <span class="align-middle">Kategori</span>
                </a>
            </li>
            <li class="sidebar-item {{ request()->routeIs(['indexUnit', 'createUnit', 'editUnit']) ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('indexUnit') }}">
                    <i class="align-middle" data-feather="tag"></i> <span class="align-middle">Satuan</span>
                </a>
            </li>
            <li class="sidebar-item {{ request()->routeIs('barang') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('barang') }}">
                    <i class="align-middle" data-feather="package"></i> <span class="align-middle">Barang</span>
                </a>
            </li>
            <li class="sidebar-item {{ request()->routeIs(['indexSupplier', 'createSupplier', 'editSupplier']) ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('indexSupplier') }}">
                    <i class="align-middle" data-feather="truck"></i> <span class="align-middle">Supplier</span>
                </a>
            </li>
            <li class="sidebar-item {{ request()->routeIs(['indexUser', 'createUser', 'editUser']) ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('indexUser') }}">
                    <i class="align-middle" data-feather="users"></i> <span class="align-middle">User</span>
                </a>
            </li>

            <li class="sidebar-header">
                Transaksi
            </li>

            <li class="sidebar-item {{ request()->routeIs('barangMasuk') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('barangMasuk') }}">
                    <i class="align-middle" data-feather="arrow-down-circle"></i> <span class="align-middle">Barang
                        Masuk</span>
                </a>
            </li>
            <li class="sidebar-item {{ request()->routeIs('barangKeluar') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('barangKeluar') }}">
                    <i class="align-middle" data-feather="arrow-up-circle"></i> <span class="align-middle">Barang
                        Keluar</span>
                </a>
            </li>

            <li class="sidebar-header">
                Laporan
            </li>

            <li class="sidebar-item {{ request()->routeIs('laporanBarangMasuk') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('laporanBarangMasuk') }}">
                    <i class="align-middle" data-feather="bar-chart-2"></i> <span class="align-middle">Barang
                        Masuk</span>
                </a>
            </li>
            <li class="sidebar-item {{ request()->routeIs('laporanBarangKeluar') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('laporanBarangKeluar') }}">
                    <i class="align-middle" data-feather="bar-chart-2"></i> <span class="align-middle">Barang
                        Keluar</span>
                </a>
            </li>
            <li class="sidebar-item {{ request()->routeIs('syncStokFifo') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('syncStokFifo') }}">
                    <i class="align-middle" data-feather="refresh-cw"></i> <span class="align-middle">Sync Stok
                        FIFO</span>
                </a>
            </li>

            <li class="sidebar-header"></li>
            <li class="sidebar-item {{ request()->routeIs('setting') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('setting') }}">
                    <i class="align-middle" data-feather="settings"></i> <span class="align-middle">Setting</span>
                </a>
            </li>
            <li class="sidebar-item {{ request()->routeIs('logout') ? 'active' : '' }}">
                <a class="sidebar-link" href="{{ route('logout') }}">
                    <i class="align-middle" data-feather="log-out"></i> <span class="align-middle">Logout</span>
                </a>
            </li>
        </ul>
    </div>
</nav>
