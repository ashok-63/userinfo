@if ($licKey)
    @php
        $corpDetails = '';
        try {
            $corpDetails = DB::connection('mysql7')->table('mylic as m')->select('c.corpid', 'emailID as emailID', 'c.Mobile as Mobile', 'c.DlrCode as DlrCode', 'c.FirmName as FirmName', 'c.cState as cState', 'c.District as District', 'c.City as City')->leftJoin('corporatemaster as c', 'm.corpid', '=', 'c.corpid')->where('m.serialno', $licKey)->first();
        } catch (\Exception $e) {
            // return response()->json($e->getMessage());
        }
    @endphp

    @if ($corpDetails)
        <span style="font-size: 13px;font-weight: bold;">
            <span class="highUc"> CorpId : {{ $corpDetails->corpid }}</span> | Email : {{ $corpDetails->emailID }} | Mob
            :
            {{ $corpDetails->Mobile }} | FirmName : {{ $corpDetails->FirmName }} | City : {{ $corpDetails->City }} |
            DlrCode
            : {{ $corpDetails->DlrCode }}
        </span>
    @endif
@endif

<table id="custom_datatable" class="table table-bordered table-hover table-responsive" width="100%">
    <thead class=" text-white" style="background-color: #28a745a6!important;">
        <tr>
            <th>Customer Information</th>
            <th>Installation Information</th>
            <th>Other Details</th>
        </tr>
    </thead>
    <tbody>
        @if (!empty($searchresults) || sizeOf($searchresults) > 0 || $searchresults != '' || $searchresults != null)
            @foreach ($searchresults as $key => $data)
                @php
                    $LoggedUser = auth()->user()->Display_Name;
                    $SerialNo = $data->SerialNo;
                    $SerialNoLength = strlen($SerialNo);
                    $ExpiryDate = $data->ExpiryDate;
                    $InstCode = $data->installCode;
                    $Address = $data->Address;
                    $unlockCode = $data->unlockCode;
                    $installDate_tmp = $data->installDate;
                    $strinstallDate = explode('-', $installDate_tmp);
                    $di = substr($strinstallDate[1], 0, 2); //20
                    $Yi = $strinstallDate[0]; //2024
                    $mi = substr($strinstallDate[2], 0, 2);
                    if ($di <= 12 && $mi <= 12) {
                        $insday = $mi;
                        $insmnth = $di;
                    } else {
                        $insday = $di;
                        $insmnth = $mi;
                    }
                    $installDate = $Yi . '-' . $insday . '-' . $insmnth;

                    $demoDate_tmp = $data->demoDate;
                    $strdemoDate = explode('-', $demoDate_tmp);
                    $di_demo = substr($strdemoDate[1], 0, 2);
                    $Yi_demo = $strdemoDate[0];
                    $mi_demo = substr($strdemoDate[2], 0, 2);
                    if ($di_demo <= 12 && $mi_demo <= 12) {
                        $insday_demo = $mi_demo;
                        $insmnth_demo = $di_demo;
                    } else {
                        $insday_demo = $di_demo;
                        $insmnth_demo = $mi_demo;
                    }
                    $demoDate = $Yi . '-' . $insday_demo . '-' . $insmnth_demo;

                    $AuthoBy = $data->AuthoBy;
                    $BillNo = !empty($data->billNo) ? $data->billNo : '';
                    $installBy = $data->installBy;

                    $Dealer = $data->Dealer;
                    $DealerMobile = $data->DealerMobile;
                    $DealerEmailID = $data->DealerEmailID;
                    $dlrCode = $data->dlrCode;
                    $newCustNoRow = dechex($data->customerNumber);
                    $newCustNo = $data->customerNumber;
                    $custName = $data->Name;
                    $licExpired_div = '';
                    if (!empty($data->old_customerNumber)) {
                        $NotesFolder = 'Notes';
                        $custNo = $data->old_customerNumber;
                    } else {
                        $NotesFolder = 'notesmy';
                        $custNo = $data->customerNumber;
                    }
                    //----- Maintain First CustNo and Lic to show H/W Details -----//
                    $LatestCustNo = empty($LatestCustNo) ? $searchresults[0]->customerNumber : '';
                    $LatestSerialNo = empty($LatestSerialNo) ? $searchresults[0]->SerialNo : '';
                    $LatestCustNo4Notes = empty($LatestCustNo4Notes) ? $custNo : '';
                    //----- Fetch Cutomers Details -----//
                    //fetch customer mobile2 field from table customerlocation
                    $FetchCustomer = DB::table('customerlocation')->where('CustomerNumber', '=', $newCustNo)->orWhere('SerialNo', '=', $SerialNo)->select('CustMob2', 'CorpId', 'CustCountry', 'CustState', 'CustDistrict', 'CustCity')->orderBy('LocationId', 'desc')->first();
                    $clCustMob2 = !empty($FetchCustomer) ? $FetchCustomer->CustMob2 : 'N/A';
                    $clCorpId = !empty($FetchCustomer) ? $FetchCustomer->CorpId : 'N/A';
                    $clCountry = !empty($FetchCustomer) ? $FetchCustomer->CustCountry : 'N/A';
                    $clState = !empty($FetchCustomer) ? $FetchCustomer->CustState : 'N/A';
                    $clDist = !empty($FetchCustomer) ? $FetchCustomer->CustDistrict : 'N/A';
                    $clCity = !empty($FetchCustomer) ? $FetchCustomer->CustCity : 'N/A';
                    //---- If locations not found then try to search with only licNo -----//
                    // if ($clCorpId == 'N/A' && $clCountry == 'N/A' && $clState == 'N/A' && $clDist == 'N/A' && $clCity == 'N/A') {
                    //     $FetchCustomer = DB::table('customerlocation')
                    //         ->where('SerialNo', '=', $SerialNo)
                    //         ->select('CustMob2', 'CorpId', 'CustCountry', 'CustState', 'CustDistrict', 'CustCity')
                    //         ->orderBy('LocationId', 'desc')
                    //         ->first();
                    //     $clCustMob2 = !empty($FetchCustomer) ? $FetchCustomer->CustMob2 : 'N/A';
                    //     $clCorpId = !empty($FetchCustomer->CorpId) ? $FetchCustomer->CorpId : 'N/A';
                    //     $clCountry = !empty($FetchCustomer) ? $FetchCustomer->CustCountry : 'N/A';
                    //     $clState = !empty($FetchCustomer) ? $FetchCustomer->CustState : 'N/A';
                    //     $clDist = !empty($FetchCustomer) ? $FetchCustomer->CustDistrict : 'N/A';
                    //     $clCity = !empty($FetchCustomer) ? $FetchCustomer->CustCity : 'N/A';
                    // }
                    //Lan card no
                    $lanCardNo = $data->lanCardNo;
                    if ($data->lanCardNo == '0200-4C4F-4F50') {
                        $lanCardNo = "<span class='style8'>'.$lanCardNo.'</span>";
                    } elseif (substr($lanCardNo, 0, 2) == 'F1' && strlen($lanCardNo) == 14) {
                        $chkChr = '';
                        $chkChr1 = '';
                        $isProbmatic = false;
                        $lanArr = explode('-', $lanCardNo);
                        foreach ($lanArr as $key => $lanArrValue) {
                            if ($key == 0) {
                                $chkChr = substr($lanArrValue, -2);
                                if (($chkChr >= dechex(48) && $chkChr <= dechex(57)) || ($chkChr >= dechex(65) && $chkChr <= dechex(90)) || ($chkChr >= dechex(97) && $chkChr <= dechex(122))) {
                                    $isProbmatic = false;
                                } else {
                                    $isProbmatic = true;
                                    break;
                                }
                            } else {
                                $chkChr = substr($lanArrValue, 0, 2);
                                $chkChr1 = substr($lanArrValue, -2);
                                if (($chkChr >= dechex(48) && $chkChr <= dechex(57)) || ($chkChr >= dechex(65) && $chkChr <= dechex(90)) || ($chkChr >= dechex(97) && $chkChr <= dechex(122))) {
                                    $isProbmatic = false;
                                } else {
                                    $isProbmatic = true;
                                    break;
                                }
                                if (($chkChr1 >= dechex(48) && $chkChr1 <= dechex(57)) || ($chkChr1 >= dechex(65) && $chkChr1 <= dechex(90)) || ($chkChr1 >= dechex(97) && $chkChr1 <= dechex(122))) {
                                    $isProbmatic = false;
                                } else {
                                    $isProbmatic = true;
                                    break;
                                }
                            }
                        }
                        if ($isProbmatic == true) {
                            $lanCardNo = "<span class='isPrb'>'. $lanCardNo .'</span>";
                        } else {
                            $lanCardNo = "<span>$lanCardNo</span>";
                        }
                    } else {
                        $lanCardNo = "<span>$lanCardNo</span>";
                    }
                    // ----- Special Key Msg Block ------//
                    $Zs3Yr = false;
                    $ZsSrv = false;
                    $FxPcKey = false;
                    $AvgExpKey = false;
                    $Is3Yr = false;
                    $packDays = '';
                    if ($SerialNoLength == 12) {
                        //fetch strSql
                        $strSql = DB::table('AVERAGEEXPIRY')
                            ->where('KEYNO', '=', $SerialNo)
                            ->select(
                                'KEYNO',
                                'addedBy',
                                'userInstDate',
                                'indate',
                                // 'doneDate',
                                \DB::raw('(CASE
                        WHEN AVERAGEEXPIRY.IS3YR = TRUE THEN 1
                        ELSE 0 END) AS IS3YR'),
                            )
                            ->first();
                        if (!empty($strSql)) {
                            $addedBy = $strSql->addedBy;
                            $userInstDate = $strSql->userInstDate;
                            $indate = $strSql->indate;
                            if ($SerialNo == $strSql->KEYNO) {
                                $AvgExpKey = true;
                                if ($strSql->IS3YR == 1) {
                                    $Is3Yr = true;
                                }
                            }
                        }
                    }
                    // if ($AvgExpKey == false) {
                    $SubSerialNo = substr($SerialNo, 0, 1);
                    // if ($SubSerialNo == 'X' || $SubSerialNo == 'L' || $SubSerialNo == 'V' || $SubSerialNo == 'P') {  // commented due to R1
                    //--- Check In SERIALNUMS_ZS3YR Table --//
                    $FetchSERIALNO = DB::table('SERIALNUMS_ZS3YR')->where('SERIALNO', '=', $SerialNo)->select('SERIALNO', 'PackDays')->first();
                    if (!empty($FetchSERIALNO)) {
                        if ($SerialNo == $FetchSERIALNO->SERIALNO) {
                            // $Zs3Yr = true;
                            $keyMsg = '';
                            if ($FetchSERIALNO->PackDays == null) {
                                $packDays = 'ZS 3 Yr'; //R1= If Packdays available then show packdays and if not available then shoe Zs 3Yr || no checking of SerialInitial || Req by GaneshW sir on 08/02/2024
                                // if ($SubSerialNo == 'X') {
                                //     $keyMsg = 'ZS 3 Yr';
                                // } elseif ($SubSerialNo == 'L') {
                                //     $keyMsg = 'AV 3 yr';
                                // } elseif ($SubSerialNo == 'V') {
                                //     $keyMsg = 'TSP 3 yr';
                                // } elseif ($SubSerialNo == 'P') {
                                //     $keyMsg = 'IS 3yr';
                                // }
                            } else {
                                $packDays = 'Packdays :' . $FetchSERIALNO->PackDays;
                            }
                        }
                    }
                    // commented code due to R1
                    // } elseif ($SubSerialNo == 'S' || $SubSerialNo == 'T') {
                    //     //--- Check In SERIALNUMS_ZSSRV Table --//
                    //     $FetchSERIALNO = DB::table('SERIALNUMS_ZSSRV')->where('SERIALNO', '=', $SerialNo)->select('SERIALNO')->first();
                    //     if (!empty($FetchSERIALNO)) {
                    //         if ($SerialNo == $FetchSERIALNO->SERIALNO) {
                    //             $ZsSrv = true;
                    //         }
                    //     }
                    // } elseif ($SerialNoLength == 12 && substr(substr($SerialNo, 0, 3), -1) == 'A' && substr($SerialNo, -1) == 'A') {
                    //     //--- Check In SERIALNUMS_FXPCSKEYS Table --//
                    //     $FetchSERIALNO = DB::table('SERIALNUMS_FXPCSKEYS')->where('SERIALNO', '=', $SerialNo)->select('SERIALNO')->first();
                    //     if (!empty($FetchSERIALNO)) {
                    //         if ($SerialNo == $FetchSERIALNO->SERIALNO) {
                    //             $FxPcKey = true;
                    //         }
                    //     }
                    // }
                    // }
                    $SpecialKeyMsg = '';
                    if ($Zs3Yr == true || $ZsSrv == true || $FxPcKey == true || $AvgExpKey == true) {
                        if ($Zs3Yr == true) {
                            // $SpecialKeyMsg = $packDays;  // If $Zs3Yr=true  then it will print the same msg as $SpecialKeyMsg and $packDays so this is commented || 08/02/2024
                        } elseif ($ZsSrv == true) {
                            $SpecialKeyMsg = 'Server With Z Security';
                        } elseif ($FxPcKey == true) {
                            $SpecialKeyMsg = 'Multi 5PC/10PC';
                        } elseif ($AvgExpKey == true) {
                            if ($Is3Yr == true) {
                                $SpecialKeyMsg = '3 Yr';
                            } else {
                                $SpecialKeyMsg = 'Avg. Exp.';
                            }
                        } else {
                            $SpecialKeyMsg = 'Avg. Exp.';
                        }
                    }
                    // ----- End Special Key Msg Block ------//
                    //Expiry date block
                    $DaysRemain = '';
                    $extraDays = 0;
                    $licExpired = false;
                    if (strpos($ExpiryDate, '/', 1)) {
                        $dtChk_date = Carbon\Carbon::createFromFormat('d/m/Y', $ExpiryDate)->format('Y-m-d');
                    }
                    $dtChk = Carbon\Carbon::parse($dtChk_date);
                    $now = Carbon\Carbon::now()->addDay(-1);
                    $time = $now->diff($dtChk);
                    $date_differnce = $dtChk->diff($now)->format('%y years,%m months and %d days');
                    if ($dtChk > $now && !empty($date_differnce)) {
                        $style = 'color:green';
                        $DaysRemain = $time->y . ' Year' . ', ' . $time->m . ' Month' . ', ' . $time->d . ' Days Remain';
                    } else {
                        $style = 'color: #F27900;';
                        $DaysRemain = 'Expired';
                        $licExpired = true;
                    }
                    if ($licExpired == false) {
                        $LeftSerialNo = substr($SerialNo, 0, 1);
                        $RightSerialNo = substr($SerialNo, -10);

                        $strRenD1 = DB::table('SerialNums')->select('RenewalDone', 'GenDate', DB::raw("(CASE WHEN ActivationCode = '' or ActivationCode is null THEN 'emptyactivationcode' ELSE ActivationCode END) AS ActivationCode"))->Where('SerialInitial', $LeftSerialNo)->where('SerialNo', $RightSerialNo)->first();

                        if ($strRenD1 != null) {
                            $actcode = $strRenD1->ActivationCode;
                            $RenewalDone = $strRenD1->RenewalDone;

                            // print_r($RenewalDone);
                            if (substr($actcode, 0, 11) != 'EPS-OFFLINE') {
                                if ($RenewalDone == false) {
                                    $licExpired_div = '<a href="javascript:void(0)"><span class="square-bracket reactivate_details" data-serial_no="' . $SerialNo . '" data-user_name="' . $LoggedUser . '" data-customer_no="' . $newCustNo . '"><strong>[Reactivate]</strong></span></a>';
                                } elseif ($RenewalDone == true && ($LoggedUser == 'sumeet' || $LoggedUser == 'tusharb' || $LoggedUser == 'sudhirg' || $LoggedUser == 'vikramkumar')) {
                                    $licExpired_div = '<a href="javascript:void(0)"><span class="square-bracket reactivate_details" data-serial_no="' . $SerialNo . '" data-user_name="' . $LoggedUser . '" data-customer_no="' . $newCustNo . '"><strong>[Reactivate]</strong></span></a>';
                                } else {
                                    $licExpired_div = '<span style="color:#999999;"><strong>[Reactivate]</strong></span>';
                                }
                            }
                        }
                    }

                    $log_div = '';
                    $PINMobileNoDiv = '';
                    //strpos - for search string
                    //strlen - if strpos return 0 or any position then strlen return 1 otherwise return 0.
                    if (!empty(strlen(strpos($Address, 'AUTO-REACT*', 0)))) {
                        //---- Pin Mobile No Block ----//
                        $PinMob = DB::table('TrackAutoReactMaster')->where('LicNo', '=', $SerialNo)->select('PINMobile', 'userInputMobile')->orderBy('AutoReactId', 'desc')->first();
                        if (!empty($PinMob)) {
                            $userInputMobile = $PinMob->userInputMobile;
                            $PINMobile = $PinMob->PINMobile;
                            if (!empty($userInputMobile)) {
                                $PINMobileNo = $PINMobile . '(' . $userInputMobile . ')';
                            } else {
                                $PINMobileNo = $PINMobile;
                            }
                            if ($PINMobileNo) {
                                $PINMobileNoDiv = '<br><span class="style8 text-danger"><strong>PIN Mobile:</strong> ' . $PINMobileNo . '</span>';
                            }
                        }
                        //---- End Pin Mobile No Block ----//
                        $log_div = '<a href="javascript:void(0)"><span class="square-bracket show_log" data-serial_no=' . $SerialNo . '>[Log]</span></a>';
                    }
                    $b_div = '| <span><a href="' . url('block_history/' . $SerialNo) . '" target="_blank" class="square-bracket block_history">[B]</a></span>';
                    //--- Check In SERIALNUMS Table --//
                    $LeftSerialNo = substr($SerialNo, 0, 1);
                    $RightSerialNo = substr($SerialNo, -10);
                    $TopUp_div = '';
                    $FetchRenewal = DB::table('SERIALNUMS')->where('SerialInitial', '=', $LeftSerialNo)->where('SerialNo', '=', $RightSerialNo)->select('RenewalDone', 'GenDate')->first();
                    if (!empty($FetchRenewal)) {
                        if ($FetchRenewal->RenewalDone == true) {
                            $NewTopUpPos = strpos($Address, 'NewTopUpLic:', 0); //changed start index from 0 as proposed string starts from 0
                            if ($NewTopUpPos == 0) {
                                $SubTopUp = substr($Address, $NewTopUpPos, 24);
                                $TopUp_div = '<span class="text-danger"> <strong> RenewalDone [' . $SubTopUp . ']</strong></span>';
                            } else {
                                $TopUp_div = '<span class="text-danger"><strong>RenewalDone</strong></span>';
                            }
                        }
                    }
                    $pio_div = '| <span><a href="javascript:void(0)" class="square-bracket pio_details" data-serial_no="' . $SerialNo . '" >PIO</a></span></strong>';
                    if (strpos($InstCode, '-', 1) > 0) {
                        $instCD = explode('-', $InstCode);
                        $HexAdd = 0;
                        foreach ($instCD as $key => $instCD_val) {
                            $HexAdd = $HexAdd + round((int) ('H' . $instCD_val));
                        }
                        $HexAdd = dechex($HexAdd);
                    }
                    $rsUCB = DB::table('UCBlock')->where('unlockCode', '=', $unlockCode)->where('isDelete', '=', false)->select('ucId')->first();
                    $unlock_status = !empty($rsUCB) ? true : false;
                    $unlock_code_class = $unlock_status == true ? 'class=" square-bracket"' : '';
                    $unlockCode_div = '<span id="uc' . $custNo . '" ' . $unlock_code_class . ' >' . $unlockCode . ' <i class="fa fa-clipboard"></i></span><a href="javascript:void(0)"><span class="square-bracket block_unlockcode" data-customer_no="' . $newCustNo . '" data-unlock_code="' . $unlockCode . '" data-serial_no="' . $SerialNo . '">[Block]</span></a>';
                    // $AuthoriedByName = '';
                    if (empty($AuthoBy) && strlen($BillNo) >= 10) {
                        $AuthoriedByName = 'Online Activation';
                    } else {
                        $AuthoriedByName = $AuthoBy;
                    }
                    //---- fetch in date block ---- //
                    $FetchInDate = DB::table('Info_InDates')->where('CustomerNumber', '=', $custNo)->select(DB::raw('DATE_FORMAT(InDate, "%d-%b-%Y %h:%i %p") as fInDate'))->first();
                    $fInDate = !empty($FetchInDate) ? $FetchInDate->fInDate : '';
                    //---- End fetch in date block ---- //
                    //---- fetch SUC block ---- //
                    if (strpos($SerialNo, '-', 0) > 0) {
                        $licArr = explode('-', $SerialNo);
                    } elseif (strpos($SerialNo, '=', 0) > 0) {
                        $licArr = explode('=', $SerialNo);
                    } else {
                        $licArr = [];
                    }
                    $SUCDiv = '';
                    if (!empty($licArr)) {
                        $FetchActiviationCode = DB::table('SerialNums')
                            ->where('SerialInitial', '=', $licArr[0])
                            ->where('SerialNo', '=', $licArr[1])
                            ->select('ActivationCode')
                            ->first();
                        if (!empty($FetchActiviationCode)) {
                            $ActivationCode = $FetchActiviationCode->ActivationCode;
                            if (!empty($unlockCode) && $unlockCode == $ActivationCode) {
                                $SUCDiv = '<br/><strong>SUC: </strong>' . $ActivationCode . ' ';
                            } else {
                                $SUCDiv = '<br /><strong>SUC: </strong><span class="highUc">' . $ActivationCode . '</span>';
                            }
                        }
                    }
                    //---- End fetch SUC block ---- //
                    $rsReactOpNm = DB::table('reactoperators')->where('custNo', '=', $newCustNo)->select('operatorName', 'isOnlineDone', 'reactReason', DB::raw('DATE_FORMAT(InDate, "%d-%b-%Y %h:%i %p") as indate'))->first();
                    $OnlineStatusDiv = '';
                    if (!empty($rsReactOpNm)) {
                        if ($rsReactOpNm->isOnlineDone == true) {
                            $isOffline = 'Online';
                        } else {
                            $isOffline = 'Offline';
                        }
                        $OnlineStatusDiv =
                            '
           <img src=' .
                            asset('/public/backend/assets/images/line.gif') .
                            ' class="img-responsive" style="height:2;width:98%"><br />
           <strong>React By: </strong>' .
                            $rsReactOpNm->operatorName .
                            '<br/>
           <strong>Reason: </strong>' .
                            $rsReactOpNm->reactReason .
                            '<br/>
           <strong>Given Date: </strong>' .
                            $rsReactOpNm->indate .
                            '<br/>
           <strong><span class="indate">' .
                            $isOffline .
                            '</span></strong>';
                    }
                    if (!empty($Address)) {
                        $NewAddress = str_replace('vbCrlf', '<br />', $Address);
                    }
                    if (strpos($NewAddress, 'phone :') > 0) {
                        $NewAddress = wordwrap($NewAddress, strpos($NewAddress, 'phone :'), '<br/>');
                        $Address_div = '<span id="cstAdd' . $newCustNo . '" >' . $NewAddress . '</span>';
                    } else {
                        $Address_div = '<span id="cstAdd' . $newCustNo . '" >' . $NewAddress . '</span>';
                    }
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
                @endphp
                <tr>
                    <td class="col-3" data-order="{{ $data->customerNumber }}">
                        <strong><span>HID: </span></strong>
                        <span>{{ $newCustNoRow }}</span>
                        [{{ $NotesFolder }}]
                        <a href="javascript:void(0)" onclick="OpenHwDetails({{ $newCustNo }},'{{ $SerialNo }}')"
                            data-toggle="tooltip" data-placement="bottom" title="Hardware Details1">HW1</a> |
                        <span><a target="_blank" href="{{ url("/FetchHWDetails2/$newCustNo/$SerialNo") }}"
                                {{-- onclick="OpenSecondHwDetails({{ $newCustNo }},'{{ $SerialNo }}')" --}} data-toggle="tooltip" data-placement="bottom"
                                title="Hardware Details2">HW2</a></span>|
                        <strong><a href="javascript:void(0)" class="square-bracket OpenContactDetails"
                                data-serial-no="{{ $SerialNo }}" data-toggle="tooltip" data-placement="bottom"
                                title="Contact Info"> [C]</a></strong> <br />
                        <div class="contact_details" style="display: none">
                            <span class="pull-right clickable close-icon" data-effect="fadeOut"><i
                                    class="fa fa-times"></i></span>
                            <strong>CMobile: </strong><span class="contact_mob"></span><br>
                            <strong>CEmail: </strong><span class="contact_email"></span><br>
                            <strong>CDate: </strong><span class="contact_date"></span>
                        </div>
                        <strong>Name: </strong><a href="javascript:void(0)"
                            onclick="OpenUserDetails({{ $newCustNo }})" data-toggle="tooltip"
                            data-placement="bottom" title="User Info"></strong><span
                                id="nm{{ $newCustNo }}">{!! wordwrap($data->Name, 40, '<br/>') !!}</span></a><br />
                        <strong>Cp:</strong><a href="javascript:void(0)" onclick="OpenUserDetails({{ $newCustNo }})"
                            data-toggle="tooltip" data-placement="bottom" title="User Info"></strong><span
                                id="sp{{ $newCustNo }}">{{ $data->contactPerson }}</span></a><br />
                        <strong>Mobile: <a href="javascript:void(0)" onclick="OpenUserDetails({{ $newCustNo }})"
                                data-toggle="tooltip" data-placement="bottom" title="User Info"><span
                                    id="cstMob{{ $newCustNo }}">{{ !empty($data->CustMobile) ? $data->CustMobile : 'Add Mob-1' }}</span></a>
                        </strong>

                        <strong>Mob-2: <a href="javascript:void(0)"
                                onclick="OpenUserMobDetails({{ $newCustNo }},'{{ $SerialNo }}','{{ $clCustMob2 }}')"
                                data-toggle="tooltip" data-placement="bottom" title="User Mobile"><span
                                    id="cstMob{{ $newCustNo }}">{{ !empty($clCustMob2) ? $clCustMob2 : 'Add Mob-2' }}</span></a>
                        </strong> <br />
                        <strong>
                            Email: <a href="javascript:void(0)" onclick="OpenUserDetails({{ $newCustNo }})"
                                data-toggle="tooltip" data-placement="bottom" title="User Info"><span
                                    id="cstEmail{{ $newCustNo }}">{{ !empty($data->emailID) ? $data->emailID : 'Add EmailID' }}</span></a><br />
                            <img src="{{ asset('/public/backend/assets/images/line.gif') }}" class="img-responsive"
                                style="height:2;width:98%">
                        </strong>
                        <br />
                        <strong>Lan card no:</strong>{!! $lanCardNo !!}<br />
                        <strong>Comp Name:</strong> {{ $data->computerName }}<br />
                        <div class="row">
                            <button class="btn btn-outline-primary btn-sm mx-1 createNotes"
                                data-custno="{{ $custNo }}" data-notesfolder="{{ $NotesFolder }}"
                                style="width: min-content;"><i class="fas fa-sticky-note"></i> <br>
                                <span> Create Notes </span>
                            </button>
                            <button type="" class="btn btn-outline-primary btn-sm mx-1 "
                                onclick="fnSendSMS('{{ $data->CustMobile }}','{{ $clCustMob2 }}','{{ $unlockCode }}','{{ $SerialNo }}','HelpDesk No.: 09325102020, 02067440810, 02067440800','{{ $DealerMobile }}','{{ $LoggedUser }}')"
                                style="width: min-content;"><i class="fa fa-envelope-open-text"
                                    aria-hidden="true"></i><br>
                                <span> Send SMS
                                </span>
                            </button>
                            <button type="" class="btn btn-outline-primary btn-sm mx-1 "
                                onclick="fnSendEmail('{{ $SerialNo }}','{{ $unlockCode }}','{{ $data->emailID }}')"
                                style="width: min-content;"><i class="fa fa-envelope" aria-hidden="true"></i><br>
                                <span>Send Email </span>
                            </button>
                            <button type="button" class="btn btn-outline-primary btn-sm mx-1" title="Send Renewal WMS"
                                onclick="fnSendReactEmail('{{ $SerialNo }}','{{ $custNo }}','{{ $clCity }}' ,'{{ $data->CustMobile }}','{{ $custName }}')"
                                style="width: min-content;"><i class="fa fa-paper-plane" aria-hidden="true"></i><br>
                                <span>Send WMS
                                </span> </button>
                            <a name="" id="" class="btn btn-outline-primary btn-sm mx-1"
                                href="http://laptracknew.npav.net/viewInfo?srchTxt={{ $SerialNo }}" role="button"
                                target="_blank" style="width: auto">
                                <i class="fas fa-toolbox    "></i>
                                <br>
                                <span>Live H/W</span></a>
                            {{-- Reactivation Requests --}}
                            @php
                                $now = Carbon\Carbon::now();
                                $cur_month = $now->format('M');
                                $cur_year = $now->year;
                                $SerialNo1 = $SerialNo;
                                //prev month and year
                                $prev_month = Carbon\Carbon::now()->subMonths(1)->format('M');
                                $prev_year = Carbon\Carbon::now()->subMonths(1)->format('Y');
                                $file = 'E:\ACTIVATIONDATA\React\\' . $cur_month . '-' . $cur_year . '\\' . $SerialNo1 . '.txt';
                                $prev_file = 'E:\ACTIVATIONDATA\React\\' . $prev_month . '-' . $prev_year . '\\' . $SerialNo1 . '.txt';
                                if (file_exists($file)) {
                                    $path = $file;
                                } elseif (file_exists($prev_file)) {
                                    $path = $prev_file;
                                } else {
                                    $path = '';
                                }
                            @endphp
                            @if (file_exists($file) || file_exists($prev_file))
                                <button type="button"
                                    class="btn btn-outline-danger btn-sm mx-1 btn-icon-only reactReqs"
                                    style="width: min-content;" data-filepath="{{ $path }}"
                                    data-serial-no="{{ $SerialNo1 }}">
                                    <strong>R</strong>
                                </button>
                            @endif
                        </div>
                    </td>
                    <td data-order="{{ $installDate }}">
                        <strong><span>Key:</span></strong>
                        <span>{{ $SerialNo }} <i class="fa fa-clipboard"></i></span>
                        @if ($SpecialKeyMsg)
                            <strong class='text-danger'
                                title="{{ $SpecialKeyMsg }}-{{ $addedBy }}">[{{ $SpecialKeyMsg }}]</strong>
                        @endif
                        @if ($packDays)
                            <strong class='text-danger' title="{{ $packDays }}">[{{ $packDays }}]</strong>
                        @endif
                        {!! $licExpired_div !!}
                        @if ($log_div)
                            {!! $log_div !!}
                        @endif
                        @if ($TopUp_div)
                            {!! $TopUp_div !!}
                        @endif
                        {!! $b_div !!}
                        {!! $pio_div !!}
                        <br />
                        <strong>IC:</strong> <span>{{ $Install_Code }} <i class="fa fa-clipboard"></i></span><br />
                        <strong>UC:</strong>{!! $unlockCode_div !!}<br />
                        <strong>Installed Date:</strong>{{ date('d/m/Y', strtotime($installDate)) }}<br />
                        <strong>Expiry Date:</strong> {{ $ExpiryDate }} <span class="rem-days"
                            style="{{ $style }}"> <strong>[{{ $DaysRemain }}]</strong> </span><br />
                        <img src="{{ asset('/public/backend/assets/images/line.gif') }}" class="img-responsive"
                            style="height:1;width:98%">
                        Authoried By:{{ $AuthoriedByName }}<br />
                        Install By: {{ $installBy }}<br />
                        <strong>DemoDt:</strong> {{ date('d-M-Y g:i A', strtotime($demoDate)) }}
                        @if ($PINMobileNoDiv)
                            {!! $PINMobileNoDiv !!}
                        @endif
                        @if ($fInDate)
                            <br /><strong>InDate: </strong><span
                                class='indate text-danger'><strong>{{ $fInDate }}</strong> </span>
                        @endif
                        @if ($SUCDiv)
                            {!! $SUCDiv !!}
                        @endif
                        @if ($OnlineStatusDiv)
                            {!! $OnlineStatusDiv !!}
                        @endif
                    </td>
                    <td>
                        <a href="javascript:void(0)" onclick="OpenUserDetails({{ $newCustNo }})"
                            data-toggle="tooltip" data-placement="bottom"
                            title="User Info"><strong>Address:</strong></a>{!! $Address_div !!}<br />
                        <div class="row location-box">
                            <div class="col-md-6">
                                <strong>City</strong>: {{ $clCity }}<br />
                                <strong>Dist</strong>: {{ $clDist }}<br />
                                <strong>State</strong>: {{ $clState }}
                            </div>
                            <div class="col-md-6">
                                <strong>Country</strong>: {{ $clCountry }}<br />
                                <strong>CorpID</strong>: {{ !empty($clCorpId) ? $clCorpId : 'N/A' }}<br />
                                <strong>Ip</strong>: {{ $BillNo }}
                            </div>
                        </div>
                        <strong>Dealer: </strong>{!! wordwrap($Dealer, 40, '<br/>') !!}<br />
                        @if ($DealerMobile)
                            <strong>Mobile: </strong>{{ $DealerMobile }}<br />
                        @endif
                        @if ($DealerEmailID)
                            <strong>Email: </strong>{{ $DealerEmailID }}<br />
                        @endif
                        <strong>Dlr Code: </strong>{{ $dlrCode }}<br />

                    </td>
                </tr>
            @endforeach
        @endif
        @if (
            !empty($searchresults_inactive) ||
                sizeOf($searchresults_inactive) > 0 ||
                $searchresults_inactive != '' ||
                $searchresults_inactive != null)
            {{-- <tr>
                <td colspan="3">Records from Serial Table</td>
            </tr> --}}
            @foreach ($searchresults_inactive as $data)
                @php
                    //$type = Helpers::getKeyType($search_txt);
                    $Zs3Yr1 = false;
                    $ZsSrv1 = false;
                    $FxPcKey1 = false;
                    $AvgExpKey1 = false;
                    $Is3Yr1 = false;
                    $Is3YrSN1 = false;
                    $AVPro3Yr1 = false;
                    $packDays1 = '';
                    $explode_lic = explode('-', $search_txt);
                    if ($AvgExpKey1 == false) {
                        if (substr($search_txt, 0, 1) == 'X' || substr($search_txt, 0, 1) == 'L' || substr($search_txt, 0, 1) == 'P') {
                            // Check In serialnums_zs3yr Table
                            $query = DB::table('serialnums_zs3yr')->select('SerialNo', 'PackDays')->where('SerialNo', $search_txt)->first();
                            if (!empty($query)) {
                                $packDays1 = $query->PackDays;
                                if ($query->SerialNo == $search_txt) {
                                    if (substr($search_txt, 0, 1) == 'X') {
                                        $Zs3Yr1 = true;
                                    } elseif (substr($search_txt, 0, 1) == 'L') {
                                        $AVPro3Yr1 = true;
                                    } elseif (substr($search_txt, 0, 1) == 'P') {
                                        $Is3YrSN1 = true;
                                    }
                                }
                            }
                        } elseif (substr($search_txt, 0, 1) == 'S' || substr($search_txt, 0, 1) == 'T') {
                            // Check In serialnums_zssrv Table
                            $query = DB::table('serialnums_zssrv')->select('SerialNo')->where('SerialNo', $search_txt)->first();
                            if (!empty($query)) {
                                if ($query->SerialNo == $search_txt) {
                                    $ZsSrv1 = true;
                                }
                            }
                        } elseif (strlen($search_txt) == 12 && substr($search_txt, -1, 1) == 'A' && substr($search_txt, 2, 1) == 'A') {
                            // Check In SERIALNUMS_FXPCSKEYS Table
                            $query = DB::table('serialnums_fxpcskeys')->select('SerialNo')->where('SerialNo', $search_txt)->first();
                            if (!empty($query)) {
                                if ($query->SerialNo == $search_txt) {
                                    $FxPcKey1 = true;
                                }
                            }
                        }
                    }
                    $SpecialKeyMsg1 = '';
                    if ($Zs3Yr1 == true || $ZsSrv1 == true || $FxPcKey1 == true || $AvgExpKey1 == true || $Is3YrSN1 == true || $AVPro3Yr1 == true) {
                        if ($Zs3Yr1 == true) {
                            $SpecialKeyMsg1 = 'ZS 3 Yr';
                        } elseif ($ZsSrv1 == true) {
                            $SpecialKeyMsg1 = 'Server With Z Security';
                        } elseif ($FxPcKey1 == true) {
                            $SpecialKeyMsg1 = 'Multi 5PC/10PC';
                        } elseif ($Is3YrSN1 == true) {
                            $SpecialKeyMsg1 = 'IS 3 Yr';
                        } elseif ($AVPro3Yr1 == true) {
                            $SpecialKeyMsg1 = 'AVPro 3 Yr';
                        } elseif ($AvgExpKey1 == true) {
                            if ($Is3Yr = true) {
                                $SpecialKeyMsg1 = '3 Yr';
                            } else {
                                $SpecialKeyMsg1 = 'Avg. Exp.';
                            }
                        }
                    }
                    $type = $SpecialKeyMsg1;
                @endphp
                <tr style="vertical-align: bottom;">
                    <td>
                        <h6>Records from Serialnums Table</h6>
                        <strong>UC : </strong> {{ $data->ActivationCode }}
                    </td>
                    <td><strong>Pack Days :</strong> {{ $data->PackDays }}
                        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                        <strong>GenDate :</strong> {{ $data->GenDate }}
                    </td>
                    <td>
                        @if (!empty($packDays1))
                            <strong>PackDays </strong> <small>[From serialnums_zs3yr table]</small> :
                            {{ $packDays1 }}
                        @else
                            <strong>KeyType :</strong>
                            @if (!empty($type))
                                {{ $type }}
                            @endif
                        @endif
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
<br />
<div class="row">
    @if (!empty($searchresults) && !empty($searchresults[0]))
        @php
            $objrs = DB::table('ActHwMaster')
                ->where('CustomerNumber', '=', $searchresults[0]->customerNumber)
                ->where('SerialNo', '=', $searchresults[0]->SerialNo)
                ->orderBy('hwId', 'desc')
                ->select('SerialNo', 'Lc1No', 'Lc2No', 'Lc3No', 'Lc1Name', 'Lc2Name', 'Lc3Name', 'Lc1Ip', 'Lc2Ip', 'Lc3Ip', 'HDD1', 'HDD2', 'HDDModels', 'CPUName', 'CPUSpeed', 'MachineName', 'MBID', 'OS', 'BITS', 'CDVSN', 'DDVSN', 'HDDInstCode', 'LCInstCode', 'MBInstCode', 'Manufacturer', 'Model')
                ->first();
        @endphp
        <div class="col-md-6">
            <span class="span_heading">Hardware Details / Notes :</span>
            <div class="divHwDetails" id="Notes">
                @if (!empty($objrs))
                    <span class="hwDetailsColHead">Key
                        No:</span><span
                        onmouseover='matchWithReactRequest(this);'>{{ !empty($objrs) ? $objrs->SerialNo : '' }}</span><br />
                    <span class="hwDetailsColHead">InstCode:</span><span
                        onmouseover='matchWithReactRequest(this);'>{{ $Install_Code }}</span><br />
                    <span class="hwDetailsColHead">Lancard No
                        1:</span><span
                        onmouseover='matchWithReactRequest(this);'>{{ !empty($objrs) ? $objrs->Lc1No : '' }}</span><br />
                    <span class="hwDetailsColHead">Lancard No
                        2:</span><span
                        onmouseover='matchWithReactRequest(this);'>{{ !empty($objrs) ? $objrs->Lc2No : '' }}</span><br />
                    <span class="hwDetailsColHead">Lancard No
                        3:</span><span
                        onmouseover='matchWithReactRequest(this);'>{{ !empty($objrs) ? $objrs->Lc3No : '' }}</span><br />
                    <span class="hwDetailsColHead">Lancard-1
                        Name:</span><span
                        onmouseover='matchWithReactRequest(this);'>{{ !empty($objrs) ? $objrs->Lc1Name : '' }}</span><br />
                    <span class="hwDetailsColHead">Lancard-2
                        Name:</span><span
                        onmouseover='matchWithReactRequest(this);'>{{ !empty($objrs) ? $objrs->Lc2Name : '' }}</span><br />
                    <span class="hwDetailsColHead">Lancard-3
                        Name:</span><span
                        onmouseover='matchWithReactRequest(this);'>{{ !empty($objrs) ? $objrs->Lc3Name : '' }}</span><br />
                    <span class="hwDetailsColHead">Lancard-1
                        Ip:</span><span
                        onmouseover='matchWithReactRequest(this);'>{{ !empty($objrs) ? $objrs->Lc1Ip : '' }}</span><br />
                    <span class="hwDetailsColHead">Lancard-2
                        Ip:</span><span
                        onmouseover='matchWithReactRequest(this);'>{{ !empty($objrs) ? $objrs->Lc2Ip : '' }}</span><br />
                    <span class="hwDetailsColHead">Lancard-3
                        Ip:</span><span
                        onmouseover='matchWithReactRequest(this);'>{{ !empty($objrs) ? $objrs->Lc3Ip : '' }}</span><br />
                    <span class="hwDetailsColHead">HDD1:</span><span
                        onmouseover="matchWithReactRequest(this,'HDD1');">{{ !empty($objrs) ? $objrs->HDD1 : '' }}</span><br />
                    <span class="hwDetailsColHead">HDD2:</span><span
                        onmouseover="matchWithReactRequest(this,'HDD2');">{{ !empty($objrs) ? $objrs->HDD2 : '' }}</span><br />
                    <span class="hwDetailsColHead">HDDModels:</span><span
                        onmouseover="matchWithReactRequest(this,'HDDModels');">{{ !empty($objrs) ? $objrs->HDDModels : '' }}</span><br />
                    <span class="hwDetailsColHead">CPUName:</span><span
                        onmouseover="matchWithReactRequest(this,'CPUName');">{{ !empty($objrs) ? $objrs->CPUName : '' }}</span><br />
                    <span class="hwDetailsColHead">CPUSpeed:</span><span
                        onmouseover="matchWithReactRequest(this,'CPUSpeed');">{{ !empty($objrs) ? $objrs->CPUSpeed : '' }}</span><br />
                    <span class="hwDetailsColHead">MachineName:</span><span
                        onmouseover="matchWithReactRequest(this);">{{ !empty($objrs) ? $objrs->MachineName : '' }}</span><br />
                    <span class="hwDetailsColHead">MBID:</span><span
                        onmouseover="matchWithReactRequest(this,'MBID');">{{ !empty($objrs) ? $objrs->MBID : '' }}</span><br />
                    <span class="hwDetailsColHead">OS:</span><span
                        onmouseover="matchWithReactRequest(this);">{{ !empty($objrs) ? $objrs->OS : '' }}</span><br />
                    <span class="hwDetailsColHead">BITS:</span><span
                        onmouseover="matchWithReactRequest(this);">{{ !empty($objrs) ? $objrs->BITS : '' }}</span><br />
                    <span class="hwDetailsColHead">CDVSN:</span><span
                        onmouseover="matchWithReactRequest(this,'CDVSN');">{{ !empty($objrs) ? $objrs->CDVSN : '' }}</span><br />
                    <span class="hwDetailsColHead">DDVSN:</span><span
                        onmouseover="matchWithReactRequest(this,'DDVSN');">{{ !empty($objrs) ? $objrs->DDVSN : '' }}</span><br />
                    <span class="hwDetailsColHead">HDDInstCode:</span><span
                        onmouseover="matchWithReactRequest(this,'HDDIC');">{{ !empty($objrs) ? $objrs->HDDInstCode : '' }}</span><br />
                    <span class="hwDetailsColHead">LCInstCode:</span><span
                        onmouseover="matchWithReactRequest(this,'LCIC');">{{ !empty($objrs) ? $objrs->LCInstCode : '' }}</span><br />
                    <span class="hwDetailsColHead">MBInstCode:</span><span
                        onmouseover="matchWithReactRequest(this,'MBIC');">{{ !empty($objrs) ? $objrs->MBInstCode : '' }}</span><br />
                    <span class="hwDetailsColHead">Manufacturer:</span><span
                        onmouseover="matchWithReactRequest(this);">{{ !empty($objrs) ? $objrs->Manufacturer : '' }}</span><br />
                    <span class="hwDetailsColHead">Model:</span><span
                        onmouseover="matchWithReactRequest(this);">{{ !empty($objrs) ? $objrs->Model : '' }}</span>
                    {{-- @else --}}
                @endif
                @if (file_exists('E:/ACTIVATIONDATA/' . $NotesFolder . '/' . $custNo . '.log'))
                    @php
                        $content = file_get_contents('E:/ACTIVATIONDATA/' . $NotesFolder . '/' . $custNo . '.log', 'r');
                    @endphp
                    <br>
                    <br>
                    <span class="text-danger" style="background-color: yellow;">------Notes------</span> <br>
                    @if ($content)
                        @php
                            $explode_text = explode(PHP_EOL, $content);
                        @endphp
                        @foreach ($explode_text as $key => $value)
                            {{ $value }} <br>
                        @endforeach
                    @endif
                @endif
                {{-- @endif --}}
            </div>
        </div>
        <div id="total_records">
            <strong> {{ $SearchCount }}</strong>
        </div>
        <div class="col-md-6">
            <span id="spnReactivate" style="display: none;" class="reactable-lic"> <button
                    class="btn btn-sm btn-outline-warning">REACTIVATE</button> </span>
            <span class="span_heading">Reactivation Request :</span>
            @php
                $now = Carbon\Carbon::now();
                $cur_month = $now->format('M');
                $cur_year = $now->year;
                $SerialNo1 = $SerialNo;
                //prev month and year
                $prev_month = Carbon\Carbon::now()->subMonths(1)->format('M');
                $prev_year = Carbon\Carbon::now()->subMonths(1)->format('Y');
                $file = 'E:\ACTIVATIONDATA\React\\' . $cur_month . '-' . $cur_year . '\\' . $SerialNo1 . '.txt';
                $prev_file = 'E:\ACTIVATIONDATA\React\\' . $prev_month . '-' . $prev_year . '\\' . $SerialNo1 . '.txt';
                if (file_exists($file)) {
                    $content_react = file_get_contents($file, 'r');
                } elseif (file_exists($prev_file)) {
                    $content_react = file_get_contents($prev_file, 'r');
                } else {
                    $content_react = '';
                }
            @endphp
            <div class="divHwDetails" id="div_ReactReq">
                @if ($content_react)
                    @php
                        $explode_text_react = explode(PHP_EOL, $content_react);
                    @endphp
                    @foreach ($explode_text_react as $value_react)
                        {{ $value_react }} <br>
                    @endforeach
                @endif
                {{-- {{$file}} --}}
            </div>
        </div>
    @endif
</div>
{{-- add template Model Start --}}
<div class="modal fade reactReqsModal" data-bs-backdrop="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg reactReqsModal-dialog">
        <div class="modal-content">
            <div class="modal-header reactReqsModal-header">
                <h4 style="font-size: 18px;" class="modal-title" id="myLargeModalLabel">
                    Reactivate </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @php
                    $now = Carbon\Carbon::now();
                    $cur_month = $now->format('M');
                    $cur_year = $now->year;
                    // $SerialNo1 = $SerialNo;
                    //prev month and year
                    $prev_month = Carbon\Carbon::now()->subMonths(1)->format('M');
                    $prev_year = Carbon\Carbon::now()->subMonths(1)->format('Y');
                    if (!empty($SerialNo)) {
                        $file = 'E:\ACTIVATIONDATA\React\\' . $cur_month . '-' . $cur_year . '\\' . $SerialNo . '.txt';
                        $prev_file = 'E:\ACTIVATIONDATA\React\\' . $prev_month . '-' . $prev_year . '\\' . $SerialNo . '.txt';
                        if (file_exists($file)) {
                            $content_react = file_get_contents($file, 'r');
                        } elseif (file_exists($prev_file)) {
                            $content_react = file_get_contents($prev_file, 'r');
                        } else {
                            $content_react = '';
                        }
                    } else {
                        $content_react = '';
                    }
                @endphp
                <div class="divHwDetails">
                    @if ($content_react)
                        @php
                            $explode_text_react = explode(PHP_EOL, $content_react);
                        @endphp
                        @foreach ($explode_text_react as $value_react)
                            {{ $value_react }} <br>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
{{-- add template Model End --}}
