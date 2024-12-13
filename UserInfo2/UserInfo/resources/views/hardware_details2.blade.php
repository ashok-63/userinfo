<title>Userinfo | Hardware Details </title>
<link rel="shortcut icon" href="{{ url('/public/backend/assets/images/favicon.png') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="{{ url('/') }}/public/backend/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet"
    type="text/css">
<link href="{{ url('/') }}/public/backend/assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css">
<link href="{{ url('/') }}/public/backend/assets/css/custom.css" id="app-style" rel="stylesheet" type="text/css">
<script src="{{ url('/') }}/public/backend/assets/libs/jquery/jquery.min.js"></script>
<style>
    b,
    strong {
        font-weight: bolder;
    }

    table {
        border-collapse: separate;
        line-height: 0;
        font-size: 12px
    }

    tr {
        display: block;
        float: left;
        width: auto;
    }

    th,
    td {
        display: block;
        border-bottom: 0.05px solid !important;
        border-top: 0.1px solid !important;
        border-left: 0.1px solid !important;
        border-right: 0.1px solid !important;
        padding: 14px !important;
    }

    .topnav {
        padding: 10px;
        position: fixed !important;
        top: 0px !important;
        left: 0px !important;
        background: #71c484;
        width: -webkit-fill-available
    }

    .sticky-tr {
        position: sticky;
        left: 0;
        background: white;
        width: 250px;
    }

    .same {
        background-color: #eef366 !important;
        font-weight: bold;
        padding: 2px;
    }

    /* .different {
        background-color: #e0b35e !important ;
    } */
</style>

<div>
    <span>
        <h5 class="topnav">
            HW2 | Srv : Activation | DB : installinfo |Table : ActHwMaster | Hardware Details : {{ $SerialNo }} | Total Records : {{ $data->count() }} </h5>
    </span>
</div>

<div class="mt-5" style="width: max-content">
    <table class="table">

        <tr class="sticky-tr">
            <th>#</th>
            <th><strong>In Date</strong> </th>
            <th>Info Lan Card No</th>
            <th>Installation Code </th>
            <th>Unlock Code </th>
            <th>Mobile Number </th>
            <th>Contact Person </th>
            <th>Lancard No 1 </th>
            <th>Lancard No 2 </th>
            <th>Lancard No 3 </th>
            <th>Lancard-1 Name</th>
            <th>Lancard-2 Name</th>
            <th>Lancard-3 Name</th>
            <th><strong>Manufacturer</strong> </th>
            <th><strong>Model</strong> </th>
            <th><strong>CPUName</strong> </th>
            <th><strong>CDVSN</strong> </th>
            <th><strong>DDVSN</strong> </th>
            <th><strong>HDD1</strong> </th>
            <th><strong>HDD2</strong> </th>
            <th><strong>HDDModels</strong> </th>
            <th>Lancard-1 Ip </th>
            <th>Lancard-2 Ip </th>
            <th>Lancard-3 Ip </th>
            <th>CPUSpeed </th>
            <th>MachineName </th>
            <th>MBID </th>
            <th>OS </th>
            <th>BITS </th>
            <th>MBInstCode </th>
            <th>LCInstCode </th>
            <th>HDDInstCode </th>
        </tr>

        @if ($data)
            @php
                $cnt = 0;
                $clsCnt = 0;
                $cpuname_arr = [];
                $hdd2_arr = [];
                $Lc1No_arr = [];
                $Manufacturer_arr = [];
                $Model_arr = [];
                $CDVSN_arr = [];
                $DDVSN_arr = [];
                $HDD1_arr = [];
                $HDDModels_arr = [];
            @endphp

            @foreach ($data as $val1)
                @php
                    if ($val1->CPUName != '' && $val1->CPUName != 'N/A' && $val1->CPUName != 'To be filled by O.E.M.') {
                        $cpuname_arr[] = $val1->CPUName;
                    }
                    if ($val1->HDD2 != '' && $val1->HDD2 != 'N/A' && $val1->HDD2 != 'To be filled by O.E.M.') {
                        $hdd2_arr[] = $val1->HDD2;
                    }
                    if ($val1->Lc1No != '' && $val1->Lc1No != 'N/A' && $val1->Lc1No != 'To be filled by O.E.M.') {
                        $Lc1No_arr[] = $val1->Lc1No;
                    }
                    if (
                        $val1->Manufacturer != '' &&
                        $val1->Manufacturer != 'N/A' &&
                        $val1->Manufacturer != 'To be filled by O.E.M.'
                    ) {
                        $Manufacturer_arr[] = $val1->Manufacturer;
                    }
                    if ($val1->Model != '' && $val1->Model != 'N/A' && $val1->Model != 'To be filled by O.E.M.') {
                        $Model_arr[] = $val1->Model;
                    }
                    if ($val1->CDVSN != '' && $val1->CDVSN != 'N/A' && $val1->CDVSN != 'To be filled by O.E.M.') {
                        $CDVSN_arr[] = $val1->CDVSN;
                    }
                    if ($val1->DDVSN != '' && $val1->DDVSN != 'N/A' && $val1->DDVSN != 'To be filled by O.E.M.') {
                        $DDVSN_arr[] = $val1->DDVSN;
                    }
                    if ($val1->HDD1 != '' && $val1->HDD1 != 'N/A' && $val1->HDD1 != 'To be filled by O.E.M.') {
                        $HDD1_arr[] = $val1->HDD1;
                    }
                    if (
                        $val1->HDDModels != '' &&
                        $val1->HDDModels != 'N/A' &&
                        $val1->HDDModels != 'To be filled by O.E.M.'
                    ) {
                        $HDDModels_arr[] = $val1->HDDModels;
                    }
                @endphp
            @endforeach



            @foreach ($data as $key => $val)
                @php
                    /**-------------------Highlight Section-----------------------**/
                    $count_cpu = array_count_values($cpuname_arr);
                    $count_hdd2 = array_count_values($hdd2_arr);
                    $count_Lc1No = array_count_values($Lc1No_arr);
                    $count_Manufacturer = array_count_values($Manufacturer_arr);
                    $count_Model = array_count_values($Model_arr);
                    $count_CDVSN = array_count_values($CDVSN_arr);
                    $count_DDVSN = array_count_values($DDVSN_arr);
                    $count_HDD1 = array_count_values($HDD1_arr);
                    $count_HDDModels = array_count_values($HDDModels_arr);

                    if (in_array($val->CPUName, $cpuname_arr)) {
                        if ($count_cpu[$val->CPUName] > 1) {
                            $class_cpu = 'same';
                        } else {
                            $class_cpu = '';
                        }
                    } else {
                        $class_cpu = '';
                    }

                    if (in_array($val->HDD2, $hdd2_arr)) {
                        if ($count_hdd2[$val->HDD2] > 1) {
                            $class_hdd2 = 'same';
                        } else {
                            $class_hdd2 = '';
                        }
                    } else {
                        $class_hdd2 = '';
                    }

                    if (in_array($val->CDVSN, $CDVSN_arr)) {
                        if ($count_CDVSN[$val->CDVSN] > 1) {
                            $class_CDVSN = 'same';
                        } else {
                            $class_CDVSN = '';
                        }
                    } else {
                        $class_CDVSN = '';
                    }

                    if (in_array($val->DDVSN, $DDVSN_arr)) {
                        if ($count_DDVSN[$val->DDVSN] > 1) {
                            $class_DDVSN = 'same';
                        } else {
                            $class_DDVSN = '';
                        }
                    } else {
                        $class_DDVSN = '';
                    }

                    if (in_array($val->Lc1No, $Lc1No_arr)) {
                        if ($count_Lc1No[$val->Lc1No] > 1) {
                            $class_Lc1No = 'same';
                        } else {
                            $class_Lc1No = '';
                        }
                    } else {
                        $class_Lc1No = '';
                    }

                    if (in_array($val->Manufacturer, $Manufacturer_arr)) {
                        if ($count_Manufacturer[$val->Manufacturer] > 1) {
                            $class_Manufacturer = 'same';
                        } else {
                            $class_Manufacturer = '';
                        }
                    } else {
                        $class_Manufacturer = '';
                    }
                    if (in_array($val->Model, $Model_arr)) {
                        if ($count_Model[$val->Model] > 1) {
                            $class_Model = 'same';
                        } else {
                            $class_Model = '';
                        }
                    } else {
                        $class_Model = '';
                    }

                    if (in_array($val->HDD1, $HDD1_arr)) {
                        if ($count_HDD1[$val->HDD1] > 1) {
                            $class_HDD1 = 'same';
                        } else {
                            $class_HDD1 = '';
                        }
                    } else {
                        $class_HDD1 = '';
                    }
                    if (in_array($val->HDDModels, $HDDModels_arr)) {
                        if ($count_HDDModels[$val->HDDModels] > 1) {
                            $class_HDDModels = 'same';
                        } else {
                            $class_HDDModels = '';
                        }
                    } else {
                        $class_HDDModels = '';
                    }

                    /**-------------------Highlight Section-----------------------**/

                    $cnt++;
                    $installCodeRev = strrev($val->installCode);
                    if (strpos($val->installCode, '-', 0) > 0) {
                        $HexAdd = 0;
                        $instatestllCD = explode('-', $val->installCode);
                        foreach ($instatestllCD as $key => $instCD_val) {
                            $HexAdd = intval($HexAdd + hexdec($instCD_val));
                        }
                    }
                    $HexAdd = dechex($HexAdd);
                    $HexAdd_length = strlen($HexAdd);
                    $sub_HexAdd = substr($HexAdd, 1, $HexAdd_length - 1);
                    $ic = 'HR-' . $installCodeRev . '-' . strtoupper($sub_HexAdd);
                @endphp

                <tr>
                    <td><strong> {{ $val->CustomerNumber }} | PC - {{ $cnt }} </strong></td>
                    <td>{{ $val->iDate2 }}</td>
                    <td>{{ $val->lanCardNo }}</td>
                    <td>{{ $ic }} </td>
                    <td>{{ $val->unlockCode }}</td>
                    <td>{{ $val->CustMobile }}</td>
                    <td>{{ $val->contactPerson }}</td>
                    <td> <span class="{{ $class_Lc1No }}"> {{ $val->Lc1No }}</span></td>
                    <td>{{ $val->Lc2No }}</td>
                    <td>{{ $val->Lc3No }}</td>
                    <td>{{ $val->Lc1Name }}</td>
                    <td>{{ $val->Lc2Name }}</td>
                    <td>{{ $val->Lc3Name }}</td>
                    <td> <span class="{{ $class_Manufacturer }}">{{ $val->Manufacturer }}</span></td>
                    <td> <span class="{{ $class_Model }}"> {{ $val->Model }} </span></td>
                    <td> <span class="{{ $class_cpu }}">{{ $val->CPUName }} </span></td>
                    <td> <span class="{{ $class_CDVSN }}">{{ $val->CDVSN }} </span></td>
                    <td> <span class="{{ $class_DDVSN }}">{{ $val->DDVSN }} </span></td>
                    <td> <span class="{{ $class_HDD1 }}">{{ $val->HDD1 }} </span></td>
                    <td> <span class="{{ $class_hdd2 }}">{{ $val->HDD2 }}</span></td>
                    <td> <span class="{{ $class_HDDModels }}">{{ $val->HDDModels }}</span></td>
                    <td>{{ $val->Lc1Ip }}</td>
                    <td>{{ $val->Lc2Ip }}</td>
                    <td>{{ $val->Lc3Ip }}</td>
                    <td>{{ $val->CPUSpeed }}</td>
                    <td>{{ $val->MachineName }}</td>
                    <td>{{ $val->MBID }}</td>
                    <td>{{ $val->OS }}</td>
                    <td>{{ $val->BITS }}</td>
                    <td>{{ $val->MBInstCode }}</td>
                    <td>{{ $val->LCInstCode }}</td>
                    <td>{{ $val->HDDInstCode }}</td>
                </tr>
                @php
                    $clsCnt++;
                @endphp
            @endforeach
        @else
            <tr>
                <td>- </td>
                <td>- </td>
                <td>- </td>
                <td>- </td>
                <td>- </td>
                <td>- </td>
                <td>- </td>
                <td>- </td>
                <td>- </td>
                <td>- </td>
                <td>- </td>
                <td>- </td>
                <td>- </td>
                <td>- </td>
                <td>- </td>
                <td>- </td>
                <td>- </td>
                <td>- </td>
                <td>- </td>
                <td>- </td>
                <td>- </td>
                <td>- </td>
                <td>- </td>
                <td>- </td>
                <td>- </td>
                <td>- </td>
                <td>- </td>
                <td>- </td>
                <td>- </td>
                <td>- </td>
                <td>- </td>
                <td>- </td>
            </tr>
        @endif

    </table>
</div>
