@extends('master')
<style>
    .table-bordered th,
    td {
        padding: 3px !important;
        text-align: center;
    }
</style>
@section('content')
    <div class="p-3 mt-1">
        <div class="row">
            <div class="card">
                <div class="p-1 h4">Monthwise Activation Graph</div>
                <div class="card-body">
                    {{-- <form action="javascript:void(0)" method="POST" id="actGraphForm">
                        @csrf --}}
                    <div class="d-flex" style="align-items: end;">

                        <div class="form-group col-3  mx-1">
                            <label for="" class="" style="font-size: larger;"> State </label>
                            <select name="state" id="state" class="form-select select2">
                                <option value="">Select State</option>
                                @if ($allStates)
                                    @foreach ($allStates as $row)
                                        <option value="{{ $row->stID }}">{{ $row->StateName }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-3  mx-1">
                            <label for="" class="" style="font-size: larger;"> District </label>
                            <select name="dist" id="dist" class="form-select select2">
                                <option value="">Select District</option>
                                @if ($allDists)
                                    @foreach ($allDists as $row)
                                        <option value="{{ $row->dID }}">{{ $row->DISTRICT }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-3  mx-1">
                            <label for="" class="" style="font-size: larger;"> Month</label>
                            <select name="totalMonths" id="totalMonths" class="form-select select2">
                                <option value="">Select Month</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3" selected>3</option>
                                <option value="6">6</option>
                                <option value="12">12</option>
                                <option value="18">18</option>
                                <option value="24">24</option>
                                <option value="30">30</option>
                                <option value="36">36</option>
                            </select>
                        </div>
                        <div class="form-group col-3  mx-1">
                            <button class="btn btn-md btn-primary showBtn " type="submit">Show</button>
                        </div>

                    </div>

                    {{-- </form> --}}
                </div>
                <div class="col-12 d-flex">
                    <div id="responseData" class="d-none col-2">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Month</th>
                                    <th>Count</th>
                                </tr>
                            </thead>
                            <tbody id="tbody">

                            </tbody>
                        </table>
                    </div>

                    <div id="graph" class="col-9 mx-3">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ url('public/backend/assets/js/chart.js') }}"></script>
    <script src="{{ url('public/backend/assets/js/include/actGraph.js') }}"></script>
@endsection('content')
