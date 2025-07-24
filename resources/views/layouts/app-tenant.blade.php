<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Tenant Infinite Breeze')</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('img/logo.jpg') }}" type="image/icon type">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/styleadmin.css') }}">

    <!-- Google Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
</head>
<body>
    @include('components.sidebarTenant') 

    <div class="main-body">
        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
