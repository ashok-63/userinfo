<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>User Info | Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description">
    <meta content="Themesbrand" name="author">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ url('/') }}/public/backend/assets/images/imp/favicon.png">

    <!-- Bootstrap Css -->
    <link href="{{ url('/') }}/public/backend/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet"
        type="text/css">
    <!-- Icons Css -->
    <link href="{{ url('/') }}/public/backend/assets/css/icons.min.css" rel="stylesheet" type="text/css">
    <!-- App Css-->
    <link href="{{ url('/') }}/public/backend/assets/css/app.min.css" id="app-style" rel="stylesheet"
        type="text/css">

</head>

<body class="account-pages">
    <!-- Begin page -->
    <div class="accountbg">
        <div class="row">
            <div class="col-md-12">
                <table width="66%" border="0" cellspacing="0" cellpadding="0">
                    <tbody>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td height="27" align="" valign="top" scope="col"><span
                                    class="reactivate style9">Instructions / News</span></td>
                        </tr>
                        <tr>
                            <td height="27" align="" valign="top" scope="col">
                                <p class="style10">28-Apr-2017</p>
                                <p>
                                    Activation / Reactivation WhatsApp Number <br />
                                    <img src="http://www.indiaantivirus.com/images/whatsApp_18x18.png" width="18"
                                        height="18" /> <span class="style2">8055776321</span> <br />
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td height="27" align="" valign="top" bgcolor="#DBDBB7" scope="col">
                                </br>
                                <p class="style10"><strong>20-Jan-2016 </strong></p>
                                <p>For Activation ask Customer if PC has Internet</p>
                                <p>If Internet is available then</p>
                                <p><strong>Close Registration Wizard And Run "Topup License"</strong></p>
                                <p>OR</p>
                                <p>
                                    <strong>
                                        Close Registration Wizard <br />
                                        and Double Click NPAV icon on Desktop
                                    </strong>
                                </p>
                                <p>
                                    Registration Wizard will Open Again<br />
                                    Next &gt; Next &gt; Try Online Activation Again
                                </p>
                                <p>
                                    Reason:<br />
                                    Registration Wizard in Update is OK<br />
                                    Registration Wizard in some CDs has problem for Online Activation
                                </p>
                                <p></p>
                            </td>
                        </tr>

                        <tr>
                            <td align="" bgcolor="#FFE2C6">
                                <p>&nbsp;</p>
                                <p>
                                    <strong>
                                        <span class="style10">08 Jan 2016 </span> <br />
                                        <br />
                                        <span class="style15">Important !</span>
                                    </strong>
                                </p>
                                <p>
                                    <strong>
                                        <span class="style15">
                                            Before Transferring any Call to Support department.<br />
                                            <br />
                                            Add Mobile number and Name to <a
                                                href="http://srv9.computerkolkata.com/calltracker/Login.aspx"
                                                target="_blank">srv9 CallTracker Software </a> Surely.
                                        </span>
                                    </strong>
                                </p>
                                <p><a href="http://srv9.computerkolkata.com/calltracker/"
                                        target="_blank">http://srv9.computerkolkata.com/calltracker/</a></p>
                                <p>&nbsp;</p>
                            </td>
                        </tr>
                        <tr>
                            <td bgcolor="#FFFFD9">
                                <p>
                                    <br />
                                    <span class="style10">1. For New Activation, New Number:<br /> </span> Now we have
                                    single Mobile number.<br />
                                    Please give this single mobile number to all your dealers and customers :
                                    <strong>9370 458 333<br /> </strong> For Out of Maharashtra give the
                                    respective&nbsp;State Mobile Numbers.<br />
                                    <br />
                                    <span class="style10">2. If any Dealer does not have a Dealer-Code :</span><br />
                                    Ask him to visit <strong>www.indiaantivirus.com/DlrCode</strong><br />
                                    <br />
                                    <strong class="style10">3. For Support please give new number :</strong><br />
                                    <strong>9325102020 / 020-30293029</strong><br />
                                    <br />
                                    <strong class="style10">4. For Activation on SMS : </strong><br />
                                    Mobile Number : <strong>9890501163</strong>, <strong>9657009570 </strong><br />
                                    <br />
                                    <strong class="style10">5. If Dealer wants Dealer-Portal Password :</strong> <br />
                                    Ask him to visit <strong>www.indiaantivirus.com/DealerPortal</strong><br />
                                    and click on 'Don't have password click here' -&gt; Enter DlrCode -&gt; Click 'Go'
                                    button -&gt; Get password on his registered Email-Id. <br />
                                    After this, if Dealer doesn't get password again then send Dlr-Code to Fazal
                                    (020-65601939).<br />
                                    <br />
                                    <strong class="style10">6. Laptop Lost / Stolen Case :</strong><br />
                                    Ask Customer to call on,<br />
                                    <strong>020-65601489</strong> (Abhijit)
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <div class="wrapper-page account-page-full">

        <div class="card shadow-none">
            <div class="card-block">

                <div class="account-box">

                    <div class="card-box shadow-none p-4">
                        <div class="p-2">
                            <div class="text-center mt-4">
                                <a href="{{ url('/') }}"><img
                                        src="{{ url('/public/backend/assets/images/imp/logo.png') }}"
                                        class="img-responsive" alt="logo"></a>
                            </div>

                            <h4 class="font-size-18 mt-2 text-center">Welcome Back !</h4>
                            <!-- <p class="text-muted text-center">Sign in to continue to Userinfo.</p> -->
                            <div class="info">
                                @if (Session::has('success'))
                                    <h5 class="text-success text-center"> {{ Session::get('success') }}</h5>
                                @elseif(Session::has('error'))
                                    <h5 class="text-danger text-center"> {{ Session::get('error') }}</h5>
                                @endif
                            </div>
                            <form class="mt-4" action="{{ url('CheckLogin') }}" role="form" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label" for="User_Name">Username</label>
                                    <input type="text" class="form-control" id="User_Name" name="User_Name"
                                        placeholder="Enter Username">
                                </div>


                                <div class="mb-3">
                                    <label class="form-label" for="Password">Password</label>
                                    <input type="password" class="form-control" id="Password" name="Password"
                                        placeholder="Enter Password">
                                </div>

                                <div class="mb-3 row">
                                    <div class="col-sm-6">
                                    </div>
                                    <div class="col-sm-6 text-end">
                                        <button class="btn btn-success w-md waves-effect waves-light"
                                            type="submit">Log
                                            In</button>
                                    </div>
                                </div>

                                <div class="">
                                    <div class="col-12 mt-3">
                                    </div>
                                </div>

                            </form>

                            <div class="mt-1 pt-1 text-center">
                                <p>
                                    {{-- <a href="#" onclick="fnSmsReact();"><strong>Send REACT Sms </strong></a>|
                                    <a href="#" onclick="fnSupWMS();"><strong>Send WMS to Support Department</strong></a> |
                                    <a href="#" onclick="fnSRenewalWMS();"><strong>Send WMS to Renewal Department</strong></a> |
                                    <a href="http://activation.indiaantivirus.com/actdlrreg/" target="_blank"><strong>Activation Dealer Registration</strong></a> <br />
                                    | <a href="#" onclick="fnSDlrCodeWMS();"><strong>Send Request Dealer Code </strong></a>|<a href="#" class="style6" onclick="fnReactRequest();"> <strong>Send Mail to Reactivation </strong></a> |
                                    <a href="http://www.computergoa.com/reactrequest/" target="_blank" class="style2"><strong>Send Reactivation Request </strong></a>|
                                    <span class="style8"><a href="http://www.computergoa.com/sendenq/" target="_blank" style="color: #ff0000;"><strong>Sales Enquiry</strong></a></span> --}}
                                </p>
                                <p>©
                                    <script>
                                        2022
                                    </script> NPAV.
                                </p>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>



    <!-- JAVASCRIPT -->
    <script src="{{ url('/') }}/public/backend/assets/libs/jquery/jquery.min.js"></script>
    <script src="{{ url('/') }}/public/backend/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ url('/') }}/public/backend/assets/libs/metismenu/metisMenu.min.js"></script>
    {{-- <script src="{{ url('/') }}/public/backend/assets/libs/simplebar/simplebar.min.js"></script>
                {{-- <script src="{{ url('/') }}/public/backend/assets/libs/node-waves/waves.min.js"></script> --}} --}}
    <style type="text/css">
        img.img-responsive {
            width: 33%;
        }

        a {
            color: #198754 ! important;
        }

        .accountbg {
            left: 34% ! important;
            background-color: #FFFFD9;
        }

        .account-page-full {
            width: 34% ! important;
            position: fixed;
        }

        body {
            overflow-x: hidden;
        }

        body,
        td,
        th {
            font-family: Verdana, Arial, Helvetica, sans-serif;
            font-size: 12px;
            line-height: 18px;
            color: #000 ! important;
        }

        .style9 {
            color: #ff0000;
        }

        td p {
            margin-left: 10%;
        }

        span.reactivate.style9 {
            margin-left: 10%;
        }

        .reactivate {
            font-size: 18px;
            font-weight: bold;
        }

        .style10 {
            color: #ff0000;
            font-weight: bold;
        }

        strong {
            font-weight: bold;
        }

        .style15 {
            font-size: 13px;
            font-weight: bold;
        }

        .btn-success {
            color: #fff;
            background-color: #198754 ! important;
            border-color: #198754 ! important;
        }
    </style>
</body>

</html>
