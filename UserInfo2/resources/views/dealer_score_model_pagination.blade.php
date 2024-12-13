<table id="custom_datatable" class="table table-bordered table-striped" width="100%">
    <thead>
        <tr>
            <th>Sr. No.</th>
            <th>Reward Lic Sent Date</th>
            <th>Email Status</th>
            <th>Options</th>
        </tr>
    </thead>
    <tbody>
        @php
            $i = 1;
        @endphp
        @if (!empty($RewardLog))
            @foreach ($RewardLog as $key => $data)
                @php

                    $EmailDiv = '';
                    // if ($data->EmailStatus == 'Sent|Sent' || trim($data->EmailStatus) == 'Sent') {
                    if ($data->EmailStatus == 'Sent|Sent' || strpos($data->EmailStatus, 'Sent') !== false) {
                        $EmailDiv .= '<span class="greenTxt">Mail Sent Successfully</span>';
                    } else {
                        $EmailDiv .= '<span class="redTxt">Error in Sending Mail</span>';
                    }

                    $dtChk = Carbon\Carbon::parse($data->SentDate);
                    $now = Carbon\Carbon::now();
                    $diff_in_days = $dtChk->diffInDays($now);
                    $mailOption = '';
                    if ($diff_in_days <= 10) {
                        $mailOption .= '<a href="#" class="resendRewardEmail" data-id="' . $data->Id . '" data-dlr_code="' . $data->DlrCode . '" data-sent_lic="' . $data->SentLic . '">Resend Email</a>';
                    }
                @endphp
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $data->SentDate }}</td>
                    <td>{!! $EmailDiv !!}</td>
                    <td>{!! $mailOption !!}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
{{--
@if ($RewardLog instanceof \Illuminate\Pagination\LengthAwarePaginator)
    <div id="pagination" class="d-flex flex-row-reverse">
        {{ $RewardLog->links('custom_pagination') }} --}}
        {{-- <div id="total_records" style="display:none">Total records found:
            <span class="badge badge-success" style="color: #626ed4;font-size:16px">{{ $RewardLog->total() }}</span>
        </div> --}}
    {{-- </div>
@endif --}}
