<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head >
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="{{mix('js/app.js')}}"></script>
    <link rel = "icon" href =
    "{{asset('2227044.jpg')}}"
          type = "image/x-icon">
    <!--Title--> <title id="title">@yield('title')</title> <!--END-Title-->

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{mix('css/app.css')}}">
    <!--Css-->
    <link id="css" rel="stylesheet" href="@yield('css')">
    <!--END-Css-->

    <style>
        body {
            font-family: 'Nunito';
        }
    </style>
</head>

<body>
<!-- HTML -->
<x-alert-success />
<x-load-spinner/>
<!-- question the user -->
<div id="report">
    <i id="closeWindow" class="fas fa-window-close"></i>
<p class="message">Are you Sure  !</p>
    <button type="button" id="confirm" class="btn btn-info">Confirm</button>
    <button type="button"  id="cancel"  class="btn btn-success">Cancel</button>
</div>
<!-- start nav -->
<x-nav-bar />
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
