@extends('master')
@section('title')OTP Master @stop
<link href="{{ url('public/backend/assets/css/jquery.dataTables.min.css') }}" rel="stylesheet">
@section('content')
    <div class="card">
        <div class="card-title mx-1 mt-1 d-flex" style="align-items: center">
            <span class="mx-1">
                <h3> OTP Master</h3>
            </span>
        </div>
        <div>
            <div class="table-responsive">
                <table id="otpTable" class="table table-bordered">
                    <thead
                        style="font-size: 14px;letter-spacing: 0.9px;color: white;
                    background-color: #28a745a6!important;">
                        <tr>
                            <th>Sr</th>
                            <th>Username</th>
                            <th>Mobile</th>
                            <th>OTP</th>
                            <th>InDate</th>
                            <th>Status</th>
                            <th>StatusDate</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($otp)
                            @php
                                $count = 1;
                            @endphp
                            @foreach ($otp as $key => $row)
                                <tr>
                                    <td class="text-center"><b>{{ $count++ }}</b></td>
                                    <td class="">{{ $row->User }}</td>
                                    <td class="">{{ $row->Mobile }}</td>
                                    <td class="">{{ $row->Otp }}</td>
                                    <td class="">{{ $row->InDate }}</td>
                                    <td class="">
                                        @php
                                            $prevInDate = $row->InDate;
                                            $currentDate = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
                                            $diff_in_minutes = $currentDate->diffInMinutes($prevInDate);
                                            if ($row->Status == 1) {
                                                $msg = 'Used';
                                            }
                                            if ($row->Status == 0) {
                                                if ($diff_in_minutes > 10) {
                                                    $msg = 'OTP Expired';
                                                } else {
                                                    $msg = 'Not Used';
                                                }
                                            }
                                            if ($row->Status == 1) {
                                                $msg = 'Used';
                                            }
                                        @endphp
                                        {{ $msg }}
                                    </td>
                                    <td class="">{{ $row->StatusDate }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="{{ url('public/backend/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script>
        $("#otpTable").DataTable({
            pageLength: 100,
            saveState: true,
        });
    </script>
@stop
