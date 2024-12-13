@extends('master')
@section('title')
    User Permissions
@stop

<link rel="stylesheet" href="{{url('/backend/assets/css/jquery.dataTables.min.css')}}">
<style>
    body {
        width: fit-content;
        overflow: scroll
    }
</style>
@section('content')
    <div class="card">
        <div class="card-title mx-1 d-flex">
            <h3> User Permissions Viewer</h3>


            @php
                $chechAccess = DB::connection('mysql6')
                    ->table('userpermissionmaster')
                    ->select('UserPermission')
                    ->where('User_Name', auth()->user()->User_Name)
                    ->first();
            @endphp
            @if ($chechAccess->UserPermission == '1')
                <button class="btn btn-sm btn-primary mx-5 syncUsersBtn"
                    title="Click on this button if new created users are not showing in this list."> Sync Users </button>
            @endif


        </div>
        @if ($chechAccess->UserPermission == '1')
            <div class="table-responsive" id="statewisecounter">
            </div>
        @else
            <div class="" id="">
                <h2 class="text-danger text-center">You don't have permissions to access this page..! </h2>
            </div>
        @endif
    </div>
    <script src="{{ url('/public/backend/assets/js/include/userPermissions.js') }}"></script>
@stop
