<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@400;500&display=swap" rel="stylesheet">
    <title>{{ $details['title'] }}</title>
    <style>
        @media (max-width: 650px) {
            .container {
                width: 550px;
            }
        }

        @media (max-width: 500px) {
            .container {
                width: 400px;
            }
        }

        @media (max-width: 380px) {
            .container {
                width: 340px;
            }
        }

        @media (max-width: 320px) {
            .container {
                width: 290px;
            }
        }

    </style>
</head>
<body style="margin: 0; padding: 0; font-family: 'Jost', sans-serif; font-weight: 400; background: #5e3fc9;">
<div class="container" style="width: 650px; margin: 0 auto; padding-top:15px; padding-bottom: 15px;">
    <div class="header" style="padding: 15px 15px; background: #fff;">
        <a href="{{ $details['site_link'] }}" style="text-decoration: none; transition: 0.3s;">
            <img style="height: 20px; width: auto;" src="{{ $details['site_logo'] }}" alt="">
        </a>

    </div>
    <div class="main-content">
        <div class="banner" style="margin-bottom: 0px;">
            <img style="max-width: 100%;" src="{{ $details['banner'] }}" alt="">
        </div>
        <div class="contents" style="color: #666; background: #fff; padding: 35px;">
            <h2 class="title"
                style="font-size: 24px; font-weight: 500; color: #333; margin-bottom: 40px;">{{ $details['title'] }}</h2>
            <div class="greetings" style="margin-bottom: 15px; margin-top: 15px;">
                {{ $details['salutation'] }}
            </div>
            <p style="margin-bottom: 0px; line-height: 32px; font-size: 16px;">{!! $details['message_body'] !!}</p>
            <a href="{{ $details['button_link'] }}" class="btn-link"
               style="margin-top: 35px; display: inline-block; padding: 18px 42px; border-radius: 3px; color: #001219; background: #ffffff; font-weight: 500; text-transform: uppercase; font-size: 13px; box-shadow: 0px 0px 2px #00304966; background: #e73667; color: #ffffff; text-decoration: none; text-decoration: none; transition: 0.3s;">{{ $details['button_level'] }}</a>

            @if($details['footer_status'])
                <div class="content-footer" style="margin-top: 50px;">
                    <img class="footer-logo" style="height: 15px; margin-bottom: 5px;" src="{{ $details['site_logo'] }}"
                         alt="{{ $details['site_title'] }}">
                    <p style="font-size: 14px !important; line-height: 12px !important;">{!! $details['footer_body'] !!}</p>
                </div>
            @endif
        </div>
        @if($details['bottom_status'])
            <div class="newslatter-bottom" style="padding: 35px; background: #fff; margin-top: 15px;">
                <h3 class="title"
                    style="font-size: 18px; margin-bottom: 10px; font-weight: 500;">{{ $details['bottom_title'] }}</h3>
                <p class="text" style="font-size: 14px; line-height: 24px;">{!! $details['bottom_body'] !!}</p>
                <a href="{{ $details['site_link'] }}" class="link"
                   style="font-size: 14px; font-weight: 500; color: #e73667; display: inline-block; margin-top: 10px; text-decoration: none;">Learn
                    More</a>
            </div>
        @endif
    </div>
</div>
</body>
</html>
