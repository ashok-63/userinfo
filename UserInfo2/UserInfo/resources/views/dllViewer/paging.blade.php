<div class="fw-bold" style="position: relative">
    <span id="">Total : {{ $getKeyInfo->count() }}</span> | RUC : {{ $getKeyCnt->RUC_Count }} | NUC :
    {{ $getKeyCnt->NUC_Count }} | TUC : {{ $getKeyCnt->TUC_Count }}
</div>
<div class="table-responsive">
    <table id="usersTable" class="table table-bordered table-striped text-nowrap">
        <thead
            style="font-size: 14px;letter-spacing: 0.9px;color: white;
        background-color: #28a745a6!important;">
            <tr>
                <th>Sr</th>
                <th>Key</th>
                <th>InstallCode</th>
                <th>UnlockCode</th>
                <th>ComputerName</th>
                <th>InstallDate</th>
                <th>ExpiryDate</th>
                <th>Address</th>
            </tr>
        </thead>
        <tbody>
            @if ($getKeyInfo)
                @php
                    $count = 1;
                @endphp
                @foreach ($getKeyInfo as $key => $row)
                    @php
                        $InstCode = $row->installCode;

                        $installCodeRev = strrev($InstCode);
                        if (strpos($InstCode, '-', 0) > 0) {
                            $HexAdd = 0;
                            $instatestllCD = explode('-', $InstCode);
                            foreach ($instatestllCD as $key => $instCD_val) {
                                $HexAdd = intval($HexAdd + hexdec($instCD_val));
                            }
                        }
                        $HexAdd = dechex($HexAdd);
                        $HexAdd_length = strlen($HexAdd);
                        $sub_HexAdd = substr($HexAdd, 1, $HexAdd_length - 1);
                        $Install_Code = 'HR-' . $installCodeRev . '-' . strtoupper($sub_HexAdd);

                        $installDate = $row->installDate;
                        // $strinstallDate = explode('-', $installDate_tmp);
                        // $di = substr($strinstallDate[1], 0, 2); //20
                        // $Yi = $strinstallDate[0]; //2024
                        // $mi = substr($strinstallDate[2], 0, 2);
                        // if ($di <= 12 && $mi <= 12) {
                        //     $insday = $mi;
                        //     $insmnth = $di;
                        // } else {
                        //     $insday = $di;
                        //     $insmnth = $mi;
                        // }
                        // $installDate = $Yi . '-' . $insday . '-' . $insmnth;
                    @endphp
                    <tr>
                        <td class="text-center fw-bold">{{ $count++ }}</td>
                        <td class="">{{ $row->SerialNo }}</td>
                        <td class="">{{ $Install_Code }}</td>
                        <td class="">{{ $row->unlockCode }}</td>
                        <td class="">{{ $row->computerName }}</td>
                        <td class="">{{ date('Y-m-d H:i:s', strtotime($installDate)) }}</td>
                        <td class="">{{ $row->ExpiryDate }}</td>
                        <td class="" style="text-wrap: balance;">{{ $row->Address }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
