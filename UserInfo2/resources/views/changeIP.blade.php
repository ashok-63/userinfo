@extends('master')
@section('title')
    Change IP
@stop
@section('content')
    <div class="card">
        <div class="card-title mx-1">
            <h3> Write New Userinfo IP List</h3>
        </div>
        <div class="m-2" id="statewisecounter">
            @php
                $contantIP = '';
                $changedIP = '';
                if ($allIps) {
                    for ($i = 0; $i < sizeOf($allIps); $i++) {
                        if ($i <= 6) {
                            // if ($contantIP = '') {
                            //     $contantIP = $allIps[$i] . '\r\n';
                            // } else {
                            $contantIP .= $allIps[$i]->ip_address . ',';
                            // }
                        } else {
                            $changedIP .= $allIps[$i]->ip_address . ',';
                        }
                    }
                    // print_r($contantIP);
                }
            @endphp
            <div class="info">
                @if (Session::has('success'))
                    <h6 class="mx-3 my-1" style="color: #e11010;"> {{ Session::get('success') }}
                    </h6>
                @elseif(Session::has('error'))
                    <h6 class="mx-4 my-1 " style="color: #e11010;text-align:center">
                        {{ Session::get('error') }}</h6>
                @endif
            </div>
            <form action="{{ url('addNewIp') }}" method="POST" autocomplete="off">
                @csrf
                <div class="d-flex" style="justify-content: center">
                    <div class="col-4 mx-1 form-group">
                        <label for="constantIPs" class="h6">Constant IPs</label>
                        <textarea name="constantIPs" id="constantIPs" cols="30" rows="10" class="form-control">
@if ($contantIP)
@php
    $explode_f = explode(',', $contantIP);
@endphp
@foreach ($explode_f as $key => $value)
{{ $value }}
@endforeach
@endif
</textarea>
                    </div>
                    <div class="col-4 mx-1 form-group">
                        <label for="changeIPs" class="h6">Change Ip</label>
                        <textarea name="changeIPs" id="changeIPs" cols="30" rows="10" class="form-control">
@if ($changedIP)
@php
    $explode_c = explode(',', $changedIP);
@endphp
@foreach ($explode_c as $key => $value)
{{ $value }}
@endforeach
@endif
</textarea>
                    </div>
                </div>
                <div class="col-10 d-flex m-2 " style="justify-content: end">
                    <button class="btn btn-primary btn-md" id="" type="submit">Add New IP</button>
                </div>
            </form>
        </div>
    </div>
    {{-- <script src="{{ url('/public/backend/assets/js/include/showActCnt.js') }}"></script> --}}
@stop
