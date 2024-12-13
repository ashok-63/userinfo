@extends('master')
@section('content')
    <div class="container-fluid mt-1 main_container">
        <div class="row">
            <div class="card">
                <div class="p-1 h4">Block Key Numbers...</div>
                <div class="card-body">
                    <form action="javascript:void(0)" method="POST" id="blockKeysForm">
                        @csrf
                        <div class="form-group col-12 d-flex mb-3">
                            <label for="" class="col-4" style="font-size: larger;">Enter Key Number on each new line
                                <span class="text-danger">*</span>
                                :</label>
                            <textarea name="licNo" id="licNo_blockkey" cols="5" rows="5" class="form-control" required></textarea>
                        </div>
                        <div class="form-group col-12 d-flex mb-3">
                            <label for="" class="col-4" style="font-size: larger;"> Block Reason <span
                                    class="text-danger">*</span> : </label>
                            <textarea name="reason" id="reason" cols="4" rows="2" class="form-control" required></textarea>
                        </div>
                        <div class="form-group col-12 d-flex mb-3">
                            <label for="" class="col-4" style="font-size: larger;">Password <span
                                    class="text-danger">*</span> :</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                        <div>
                            <button class="btn btn-md btn-primary blockKeysBtn pull-right" type="submit">Block</button>
                        </div>
                    </form>
                </div>
                <div class="p-1 h4 d-none info">Show Blocked Key Numbers...</div>
                <div id="blockKeyData">
                </div>
            </div>
        </div>
    </div>
    <script src="{{ url('public/backend/assets/js/include/blockKeys.js') }}"></script>
@endsection('content')
