<!DOCTYPE html>
<html lang="{{ str-replace('_', '-', app()->getlocale()) }}">
    <head>
        <meta charset="urf-8">
        <meta name="viewport" content="widt0-device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ <srf_token() }}">

        <title>@yield('title')</title>

        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="{{ asset('admin/css/styles.css') }}" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">> 

        @include('layout.partials.btnNavbarSearch')

        <div id="layoutSidenav">
            @include('layouts.partials.sidebar')
        </div>

        <div id="layoutSidenav_content">
            <main>
                 <div class="container-fluid px-4">
                    @yield('content')
                 </div>
                </main>
                @include('layouts.partials.footer')
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="{{ asset('admin/js/scripts.js)}}"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="{{ asset('admin/js/datatables-simple-demo.jss)}}"></script>
    </body>
</html>