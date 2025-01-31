<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
        }

        .dark-bg {
            background: linear-gradient(112.1deg, rgb(32, 38, 57) 11.4%, rgb(63, 76, 119) 70.2%);
            color: #fff;
        }

        .light-bg {
            background: #fff;
            color: #001219b3;
        }

        .unusual-page {
            width: 100%;
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .unusual-page .unusual-page-img {
            height: 250px;
            margin-bottom: 40px;
        }

        .back-to-home-btn {
            display: inline-block;
            padding: 13px 27px;
            border-radius: 50px;
            color: #ffffff;
            background: #2988ed;
            font-weight: 500;
            font-size: 13px;
            text-transform: uppercase;
            box-shadow: 0px 0px 2px #00304966;
            text-decoration: none;
            margin-top: 20px;
        }

        @media (max-width: 991px) {
            .unusual-page .unusual-page-img {
                height: 150px;
            }
        }

        .unusual-page .title {
            font-size: 62px;
            font-weight: 700;
            margin-bottom: 30px;
        }

        @media (max-width: 991px) {
            .unusual-page .title {
                font-size: 42px;
            }
        }

        .unusual-page .description {
            font-size: 28px;
            font-weight: 700;
        }

        @media (max-width: 991px) {
            .unusual-page .description {
                font-size: 18px;
            }
        }
    </style>
</head>

<body class="dark-bg">

<div class="unusual-page">
    @yield('content')
</div>

</body>
</html>


