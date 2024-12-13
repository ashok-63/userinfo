<title>Userinfo | Hardware Details </title>
<link rel="shortcut icon" href="{{ url('/public/backend/assets/images/favicon.png') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="{{ url('/') }}/public/backend/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet"
    type="text/css">
<link href="{{ url('/') }}/public/backend/assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css">
<link href="{{ url('/') }}/public/backend/assets/css/custom.css" id="app-style" rel="stylesheet" type="text/css">

<style>
    b,
    strong {
        font-weight: bolder;
    }
</style>
@php
    $recCount = 0;
    $hdd = '';
    $hdd12 = '';
    $cdv = '';
    $ddv = '';
    $hdd1 = '';
    $hdd2 = '';
    $cdv1 = '';
    $ddv1 = '';
    $cdv2 = '';
    $ddv2 = '';
    $rsInfo = DB::table('info')
        ->where('CustomerNumber', '=', $CustNo)
        ->select('CustomerNumber', 'contactPerson', 'CustMobile', 'lanCardNo', 'installCode', 'unlockCode')
        ->first();

    if (!empty($rsInfo)) {
        $cp = $rsInfo->contactPerson;
        $mob = $rsInfo->CustMobile;
        $uc = $rsInfo->unlockCode;
        $InstCode = $rsInfo->installCode;
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
        $ic = 'HR-' . $installCodeRev . '-' . strtoupper($sub_HexAdd);
        $iLc = $rsInfo->lanCardNo;
    }

    $objrs = DB::table('ActHwMaster')
        ->where('CustomerNumber', '=', $CustNo)
        ->where('SerialNo', '=', $SerialNo)
        ->orderBy('hwId', 'desc')
        ->select(
            'Lc1No',
            'Lc2No',
            'Lc3No',
            'Lc1Name',
            'Lc2Name',
            'Lc3Name',
            'Lc1Ip',
            'Lc2Ip',
            'Lc3Ip',
            'HDD1',
            'HDD2',
            'HDDModels',
            'CPUName',
            'CPUSpeed',
            'MachineName',
            'MBID',
            'OS',
            'BITS',
            'CDVSN',
            'DDVSN',
            'MBInstCode',
            'Manufacturer',
            'Model',
            'HDDInstCode',
            'LCInstCode',
            DB::raw('DATE_FORMAT(InDate, "%d-%b-%Y %h:%i %p") as iDate'),
        )
        ->first();

    if (!empty($objrs)) {
        $recCount = 1;
        $lc11 = $objrs->Lc1No;
        $lc12 = $objrs->Lc2No;
        $lc13 = $objrs->Lc3No;
        $lc11Nm = $objrs->Lc1Name;
        $lc12Nm = $objrs->Lc2Name;
        $lc13Nm = $objrs->Lc3Name;
        $lcIp11 = $objrs->Lc1Ip;
        $lcIp12 = $objrs->Lc2Ip;
        $LcIp13 = $objrs->Lc3Ip;
        $hdd = $objrs->HDD1;
        $hdd12 = $objrs->HDD2;
        $hddm = $objrs->HDDModels;
        $cpu = $objrs->CPUName;
        $speed = $objrs->CPUSpeed;
        $mac = $objrs->MachineName;
        $mbid = $objrs->MBID;
        $os = $objrs->OS;
        $bits = $objrs->BITS;
        $cdv = $objrs->CDVSN;
        $ddv = $objrs->DDVSN;
        $mbic = $objrs->MBInstCode;
        $man = $objrs->Manufacturer;
        $model = $objrs->Model;
        $hddic = $objrs->HDDInstCode;
        $lcic = $objrs->LCInstCode;
        $indt = $objrs->iDate;
    } //objrs
    $SubQuery = DB::table('info')
        ->where('CustomerNumber', '=', $CustNo)
        ->orderBy('CustomerNumber', 'desc')
        ->select('CustomerNumber')
        ->first();
    $customer_no = !empty($SubQuery) ? $SubQuery->CustomerNumber : 0;

    // $subQry = DB::table('info')
    //     ->where('CustomerNumber', '<', $customer_no)
    //     ->select('CustomerNumber')
    //     ->toSql();

    $rsInfo1 = DB::table('info')
        ->where('SerialNo', '=', $SerialNo)
        ->where('CustomerNumber', '<', $customer_no)
        ->orderBy('CustomerNumber', 'DESC')
        ->select('CustomerNumber', 'contactPerson', 'CustMobile', 'lanCardNo', 'installCode', 'unlockCode')
        ->first();

    $custNo1 = '';

    if (!empty($rsInfo1)) {
        $cp1 = $rsInfo1->contactPerson;
        $mob1 = $rsInfo1->CustMobile;
        $custNo1 = $rsInfo1->CustomerNumber;
        $uc1 = $rsInfo1->unlockCode;
        $ic1 = $rsInfo1->installCode;
        $installCodeRev = strrev($ic1);
        if (strpos($ic1, '-', 0) > 0) {
            $HexAdd = 0;
            $instatestllCD = explode('-', $ic1);
            foreach ($instatestllCD as $key => $instCD_val) {
                $HexAdd = intval($HexAdd + hexdec($instCD_val));
            }
        }
        $HexAdd = dechex($HexAdd);
        $HexAdd_length = strlen($HexAdd);
        $sub_HexAdd = substr($HexAdd, 1, $HexAdd_length - 1);
        $ic1 = 'HR-' . $installCodeRev . '-' . strtoupper($sub_HexAdd);
        $iLc1 = $rsInfo1->lanCardNo;
    } //rsInfo1
    if (!empty($custNo1)) {
        $objrs1 = DB::table('ActHwMaster')
            ->where('CustomerNumber', '=', $custNo1)
            ->where('SerialNo', '=', $SerialNo)
            ->orderBy('hwId', 'desc')
            ->select(
                'Lc1No',
                'Lc2No',
                'Lc3No',
                'Lc1Name',
                'Lc2Name',
                'Lc3Name',
                'Lc1Ip',
                'Lc2Ip',
                'Lc3Ip',
                'HDD1',
                'HDD2',
                'HDDModels',
                'CPUName',
                'CPUSpeed',
                'MachineName',
                'MBID',
                'OS',
                'BITS',
                'CDVSN',
                'DDVSN',
                'MBInstCode',
                'Manufacturer',
                'Model',
                'HDDInstCode',
                'LCInstCode',
                DB::raw('DATE_FORMAT(InDate, "%d-%b-%Y %h:%i %p") as iDate1'),
            )
            ->first();

        if (!empty($objrs1)) {
            $recCount = 2;
            $lc1 = $objrs1->Lc1No;
            $lc2 = $objrs1->Lc2No;
            $lc3 = $objrs1->Lc3No;
            $lc1Nm = $objrs1->Lc1Name;
            $lc2Nm = $objrs1->Lc2Name;
            $lc3Nm = $objrs1->Lc3Name;
            $lcIp1 = $objrs1->Lc1Ip;
            $lcIp2 = $objrs1->Lc2Ip;
            $LcIp3 = $objrs1->Lc3Ip;
            $hdd1 = $objrs1->HDD1;
            $hdd2 = $objrs1->HDD2;
            $hddm1 = $objrs1->HDDModels;
            $cpu1 = $objrs1->CPUName;
            $speed1 = $objrs1->CPUSpeed;
            $mac1 = $objrs1->MachineName;
            $mbid1 = $objrs1->MBID;
            $os1 = $objrs1->OS;
            $bits1 = $objrs1->BITS;
            $cdv1 = $objrs1->CDVSN;
            $ddv1 = $objrs1->DDVSN;
            $mbic1 = $objrs1->MBInstCode;
            $man1 = $objrs1->Manufacturer;
            $model1 = $objrs1->Model;
            $hddic1 = $objrs1->HDDInstCode;
            $lcic1 = $objrs1->LCInstCode;
            $indt1 = $objrs1->iDate1;
        }

        $SubQuery1 = DB::table('info')
            ->where('CustomerNumber', '=', $custNo1)
            ->orderBy('CustomerNumber', 'desc')
            ->select('CustomerNumber')
            ->first();

        $customer_no1 = !empty($SubQuery1) ? $SubQuery1->CustomerNumber : 0;
        $rsInfo2 = DB::table('info')
            ->where('SerialNo', '=', $SerialNo)
            ->where('CustomerNumber', '<', $customer_no1)
            ->select('CustomerNumber', 'contactPerson', 'CustMobile', 'lanCardNo', 'installCode', 'unlockCode')
            ->orderBy('CustomerNumber', 'DESC')
            ->first();

        if (!empty($rsInfo2)) {
            $cp2 = $rsInfo2->contactPerson;
            $mob2 = $rsInfo2->CustMobile;
            $custNo2 = $rsInfo2->CustomerNumber;
            $uc2 = $rsInfo2->unlockCode;
            $ic2 = $rsInfo2->installCode;
            $installCodeRev = strrev($ic2);
            if (strpos($ic2, '-', 0) > 0) {
                $HexAdd = 0;
                $instatestllCD = explode('-', $ic2);
                foreach ($instatestllCD as $key => $instCD_val) {
                    $HexAdd = intval($HexAdd + hexdec($instCD_val));
                }
            }
            $HexAdd = dechex($HexAdd);
            $HexAdd_length = strlen($HexAdd);
            $sub_HexAdd = substr($HexAdd, 1, $HexAdd_length - 1);
            $ic2 = 'HR-' . $installCodeRev . '-' . strtoupper($sub_HexAdd);
            $iLc2 = $rsInfo2->lanCardNo;
        }

        //rsInfo2
        if (!empty($custNo2)) {
            $objrs2 = DB::table('ActHwMaster')
                ->where('CustomerNumber', '=', $custNo2)
                ->where('SerialNo', '=', $SerialNo)
                ->orderBy('hwId', 'desc')
                ->select(
                    'Lc1No',
                    'Lc2No',
                    'Lc3No',
                    'Lc1Name',
                    'Lc2Name',
                    'Lc3Name',
                    'Lc1Ip',
                    'Lc2Ip',
                    'Lc3Ip',
                    'HDD1',
                    'HDD2',
                    'HDDModels',
                    'CPUName',
                    'CPUSpeed',
                    'MachineName',
                    'MBID',
                    'OS',
                    'BITS',
                    'CDVSN',
                    'DDVSN',
                    'MBInstCode',
                    'Manufacturer',
                    'Model',
                    'HDDInstCode',
                    'LCInstCode',
                    DB::raw('DATE_FORMAT(InDate, "%d-%b-%Y %h:%i %p") as iDate2'),
                )
                ->first();
            if (!empty($objrs2)) {
                $recCount = 3;
                $lc31 = $objrs2->Lc1No;
                $lc22 = $objrs2->Lc2No;
                $lc32 = $objrs2->Lc3No;
                $lc1Nm2 = $objrs2->Lc1Name;
                $lc2Nm2 = $objrs2->Lc2Name;
                $lc3Nm2 = $objrs2->Lc3Name;
                $lcIp112 = $objrs2->Lc1Ip;
                $lcIp22 = $objrs2->Lc2Ip;
                $LcIp32 = $objrs2->Lc3Ip;
                $hdd13 = $objrs2->HDD1;
                $hdd22 = $objrs2->HDD2;
                $hddm2 = $objrs2->HDDModels;
                $cpu2 = $objrs2->CPUName;
                $speed2 = $objrs2->CPUSpeed;
                $mac2 = $objrs2->MachineName;
                $mbid2 = $objrs2->MBID;
                $os2 = $objrs2->OS;
                $bits2 = $objrs2->BITS;
                $cdv2 = $objrs2->CDVSN;
                $ddv2 = $objrs2->DDVSN;
                $mbic2 = $objrs2->MBInstCode;
                $man2 = $objrs2->Manufacturer;
                $model2 = $objrs2->Model;
                $hddic2 = $objrs2->HDDInstCode;
                $lcic2 = $objrs2->LCInstCode;
                $indt2 = $objrs2->iDate2;
            } // objrs2
        } //custNo2
    } //custNo1
    $isLan = false;
    $isManf = false;
    $isModel = false;
    $isCpuNm = false;
    $isHdd1 = false;
    $isHdd2 = false;
    $isHddModels = false;
    $isCDrv = false;
    $isDDrv = false;
    $isLan1 = false;
    $isManf1 = false;
    $isModel1 = false;
    $isCpuNm1 = false;
    $isHdd11 = false;
    $isHdd21 = false;
    $isHddModels1 = false;
    $isCDrv1 = false;
    $isDDrv1 = false;
    $isLan2 = false;
    $isManf2 = false;
    $isModel2 = false;
    $isCpuNm2 = false;
    $isHdd12 = false;
    $isHdd22 = false;
    $isHddModels2 = false;
    $isCDrv2 = false;
    $isDDrv2 = false;
    if ($recCount > 1) {
        if (!empty($lc11) && !empty($lc1) && $lc11 == $lc1) {
            $isLan = true;
        }
        if (!empty($man) && !empty($man1) && $man == $man1) {
            $isManf = true;
        }
        if (!empty($model) && !empty($model1) && $model == $model1) {
            $isModel = true;
        }
        if (!empty($cpu) && !empty($cpu1) && $cpu == $cpu1) {
            $isCpuNm = true;
        }

        $hdd_len = strlen($hdd);
        $hdd_upper = strtoupper($hdd);
        $hdd1_upper = strtoupper($hdd1);
        $hdd2_upper = strtoupper($hdd2);
        if ($hdd_len > 3 && ($hdd1_upper == $hdd_upper || $hdd2_upper == $hdd_upper)) {
            $isHdd1 = true;
        }
        $hdd12_len = strlen($hdd12);
        $hdd12_upper = strtoupper($hdd12);
        if ($hdd12_len > 3 && ($hdd1_upper == $hdd12_upper || $hdd2_upper == $hdd12_upper)) {
            $isHdd2 = true;
        }
        if (!empty($hddm) && !empty($hddm1)) {
            $hddm_upper = strtoupper(substr($hddm, 0, 20));
            $hddm1_upper = strtoupper(substr($hddm1, 0, 20));
            if ($hddm_upper == $hddm1_upper) {
                $isHddModels = true;
            }
        }
        $cdv_len = strlen($cdv);
        $cdv_upper = strtoupper($cdv);
        $cdv1_upper = strtoupper($cdv1);
        $ddv1_upper = strtoupper($ddv1);
        if ($cdv_len > 3 && ($cdv_upper == $cdv1_upper || $cdv_upper == $ddv1_upper)) {
            $isCDrv = true;
        }
        $ddv_len = strlen($ddv);
        $ddv_upper = strtoupper($ddv);
        if ($ddv_len > 3 && ($ddv_upper == $cdv1_upper || $ddv_upper == $ddv1_upper)) {
            $isDDrv = true;
        }
        if ($recCount == 3) {
            if (!empty($lc1) && !empty($lc31) && $lc1 == $lc31) {
                $isLan1 = true;
            }
            if (!empty($man1) && !empty($man2) && $man1 == $man2) {
                $isManf1 = true;
            }
            if (!empty($model1) && !empty($model2) && $model1 == $model2) {
                $isModel1 = true;
            }
            if (!empty($cpu1) && !empty($cpu2) && $cpu1 == $cpu2) {
                $isCpuNm1 = true;
            }
            $hdd1_len = strlen($hdd1);
            $hdd13_upper = strtoupper($hdd13);
            $hdd22_upper = strtoupper($hdd22);
            if ($hdd1_len > 3 && ($hdd1_upper == $hdd13_upper || $hdd1_upper == $hdd22_upper)) {
                $isHdd11 = true;
            }
            $hdd2_len = strlen($hdd2);
            if ($hdd2_len > 3 && ($hdd2_upper == $hdd13_upper || $hdd2_upper == $hdd22_upper)) {
                $isHdd2 = true;
            }
            if (!empty($hddm1) && !empty($hddm2)) {
                $hddm1_upper = strtoupper(substr($hddm1, 0, 20));
                $hddm2_upper = strtoupper(substr($hddm2, 0, 20));
                if ($hddm1_upper == $hddm2_upper) {
                    $isHddModels1 = true;
                }
            }
            $cdv1_len = strlen($cdv1);
            $cdv2_upper = strtoupper($cdv2);
            if ($cdv1_len > 3 && $cdv1_upper == $cdv2_upper) {
                $isCDrv1 = true;
            }
            $ddv1_len = strlen($ddv1);
            $ddv2_upper = strtoupper($ddv2);
            if ($ddv1_len > 3 && ($ddv1_upper == $cdv2_upper || $ddv1_upper == $ddv2_upper)) {
                $isDDrv1 = true;
            }
            if (!empty($lc11) && !empty($lc31) && $lc11 == $lc31) {
                $isLan2 = true;
            }
            if (!empty($man) && !empty($man2) && $man == $man2) {
                $isManf2 = true;
            }
            if (!empty($model) && !empty($model2) && $model == $model2) {
                $isModel2 = true;
            }
            if (!empty($cpu) && !empty($cpu2) && $cpu == $cpu2) {
                $isCpuNm2 = true;
            }
            $hdd13_upper = strtoupper($hdd13);
            $hdd22_upper = strtoupper($hdd22);
            // print_r($hdd_len);
            if ($hdd_len > 3 && ($hdd_upper == $hdd13_upper || $hdd_upper == $hdd22_upper)) {
                $isHdd12 = true;
            }
            $hdd13_upper = strtoupper($hdd13);

            if ($hdd12_len > 3 && ($hdd2_upper == $hdd13_upper || $hdd2_upper == $hdd22_upper)) {
                $isHdd22 = true;
            }
            if (!empty($hddm) && !empty($hddm2)) {
                $hddm_upper = strtoupper(substr($hddm, 0, 20));
                $hddm2_upper = strtoupper(substr($hddm2, 0, 20));
                if ($hddm_upper == $hddm2_upper) {
                    $isHddModels2 = true;
                }
            }
            if ($cdv_len > 3 && ($cdv_upper == $cdv2_upper || $cdv_upper == $ddv2_upper)) {
                $isCDrv2 = true;
            }
            if ($ddv_len > 3 && ($ddv_upper == $cdv2_upper || $ddv_upper == $ddv2_upper)) {
                $isDDrv2 = true;
            }
        }
    }
@endphp
<style>
    table {
        border-collapse: unset !important;
    }

    td,
    th {
        /* border: 2px solid #84b7f7 ;   */
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even) {
        background-color: #ffffff;
    }
</style>
<div class="container-fluid m-2 hardware_details2">
    <div class="row">

        <table width="100%" border="0" cellspacing="0" cellpadding="0" id="hardwareDetails2" class="">
            <tr>
                <td colspan="4" height="34" align="left" valign="middle" bgcolor="#D5DCFF" class="pghead"
                    scope="col"><span class="style1">&nbsp;Hardware Details of</span> <span
                        class="style2">{{ $SerialNo }}.</span></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td class="brdCell" width="20%"></td>
                <td class="brdCell" width="30%"><strong>{{ dechex($CustNo) . ' ' }} :PC1</strong></td>
                <td class="brdCell" width="25%">
                    <strong>{{ !empty($custNo1) ? dechex($custNo1) . ' : PC2' : '' }}</strong>
                </td>
                <td class="brdCell" width="25%">
                    <strong>{{ !empty($custNo2) ? dechex($custNo2) . ' : PC3' : '' }}</strong>
                </td>
            </tr>
            <tr>
                <td class="brdCell"><strong>In Date</strong></td>
                <td class="brdCell">{{ !empty($indt) ? $indt : '' }}</td>
                <td class="brdCell">{{ !empty($indt1) ? $indt1 : '' }}</td>
                <td class="brdCell">{{ !empty($indt2) ? $indt2 : '' }}</td>
            </tr>
            <tr>
                <td class="brdCell">Info Lan Card No</td>
                <td class="brdCell">{{ $iLc }}</td>
                <td class="brdCell">{{ !empty($iLc1) ? $iLc1 : '' }}</td>
                <td class="brdCell">{{ !empty($iLc2) ? $iLc2 : '' }}</td>
            </tr>
            <tr>
                <td class="brdCell">Installation Code</td>
                <td class="brdCell">{{ $ic }}</td>
                <td class="brdCell">{{ !empty($ic1) ? $ic1 : '' }}</td>
                <td class="brdCell">{{ !empty($ic2) ? $ic2 : '' }}</td>
            </tr>
            <tr>
                <td class="brdCell">Unlock Code</td>
                <td class="brdCell">{{ $uc }}</td>
                <td class="brdCell">{{ !empty($uc1) ? $uc1 : '' }}</td>
                <td class="brdCell">{{ !empty($uc2) ? $uc2 : '' }}</td>
            </tr>
            <tr>
                <td class="brdCell">Mobile Number</td>
                <td class="brdCell">{{ $mob }}</td>
                <td class="brdCell">{{ !empty($mob1) ? $mob1 : '' }}</td>
                <td class="brdCell">{{ !empty($mob2) ? $mob2 : '' }}</td>
            </tr>
            <tr>
                <td class="brdCell">Contact Person</td>
                <td class="brdCell">{{ $cp }}</td>
                <td class="brdCell">{{ !empty($cp1) ? $cp1 : '' }}</td>
                <td class="brdCell">{{ !empty($cp2) ? $cp2 : '' }}</td>
            </tr>

            <tr>
                <td class="brdCell">Lancard No 1</td>
                <td class="brdCell"><span
                        {{ $isLan == true || $isLan2 == true ? 'style=background-color:#F4F799;' : '' }}>{{ !empty($lc11) ? $lc11 : '' }}</span>
                </td>
                <td class="brdCell"><span
                        {{ $isLan == true || $isLan1 == true || $isLan2 == true ? 'style=background-color:#F4F799; ' : '' }}>{{ !empty($lc1) ? $lc1 : '' }}</span>
                </td>
                <td class="brdCell"><span
                        {{ $isLan == true || $isLan1 == true || $isLan2 == true ? 'style=background-color:#F4F799;' : '' }}>{{ !empty($lc31) ? $lc31 : '' }}</span>
                </td>
            </tr>
            <tr>
                <td class="brdCell">Lancard No 2</td>
                <td class="brdCell">{{ !empty($lc12) ? $lc12 : '' }}</td>
                <td class="brdCell">{{ !empty($lc2) ? $lc2 : '' }}</td>
                <td class="brdCell">{{ !empty($lc22) ? $lc22 : '' }}</td>
            </tr>
            <tr>
                <td class="brdCell">Lancard No 3</td>
                <td class="brdCell">{{ !empty($lc13) ? $lc13 : '' }}</td>
                <td class="brdCell">{{ !empty($lc3) ? $lc3 : '' }}</td>
                <td class="brdCell">{{ !empty($lc32) ? $lc32 : '' }}</td>
            </tr>
            <tr>
                <td class="brdCell">Lancard-1 Name</td>
                <td class="brdCell">{{ !empty($lc11Nm) ? $lc11Nm : '' }}</td>
                <td class="brdCell">{{ !empty($lc1Nm) ? $lc1Nm : '' }}</td>
                <td class="brdCell">{{ !empty($lc1Nm2) ? $lc1Nm2 : '' }}</td>
            </tr>
            <tr>
                <td class="brdCell">Lancard-2 Name</td>
                <td class="brdCell">{{ !empty($lc12Nm) ? $lc12Nm : '' }}</td>
                <td class="brdCell">{{ !empty($lc2Nm) ? $lc2Nm : '' }}</td>
                <td class="brdCell">{{ !empty($lc2Nm2) ? $lc2Nm2 : '' }}</td>
            </tr>
            <tr>
                <td class="brdCell">Lancard-3 Name</td>
                <td class="brdCell">{{ !empty($lc13Nm) ? $lc13Nm : '' }}</td>
                <td class="brdCell">{{ !empty($lc3Nm) ? $lc3Nm : '' }}</td>
                <td class="brdCell">{{ !empty($lc3Nm2) ? $lc3Nm2 : '' }}</td>
            </tr>
            <tr>
                <td class="brdCell"><strong>Manufacturer</strong></td>
                <td class="brdCell"><span
                        {{ $isManf == true || $isManf2 == true ? 'style=background-color:#F4F799; class=matched' : '' }}>{{ !empty($man) ? $man : '' }}</span>
                </td>
                <td class="brdCell"><span
                        {{ $isManf == true || $isManf1 == true || $isManf2 == true ? 'style=background-color:#F4F799; class=matched' : '' }}>{{ !empty($man1) ? $man1 : '' }}</span>
                </td>
                <td class="brdCell">
                    <span
                        {{ $isManf == true || $isManf1 == true || $isManf2 == true ? 'style=background-color:#F4F799; class=matched' : '' }}>
                        {{ !empty($man2) ? $man2 : '' }}
                    </span>
                </td>
                {{--
                <td class="brdCell cntCell">

                </td> --}}
            </tr>
            <tr>
                <td class="brdCell"><strong>Model</strong></td>
                <td class="brdCell"><span
                        {{ $isModel == true || $isModel2 == true ? 'style=background-color:#F4F799; class=matched' : '' }}>{{ !empty($model) ? $model : '' }}</span>
                </td>
                <td class="brdCell"><span
                        {{ $isModel == true || $isModel1 == true || $isModel2 == true ? 'style=background-color:#F4F799; class=matched' : '' }}>{{ !empty($model1) ? $model1 : '' }}</span>
                </td>
                <td class="brdCell"><span
                        {{ $isModel == true || $isModel1 == true || $isModel2 == true ? 'style=background-color:#F4F799; class=matched' : '' }}>{{ !empty($model2) ? $model2 : '' }}</span>
                </td>
                {{-- <td class="brdCell cntCell">

                </td> --}}
            </tr>
            <tr>
                <td class="brdCell"><strong>CPUName</strong></td>
                <td class="brdCell"><span
                        {{ $isCpuNm == true || $isCpuNm2 == true ? 'style=background-color:#F4F799; class=matched' : '' }}>{{ !empty($cpu) ? $cpu : '' }}</span>
                </td>
                <td class="brdCell"><span
                        {{ $isCpuNm == true || $isCpuNm1 == true || $isCpuNm2 == true ? 'style=background-color:#F4F799; class=matched' : '' }}>{{ !empty($cpu1) ? $cpu1 : '' }}</span>
                </td>
                <td class="brdCell"><span
                        {{ $isCpuNm == true || $isCpuNm1 == true || $isCpuNm2 == true ? 'style=background-color:#F4F799; class=matched' : '' }}>{{ !empty($cpu2) ? $cpu2 : '' }}</span>
                </td>
                {{-- <td class="brdCell cntCell">

                </td> --}}
            </tr>
            <tr>
                <td class="brdCell"><strong>CDVSN</strong></td>
                <td class="brdCell"><span
                        {{ $isCDrv == true || $isCDrv2 == true ? 'style=background-color:#F4F799; class=matched' : '' }}>{{ !empty($cdv) ? $cdv : '' }}</span>
                </td>
                <td class="brdCell"><span
                        {{ $isCDrv == true || $isCDrv1 == true || $isCDrv2 == true ? 'style=background-color:#F4F799; class=matched' : '' }}>{{ !empty($cdv1) ? $cdv1 : '' }}</span>
                </td>
                <td class="brdCell"><span
                        {{ $isCDrv == true || $isCDrv1 == true || $isCDrv2 == true ? 'style=background-color:#F4F799; class=matched' : '' }}>{{ !empty($cdv2) ? $cdv2 : '' }}</span>
                </td>
                {{-- <td class="brdCell cntCell">

                </td> --}}
            </tr>
            <tr>
                <td class="brdCell"><strong>DDVSN</strong></td>
                <td class="brdCell"><span
                        {{ $isDDrv == true || $isDDrv2 == true ? 'style=background-color:#F4F799; class=matched' : '' }}>{{ !empty($ddv) ? $ddv : '' }}</span>
                </td>
                <td class="brdCell"><span
                        {{ $isDDrv == true || $isDDrv1 == true || $isDDrv2 == true ? 'style=background-color:#F4F799; class=matched' : '' }}>{{ !empty($ddv1) ? $ddv1 : '' }}</span>
                </td>
                <td class="brdCell"><span
                        {{ $isDDrv == true || $isDDrv1 == true || $isDDrv2 == true ? 'style=background-color:#F4F799; class=matched' : '' }}>{{ !empty($ddv2) ? $ddv2 : '' }}</span>
                </td>
                {{-- <td class="brdCell cntCell">

                </td> --}}
            </tr>
            <tr>
                <td class="brdCell"><strong>HDD1</strong></td>
                <td class="brdCell"><span
                        {{ $isHdd1 == true || $isHdd12 == true ? 'style=background-color:#F4F799; class=matched' : '' }}>{{ !empty($hdd) ? $hdd : '' }}</span>
                </td>
                <td class="brdCell"><span
                        {{ $isHdd1 == true || $isHdd11 == true || $isHdd12 == true ? 'style=background-color:#F4F799; class=matched' : '' }}>{{ !empty($hdd1) ? $hdd1 : '' }}</span>
                </td>
                <td class="brdCell"><span
                        {{ $isHdd1 == true || $isHdd11 == true || $isHdd12 == true ? 'style=background-color:#F4F799; class=matched' : '' }}>{{ !empty($hdd13) ? $hdd13 : '' }}</span>
                </td>
                {{-- <td class="brdCell cntCell">

                </td> --}}
            </tr>
            <tr>
                <td class="brdCell"><strong>HDD2</strong></td>
                <td class="brdCell"><span
                        {{ $isHdd2 == true || $isHdd22 == true ? 'style=background-color:#F4F799; class=matched' : '' }}>{{ !empty($hdd12) ? $hdd12 : '' }}</span>
                </td>
                <td class="brdCell"><span
                        {{ $isHdd2 == true || $isHdd21 == true || $isHdd22 == true ? 'style=background-color:#F4F799; class=matched' : '' }}>{{ !empty($hdd2) ? $hdd2 : '' }}</span>
                </td>
                <td class="brdCell"><span
                        {{ $isHdd2 == true || $isHdd21 == true || $isHdd22 == true ? 'style=background-color:#F4F799; class=matched' : '' }}>{{ !empty($hdd22) ? $hdd22 : '' }}</span>
                </td>
                {{-- <td class="brdCell cntCell">

                </td> --}}
            </tr>
            <tr>
                <td class="brdCell"><strong>HDDModels</strong></td>
                <td class="brdCell">
                    <span
                        {{ $isHddModels == true || $isHddModels2 == true ? 'style=background-color:#F4F799; class=matched' : '' }}>{{ !empty($hddm) ? $hddm : '' }}</span>
                </td>
                <td class="brdCell">
                    <span
                        {{ $isHddModels == true || $isHddModels1 == true || $isHddModels2 == true ? 'style=background-color:#F4F799; class=matched' : '' }}>{{ !empty($hddm1) ? $hddm1 : '' }}</span>
                </td>
                <td class="brdCell">
                    <span
                        {{ $isHddModels == true || $isHddModels1 == true || $isHdd22 == true ? 'style=background-color:#F4F799; class=matched' : '' }}>{{ !empty($hddm2) ? $hddm2 : '' }}</span>
                </td>
                {{-- <td class="brdCell cntCell">

                </td> --}}
            </tr>
            <tr>
                <td class="brdCell">Lancard-1 Ip</td>
                <td class="brdCell">{{ !empty($lcIp11) ? $lcIp11 : '' }}</td>
                <td class="brdCell">{{ !empty($lcIp1) ? $lcIp1 : '' }}</td>
                <td class="brdCell">{{ !empty($lcIp112) ? $lcIp112 : '' }}</td>
            </tr>
            <tr>
                <td class="brdCell">Lancard-2 Ip</td>
                <td class="brdCell">{{ !empty($olcIp12) ? $olcIp12 : '' }}</td>
                <td class="brdCell">{{ !empty($lcIp2) ? $lcIp2 : '' }}</td>
                <td class="brdCell">{{ !empty($lcIp22) ? $lcIp22 : '' }}</td>
            </tr>
            <tr>
                <td class="brdCell">Lancard-3 Ip</td>
                <td class="brdCell">{{ !empty($lcIp13) ? $lcIp13 : '' }}</td>
                <td class="brdCell">{{ !empty($lcIp3) ? $lcIp3 : '' }}</td>
                <td class="brdCell">{{ !empty($lcIp32) ? $lcIp32 : '' }}</td>
            </tr>
            <tr>
                <td class="brdCell">CPUSpeed</td>
                <td class="brdCell">{{ !empty($speed) ? $speed : '' }}</td>
                <td class="brdCell">{{ !empty($speed1) ? $speed1 : '' }}</td>
                <td class="brdCell">{{ !empty($speed2) ? $speed2 : '' }}</td>
            </tr>
            <tr>
                <td class="brdCell">MachineName</td>
                <td class="brdCell">{{ !empty($mac) ? $mac : '' }}</td>
                <td class="brdCell">{{ !empty($mac1) ? $mac1 : '' }}</td>
                <td class="brdCell">{{ !empty($mac2) ? $mac2 : '' }}</td>
            </tr>
            <tr>
                <td class="brdCell">MBID</td>
                <td class="brdCell">{{ !empty($mbid) ? $mbid : '' }}</td>
                <td class="brdCell">{{ !empty($mbid1) ? $mbid1 : '' }}</td>
                <td class="brdCell">{{ !empty($mbid2) ? $mbid2 : '' }}</td>
            </tr>
            <tr>
                <td class="brdCell">OS</td>
                <td class="brdCell">{{ !empty($os) ? $os : '' }}</td>
                <td class="brdCell">{{ !empty($os1) ? $os1 : '' }}</td>
                <td class="brdCell">{{ !empty($os2) ? $os2 : '' }}</td>
            </tr>
            <tr>
                <td class="brdCell">BITS</td>
                <td class="brdCell">{{ !empty($bits) ? $bits : '' }}</td>
                <td class="brdCell">{{ !empty($bits1) ? $bits1 : '' }}</td>
                <td class="brdCell">{{ !empty($bits2) ? $bits2 : '' }}</td>
            </tr>
            <tr>
                <td class="brdCell">MBInstCode</td>
                <td class="brdCell">{{ !empty($mbic) ? $mbic : '' }}</td>
                <td class="brdCell">{{ !empty($mbic1) ? $mbic1 : '' }}</td>
                <td class="brdCell">{{ !empty($mbic2) ? $mbic2 : '' }}</td>
            </tr>
            <tr>
                <td class="brdCell">LCInstCode</td>
                <td class="brdCell">{{ !empty($lcic) ? $lcic : '' }}</td>
                <td class="brdCell">{{ !empty($lcic1) ? $lcic1 : '' }}</td>
                <td class="brdCell">{{ !empty($lcic2) ? $lcic2 : '' }}</td>
            </tr>
            <tr>
                <td class="brdCell">HDDInstCode</td>
                <td class="brdCell">{{ !empty($hddic) ? $hddic : '' }}</td>
                <td class="brdCell">{{ !empty($hddic1) ? $hddic1 : '' }}</td>
                <td class="brdCell">{{ !empty($hddic2) ? $hddic2 : '' }}</td>
            </tr>
            {{-- <tr>
                <td class="brdCell">Matched</td>
                <td class="col1"></td>
                <td class="col2"></td>
                <td class="col3"></td>
            </tr> --}}

        </table>
    </div>
</div>
<script src="{{ url('/') }}/public/backend/assets/libs/jquery/jquery.min.js"></script>
<script>
    // $(".cntCell").each("click", function() {
    //     $('.main_container').show()
    //     $('.hardware_details2').hide()
    // })


    $(".cntCell").each(function(index) {
        var totalrows = $(this).siblings('td').children('span').length;
        var matchedtd = $(this).siblings('td').children('span[class=matched]').length;
        var title = $(this).siblings('td:eq(0)').text();
        var text = matchedtd + '/' + totalrows;
        $(this).text(text)
    });
</script>
