<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Error 503 - Service Unavailable</title>
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

        .error-icon svg.bounce {
            animation: bounce404 1.25s infinite alternate;
        }

        @keyframes bounce404 {
            0% {
                transform: translateY(0);
            }

            100% {
                transform: translateY(-18px);
            }
        }

        .error-icon text {
            font-weight: bold;
        }
    </style>
</head>

<body class="animsition">
    <div class="error-container flex-c-m flex-col-c">
        <div class="error-icon m-b-24">
            <svg class="shake" width="112" height="112" viewBox="0 0 112 112">
                <circle cx="56" cy="56" r="50" fill="#fff" stroke="#f74877" stroke-width="7" />
                <text x="56" y="72" text-anchor="middle" fill="#f74877" font-size="48"
                    font-family="Montserrat,Arial,sans-serif">503</text>
            </svg>
        </div>
        <h1 class="ltext-103 cl11 m-b-10">Service Unavailable</h1>
        <p class="stext-103 cl3 m-b-24">Oops! This service is unavailable.<br>Please try again later, or <a
                href="{{ route('contact') }}" class="cl1 hov-cl1">contact support</a>.</p>
    </div>


    <script src="/vendor/animsition/js/animsition.min.js"></script>
    <script src="/js/main.js"></script>
</body>

</html>