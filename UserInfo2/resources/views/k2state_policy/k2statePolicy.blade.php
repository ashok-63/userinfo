@extends('master')
@section('title')
    Policies
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
    </style>

    <div class="container-fluid ">
        <div class="row card">
            <div class="col-md-12  p-3">
                <div id="outer">
                    <div id="inner" class="col-12">
                        <div class="col-12">
                            <h4 class="text-danger_">Policies</h4>
                        </div>

                    </div>



                </div>

                <hr>

                <div class="col-12">
                    <ul class="nav nav-tabs" id="policyTab" role="tablist">
                        <li class="nav-item policyTabLi" role="presentation">
                            <button class="nav-link active" id="policy_on_off" data-bs-toggle="tab"
                                data-bs-target="#policy_on_off_tab" type="button" role="tab" aria-controls=""
                                aria-selected="true">Policy On/Off</button>
                        </li>
                        {{-- <li class="nav-item policyTabLi" role="presentation">
                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                            type="button" role="tab" aria-controls="profile" aria-selected="false">Profile</button>
                    </li> --}}

                    </ul>
                    <div class="tab-content" id="policyTabContent">
                        <div class="tab-pane fade show active" id="policy_on_off_tab" role="tabpanel"
                            aria-labelledby="policy_on_off_tab">
                            <form action="javascript:void(0)" id="updatePolicyForm" method="POST">
                                @csrf
                                <div class="row col-12 my-2">
                                    <div class="col-4 row">
                                        <div class='col-md-6'>
                                            <div class="form-group">
                                                <input type="text" name="MH_PolName" id="MH_PolName"
                                                    class="form-control polName" readonly value="MHPOL010524">
                                            </div>
                                        </div>

                                        <div class='col-md-6'>
                                            <div class="form-group">
                                                <select class="form-control form-control-sm polAction" name="MH_Action"
                                                    id="MH_Action">

                                                    <option value="BLK" {{ $MahPol == 'BLK' ? 'selected' : '' }}>Block
                                                    </option>
                                                    <option value="AUD" {{ $MahPol == 'AUD' ? 'selected' : '' }}>Audit
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                    |
                                    <div class="col-4 row">
                                        <div class='col-md-6'>
                                            <div class="form-group">
                                                <input type="text" name="GJ_PolName" id="GJ_PolName" class="form-control"
                                                    readonly value="GUJPOL030524">
                                            </div>
                                        </div>

                                        <div class='col-md-6'>
                                            <div class="form-group">
                                                <select class="form-control form-control-sm polAction" name="GJ_Action"
                                                    id="GJ_Action">

                                                    <option value="BLK" {{ $GjPol == 'BLK' ? 'selected' : '' }}>Block
                                                    </option>
                                                    <option value="AUD" {{ $GjPol == 'AUD' ? 'selected' : '' }}>Audit
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    |
                                    <div class="col-4 row">
                                        <div class='col-md-6'>
                                            <div class="form-group">
                                                <input type="text" name="RJ_PolName" id="RJ_PolName" class="form-control"
                                                    readonly value="RAJPOL210624">
                                            </div>
                                        </div>

                                        <div class='col-md-6'>
                                            <div class="form-group">
                                                <select class="form-control form-control-sm polAction" name="RJ_Action"
                                                    id="RJ_Action">

                                                    <option value="BLK" {{ $RjPol == 'BLK' ? 'selected' : '' }}>Block
                                                    </option>
                                                    <option value="AUD" {{ $RjPol == 'AUD' ? 'selected' : '' }}>Audit
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    |
                                    <div class="col-4 mt-2 row">
                                        <div class='col-md-6'>
                                            <div class="form-group">
                                                <input type="text" name="MP_PolName" id="MP_PolName" class="form-control"
                                                    readonly value="MPPOL280624">
                                            </div>
                                        </div>

                                        <div class='col-md-6'>
                                            <div class="form-group">
                                                <select class="form-control form-control-sm polAction" name="MP_Action"
                                                    id="MP_Action">

                                                    <option value="BLK" {{ $MpPol == 'BLK' ? 'selected' : '' }}>Block
                                                    </option>
                                                    <option value="AUD" {{ $MpPol == 'AUD' ? 'selected' : '' }}>Audit
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    |
                                    <div class="col-4 mt-2 row">
                                        <div class='col-md-6'>
                                            <div class="form-group">
                                                <input type="text" name="Dhule_PolName" id="Dhule_PolName" class="form-control"
                                                    readonly value="DHULENANJAL2907">
                                            </div>
                                        </div>
                                        <div class='col-md-6'>
                                            <div class="form-group">
                                                <select class="form-control form-control-sm polAction" name="Dhule_Action"
                                                    id="Dhule_Action">
                                                    <option value="BLK" {{ $DhulePol == 'BLK' ? 'selected' : '' }}>Block
                                                    </option>
                                                    <option value="AUD" {{ $DhulePol == 'AUD' ? 'selected' : '' }}>Audit
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        {{-- <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">...</div> --}}

                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="{{ url('/public/backend/assets/js/include/policy.js') }}"></script>
@endsection('content')
