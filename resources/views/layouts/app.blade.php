<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('leaflet/leaflet.css') }}">
    @notifyCss
    @laravelPWA

    <script type="text/javascript">
        // Initialize the service worker
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/serviceworker.js', {
                scope: '.'
            }).then(function (registration) {
                // Registration was successful
                console.log('Laravel PWA: ServiceWorker registration successful with scope: ', registration.scope);
            }, function (err) {
                // registration failed :(
                console.log('Laravel PWA: ServiceWorker registration failed: ', err);
            });
        }
    </script>


    <script src="{{ asset('leaflet/leaflet.js') }}"></script>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>

    <style>
        #map0{
            margin: auto;
            margin-top: 30px;
            width: 100%;
            height: 450px;
        }
        #map{
            margin: auto;
            margin-top: 30px;
            width: 90%;
            height: 450px;
        }
    </style>

</head>
<body>

    @include('components.nav')

    @yield('document')

    @if (auth()->user())

        @include('components.notifications')

    @endif

   
    @include('notify::components.notify')

    @stack('extra-script')

    @notifyJs

    <script src="{{ asset('js/bundle.js') }}"></script>

</body>
</html>
