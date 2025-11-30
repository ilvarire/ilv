<!DOCTYPE html>
<html lang="en">

<head>
    <title>Maintenance Mode</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="{{ $site->site_title ?? config('app.name')}}">
    <meta name="keywords"
        content="online shopping, e-commerce, buy online, online store, best deals, shopping cart, shopping website, ecommerce store, products online, fast delivery, free shipping, secure checkout, online deals">
    <meta name="robots" content="">
    <link rel="canonical" href="{{ config('app.url') }}" />


    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ config('app.url') }}">
    <meta property="og:title" content="{{ $site->site_description}}">
    <meta property="og:description"
        content="Discover the latest trends and best deals at {{ config('app.name') }}, Shop now for devices, electronics, home goods, and more with free shipping and secure checkout.">
    <meta property="og:image" content="{{ $site->og_image}}">


    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ config('app.url') }}">
    <meta name="twitter:title" content="{{ $site->site_description}}">
    <meta name="twitter:description"
        content="Discover the latest trends and best deals at {{ config('app.name') }}, Shop now for devices, electronics, home goods, and more with free shipping and secure checkout.">
    <meta name="twitter:image" content="{{ $site->og_image}}">


    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="{{ asset('storage/' . $site->favicon) }}" />

    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/fonts/iconic/css/material-design-iconic-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/fonts/linearicons-v1.0.0/icon-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/vendor/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/vendor/perfect-scrollbar/perfect-scrollbar.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/css/util.css">
    <link rel="stylesheet" type="text/css" href="/css/main.css">
    <!--===============================================================================================-->
    <style>
        .maintenance-container {
            min-height: 100vh;
            align-items: center;
            justify-content: center;
            text-align: center;
            background: #fff;
            padding: 10vw 16px 0 16px;
        }

        .maintenance-icon svg.spin {
            animation: spin 1.6s linear infinite;
            margin-bottom: 24px;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .maintenance-bar {
            width: 160px;
            height: 12px;
            background: #e6e6e6;
            border-radius: 6px;
            margin: 24px auto 0 auto;
            overflow: hidden;
            position: relative;
        }

        .maintenance-bar .bar {
            height: 100%;
            width: 60px;
            background: #717fe0;
            border-radius: 6px;
            animation: bar-move 1.2s cubic-bezier(.6, .3, .3, 1) infinite alternate;
            position: absolute;
            left: 0;
        }

        @keyframes bar-move {
            0% {
                left: 0;
                width: 60px;
            }

            80% {
                left: 100px;
                width: 60px;
            }

            100% {
                left: 100px;
                width: 12px;
            }
        }

        @media (max-width:600px) {
            .maintenance-bar {
                width: 90px;
            }
        }
    </style>
    @fluxAppearance
</head>

<body class="animsition">
    <div class="maintenance-container flex-c-m flex-col-c">
        <div class="maintenance-icon m-b-32">
            <svg class="spin" width="96" height="96" viewBox="0 0 96 96">
                <circle cx="48" cy="48" r="40" fill="none" stroke="#717fe0" stroke-width="8"
                    stroke-dasharray="180 70" />
            </svg>
        </div>
        <h1 class="ltext-103 cl1 m-b-16">We&rsquo;ll Be Back Soon!</h1>
        <p class="stext-103 cl3 m-b-32">We're currently undergoing scheduled maintenance.<br>Please check back
            in a little while. Thank you for your patience!</p>
        <div class="maintenance-bar m-b-32">
            <div class="bar"></div>
        </div>
        <span class="stext-106 cl4">— Team</span>
    </div>


    <!--===============================================================================================-->
    <script src="/vendor/jquery/jquery-3.2.1.min.js"></script>
    <!--===============================================================================================-->
    <script src="/vendor/animsition/js/animsition.min.js"></script>
    <!--===============================================================================================-->
    <script src="/vendor/bootstrap/js/popper.js"></script>
    <script src="/vendor/bootstrap/js/bootstrap.min.js"></script>

    <script src="/js/slick-custom.js"></script>
    <!--===============================================================================================-->
    <script src="/vendor/parallax100/parallax100.js"></script>
    <script>
        $('.parallax100').parallax100();
    </script>
    <!--===============================================================================================-->
    <script src="/vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script>
        $('.js-pscroll').each(function () {
            $(this).css('position', 'relative');
            $(this).css('overflow', 'hidden');
            var ps = new PerfectScrollbar(this, {
                wheelSpeed: 1,
                scrollingThreshold: 1000,
                wheelPropagation: false,
            });

            $(window).on('resize', function () {
                ps.update();
            })
        });
    </script>
    <!--===============================================================================================-->
    <script src="/js/main.js"></script>
    @fluxScripts
</body>

</html>