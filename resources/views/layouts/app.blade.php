<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}?v=1.0.4" defer></script>

    @yield('scripts')

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Pirata+One&family=Roboto:wght@500;900&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}?v=1.0.3" rel="stylesheet">

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('favicon/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('favicon/safari-pinned-tab.svg') }}" color="#5bbad5">
</head>

<body>
    <a class="logo-link" href="#landing">
        <img src="{{ asset('images/pragwoodt-small.png') }}" alt="na vrh">
    </a>
    <nav>
        <ul>
            <li>
                <a class="btn-nav" id="onas-link" href="#onas">O nas</a>
            </li>
            <li>
                <a class="btn-nav" id="izdelki-link" href="#izdelki">Izdelki</a>
            </li>
            <li>
               <a class="btn-nav" id="kontakt-link" href="#kontakt">Kontakt</a>
            </li>
        </ul>
    </nav>
    <div id="app">
        <main>
            @yield('content')
        </main>
    </div>
    <footer>
        <div class="spacer wave-start flip"></div>
        <div class="footer">
            <div class="more">
                2021 Pragwald Woodworks &copy;
            </div>
            <div class="ig-link">
                <a class="btn-img" href="https://www.instagram.com/pragwald_woodworks/">
                    <img src="{{ asset('images/instagram_icon.webp') }}" alt="instagram">
                </a>
            </div>
            <div class="holds-less">
                <div class="less">
                    <span>Žan Vozlič | <a class="email-white" href="mailto:zan.vozlic@gmail.com">zan.vozlic@gmail.com</a></span> 
                </div>
                <div class="less">
                    <span>Nace Tavčer | <a class="email-white" href="mailto:nace.tavcer@gmail.com">nace.tavcer@gmail.com</a></span> 
                </div>
            </div>
        </div>  
    </footer>
</body>
</html>