<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ secure_asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ secure_asset('css/app.css') }}" rel="stylesheet">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="194x194" href="/favicon-194x194.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/android-chrome-192x192.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-TileImage" content="/mstile-144x144.png">
    <meta name="theme-color" content="#da532c">
    <script src="https://kit.fontawesome.com/a2259b49a6.js"></script>
</head>
<body class="d-flex flex-column">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm" id="topnav">
            <div class="container">
                <a class="navbar-brand" href="{{ secure_url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ secure_url('/tests')}}"> {{__('Zu den Karteien')}}</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav ml-auto">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            @impersonating
                                <li class="nav-item">
                                    <a href="{{ route('impersonate.leave') }}" class="nav-link">Leave impersonation</a>
                                </li>
                            @endImpersonating
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    @if(auth()->user()->isAdmin())
                                    <a class="dropdown-item" href="{{ url('/admin') }}">Einstellungen & Statistik</a>
                                    @endif
                                    <a class="dropdown-item"  href="{{ url('/user/'.auth()->user()->id) }}">Profil anzeigen</a>

                                    <a class="dropdown-item" id="darkModeToggle">Toggle darkmode</a>

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4 maincontent">
            @yield('content')
        </main>
    </div>
    @include('components.footer', ["class" => "mastfoot mt-auto"])


    @yield('js')
    <script>
        function createCookie(cookieName,cookieValue,daysToExpire) {
          var date = new Date();
          date.setTime(date.getTime()+(daysToExpire*24*60*60*1000));
          document.cookie = cookieName + "=" + cookieValue + "; expires=" + date.toGMTString();
        }
		function accessCookie(cookieName) {
          var name = cookieName + "=";
          var allCookieArray = document.cookie.split(';');
          for(var i=0; i<allCookieArray.length; i++)
          {
            var temp = allCookieArray[i].trim();
            if (temp.indexOf(name)==0)
            return temp.substring(name.length,temp.length);
       	  }
        	return "";
        }

		function toggleDarkmode(darkmode)
        {
            body = document.getElementsByTagName("body")[0];
            navbar = document.getElementById("topnav");
            if(darkmode === true){
                navbar.classList.remove("navbar-light");
                navbar.classList.add("navbar-dark");
                navbar.classList.remove("bg-white");
                navbar.classList.add("bg-dark");
                body.classList.add("dark-mode");
            } else {
                navbar.classList.remove("bg-dark");
                navbar.classList.add("navbar-light");
                navbar.classList.remove("navbar-dark");
                navbar.classList.add("bg-white");
                body.classList.remove("dark-mode");
            }
        }
        document.addEventListener('click', function (event) {
            if(event.target.matches('#darkModeToggle')) {
                event.preventDefault();
                darkmode = checkDarkmode();
                setDarkmode(Boolean(darkmode)==false ? true : false);
                toggleDarkmode(Boolean(darkmode)==false ? true : false);
            }
        }, false);


        function checkDarkmode(){
            var darkmode = accessCookie("darkmode");
            if(darkmode.length == 0) {
                var prefersDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
                createCookie("darkmode", prefersDarkMode, 99999);
                darkmode = prefersDarkMode;
            }

            return (darkmode == "true");
        }
        function setDarkmode(darkmode){
            createCookie("darkmode", Boolean(darkmode), 99999);
        }
        toggleDarkmode(checkDarkmode());

    </script>
</body>
</html>
