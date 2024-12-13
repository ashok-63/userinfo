@extends('master')
@section('title')
    Computer Name Count
@stop

<link href="{{ url('public/backend/assets/css/jquery.dataTables.min.css') }}" rel="stylesheet">

@section('content')

    <div class="card">
        <div class="card-title mx-1 mt-1 d-flex" style="align-items: center">
            <span class="mx-1">
                <h3>Computer Name Count</h3>
            </span>
        </div>

        <div class="" id="dataviewer"></div>

    </div>

    <script src="{{ url('/public/backend/assets/js/include/compNameCnt.js') }}"></script>
@stop
