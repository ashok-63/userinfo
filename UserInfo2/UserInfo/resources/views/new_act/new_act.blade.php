@extends('master')
@section('title')
    New Act
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

    @include('new_act.DealerInfoModal')
    @include('new_act.findDlrModal')
    @include('new_act.uc_modal')
    <div class="container-fluid new_activation_div">
        <div class="row card">
            <div class="col-md-12  p-3">
                <div id="outer">
                    <div id="inner" class="col-12">
                        <div class="col-4">
                            <img src="{{ url('/public/backend/assets/images/imp/logo2.png') }}" alt=""
                                style="height: 100px ; margin-top: -5%;">
                        </div>
                        <div class="col-4">
                            <div class="company_name">Biz Secure Labs Pvt. Ltd.</div>
                            <div class="text-success" style="font-weight: bold">NET PROTECTOR {{ date('Y') }} INTERNET
                                SECURITY</div>
                            <h4 class="text-danger">REGISTRATION FOR ACTIVATION</h4>
                        </div>
                        <div class="col-4">
                            <div class="">
                                <button class="btn btn-outline-success btn-md mt-3" id="autoLoading_btn"
                                    value="Auto-Loading is ON"> <span id="btn_txt"> Auto-Loading is
                                        ON</span> </button>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <form method="POST" action="javascript:void(0)" id="registrationForm">
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <h5 class="panel_heading">NPAV Key Details</h5>
                                <div class="row mb-1">
                                    <div class='col-md-3 modal_cust_label text-start'>Key No <span
                                            class="small">[Alt+1]</span></div>
                                    <div class="col-md-1">:</div>
                                    <div class='col-md-5'>
                                        <input type="text" class="form-control form-control-sm" name="txtLicense"
                                            id="txtLicense">
                                    </div>
                                    <div class='col-md-1'>
                                        <button type="button" class="btn btn-outline-primary btn-sm btn-icon"
                                            id="viewKeyDetails" title="View Details">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <div class="col-md-3 text-start">InstCode</div>
                                    <div class="col-md-1">: </div>
                                    <div class="row col-md-6 hr_code_input_">
                                        <input type="text" class="col-md-5 form-control form-control-sm"
                                            name="txtPlainHR" id="txtPlainHR" placeholder="Plain HR- Code or NN- Code">
                                    </div>
                                </div>
                                <div class="row justify-content-center mb-1">
                                    <div class="col-sm-2">
                                        HR-
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control form-control-sm" name="txtIC1"
                                            id="txtIC1" style="text-transform: uppercase;" onkeydown="fnFwBK(this);"
                                            onkeyup="GetLast4sOfHRInstCode();">
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control form-control-sm" name="txtIC2"
                                            id="txtIC2" style="text-transform: uppercase;" onkeydown="fnFwBK(this);"
                                            onkeyup="GetLast4sOfHRInstCode();">
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control form-control-sm" name="txtIC3"
                                            id="txtIC3" style="text-transform: uppercase;" onkeydown="fnFwBK(this);"
                                            onkeyup="GetLast4sOfHRInstCode();">
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control form-control-sm" name="txtIC4"
                                            id="txtIC4" style="text-transform: uppercase;" onkeydown="fnFwBK(this);"
                                            onkeyup="GetLast4sOfHRInstCode();">
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control form-control-sm" name="txtIC5"
                                            id="txtIC5" style="text-transform: uppercase;" >
                                    </div>
                                </div>
                                <div class="row justify-content-center mb-2">
                                    <div class="col-sm-2">
                                        NN-
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control form-control-sm" name="txtICNN1"
                                            id="txtICNN1" style="text-transform: uppercase;" onkeydown="fnFwBKNN(this);"
                                            onkeyup="GetLast4sOfNNInstCode();">
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control form-control-sm" name="txtICNN2"
                                            id="txtICNN2" style="text-transform: uppercase;" onkeydown="fnFwBKNN(this);"
                                            onkeyup="GetLast4sOfNNInstCode();">
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control form-control-sm" name="txtICNN3"
                                            id="txtICNN3" style="text-transform: uppercase;" onkeydown="fnFwBKNN(this);"
                                            onkeyup="GetLast4sOfNNInstCode();">
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control form-control-sm" name="txtICNN4"
                                            id="txtICNN4" style="text-transform: uppercase;" onkeydown="fnFwBKNN(this);"
                                            onkeyup="GetLast4sOfNNInstCode();">
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control form-control-sm" name="txtICNN5"
                                            id="txtICNN5" style="text-transform: uppercase;" >
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <div class='col-md-3 modal_cust_label text-start'>Type</div>
                                    <div class="col-md-1">:</div>
                                    <div class='col-md-5'>
                                        <div class="form-group">
                                            <select class="form-control form-control-sm" name="cmbNPFor" id="cmbNPFor">
                                                <option value="Desktop">Desktop</option>
                                                <option value="Laptop">Laptop</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <div class='col-md-3 modal_cust_label text-start'>Old KeyNo </div>
                                    <div class="col-md-1">: </div>
                                    <div class='col-md-6' style="display: flex ; align-items: center;">
                                        <div class="col-10"> <input type="text" class="form-control form-control-sm"
                                                name="txtOldLicense" id="txtOldLicense"
                                                placeholder="Enter Old Key In Case Of Renewal"> </div>
                                        <div class="col-2">
                                            <span class="fa fa-solid fa-spinner fa-spin text-danger" id="oldKeySpinner"
                                                style="font-size: 20px;display:none"></span>
                                        </div>
                                    </div>

                                    <div class='col-md-2'>
                                        <span class="text-warning" id="expDate" style="font-weight: bold"></span>
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <div class='col-md-3 modal_cust_label text-start'>CorporateID</div>
                                    <div class="col-md-1">:</div>
                                    <div class='col-md-5'>
                                        <input type="text" class="form-control form-control-sm" name="txtCorpId"
                                            id="txtCorpId">
                                    </div>
                                    <div class='col-md-3 text-start'>
                                        <a href="http://activation.indiaantivirus.com/corpId/GetCorpId.asp"
                                            target="_blank">Get New CorpId</a>
                                        <br>
                                        <span>[If more than 5 acts]</span>
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <h5 class="panel_heading">Customer Details</h5>
                                    <div class='col-md-3 panel_heading' style="font-size: 12px;"></div>
                                    <div class="col-md-1"></div>
                                    <div class='col-md-3'>
                                        <label class="form-check-label">
                                            <input class="form-check-input radio-inline keyUsedAt" type="radio" name="rdoSt"
                                                id="rdoSt1" value="Home"> Home Use
                                        </label>
                                        <label class="form-check-label">
                                            <input class="form-check-input radio-inline keyUsedAt" type="radio" name="rdoSt"
                                                id="rdoSt2" value="Office" checked> Office
                                        </label>
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <div class='col-md-3 modal_cust_label text-start'>Office Name</div>
                                    <div class="col-md-1">:</div>
                                    <div class='col-md-5'>
                                        <input type="text" class="form-control form-control-sm" name="txtCompany"
                                            id="txtCompany">
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <div class='col-md-3 modal_cust_label text-start'>Cust Name</div>
                                    <div class="col-md-1">:</div>
                                    <div class='col-md-5'>
                                        <input type="text" class="form-control form-control-sm" name="txtPerson"
                                            id="txtPerson">
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <div class='col-md-3 modal_cust_label text-start'>Cust Mob. <span
                                            class="text-danger">*</span> </div>
                                    <div class="col-md-1">:</div>
                                    <div class='col-md-5'>
                                        <input type="text" class="form-control form-control-sm" name="txtCustMob"
                                            id="txtCustMob" required>
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <div class='col-md-3 modal_cust_label text-start'>Cust Email. <span
                                            class="text-danger">*</span></div>
                                    <div class="col-md-1">:</div>
                                    <div class='col-md-5'>
                                        <input type="text" class="form-control form-control-sm" name="txtemail"
                                            id="txtemail" required>
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <div class='col-md-3 modal_cust_label text-start'>Phone No.</div>
                                    <div class="col-md-1">:</div>
                                    <div class='col-md-5'>
                                        <input type="text" class="form-control form-control-sm" name="txtphno"
                                            id="txtphno">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 panel_head_div">
                                <h5 class="panel_heading">Dealer Details</h5>
                                <div class="row mb-1">
                                    <div class='col-md-3 modal_cust_label text-start'>DlrCode</div>
                                    <div class="col-md-1">:</div>
                                    <div class='col-md-4'>
                                        <input type="text" class="form-control form-control-sm" name="txtdlrcode"
                                            id="txtdlrcode" size="8" maxlength="8">
                                    </div>
                                    <div class='col-md-4'>
                                        <button type="button" class="btn btn-outline-primary btn-sm" title="Find"
                                            data-bs-toggle="modal" data-bs-target="#findDlrModal">
                                            <span class="fa fa-search"> Find</span>
                                        </button>
                                        <button type="button" class="btn btn-outline-primary btn-sm"
                                            data-bs-toggle="modal" title="View Details"
                                            data-bs-target="#DealerInfoModal">
                                            <span class="fa fa-list"> View Details</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <div class='col-md-3 modal_cust_label text-start'>Dlr Name</div>
                                    <div class="col-md-1">:</div>
                                    <div class='col-md-4'>
                                        <input type="text" class="form-control form-control-sm" name="txtDealer"
                                            id="txtDealer" list="dealers" autocomplete="off" oninput='onInput()'>
                                        <datalist id="dealers">
                                        </datalist>
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <div class='col-md-3 modal_cust_label text-start'>DlrMobile</div>
                                    <div class="col-md-1">:</div>
                                    <div class='col-md-4'>
                                        <input type="text" class="form-control form-control-sm" name="txtdlrmob"
                                            id="txtdlrmob" value="">
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <div class='col-md-3 modal_cust_label text-start'>InstEngg. Name</div>
                                    <div class="col-md-1">:</div>
                                    <div class='col-md-4'>
                                        <input type="text" class="form-control form-control-sm" name="txtInstEngg"
                                            id="txtInstEngg">
                                        <span class="fa fa-solid fa-spinner fa-spin text-danger" id="txtInstEnggSpinner"
                                            style="font-size: 20px;display:none"></span>
                                    </div>
                                    <div class='col-md-4'>
                                        <div id="enggNameddl"></div>
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <div class='col-md-3 modal_cust_label text-start'>InstEngg Mobile</div>
                                    <div class="col-md-1">:</div>
                                    <div class='col-md-4'>
                                        <input type="text" class="form-control form-control-sm" name="txtInstEnggM"
                                            id="txtInstEnggM">
                                    </div>
                                </div>
                                <br>
                                <div class="row mb-1">
                                    <h5 class='panel_heading'>Location Details</h5>
                                </div>
                                <div class="row mb-1">
                                    <div class='col-md-3 modal_cust_label text-start'>City</div>
                                    <div class="col-md-1">:</div>
                                    <div class='col-md-5'>

                                        <input type="text" class="form-control form-control-sm" name="city"
                                            id="city" list="cities" autocomplete="off">
                                        <datalist id="cities">
                                        </datalist>
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <div class='col-md-3 modal_cust_label text-start'>Country</div>
                                    <div class="col-md-1">:</div>
                                    <div class='col-md-5'>
                                        <input type="text" class="form-control form-control-sm" name="txtNCountry"
                                            id="txtNCountry" value="INDIA">
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <div class='col-md-3 modal_cust_label text-start'>State</div>
                                    <div class="col-md-1">:</div>
                                    <div class='col-md-5'>
                                        <select name="state" id="state" class="form-control form-control-sm">
                                            <option value="">Select State</option>
                                            @if ($states)
                                                @foreach ($states as $row)
                                                    <option value="{{ $row->stID . '$$' . $row->StateName }}">{{ $row->StateName }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-1">
                                    <div class='col-md-3 modal_cust_label text-start'>District</div>
                                    <div class="col-md-1">:</div>
                                    <div class='col-md-5'>
                                        <select name="district" id="district" class="form-control form-control-sm">
                                            <option value="">Select District</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="my-1">
                            <button type="submit" class="btn btn-success btn-lg">
                                <span class="fa fa-search"></span>
                                <span class="fa fa-solid fa-spinner fa-spin d-none" style="font-size: 15px;">
                                </span>
                                Get Unlock Code
                            </button>
                        </div>

                        {{-- <button data-bs-target="#unlockCodeModal" data-bs-toggle="modal"> Open Modal</button> --}}
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ url('/public/backend/assets/js/include/newAct.js') }}"></script>
@endsection('content')
