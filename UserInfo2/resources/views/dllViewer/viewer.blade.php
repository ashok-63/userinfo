@extends('master')
@section('title')
    DLL Viewer
@stop

@section('content')

    <div class="card">
        <div class="card-title mx-1 mt-1 d-flex gap-5" style="align-items: center">
            <span class="mx-1">
                <h3>Day wise Viewer</h3>
            </span>

            <span class="mx-1">
                <input type="date" class="form-control" name="selectedDate" id="selectedDate" value="{{ date('Y-m-d') }}">
            </span>

            <span class="mx-1">
                <a class="btn btn-primary" role="button" href="{{ url('/monthWiseCnt') }}" target="_blank"> View Month Wise
                    Count </a>
            </span>

        </div>

        <div class="" id="statewisecounter">
        </div>

    </div>

    <script src="{{ url('/public/backend/assets/js/include/dllViewer.js') }}"></script>
@stop

