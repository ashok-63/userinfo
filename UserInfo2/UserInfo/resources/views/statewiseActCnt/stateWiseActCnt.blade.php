@extends('master')
@section('title')
State Act Count
@stop
@section('content')

    <div class="card">
        <div class="card-title mx-1">
            <h3> State Wise Activation Counter</h3>

        </div>
        <div class=" col-6 my-1 d-flex" style="align-items: end;">
            <div class="col-4 mx-1 form-group">
                <label for="">Start Date</label>
                <input type="date" class="form-control form-control-sm" name="startDate" id="startDate"
                    value="{{ date('Y-m-d', strtotime(date('Y-m-d') . ' -1 days')) }}" placeholder=" eg. YYYY-MM-DD 2022-10-17">
            </div>
            <div class="col-4 mx-1 form-group">
                <label for="">End Date</label>
                <input type="date" class="form-control form-control-sm" name="endDate" id="endDate"
                    placeholder=" eg. YYYY-MM-DD 2022-10-16">
            </div>
            <div class="col-2 mx-1 ">
                <button class="btn btn-primary btn-md" id="showCount"> Show Counter</button>
            </div>
        </div>
        <div class="" id="statewisecounter"></div>
    </div>

    <script src="{{ url('/public/backend/assets/js/include/showActCnt.js') }}"></script>
@stop
