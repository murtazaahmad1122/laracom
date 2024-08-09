<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laracom') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <!-- <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" /> -->
        
    <link rel="shortcut icon" href="{{asset('assets/img/favicon.ico')}}" type="image/x-icon" />
    <!-- Bootstrap CSS -->
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Font-Awesome CSS -->
    <link href="{{asset('assets/css/font-awesome.min.css')}}" rel="stylesheet">
    <!-- helper class css -->
    <link href="{{asset('assets/css/helper.min.css')}}" rel="stylesheet">
    <!-- Plugins CSS -->
    <link href="{{asset('assets/css/plugins.css')}}" rel="stylesheet">
    <!-- Main Style CSS -->
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/skin-default.css')}}" rel="stylesheet" id="galio-skin">
        <!-- Scripts -->
        <!-- @vite(['resources/css/app.css', 'resources/js/app.js']) -->

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <x-banner />

        <div class="wrapper box-layout">
            @livewire('navigation-menu')

            <!-- Page Heading -->
           <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @stack('modals')

        @livewireScripts

      <!--All jQuery, Third Party Plugins & Activation (main.js) Files-->
    <script src="{{asset('assets/js/vendor/modernizr-3.6.0.min.js')}}"></script>
    <!-- Jquery Min Js -->
    <script src="{{asset('assets/js/vendor/jquery-3.3.1.min.js')}}"></script>
    <!-- Popper Min Js -->
    <script src="{{asset('assets/js/vendor/popper.min.js')}}"></script>
    <!-- Bootstrap Min Js -->
    <script src="{{asset('assets/js/vendor/bootstrap.min.js')}}"></script>
    <!-- Plugins Js-->
    <script src="{{asset('assets/js/plugins.js')}}"></script>
    <!-- Ajax Mail Js -->
    <script src="{{asset('assets/js/ajax-mail.js')}}"></script>
    <!-- Active Js -->
    <script src="{{asset('assets/js/main.js')}}"></script>
    <!-- Switcher JS [Please Remove this when Choose your Final Projct] -->
    <script src="{{asset('assets/js/switcher.js')}}"></script>


    <script>
   $('.add-to-cart-btn').click(function (e) {
    console.log('clicking');
    e.preventDefault();

    let url = $(this).data('url'); // The URL should be like `/cart/add/{id}` or a route name that expects an ID.

    $.post(url, {
        _token: '{{ csrf_token() }}' // Always include CSRF token for POST requests.
    }, function (data) {
        alert('Product added to cart'); // Handle success response.
    });
});
</script>  

    </body>
</html>
