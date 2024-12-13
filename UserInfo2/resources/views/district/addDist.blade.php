@extends('master')
@section('title')
    Add District
@stop
<link rel="stylesheet" href="{{url('/backend/assets/css/jquery.dataTables.min.css')}}">
<style>
    body {
        width: auto;
        overflow: scroll
    }
</style>
@section('content')
    <div class="card">
        <div class="card-title mx-1 d-flex">
            <h3> Districts</h3>
        </div>


        <div class="card-body ">

            <form action="javascript:void(0)" method="post" id="districtForm">
                @csrf
                <div class="row col-12">
                    <div class="form-group col-2">
                        <label for="state" class="form-label">Select State </label>
                        <select name="state" id="state" class="from-control form-control-sm select2">
                            <option value="">Select State</option>
                            @if ($states)
                                @foreach ($states as $row => $value)
                                    <option value="{{ $value->stID }}">{{ $value->StateName }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group col-2">
                        <label for="district" class="form-label">District Name </label>
                        <input type="text" name="district" id="district" class="from-control form-control-sm">
                    </div>
                    <div class="form-group col-2">
                        <button class="btn btn-sm btn-primary" type="submit"> Add District</button>
                    </div>
                </div>
            </form>

        </div>



        <hr>

        <div class="table-responsive" id="distviewer">
        </div>

    </div>
    <script src="{{ url('/public/backend/assets/js/include/district.js') }}"></script>
@stop
