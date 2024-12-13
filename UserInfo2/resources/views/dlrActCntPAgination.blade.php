<div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Count Of Activation <small style="font-weight: 100">[From {{ $fromDate }} To {{ $toDate }}]</small> </th>
                <th>1 Yr</th>
                <th>3 Yr</th>
            </tr>
        </thead>

        <tbody>
            @if ($count)
                {{-- @foreach ($data as $row) --}}
                <tr>
                    <td>{{ $count->CntCustNO }}</td>
                    <td>{{ $count->oYr }}</td>
                    <td>{{ $count->tYr }}</td>
                </tr>
                {{-- @endforeach --}}
            @endif
        </tbody>
    </table>
</div>
