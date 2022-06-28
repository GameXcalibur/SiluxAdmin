<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Silux Admin</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>SiluxAdmin : Admin Panel</title>
    <!-- plugins:css -->


    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('css') }}/style.css">

    <!-- endinject -->
    <!--    <link rel="shortcut icon" href="../images/favicon.png" />-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css') }}/main.css">
</head>

<style>
    body,
    h1,
    h2,
    h3,
    h4,
    h5,
    h6,
    thead th,
    input,
    .form-control {
        font-family: 'Josefin Sans', sans-serif !important;
    }

    .icon-btn {
        cursor: pointer;
    }

    thead th {
        color: #6610f2;
        font-weight: 700 !important;
    }

    .btn-primary {
        background: #0a003a !important;
        border: none !important;
    }

    .nav-item i {
        margin-right: 15px;
    }

</style>
</head>
<body>
    <div id="app" class="container-fluid page-body-wrapper">
    @include('sidebar')
    <div class="main-panel" style="min-height: 100vh;"> 
        @yield('content')
    </div>
    </div>
</body>
@stack('js')

</html>
