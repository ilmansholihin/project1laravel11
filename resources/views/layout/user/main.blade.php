<!DOCTYPE html>
<html lang="zxx" class="no-js">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="shortcut icon" href="{{ assets('assets/templates/user/img/fav.png') }}">

    <meta name="author" content="CodePixar">

    <meta name="description" content="">
    
    <meta name="keywords" content="">

    <meta charset="UTF-8">

    <title>Merch Store</title>

    @include('layout.user.style')
</head>
<body>
    @include('sweetalert::alert')
    @include('layout.user.navbar')
    @yield('content')
    @include('layout.user.footer')
    @include('layout.user.script')
</body>
</html>