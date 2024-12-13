<div class="fw-bold" style="position: relative">
    <span id="">Total : {{ $getKeyCount->count() }}</span>
</div>
<div class="table-responsive">
    <table id="usersTable" class="table table-bordered table-striped text-nowrap fw-bold">
        <thead
            style="font-size: 14px;letter-spacing: 0.9px;color: white;
        background-color: #28a745a6!important;">
            <tr>
                <th class="text-center">Sr</th>
                <th>Date</th>
                <th>TUC</th>
                <th>RUC</th>
                <th>NUC</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @if ($getKeyCount)
                @php
                    $count = 1;
                @endphp
                @foreach ($getKeyCount as $key => $row)
                    <tr>
                        <td class="text-center">{{ $count++ }}</td>
                        <td class="">{{ $row->Date }}</td>
                        <td class="">{{ $row->TUC_Count }}</td>
                        <td class="">{{ $row->RUC_Count }}</td>
                        <td class="">{{ $row->NUC_Count }}</td>
                        <td class="">{{ $row->Total_Count }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
