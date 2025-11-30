<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Error 403 - Forbidden</title>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/fonts/iconic/css/material-design-iconic-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="/fonts/linearicons-v1.0.0/icon-font.min.css">

    <link rel="stylesheet" type="text/css" href="/css/main.css">
    <link rel="stylesheet" type="text/css" href="/css/util.css">
    <style>
        .error-container {
            min-height: 85vh;
            text-align: center;
            align-items: center;
            justify-content: center;
            padding: 10vw 16px 0 16px;
            background: #fff;
        }

        .error-icon svg.lockani .shackle {
            transform-box: fill-box;
            transform-origin: 48px 39px;
            animation: lock403ani 1.6s cubic-bezier(.37, 1.23, .59, .93) infinite;
        }

        @keyframes lock403ani {
            0% {
                transform: rotate(-16deg);
            }

            24% {
                transform: rotate(8deg);
            }

            32% {
                transform: rotate(-8deg);
            }

            40%,
            90% {
                transform: rotate(0);
            }

            100% {
                transform: rotate(-16deg);
            }
        }
    </style>
</head>

<body class="animsition">
    <div class="error-container flex-c-m flex-col-c">
        <div class="error-icon m-b-24">
            <svg class="lockani" width="96" height="96" viewBox="0 0 96 96">
                <circle cx="48" cy="48" r="44" fill="#fff" stroke="#717fe0" stroke-width="7" />
                <rect x="30" y="42" width="36" height="32" rx="6" fill="#717fe0" />
                <rect class="shackle" x="38" y="30" width="20" height="18" rx="10" fill="#fff" stroke="#717fe0"
                    stroke-width="5" />
            </svg>
        </div>
        <h1 class="ltext-103 cl1 m-b-10">Access Denied</h1>
        <p class="stext-103 cl3 m-b-24">You do not have permission to view this page.</p>
        <a href="{{ route('home') }}" class="flex-c-m stext-101 cl0 size-104 bg1 bor1 hov-btn1 trans-04">Go Home</a>
    </div>


    <script src="/vendor/animsition/js/animsition.min.js"></script>
    <script src="/js/main.js"></script>
</body>

</html>