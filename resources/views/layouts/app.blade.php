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
    // Add to Cart with AJAX
    $('.add-to-cart-btn').click(function (e) {
        e.preventDefault();

        let url = $(this).data('url'); // URL to add to cart

        $.post(url, {
            _token: '{{ csrf_token() }}' // CSRF token for security
        }, function (data) {
            if (data.success) {
                // Product successfully added to cart
                alert('Product added to cart!');
                updateMiniCart(); // Automatically update the mini cart after adding product
            } else {
                alert('Error adding product to cart.');
            }
        }).fail(function () {
            alert('Something went wrong!');
        });
    });

    // Function to Update Mini Cart
    function updateMiniCart() {
        $.get("{{ route('cart.items') }}", function (data) {
            // Update the cart notification counter
            $('.cart-notification').text(data.totalCount);

            // Clear and populate the cart list with new items
            let cartList = $('.cart-list');
            cartList.empty(); // Clear the existing cart items

            // Loop through the items and append them dynamically
            data.items.forEach(function (item) {
                cartList.append(`
                    <li>
                        <div class="cart-img">
                            <a href="/product-details/${item.id}"><img src="${item.image_path}" alt="${item.title}"></a>
                        </div>
                        <div class="cart-info">
                            <h4><a href="/product-details/${item.id}">${item.title}</a></h4>
                            <span>$${item.price.toFixed(2)}</span> x ${item.quantity}
                        </div>
                        <div class="del-icon">
                            <i class="fa fa-times" onclick="removeFromCart(${item.id})"></i>
                        </div>
                    </li>
                `);
            });

            // Append the subtotal and checkout button after all products
            cartList.append(`
                <li class="mini-cart-price">
                    <span class="subtotal">subtotal : </span>
                    <span class="subtotal-price">PK${data.totalPrice.toFixed(0)}</span>
                </li>
                <li class="checkout-btn">
                    <a href="/checkout">checkout</a>
                </li>
            `);

            // Update the total price outside of the list
            $('.cart-total-price').html('<span>total:</span> PK' + data.totalPrice.toFixed(0));
        });
    }

    // Call the update function when the page loads to initialize the cart
    $(document).ready(function () {
        updateMiniCart(); // Initialize mini cart on page load
    });
</script>


    </body>
</html>
