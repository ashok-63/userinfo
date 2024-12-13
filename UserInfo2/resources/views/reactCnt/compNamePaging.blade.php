@extends('master')
@section('title')
    View Alternet Server Reactivation
@stop

@section('content')

    <div class="card">
        <div class="card-title mx-1 mt-1 d-flex" style="align-items: center">
            <span class="mx-1">
                <h3>React UserWiseKey <h6 class="text-danger">
                        @if ($date)
                            {{ $date }}_{{ $operator }}_{{ $count }}
                        @endif
                    </h6>

                </h3>
            </span>
        </div>
        <hr>

        <style>
            table td,
            table th {
                padding: 0.4rem 0.4rem !important;
            }

            a:visited {
                color: #ce16ed;
            }
        </style>

        <div class="table-responsive">
            <table id="reactivationtable" class="table table-bordered table-striped text-nowrap text-center">
                <thead
                    style="font-size: 14px;letter-spacing: 0.9px;color: white;
        background-color: #28a745a6!important;">
                    <tr>
                        <th>Sr</th>
                        <th>KeyNo</th>
                        <th>OperatorName</th>
                        <th>IsOnlineDone</th>
                        <th>ReactReason</th>
                        <th>Indate</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($data)
                        @php
                            $count = 1;

                        @endphp
                        @foreach ($data as $key => $row)
                            <tr>
                                <td class=""><b>{{ $count++ }}</b></td>
                                <td class="">

                                    <a href="{{ url('dashboard/' . $row->keyNo) }}" target="blank" rel="noopener noreferrer"
                                        title="{{ $row->keyNo }}">
                                        {{ $row->keysn }} </a> | <i data-keyno="{{ $row->keyNo }}"
                                        class="fa fa-clipboard copy"></i>

                                </td>
                                <td class="">{{ $row->operatorName }}</td>
                                <td class="">{{ $row->isOnlineDone }}</td>
                                <td class="" style="text-align: left">{{ $row->reactReason }}</td>
                                <td class="">{{ $row->InDate }}</td>
                            </tr>
                        @endforeach

                    @endif
                </tbody>
            </table>
        </div>


    </div>


@stop


