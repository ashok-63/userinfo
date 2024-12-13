<table class="table table-bordered">
    <thead>
        <tr>
            <th>Sr.No</th>
            <th>Key Number</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @if ($temp_arr)
            @php
                $cnt = 1;
            @endphp
            @foreach ($temp_arr as $row)
                <tr>
                    <td>{{ $cnt++ }}</td>
                    <td>{{ $row['licNo'] }}</td>
                    <td>{{ $row['msg'] }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3" style="background: #CAEAFF;"> <strong>Blocked : {{ $blocked }} , Already Activated
                        : {{ $activated }} , Not Found :
                        {{ $notFound }}</strong></td>
            </tr>
        @endif
    </tbody>
</table>
