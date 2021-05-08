<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>admin login</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{mix('css/app.css')}}">
    <link rel="stylesheet" href="@yield('css')">
    <style>
        body {
            font-family: 'Nunito';
        }
    </style>
    <script src="{{mix('js/app.js')}}"></script>
</head>

<body>
<!-- start nav -->
<x-nav-bar />
<i id="loading-icon" class="fas fa-spinner faa-spin animated faa-fast"></i>
<!-- end nav -->
<!-- start aside -->
<x-aside-nav-bar />
<!-- end aside -->
<main id="content" class="main-admin">
    @yield('content')
</main >
@yield('scripts')

</body>
</html>
