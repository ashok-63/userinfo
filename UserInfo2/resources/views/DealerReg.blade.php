@extends('master')
@section('title')
    Dealer Registration
@stop
@section('content')
    <style>
        .form-style {
            border-radius: 17px;
            box-shadow: 0px 0px 10px -1px black;
        }
    </style>
    <div class="card">
        <div class="card-title mx-1">
            <h3> Dealer Registration</h3>
        </div>
        <div class="container col-6 card-body my-1 d-flex justify-content-center">
            <form action="javascript:void(0)" method="post" class="col-8 px-3 py-3 form-style" id="dealerRegForm">
                <h4 class="card-title-">Dealer Information</h4>
                <hr>
                <span id="checking" class="d-none text-danger fw-bold"> Checking..! Please Wait..!</span>
                <span id="msg" class="text-danger  fw-bold"></span>
                @csrf
                <div class="row my-2 col-12">
                    <div class="col-4 form-group">
                        <label for="">Mobile No <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-1 form-group">
                        :
                    </div>
                    <div class="col-6 form-group">
                        <input type="text" class="form-control form-control-sm" name="mobileNo" id="mobileNo"
                            value="" placeholder="e.g. 9272707050,9272744988" required>
                    </div>
                </div>
                <div class="row my-2 col-12">
                    <div class="col-4 form-group">
                        <label for="">EmailID <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-1 form-group">
                        :
                    </div>
                    <div class="col-6 form-group">
                        <input type="email" class="form-control form-control-sm" name="emailId" id="emailId"
                            value="" placeholder="abc@gmail.com" required>
                    </div>
                </div>
                <div class="row my-2 col-12">
                    <div class="col-4 form-group">
                        <label for="">Dealer Company <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-1 form-group">
                        :
                    </div>
                    <div class="col-6 form-group">
                        <input type="text" class="form-control form-control-sm" name="dealerCompany" id="dealerCompany"
                            value="" placeholder="Dealer Company" required>
                    </div>
                </div>
                <div class="row my-2 col-12">
                    <div class="col-4 form-group">
                        <label for="">Contact Person <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-1 form-group">
                        :
                    </div>
                    <div class="col-6 form-group">
                        <input type="text" class="form-control form-control-sm" name="contactPerson" id="contactPerson"
                            value="" placeholder="Contact Person" required>
                    </div>
                </div>
                <div class="row my-2 col-12">
                    <div class="col-4 form-group">
                        <label for="">Address <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-1 form-group">
                        :
                    </div>
                    <div class="col-6 form-group">
                        <textarea name="address" id="address" cols="5" rows="5" maxlength="50" class="form-control form-control-sm" required></textarea>
                    </div>
                </div>
                <div class="row my-2 col-12">
                    <div class="col-4 form-group">
                        <label for="">Land Line No.</label>
                    </div>
                    <div class="col-1 form-group">
                        :
                    </div>
                    <div class="col-6 form-group">
                        <input type="text" class="form-control form-control-sm" name="landLineNo" id="landLineNo"
                            value="" placeholder="STD Code    -    Land Line Number.">
                    </div>
                </div>
                <div class="row my-2 col-12">
                    <div class="col-4 form-group">
                        <label for="">Dealer Rating </label>
                    </div>
                    <div class="col-1 form-group">
                        :
                    </div>
                    <div class="col-6 form-group">
                        <select name="dealerRating" id="dealerRating" class="form-control form-control-sm">
                            <option value="GOLD">GOLD</option>
                            <option value="SILVER">SILVER</option>
                            <option value="BRONZE" selected="selected">BRONZE</option>
                            <option value="BLACK">BLACK</option>
                        </select>
                    </div>
                </div>
                <div class="row my-2 col-12">
                    <div class="col-4 form-group">
                        <label for="">State <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-1 form-group">:</div>
                    <div class="col-6 form-group">
                        <select name="state" id="state" class="form-control form-control-sm select2" required>
                            <option value="">Select State</option>
                            @if ($states)
                                @foreach ($states as $row)
                                    <option value="{{ $row->stID . "$$" . $row->StateName }}">{{ $row->StateName }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="row my-2 col-12">
                    <div class="col-4 form-group">
                        <label for="">District <span class="text-danger">*</span></label>
                    </div>
                    <div class="col-1 form-group">:</div>
                    <div class="col-6 form-group">
                        <select name="district" id="district" class="form-control form-control-sm select2" required>
                            <option value="">Select Destrict</option>
                        </select>
                    </div>
                </div>
                <div class="row my-2 col-12">
                    <div class="col-4 form-group">
                        <label for="">City Name <span class="text-danger"> * </span></label>
                    </div>
                    <div class="col-1 form-group">
                        :
                    </div>
                    <div class="col-6 form-group">
                        <input type="text" class="form-control form-control-sm" name="city" id="city"
                            value="" placeholder="City Name">
                    </div>
                </div>
                <div class="row my-4 col-12" style="justify-content: center;">
                    <div class="col-4 form-group">
                        <button class="btn btn-md btn-outline-primary col-12" type="submit">Register</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="{{ url('/public/backend/assets/js/include/DealerReg.js') }}"></script>
@stop
