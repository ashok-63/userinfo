<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Userinfo | Get OTP </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="" name="description">
    <meta content="" name="author">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ url('/public/backend/assets/images/favicon.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    {{-- <link href="{{ url('/') }}/public/backend/assets/libs/chartist/chartist.min.css" rel="stylesheet"> --}}
    <!-- Bootstrap Css -->
    <link href="{{ url('/') }}/public/backend/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet"
        type="text/css">
    <!-- Icons Css -->
    <link href="{{ url('/') }}/public/backend/assets/css/icons.min.css" rel="stylesheet" type="text/css">
    <!-- App Css-->
    <link href="{{ url('/') }}/public/backend/assets/css/app.min.css" id="app-style" rel="stylesheet"
        type="text/css">
    <link href="{{ url('/') }}/public/backend/assets/css/custom.css" id="app-style" rel="stylesheet"
        type="text/css">
    <!-- Select2 Css-->
    <link href="{{ url('public/backend/assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css">
    <!-- sweet alert Css-->
    <link href="{{ url('public/backend/assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
    <!-- Datatable Css-->
    <link href="{{ url('public/backend/assets/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet">
    <link href="{{ url('public/backend/assets/css/jquery.toast.css') }}" rel="stylesheet">
    <script src="{{ url('/') }}/public/backend/assets/libs/jquery/jquery.min.js"></script>
    <script src="{{ url('public/backend/assets/js/jquery.validate.min.js') }}"></script>
    <!-- sweet alert Js-->
    <script src="{{ url('public/backend/assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <style>
        #manualOTP {
            float: right;
            font-size: 14px;
        }

        #manualOTP:hover {
            color: #526ce7;
            cursor: pointer;
        }

        .otp-input {
            display: flex;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .otp-input input {
            width: 40px;
            height: 40px;
            margin: 0 5px;
            text-align: center;
            font-size: 1.2rem;
            border: 1px solid #444;
            border-radius: 4px;
            /* background-color: #2a2a2a; */
            /* color: #ffffff; */
        }

        .otp-input input::-webkit-outer-spin-button,
        .otp-input input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .otp-input input[type="number"] {
            -moz-appearance: textfield;
        }

        #timer {
            font-size: 1.2rem;
            margin-bottom: 1rem;
            color: #ff9800;
        }

        .border-radius {
            border-radius: 3px !important;
        }
    </style>
</head>

<body data-topbar="dark" data-layout="horizontal" data-layout-size="boxed" style="">
    <div id="divLoading" style="display: none">
        <p style="position: absolute; color: White; top: 30%; left: 38%;">
            Loading, please wait...
            <img src="{{ asset('public/backend/assets/images/loader.gif') }}">
        </p>
    </div>
    <!-- Begin page -->
    <div id="layout-wrapper">
        <div class="h-100 bg-plum-plate bg-animation"
            style="background-image: url(public/backend/assets/images/imp/loginback.svg) !important;
            background-size: cover;">
            <div class="d-flex h-100 justify-content-center align-items-center">
                <div class=""
                    style=" display: flex;
                justify-content: center;
                align-items: center;
                text-align: center;
                min-height: 100vh;">
                    <div class="app-logo-inverse mx-auto mb-3"></div>
                    <div class="modal-dialog w-100 mx-auto">
                        <div class="modal-content">
                            @if (session('success'))
                                <span class="text-success mt-2 px-3"><b> {{ session('success') }}</b></span>
                            @elseif(session('error'))
                                <span class="text-danger mt-2 px-3"><b> {{ session('error') }}</b></span>
                            @endif
                            <div class="modal-body " id="getOTP">
                                <div class="h5 modal-title text-center">
                                    <h4 class="mt-2">
                                        <div class="mb-4">2 Factor Authentication</div>
                                    </h4>
                                </div>
                                <div>
                                    <form id="sendOTPForm" class="" action="javascript:void(0)" method="post"
                                        autocomplete="off">
                                        @csrf
                                        <div>
                                            <div class="input-group mb-3 col-12 d-flex justify-content-center">
                                                <label for="form-label" class="h5 mx-2 col-12">Username</label>
                                                <input type="text" class="form-control col-12 mb-2"
                                                    style="width:100%" placeholder="Enter Username" name="User_Name"
                                                    id="User_Name" required>
                                                <button type="submit"
                                                    class="btn btn-outline-primary ml-3 col-5 border-radius">Get
                                                    OTP</button>
                                            </div>
                                        </div>
                                    </form>
                                    <span id="manualOTP">I have an OTP.</span>
                                </div>
                                <div>
                                    <form id="validateOTPForm" class="d-none" action="javascript:void(0)" method="post"
                                        autocomplete="off">
                                        @csrf
                                        <div>
                                            <div class="input-group mb-3 col-12 d-flex justify-content-center">
                                                <p class="mt-2 text-success h6" id="otpSentTxt"></p>
                                                <label for="" class="h5 mx-2 col-12">OTP</label>
                                                {{-- <input type="text" class="form-control col-8" placeholder="Enter OTP"
                                                    name="OTP" id="OTP" required> --}}
                                                {{-- <div id="timer">Time remaining: 3:00</div> --}}
                                                <div class="otp-input">
                                                    <input type="number" min="0" max="9" name="otp_1"
                                                        id="otp_1" required>
                                                    <input type="number" min="0" max="9" name="otp_2"
                                                        id="otp_2" required>
                                                    <input type="number" min="0" max="9"
                                                        name="otp_3" id="otp_3" required>
                                                    <input type="number" min="0" max="9"
                                                        name="otp_4" id="otp_4" required>
                                                    <input type="number" min="0" max="9"
                                                        name="otp_5" id="otp_5" required>
                                                    <input type="number" min="0" max="9"
                                                        name="otp_6" id="otp_6" required>
                                                </div>
                                                <button type="submit"
                                                    class="btn btn-outline-primary ml-3 col-5 border-radius">Validate</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="text-center text-white opacity-8 mt-3">Copyright © </div> -->
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
</body>
<script src="{{ url('/public/backend/assets/libs/jquery/jquery.min.js') }}"></script>
<script>
    var url = "{{ url('/') }}";
</script>
<script>
    $(document).ready(function() {
        $(document).on('click', '#manualOTP', function(e) {
            e.preventDefault();
            $('#validateOTPForm').removeClass('d-none');
        })
        var temp_uname = sessionStorage.getItem('username_uinfo');
        $('#User_Name').val(temp_uname);
        $(document).on('submit', '#sendOTPForm', function(e) {
            e.preventDefault();
            var User_Name = $("#User_Name").val();
            if (!User_Name) {
                Swal.fire("Error..!!!", 'Please enter username..!', "error");
                return true;
            }
            sessionStorage.setItem('username_uinfo', User_Name);
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });
            var token = $('meta[name="csrf-token"]').attr("content");
            $.ajax({
                url: url + '/sendOTPForm',
                method: "post",
                data: {
                    _token: token,
                    User_Name: User_Name,
                },
                beforeSend: function() {
                    $("#divLoading").show(); //show loader
                },
                success: function(data) {

                    if (data.Status == "success") {
                        Swal.fire("Success..!!!", 'OTP Sent Successfully..!', "success");
                        $('#validateOTPForm').removeClass('d-none')
                        $('#otpSentTxt').empty().text(data.Message);
                    } else {
                        Swal.fire("Error..!!!", data.Message, "error");
                    }
                },
                complete: function() {
                    $("#divLoading").hide(); //hide loader
                },
                error: function(err) {
                    console.log(err)
                },
            });
        })

        /**---------Browser Id------------**/
        function generateUniqueId() {
            return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, c => {
                const r = Math.random() * 16 | 0;
                return (c === 'x' ? r : (r & 0x3 | 0x8)).toString(16);
            });
        }

        function getUniqueBrowserId() {
            const localStorageKey = 'unique_browser_id';
            let browserId = localStorage.getItem(localStorageKey) || generateUniqueId();
            localStorage.setItem(localStorageKey, browserId);
            return browserId;
        }

        const uniqueBrowserId = getUniqueBrowserId();

        /**------------------------------**/

        $(document).on('submit', '#validateOTPForm', function(e) {
            e.preventDefault();
            var User_Name = $("#User_Name").val();
            // var OTP = $("#OTP").val();

            let allFilled = true;
            let otp = '';
            for (let i = 1; i <= 6; i++) {
                let inputVal = $(`#otp_${i}`).val();
                if (inputVal === '') {
                    allFilled = false;
                    break;
                }
                otp += inputVal;
            }

            if (!User_Name) {
                Swal.fire("Error..!!!", 'Please enter username..!', "error");
                return true;
            }
            if (!allFilled) {
                Swal.fire("Error..!!!", 'Please enter otp..!', "error");
                return true;
            }
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });
            var token = $('meta[name="csrf-token"]').attr("content");
            $.ajax({
                url: url + '/validateOPT',
                method: "post",
                data: {
                    _token: token,
                    User_Name: User_Name,
                    OTP: otp,
                    uniqueBrowserId: uniqueBrowserId
                },
                beforeSend: function() {
                    $("#divLoading").show(); //show loader
                },
                success: function(data) {
                    // console.log(data);
                    if (data.Status == "success") {
                        Swal.fire("Success..!!!", data.Message, "success");
                        setTimeout(() => {
                            window.location.href = url + '/';
                        }, 1000);
                    } else {
                        Swal.fire("Error..!!!", data.Message, "error");
                    }

                },
                complete: function() {
                    $("#divLoading").hide(); //hide loader
                },
                error: function(err) {
                    console.log(err)
                },
            });
        })

        /*****************************************************/
        const $inputs = $(".otp-input input");
        const $timerDisplay = $("#timer");
        $inputs.each(function(index) {
            $(this).on("input", function(e) {
                if (e.target.value.length > 1) {
                    e.target.value = e.target.value.slice(0, 1);
                }
                if (e.target.value.length === 1) {
                    if (index < $inputs.length - 1) {
                        $inputs.eq(index + 1).focus();
                    }
                }
            });
            $(this).on("keydown", function(e) {
                if (e.key === "Backspace" && !e.target.value) {
                    if (index > 0) {
                        $inputs.eq(index - 1).focus();
                    }
                }
                if (e.key === "e") {
                    e.preventDefault();
                }
            });
        });

    })
</script>

</html>
