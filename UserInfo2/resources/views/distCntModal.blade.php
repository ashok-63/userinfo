<div id="info_dist" style="font-weight: 600" class="p-1"></div>
<table class="table table-bordered" id="DistrictWiseCntTable">
    <thead>
        <tr>
            <th>Sr.No</th>
            <th>District</th>
            <th>Activation</th>
            <th>Reactivation</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @if ($getDistrictWiseActCnt)
            @php

                $totalAct = 0;
                $totalReact = 0;
                $totalCnt = 0;
                $count = 1;
            @endphp
            @foreach ($getDistrictWiseActCnt as $data)
                @php
                    $totalAct += $data->act;
                    $totalReact += $data->react;
                    $totalCnt += $data->cnt;
                @endphp
                <tr>
                    <td>{{ $count++ }}</td>
                    <td>{{ $data->custDistrict }}</td>
                    <td>{{ $data->act }}</td>
                    <td>{{ $data->react }}</td>
                    <td>{{ $data->cnt }}</td>
                </tr>
            @endforeach
            <tr class="">
                <th class="border-0"></th>
                <th> Total : </th>
                <th>{{ $totalAct }}</th>
                <th>{{ $totalReact }}</th>
                <th>{{ $totalCnt }}</th>
            </tr>
        @endif

    </tbody>
</table>
