<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="{{ secure_asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('css/cover.css') }}" rel="stylesheet">
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
    </head>
    <body class="text-center">
        <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
            <header class="masthead mb-auto">
                <div class="inner">
                <h3 class="masthead-brand">{{ config('app.name', 'Laravel') }}</h3>
                <nav class="nav nav-masthead justify-content-center">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/tests') }}" class="nav-link">Zu den Karteien</a>
                        @else
                            <a href="{{ route('login') }}" class="nav-link">Login</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="nav-link">Register</a>
                            @endif
                        @endauth
                    @endif
                </nav>
                </div>
            </header>

          <main role="main" class="inner cover">
            <h1 class="cover-heading">Lernkartei für den ÖRK Fragenkatalog</h1>
            <p class="lead">Auf dieser Seite kannst du einfach und schnell den Fragenkatalog für Erste Hilfe und Sanitätshilfe des Österreichischen Roten Kreuz lernen und Prüfungssimulationen absolvieren.</p>
            <p>Die Lernkartei basiert dabei auf dem Prinzip von Anki und die Selbsttests haben die selben Regeln wie der NFS Einstiegstest</p>
          </main>

          @include('components.footer', ["class" => "mastfoot mt-auto"])
        </div>
    </body>
</html>
