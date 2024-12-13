<style>
    td,
    th {
        padding: 7px 5px 4px 15px !important;
    }
</style>
<div class="card col-6">
    <h5 class="p-2" id="info">
    </h5>
    <table id="statewisecnt" class="table table-bordered table-hover table-responsive" width="100%">
        <thead>
            <tr>
                <th>Sr.No</th>
                <th>State</th>
                <th>Activation</th>
                <th>Reactivation</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @if ($getStateWiseActCnt)
                @php

                    $totalAct = 0;
                    $totalReact = 0;
                    $totalCnt = 0;
                    $count = 1;
                @endphp
                @foreach ($getStateWiseActCnt as $row)
                    @php
                        $totalAct += $row->act;
                        $totalReact += $row->react;
                        $totalCnt += $row->cnt;
                    @endphp

                    <tr>
                        <td>{{ $count++ }}</td>
                        <td> <a href="javascript:void(0)" class="DistrictWiseCnt"
                                data-custstate="{{ $row->CustState }}">{{ $row->CustState }}</a> </td>
                        <td>{{ $row->act }}</td>
                        <td>{{ $row->react }}</td>
                        <td>{{ $row->cnt }}</td>
                    </tr>
                @endforeach

            @endif
        </tbody>
        <tfoot>
            <tr class="">
                <th></th>
                <th colspan="1"> Total : </th>
                <th>{{ $totalAct }}</th>
                <th>{{ $totalReact }}</th>
                <th>{{ $totalCnt }}</th>
            </tr>
        </tfoot>

    </table>
</div>
