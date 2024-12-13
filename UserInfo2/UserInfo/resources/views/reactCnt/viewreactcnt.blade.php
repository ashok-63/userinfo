@extends('master')
@section('title')
    View Alternet Server Reactivation
@stop

<link href="{{ url('public/backend/assets/css/jquery.dataTables.min.css') }}" rel="stylesheet">

@section('content')

    <div class="card">
        <div class="card-title mx-1 mt-1 d-flex" style="align-items: center">
            <span class="mx-1">
                <h3>View Reactivation User Wise</h3>
            </span>
        </div>

        <div class="form-group col-12 text-center" style="display: flex ; justify-content: center;">
            <div class=" col-2">
                <input type="text" class="datepickr form-control" name="date" id="date">
            </div>
        </div>
        <hr>
        <div class="" id="dataviewer"></div>

    </div>

    <script src="{{ url('/public/backend/assets/js/include/viewreactcnt.js') }}"></script>
@stop
