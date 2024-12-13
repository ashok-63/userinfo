<style>
    table td,
    table th {
        padding: 0.4rem 0.4rem !important;
    }
</style>

<div class="table-responsive">
    <table id="reactivationtable" class="table table-bordered table-striped text-nowrap text-center">
        <thead
            style="font-size: 14px;letter-spacing: 0.9px;color: white;
        background-color: #28a745a6!important;">
            <tr>
                <th>Sr</th>
                <th>OperatorName</th>
                <th>ReactCount</th>
                <th>InDate</th>
            </tr>
        </thead>
        <tbody>
            @if ($data)
                @php
                    $count = 1;
                    $rC_total = 0;
                @endphp
                @foreach ($data as $key => $row)
                    @php
                        $rC_total += $row->rCount;
                    @endphp
                    <tr>
                        <td class=""><b>{{ $count++ }}</b></td>
                        <td class="">{{ $row->OperatorName }}</td>
                        <td class=""> <a href="{{ url('viewreactcntkeys/' . $date . '/' . $row->OperatorName) }}"
                                target="_blank" rel="noopener noreferrer"> {{ $row->rCount }}</a> </td>
                        <td class="">{{ $row->InDate }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="2"></td>

                    <td class="text-danger">
                        <h6> --------------- <br> {{ $rC_total }}</h6>
                    </td>
                    <td></td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
