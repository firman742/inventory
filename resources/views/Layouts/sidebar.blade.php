<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
            <a href="{{ route('dashboard') }}" class="text-nowrap logo-img">
                <img src="../assets/images/logos/logo.svg" alt="" />
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-6"></i>
            </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
            <ul id="sidebarnav">
                <li class="nav-small-cap">
                    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                    <span class="hide-menu">Home</span>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link" href="{{ route('dashboard') }}" aria-expanded="false">
                        <i class="ti ti-atom"></i>
                        <span class="hide-menu">Dashboard</span>
                    </a>
                </li>
                <!-- ---------------------------------- -->
                <!-- Dashboard -->
                <!-- ---------------------------------- -->

                <li
                    class="sidebar-item {{ request()->routeIs('products.*') || request()->routeIs('product-types.*') ? 'selected' : '' }}">
                    <a class="sidebar-link justify-content-between has-arrow" href="javascript:void(0)"
                        aria-expanded="{{ request()->routeIs('products.*') || request()->routeIs('product-types.*') ? 'true' : 'false' }}">
                        <div class="d-flex align-items-center gap-3">
                            <span class="d-flex">
                                <i class="ti ti-building-store"></i>
                            </span>
                            <span class="hide-menu">Produk</span>
                        </div>
                    </a>
                    <ul aria-expanded="{{ request()->routeIs('products.*') || request()->routeIs('product-types.*') ? 'true' : 'false' }}"
                        class="collapse first-level {{ request()->routeIs('products.*') || request()->routeIs('product-types.*') ? 'in' : '' }}">
                        <li class="sidebar-item">
                            <a class="sidebar-link justify-content-between {{ request()->routeIs('product-types.*') ? 'active' : '' }}"
                                href="{{ route('product-types.index') }}">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">Jenis Produk</span>
                                </div>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link justify-content-between
                            {{ request()->routeIs('products.*') ? 'active' : '' }}"
                                href="{{ route('products.index') }}">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="round-16 d-flex align-items-center justify-content-center">
                                        <i class="ti ti-circle"></i>
                                    </div>
                                    <span class="hide-menu">Produk</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link justify-content-between"
                        href="https://bootstrapdemos.adminmart.com/modernize/dist/main/index.html"
                        aria-expanded="false">
                        <div class="d-flex align-items-center gap-3">
                            <span class="d-flex">
                                <i class="ti ti-arrow-autofit-right"></i>
                            </span>
                            <span class="hide-menu">Stok Masuk</span>
                        </div>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link justify-content-between"
                        href="https://bootstrapdemos.adminmart.com/modernize/dist/main/index2.html"
                        aria-expanded="false">
                        <div class="d-flex align-items-center gap-3">
                            <span class="d-flex">
                                <i class="ti ti-arrow-autofit-left"></i>
                            </span>
                            <span class="hide-menu">Stok Keluar</span>
                        </div>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link justify-content-between"
                        href="https://bootstrapdemos.adminmart.com/modernize/dist/main/index2.html"
                        aria-expanded="false">
                        <div class="d-flex align-items-center gap-3">
                            <span class="d-flex">
                                <i class="ti ti-clipboard-data"></i>
                            </span>
                            <span class="hide-menu">Laporan</span>
                        </div>
                    </a>
                </li>
                <li>
                    <span class="sidebar-divider lg"></span>
                </li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
