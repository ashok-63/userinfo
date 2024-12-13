@extends('master')
@section('title')
User Activity
@stop


<link href="{{ url('public/backend/assets/css/jquery.dataTables.min.css') }}" rel="stylesheet">
@section('content')

    <div class="card">
        <div class="card-title mx-1">
            <h3>User Activity</h3>
             {{-- <p><a href="{{url('/dashboard')}}">Go To Dashboard</a></p> --}}

        </div>

        <div class="" id="statewisecounter">

        </div>

    </div>

    <script src="{{ url('/public/backend/assets/js/include/loginHistory.js') }}"></script>
@stop
