<div class="table-responsive">
    <table id="usersTable" class="table table-bordered">
        <thead
            style="font-size: 14px;letter-spacing: 0.9px;color: white;
        background-color: #28a745a6!important;">
            <tr>
                <th>Sr</th>
                <th>Username</th>
                <th>Activity</th>
                <th>InDate</th>
            </tr>
        </thead>
        <tbody>
            @if ($getData)
                @php
                    $count = 1;
                @endphp
                @foreach ($getData as $key => $row)
                    <tr>
                        <td class="text-center"><b>{{ $count++ }}</b></td>
                        <td class="">{{ $row->User_Name }}</td>
                        <td class="">{{ $row->activity }}</td>
                        <td class="">{{ $row->InDate }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
