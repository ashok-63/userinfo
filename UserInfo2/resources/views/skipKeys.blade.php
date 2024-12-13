@extends('master')
@section('title')
    K2State Skip Keys
@stop
@section('content')
    <style>
        #inner {
            display: flex;
            margin: 0 auto;
            justify-content: space-between;
        }
        #outer {
            /* border: 1px solid red; */
            width: 100%;
            text-align: center;
        }
        .company_name {
            font-family: Verdana, Arial, Helvetica, sans-serif;
            font-size: 14px;
            color: #006393;
            font-weight: bold;
        }
        .panel_heading {
            color: #009900;
            font-weight: bold;
            text-align: left;
        }
        .panel_head_div {
            border-left: 1px solid green;
            height: 460px;
        }
        .small {
            font-size: 8px !important;
        }
        .instacode_span {
            font-weight: 400;
            font-size: 10px;
        }
        hr {
            margin: 0px;
        }
        .btn-success {
            border-color: #28a745;
            font-size: 15px !important;
            line-height: 1.5;
            border-radius: 5px;
        }
        .card {
            box-shadow: 0px 0px 10px -1px black;
        }
        .info1 {
            font-size: large
        }
        .required,
        .sendSMS {
            display: none
        }
    </style>
    <div class="container-fluid new_activation_div">
        <div class="row card">
            <div class="col-md-12  p-3">
                <div id="outer">
                    <div id="inner" class="col-12">
                        <div class="col-4">
                            <h4 class="text-danger_">K2 State Skip Keys</h4>
                        </div>
                        <div class="col-4">
                            <img src="{{ url('/public/backend/assets/images/imp/logo2.png') }}" alt=""
                                style="height: 100px ; margin-top: -5%;">
                        </div>
                    </div>
                    <hr>
                    <form action="javascript:void(0)" method="POST" id="skipKeysForm" class="mt-3">
                        <div class="form-group col-12 d-flex mb-3">
                            <label for="LicNo" class="col-4" style="font-size: larger">Key Number <span
                                    class="text-danger">*</span>:</label>
                            {{-- <input type="text" name="licNo" id="LicNo" class="form-control" required
                                autocomplete="off" /> --}}
                            <textarea name="licNo" id="LicNo" cols="3" rows="3" class="form-control" required autocomplete="off"
                                placeholder="Enter Keys comma seperated"></textarea>
                        </div>
                        <div class="form-group col-12 d-flex mb-3">
                            <label for="reason" class="col-4" style="font-size: larger">Reason<span
                                    class="text-danger">*</span>:</label>
                            {{-- <input type="text" name="reason" id="reason" class="form-control" required autocomplete="off" /> --}}
                            <textarea name="reason" id="reason" cols="3" rows="5" class="form-control" required autocomplete="off"></textarea>
                        </div>
                        <div>
                            <button class="btn btn-md btn-primary skipKeysBtn pull-right" type="submit">
                                Skip
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ url('/public/backend/assets/js/include/skipKeys.js') }}"></script>
@endsection('content')
