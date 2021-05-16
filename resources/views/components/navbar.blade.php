<!-- nav -->
<div class="navbar navbar-expand-lg  navbar-light bg-light" role="navigation" >
    <div class="container-fluid">
        <a class="navbar-brand home_page" href="">
            {{ config('app.name', 'Laravel') }}
        </a>
        {{-- @auth--}}
        <ul class="profile-info">
            <li class="nav-item dropdown">
                <a href="#" class="profile-nav"><img src="" class="profile-image" alt="profile image"> <span class="profile-name" id="profile_name"></span></a>
                <a class="nav-link dropdown-toggle profile-icon" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                </a>
                <ul class="dropdown-menu profile-menu" aria-labelledby="navbarDropdown">
                    <!-- Authentication Lg-dark text-whiteinks -->
                    <li><a href="{{--{{route('users.edit',[Auth::user()->id])}}--}}" class="dropdown-item">Profile</a></li>

                    {{--                        <li><a class="dropdown-item" href="#">{{ Auth::user()->email }}</a></li>--}}
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <button class="dropdown-item" id="Logout">Logout<i class="fas fa-door-open"></i></button>
                    </li>
                </ul>
            </li>
        </ul>
        {{--@endauth--}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link home_page" aria-current="page" href="">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Dropdown
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Filter
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li>
                            <a class="dropdown-item" href="#?filter=All"><input type="radio" name="Filter-Search" value=".card" style="display: inline"> All</a>
                        <li><hr class="dropdown-divider"></li>
                         <a class="dropdown-item" href="#?filter=Factory_name"><input class="dropdown-item" type="radio" name="Filter-Search" value=".factory-name" style="display: inline" >Factory name</a>
                         <a class="dropdown-item" href="#?filter=Owner_name"><input class="dropdown-item" type="radio" name="Filter-Search" value=".owner-name" style="display: inline" >Owner name</a>
                        </li>

                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </li>
                <form  class="d-flex nav-search" autocomplete="off">
                    <input id="search" class="" type="search" placeholder="Search" id="search" onclick="document.getElementById('search').style.outline='none'">
                    <button class="search-icon" type="submit"><i class="fas fa-search"></i></button>
                </form>
                <!-- user profile -->
                {{--   @guest
                       @if (Route::has('login'))
                           <li class="nav-item">
                               <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                           </li>
                       @endif

                       @if (Route::has('register'))
                           <li class="nav-item">
                               <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                           </li>
                       @endif
                   @endguest--}}
            </ul>
        </div>
    </div>
</div>
<!-- end nav nav -->
<script src="{{mix("js/nav-bar.js")}}"></script>
