<html lang="en">

<head>
    <meta charset="utf-8">
    <title>User Info | Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="" name="description">
    <meta content="" name="author">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ url('/') }}/public/backend/assets/images/imp/favicon.png">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/fontawesome.css">
    <link href="{{ url('/') }}/public/backend/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet"
        type="text/css">
    <style>
        @import url('https://fonts.googleapis.com/css?family=Raleway:400,700');

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Raleway, sans-serif;
        }

        body {
            background: linear-gradient(90deg, #c5f4de, #6ba8cc);
        }


        .container {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .screen {
            background: linear-gradient(90deg, #5da454bf, #78b889);
            position: relative;
            height: 600px;
            width: 360px;
            box-shadow: 0px 0px 24px black;
            border-radius: 22px;
        }

        .screen__content {
            z-index: 1;
            position: relative;
            height: 100%;
        }

        .screen__background {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 0;
            -webkit-clip-path: inset(0 0 0 0);
            clip-path: inset(0 0 0 0);
        }

        .screen__background__shape {
            transform: rotate(45deg);
            position: absolute;
        }

        .screen__background__shape1 {
            height: 520px;
            width: 520px;
            background: #FFF;
            top: -50px;
            right: 120px;
            border-radius: 0 72px 0 0;
        }

        .screen__background__shape2 {
            height: 220px;
            width: 220px;
            background: #63ac6c;
            top: -172px;
            right: 0;
            border-radius: 32px;
        }

        .screen__background__shape3 {
            height: 540px;
            width: 190px;
            background: linear-gradient(270deg, #54a4a0, #679e69);
            top: -24px;
            right: 0;
            border-radius: 32px;
        }

        .screen__background__shape4 {
            height: 400px;
            width: 200px;
            background: #7bb997;
            top: 420px;
            right: 50px;
            border-radius: 60px;
        }

        .login {
            /* width: 320px; */
            padding: 30px;
            /* padding-top: 156px; */
        }

        .login__field {
            padding: 13px 0px;
            position: relative;
        }

        .login__icon {
            position: absolute;
            top: 26px;
            color: #7bb997;
            margin-left: 7px;
        }

        .login__input {
            border: none;
            border-bottom: 2px solid #D1D1D4;
            background: none;
            padding: 10px;
            padding-left: 24px;
            font-weight: 700;
            width: 75%;
            transition: .2s;
            border-radius: 25px;
        }

        .login__input:active,
        .login__input:focus,
        .login__input:hover {
            outline: none;
            border-bottom-color: #72bc94;
        }

        .login__submit {
            background: #fff;
            font-size: 14px;
            margin-top: 30px;
            padding: 15px 20px;
            border-radius: 26px;
            border: 1px solid #D4D3E8;
            text-transform: uppercase;
            font-weight: 700;
            display: flex;
            align-items: center;
            width: 75%;
            /* color: #4C489D; */
            box-shadow: 0px 2px 2px #569673;
            cursor: pointer;
            transition: .2s;
        }

        .login__submit:active,
        .login__submit:focus,
        .login__submit:hover {
            border-color: #7bb997;
            outline: none;
        }

        .button__icon {
            font-size: 24px;
            margin-left: auto;
            color: #7bb997;
        }

        .social-login {
            position: absolute;
            height: 140px;
            width: 160px;
            text-align: center;
            bottom: 0px;
            right: 0px;
            color: #fff;
        }

        .social-icons {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .social-login__icon {
            padding: 20px 10px;
            color: #fff;
            text-decoration: none;
            text-shadow: 0px 0px 8px #7875B5;
        }

        .social-login__icon:hover {
            transform: scale(1.5);
        }
    </style>
</head>

<body>
    <div class="col-12 d-flex">
        <div class="col-7 d-flex justify-content-center">
            <div>
                <img src="{{ url('/public/backend/assets/images/imp/login.svg') }}" class="img-responsive my-5"
                    alt="logo">
            </div>
        </div>
        <div class="container col-5" style="overflow: hidden;">
            <div class="screen">
                <div class="screen__content">
                    <div class="d-flex">
                        <a href="{{ url('/') }}"><img
                                src="{{ url('/public/backend/assets/images/imp/user_info.svg') }}"
                                class="img-responsive" alt="logo" width="75%"
                                style="margin-top: 14px;margin-left: 26px;"></a>
                    </div>
                    <div class="info">
                        @if (Session::has('success'))
                            <h5 class="" style="color: green;text-align:center"> {{ Session::get('success') }}
                            </h5>
                        @elseif(Session::has('error'))
                            <h5 class="" style="color: red;text-align:center"> {{ Session::get('error') }}</h5>
                        @endif

                    </div>
                    <form class="login" action="{{ url('CheckLogin') }}" role="form" method="POST">
                        @csrf
                        <div class="login__field">
                            <i class="login__icon fas fa-user"></i>
                            <input type="text" class="login__input" name="User_Name" id="User_Name"
                                placeholder="Username">
                        </div>
                        <div class="login__field">
                            <i class="login__icon fas fa-lock"></i>
                            <input type="password" class="login__input" name="Password" id="Password"
                                placeholder="Password">
                        </div>
                        <button class="button login__submit" type="submit">
                            <span class="button__text">Log In Now</span>
                            <i class="button__icon fas fa-chevron-right"></i>
                        </button>
                    </form>

                    <div style="text-align: center"> <img src="{{ url('/public/backend/assets/images/imp/logo.jpg') }}"
                            class="img-responsive" alt="logo" width="30%" style="border-radius: 50%;"></div>


                </div>
                <div class="screen__background">
                    <span class="screen__background__shape screen__background__shape4"></span>
                    <span class="screen__background__shape screen__background__shape3"></span>
                    <span class="screen__background__shape screen__background__shape2"></span>
                    <span class="screen__background__shape screen__background__shape1"></span>
                </div>
            </div>
        </div>

    </div>

    <div class="text-center " style="margin-top: -40px">
        <h6>©

               2022
             NPAV.
        </h6>
    </div>
</body>

</html>
