@extends('master')
@section('title')
    All Users
@stop


{{-- <link href="{{ url('public/backend/assets/css/jquery.dataTables.min.css') }}" rel="stylesheet"> --}}
@section('content')
@include('changePassModal')
    <div class="card">
        <div class="card-title mx-1 mt-1 d-flex" style="align-items: center">
            <span class="mx-1">
                <h3> All Users</h3>
            </span>

            <span class="mx-1"> <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#AddUserModal"> <i class="fa fa-user-plus" aria-hidden="true"></i> Add User
                </button></span>
        </div>

        <div class="" id="statewisecounter">
        </div>

    </div>

    <script src="{{ url('/public/backend/assets/js/include/allUsers.js') }}"></script>
@stop
