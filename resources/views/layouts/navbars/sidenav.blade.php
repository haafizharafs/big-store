<aside
    class="sidenav overflow-hidden bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4"
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href="{{ url('dashboard') }}" target="_blank">
            <img src="{{ asset('images/big-warna.png') }}" class="navbar-brand-img h-100" alt="main_logo" />
            <span class="ms-1 font-weight-bold">BIG Store</span>
        </a>
    </div>
    <hr class="horizontal dark my-0" />
    <div class="collapse navbar-collapse position-relative w-100" id="sidenav-collapse-main">
        <ul class="navbar-nav d-flex py-2 flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->is('*dashboard*') ? 'active' : '' }}" href="{{ url('dashboard') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-gauge text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>

            {{-- @if (Auth::user() && Auth::user()->name == 'Superadmin')
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">
                        Kelola Admin
                    </h6>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/') }}">
                        <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-user text-danger text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Admin</span>
                    </a>
                </li>
            @endif --}}

            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">
                    Kelola Gudang
                </h6>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('*gudang*') ? 'active' : '' }}"
                    href="{{ url('/gudang') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-warehouse text-secondary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Gudang</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('*barang*') ? 'active' : '' }}"
                    href="{{ url('/barang') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-box text-warning text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Barang</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('*mutasi*') ? 'active' : '' }}"
                    href="{{ url('/mutasi') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-box-archive text-info text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Mutasi</span>
                </a>
            </li>

            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">
                    Kelola Penjualan
                </h6>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('*jual*') ? 'active' : '' }}"
                    href="{{ url('/jual') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-cart-shopping text-success text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Jual</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('*histori*') ? 'active' : '' }}"
                    href="{{ url('/histori') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-clock-rotate-left text-info text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Histori Penjualan</span>
                </a>
            </li>

            {{-- <hr class="horizontal dark my-3" />

            <li class="nav-item">
                <a class="nav-link {{ request()->is('*settings*') ? 'active' : '' }}"
                    href="{{ url('admin/settings') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-gear text-dark text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Pengaturan</span>
                </a>
            </li> --}}
        </ul>
    </div>
</aside>
