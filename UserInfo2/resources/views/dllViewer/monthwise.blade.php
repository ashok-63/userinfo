@extends('master')
@section('title')
    Monthwise Count Viewer
@stop
@section('content')
    <div class="card">
        <div class="card-title mx-1 mt-1 d-flex gap-5" style="align-items: center">
            <span class="mx-1">
                <h3>Month Wise Viewer</h3>
            </span>
            <span class="mx-1">
                <input type="month" class="form-control" name="selectedDate" id="selectedDate" value="{{ date('Y-m') }}">
            </span>

            <span class="mx-1">
                <a class="btn btn-success" role="button" href="{{ url('/ucdllViewer') }}" target="_blank"> View Day Wise
                    Records</a>
            </span>

        </div>
        <div class="" id="statewisecounter">
        </div>
    </div>
    <script src="{{ url('/public/backend/assets/js/include/dllViewerMonthwise.js') }}"></script>
@stop
