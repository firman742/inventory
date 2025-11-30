<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Sistem Inventory - @yield('title', '')</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/favicon.png') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}">

    <!-- html5-qrcode -->
    <script src="https://unpkg.com/html5-qrcode"></script>
    
    @stack('styles')
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        @include('Layouts.sidebar')
        <!--  Sidebar End -->

        <!--  Main wrapper -->
        <div class="body-wrapper">
            <!--  Header Start -->
            @include('Layouts.header')
            <!--  Header End -->

            <div class="body-wrapper-inner">
                <div class="container-fluid">

                    @yield('content')

                    <div class="py-6 px-6 text-center">
                        <p class="mb-0 fs-4">Design and Developed by <a href="https://github.com/firman742" target="_blank"
                                class="pe-1 text-primary text-decoration-underline">Hafidz Firman</a></p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/dist/simplebar.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    <!-- Solar icons -->
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>

    @stack('scripts')
    <script src="https://unpkg.com/html5-qrcode"></script>
</body>

</html>
