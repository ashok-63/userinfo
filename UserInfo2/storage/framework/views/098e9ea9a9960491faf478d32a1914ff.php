<span style="font-size: 13px;font-weight: bold;" id="corpDetails">
</span>
<table id="custom_datatable" class="table table-bordered table-hover table-responsive" width="100%">
    <thead class=" text-white" style="background-color: #28a745a6!important;">
        <tr>
            <th>#</th>
            <th>Customer Information</th>
            <th>Installation Information</th>
            <th>Other Details</th>
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($searchresults) || sizeOf($searchresults) > 0 || $searchresults != '' || $searchresults != null): ?>
            <?php
                $total_records = sizeOf($searchresults);
                $effective_records = $total_records - 2;
                $required_index = $total_records - 1;
                $rowcnt = 0;
                $rowcnt_index = 0;
                $unlockcode_arr = [];
                foreach ($searchresults as $d) {
                    if (!empty($d->unlockCode)) {
                        $unlockcode_arr[] = $d->unlockCode;
                    }
                }

                /*First Records Installation Date*/
                // $lastKey = $searchresults->keys()->last();
                // $installDate_tmp = $searchresults[$lastKey]->installDate;

            ?>
            <?php $__currentLoopData = $searchresults; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $rowcnt = $rowcnt + 1;
                    $searchresult_key = $key;
                    $LoggedUser = auth()->user()->User_Name;
                    $SerialNo = $data->SerialNo;
                    $SerialNoLength = strlen($SerialNo);

                    if (!empty($data->ExpiryDate)) {
                        $ExpiryDate = $data->ExpiryDate;
                    } else {
                        $expDate_serialNo = DB::table('serialnums')
                            ->where('SerialInitial', explode('-', $SerialNo)[0])
                            ->where('SerialNo', explode('-', $SerialNo)[1])
                            ->value('expiryDate');

                        $ExpiryDate = date('d/m/Y', strtotime($expDate_serialNo));
                    }

                    $InstCode = $data->installCode;
                    $Address = $data->Address;
                    $unlockCode = $data->unlockCode;
                    $count_uc = array_count_values($unlockcode_arr);

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

                    if (
                        str_contains($data->computerName, 'RUC') ||
                        str_contains($data->computerName, 'NUC') ||
                        str_contains($data->computerName, 'TUC')
                    ) {
                        $installDate = $data->installDate;
                        $demoDate = $data->demoDate;
                    } else {
                        $installDate = $Yi . '-' . $insday . '-' . $insmnth;
                        $demoDate =
                            $Yi .
                            '-' .
                            $insday_demo .
                            '-' .
                            $insmnth_demo .
                            ' ' .
                            date('g:i A', strtotime($data->demoDate));
                    }

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
                    $FetchCustomer = DB::table('customerlocation')
                        ->select('CustMob2', 'CorpId', 'CustCountry', 'CustState', 'CustDistrict', 'CustCity')
                        ->where('CustomerNumber', '=', $newCustNo)
                        ->orWhere('SerialNo', '=', $SerialNo)
                        ->orderBy('LocationId', 'desc')
                        ->first();
                    $clCustMob2 = !empty($FetchCustomer) ? $FetchCustomer->CustMob2 : 'N/A';
                    $clCorpId = !empty($FetchCustomer) ? $FetchCustomer->CorpId : 'N/A';
                    $clCountry = !empty($FetchCustomer) ? $FetchCustomer->CustCountry : 'N/A';
                    $clState = !empty($FetchCustomer) ? $FetchCustomer->CustState : 'N/A';
                    $clDist = !empty($FetchCustomer) ? $FetchCustomer->CustDistrict : 'N/A';
                    $clCity = !empty($FetchCustomer) ? $FetchCustomer->CustCity : 'N/A';
                    // Lan card no
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
                                if (
                                    ($chkChr >= dechex(48) && $chkChr <= dechex(57)) ||
                                    ($chkChr >= dechex(65) && $chkChr <= dechex(90)) ||
                                    ($chkChr >= dechex(97) && $chkChr <= dechex(122))
                                ) {
                                    $isProbmatic = false;
                                } else {
                                    $isProbmatic = true;
                                    break;
                                }
                            } else {
                                $chkChr = substr($lanArrValue, 0, 2);
                                $chkChr1 = substr($lanArrValue, -2);
                                if (
                                    ($chkChr >= dechex(48) && $chkChr <= dechex(57)) ||
                                    ($chkChr >= dechex(65) && $chkChr <= dechex(90)) ||
                                    ($chkChr >= dechex(97) && $chkChr <= dechex(122))
                                ) {
                                    $isProbmatic = false;
                                } else {
                                    $isProbmatic = true;
                                    break;
                                }
                                if (
                                    ($chkChr1 >= dechex(48) && $chkChr1 <= dechex(57)) ||
                                    ($chkChr1 >= dechex(65) && $chkChr1 <= dechex(90)) ||
                                    ($chkChr1 >= dechex(97) && $chkChr1 <= dechex(122))
                                ) {
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
                    $FetchSERIALNO = DB::table('SERIALNUMS_ZS3YR')
                        ->where('SERIALNO', '=', $SerialNo)
                        ->select('SERIALNO', 'PackDays')
                        ->first();
                    if (!empty($FetchSERIALNO)) {
                        if ($SerialNo == $FetchSERIALNO->SERIALNO) {
                            // $Zs3Yr = true;
                            $keyMsg = '';
                            if ($FetchSERIALNO->PackDays == null) {
                                $packDays = 'ZS 3 Yr'; //R1= If Packdays available then show packdays and if not available then show Zs 3Yr || no checking of SerialInitial || Req by GaneshW sir on 08/02/2024
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
                    $dtChk_date = '';
                    $extraDays = 0;
                    $licExpired = false;

                    if (!empty($ExpiryDate) && strpos($ExpiryDate, '/', 1)) {
                        $dtChk_date = Carbon\Carbon::createFromFormat('d/m/Y', $ExpiryDate)->format('Y-m-d');
                    }

                    $dtChk = Carbon\Carbon::parse($dtChk_date);
                    $now = Carbon\Carbon::now()->addDay(-1);
                    $time = $now->diff($dtChk);
                    $date_differnce = $dtChk->diff($now)->format('%y years,%m months and %d days');
                    if ($dtChk > $now && !empty($date_differnce)) {
                        $style = 'color:green';

                        $text = '';

                        if ($time->y) {
                            $text .= $time->y . ' Year ';
                        }
                        if ($time->m) {
                            $text .= $time->m . ' Month ';
                        }
                        if ($time->d) {
                            $text .= $time->d . ' Days ';
                        }

                        if ($time->y == 0 && $time->m == 0 && $time->d == 0) {
                            $style = 'color: #F27900;';
                            $text .= '0 Days ';
                        }

                        $DaysRemain = $text . 'Remain';
                    } else {
                        $style = 'color: #ec4561;';
                        $DaysRemain = 'Expired';
                        $licExpired = true;
                    }
                    if ($licExpired == false) {
                        $LeftSerialNo = substr($SerialNo, 0, 1);
                        $RightSerialNo = substr($SerialNo, -10);
                        $strRenD1 = DB::table('SerialNums')
                            ->select(
                                'RenewalDone',
                                'GenDate',
                                DB::raw(
                                    "(CASE WHEN ActivationCode = '' or ActivationCode is null THEN 'emptyactivationcode' ELSE ActivationCode END) AS ActivationCode",
                                ),
                            )
                            ->Where('SerialInitial', $LeftSerialNo)
                            ->where('SerialNo', $RightSerialNo)
                            ->first();
                        if ($strRenD1 != null) {
                            $actcode = $strRenD1->ActivationCode;
                            $RenewalDone = $strRenD1->RenewalDone;

                            if (substr($actcode, 0, 11) != 'EPS-OFFLINE') {
                                if ($RenewalDone == false) {
                                    $licExpired_div =
                                        '<a href="javascript:void(0)"><span class="square-bracket reactivate_details" data-serial_no="' .
                                        $SerialNo .
                                        '" data-user_name="' .
                                        $LoggedUser .
                                        '" data-customer_no="' .
                                        $newCustNo .
                                        '"><strong>[Reactivate]</strong></span></a>';
                                } elseif (
                                    $RenewalDone == true &&
                                    ($LoggedUser == 'sumeet' ||
                                        $LoggedUser == 'tusharb' ||
                                        $LoggedUser == 'sudhirg' ||
                                        $LoggedUser == 'vikramkumar' ||
                                        $LoggedUser == 'ganeshw')
                                ) {
                                    $licExpired_div =
                                        '<a href="javascript:void(0)"><span class="square-bracket reactivate_details" data-serial_no="' .
                                        $SerialNo .
                                        '" data-user_name="' .
                                        $LoggedUser .
                                        '" data-customer_no="' .
                                        $newCustNo .
                                        '"><strong>[Reactivate]</strong></span></a>';
                                } else {
                                    $licExpired_div =
                                        '<span style="color:#999999;"><strong>[Reactivate]</strong></span>';
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
                        $PinMob = DB::table('TrackAutoReactMaster')
                            ->where('LicNo', '=', $SerialNo)
                            ->select('PINMobile', 'userInputMobile')
                            ->orderBy('AutoReactId', 'desc')
                            ->first();
                        if (!empty($PinMob)) {
                            $userInputMobile = $PinMob->userInputMobile;
                            $PINMobile = $PinMob->PINMobile;
                            if (!empty($userInputMobile)) {
                                $PINMobileNo = $PINMobile . '(' . $userInputMobile . ')';
                            } else {
                                $PINMobileNo = $PINMobile;
                            }
                            if ($PINMobileNo) {
                                $PINMobileNoDiv =
                                    '<br><span class="style8 text-danger"><strong>PIN Mobile:</strong> ' .
                                    $PINMobileNo .
                                    '</span>';
                            }
                        }
                        //---- End Pin Mobile No Block ----//
                        $log_div =
                            '<a href="javascript:void(0)"><span class="square-bracket show_log" data-serial_no=' .
                            $SerialNo .
                            '>[Log]</span></a>';
                    }
                    $b_div =
                        '| <span><a href="' .
                        url('block_history/' . $SerialNo) .
                        '" target="_blank" class="square-bracket block_history">[B]</a></span>';
                    //--- Check In SERIALNUMS Table --//
                    $LeftSerialNo = substr($SerialNo, 0, 1);
                    $RightSerialNo = substr($SerialNo, -10);
                    $TopUp_div = '';
                    $FetchRenewal = DB::table('SERIALNUMS')
                        ->where('SerialInitial', '=', $LeftSerialNo)
                        ->where('SerialNo', '=', $RightSerialNo)
                        ->select('RenewalDone', 'GenDate')
                        ->first();
                    if (!empty($FetchRenewal)) {
                        if ($FetchRenewal->RenewalDone == true) {
                            $NewTopUpPos = strpos($Address, 'NewTopUpLic:', 0); //changed start index from 0 as proposed string starts from 0

                            if ($NewTopUpPos != '') {
                                $SubTopUp = substr($Address, $NewTopUpPos, 24);
                                $TopUp_div =
                                    '<span class="text-danger"> <strong> RenewalDone [' .
                                    $SubTopUp .
                                    ']</strong></span>';
                            } else {
                                $TopUp_div = '<span class="text-danger"><strong>RenewalDone</strong></span>';
                            }
                        }
                    }
                    $pio_div =
                        '| <span><a href="javascript:void(0)" class="square-bracket pio_details" data-serial_no="' .
                        $SerialNo .
                        '" >PIO</a></span></strong>';
                    if (strpos($InstCode, '-', 1) > 0) {
                        $instCD = explode('-', $InstCode);
                        $HexAdd = 0;
                        foreach ($instCD as $key => $instCD_val) {
                            $HexAdd = $HexAdd + round((int) ('H' . $instCD_val));
                        }
                        $HexAdd = dechex($HexAdd);
                    }
                    $rsUCB = DB::table('UCBlock')
                        ->where('unlockCode', '=', $unlockCode)
                        ->where('isDelete', '=', false)
                        ->select('ucId')
                        ->first();
                    $unlock_status = !empty($rsUCB) ? true : false;
                    $unlock_code_class =
                        $unlock_status == true ? 'class="square-bracket"' : 'class="square-bracket-success"';

                    $unlockCode_div =
                        '<span
                          id="uc' .
                        $custNo .
                        '" ' .
                        $unlock_code_class .
                        ' >' .
                        $unlockCode .
                        ' <i class="fa fa-clipboard"></i></span><a href="javascript:void(0)"><span class="square-bracket block_unlockcode" data-customer_no="' .
                        $newCustNo .
                        '" data-unlock_code="' .
                        $unlockCode .
                        '" data-serial_no="' .
                        $SerialNo .
                        '">[Block]</span></a>';
                    // $AuthoriedByName = '';
                    if (empty($AuthoBy) && strlen($BillNo) >= 10) {
                        $AuthoriedByName = 'Online Activation';
                    } else {
                        $AuthoriedByName = $AuthoBy;
                    }
                    //---- fetch in date block ---- //
                    $FetchInDate = DB::table('Info_InDates')
                        ->where('CustomerNumber', '=', $custNo)
                        ->select(
                            'InDate as info_indate',
                            DB::raw('DATE_FORMAT(InDate, "%d-%b-%Y %h:%i %p") as fInDate'),
                        )
                        ->first();
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
                                $isLastUCCodeMatched = true;
                                $SUCDiv =
                                    '<br/><strong title="UC from serialnums table" >Current UC: </strong><span class="highUc">' .
                                    $ActivationCode .
                                    '</span>';
                            } else {
                                $isLastUCCodeMatched = false;
                                $SUCDiv =
                                    '<br /><strong title="UC from serialnums table">Current UC: </strong><span class="highUc">' .
                                    $ActivationCode .
                                    '</span>';
                            }
                        }
                    }
                    //---- End fetch SUC block ---- //
                    $rsReactOpNm = DB::table('reactoperators')
                        ->where('custNo', '=', $newCustNo)
                        ->select(
                            'operatorName',
                            'isOnlineDone',
                            'reactReason',
                            'InDate as given_dt',
                            DB::raw('DATE_FORMAT(InDate, "%d-%b-%Y %h:%i %p") as indate'),
                        )
                        ->first();
                    $OnlineStatusDiv = '';
                    if (!empty($rsReactOpNm)) {
                        if ($rsReactOpNm->isOnlineDone == true) {
                            $isOffline = 'Online';
                        } else {
                            $isOffline = 'Offline';
                        }
                        $dtChk_react = Carbon\Carbon::parse($dtChk_date);
                        $dtChk2_react = Carbon\Carbon::parse($rsReactOpNm->given_dt);
                        $time_react = $dtChk2_react->diff($dtChk_react);
                        $date_differnce_react = $dtChk_react
                            ->diff($dtChk2_react)
                            ->format('%y years,%m months and %d days');
                        if ($dtChk_react > $dtChk2_react && !empty($date_differnce_react)) {
                            $style = 'color:green';

                            $text_react = 'Reactivation given before <strong>';

                            if ($time_react->y) {
                                $text_react .= $time_react->y . ' Years, ';
                            }
                            if ($time_react->m) {
                                $text_react .= $time_react->m . ' Months, ';
                            }
                            if ($time_react->d) {
                                $text_react .= $time_react->d . ' Days </strong> remained to expire.';
                            }

                            $DaysRemain_react = $text_react;
                        } else {
                            $DaysRemain_react = ' ';
                        }

                        $OnlineStatusDiv =
                            '</br><strong>React By: </strong>' .
                            $rsReactOpNm->operatorName .
                            '<br/>
                                <strong>Reason: </strong>' .
                            $rsReactOpNm->reactReason .
                            '<br/>
                              <strong>Given Date: </strong>' .
                            $rsReactOpNm->indate .
                            ' </br> <span class="text-danger">' .
                            $DaysRemain_react .
                            '</span>' .
                            '<br/>
                              <strong><span class="indate">' .
                            $isOffline .
                            '</span></strong>';
                    }
                    if (!empty($Address)) {
                        $NewAddress = str_replace('vbCrlf', '<br />', $Address);
                    }
                    if (!empty($NewAddress)) {
                        if (strpos($NewAddress, 'phone :') > 0) {
                            $NewAddress = wordwrap($NewAddress, strpos($NewAddress, 'phone :'), '<br/>');
                            $Address_div = '<span id="cstAdd' . $newCustNo . '" >' . $NewAddress . '</span>';
                        } else {
                            $Address_div = '<span id="cstAdd' . $newCustNo . '" >' . $NewAddress . '</span>';
                        }
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
                    $IC_basedOn = '';
                    if (
                        str_contains(substr($installCodeRev, 0, 4), '683') ||
                        str_contains(substr($installCodeRev, 0, 4), '68B')
                    ) {
                        $IC_basedOn = 'Motherboard';
                    } elseif (str_contains(substr($installCodeRev, 0, 4), '6CD')) {
                        $IC_basedOn = 'HDD';
                    } else {
                        $IC_basedOn = 'LAN';
                    }

                    $notesFile = 'E:/ACTIVATIONDATA/Remark/' . $custNo . '.log';
                    // $icon = '';
                    $newContent = '';
                    if (file_exists($notesFile)) {
                        $content = file_get_contents($notesFile, 'r');
                        // $newContent = str_replace('Date', PHP_EOL . '| Date ', $content);
                        $newContent = $content;
                        // if ($newContent) {
                        //     $icon = '<marquee style="font-weight: bold"> Note :  ' . $newContent . '</marquee>';
                        // }
                    }
                ?>
                <tr>
                    <td class="text-center" > <strong title="Sr.No"> <?php echo e($rowcnt); ?></strong></td>

                    <td class="col-3">
                        <strong><span>HID: </span></strong>
                        <span><?php echo e($newCustNoRow); ?></span>
                        [<?php echo e($NotesFolder); ?>]
                        <a href="javascript:void(0)" onclick="OpenHwDetails(<?php echo e($newCustNo); ?>,'<?php echo e($SerialNo); ?>')"
                            data-toggle="tooltip" data-placement="bottom" title="Hardware Details1">HW1</a> |
                        <span><a target="_blank" href="<?php echo e(url("/FetchHWDetails2/$newCustNo/$SerialNo")); ?>"
                                 data-toggle="tooltip" data-placement="bottom"
                                title="Hardware Details2">HW2</a></span>|
                        <strong><a href="javascript:void(0)" class="square-bracket OpenContactDetails"
                                data-serial-no="<?php echo e($SerialNo); ?>" data-toggle="tooltip" data-placement="bottom"
                                title="Contact Info"> [C]</a></strong>
                        <br />

                        <div class="contact_details" style="display: none">
                            <span class="pull-right clickable close-icon" data-effect="fadeOut"><i
                                    class="fa fa-times"></i></span>
                            <strong>CMobile: </strong><span class="contact_mob"></span><br>
                            <strong>CEmail: </strong><span class="contact_email"></span><br>
                            <strong>CDate: </strong><span class="contact_date"></span>
                        </div>

                        <strong>Name: </strong><a href="javascript:void(0)"
                            onclick="OpenUserDetails(<?php echo e($newCustNo); ?>)" data-toggle="tooltip" data-placement="bottom"
                            title="User Info"></strong><span
                                id="nm<?php echo e($newCustNo); ?>"><?php echo wordwrap($data->Name, 40, '<br/>'); ?></span></a><br />
                        <strong>Cp:</strong><a href="javascript:void(0)" onclick="OpenUserDetails(<?php echo e($newCustNo); ?>)"
                            data-toggle="tooltip" data-placement="bottom" title="User Info"></strong><span
                                id="sp<?php echo e($newCustNo); ?>"><?php echo e($data->contactPerson); ?></span></a><br />
                        <strong>Mobile: <a href="javascript:void(0)" onclick="OpenUserDetails(<?php echo e($newCustNo); ?>)"
                                data-toggle="tooltip" data-placement="bottom" title="User Info"><span
                                    id="cstMob<?php echo e($newCustNo); ?>"><?php echo e(!empty($data->CustMobile) ? $data->CustMobile : 'Add Mob-1'); ?></span></a>
                        </strong>
                        <strong>Mob-2: <a href="javascript:void(0)"
                                onclick="OpenUserMobDetails(<?php echo e($newCustNo); ?>,'<?php echo e($SerialNo); ?>','<?php echo e($clCustMob2); ?>')"
                                data-toggle="tooltip" data-placement="bottom" title="User Mobile"><span
                                    id="cstMob<?php echo e($newCustNo); ?>"><?php echo e(!empty($clCustMob2) ? $clCustMob2 : 'Add Mob-2'); ?></span></a>
                        </strong> <br />
                        <strong>
                            Email: <a href="javascript:void(0)" onclick="OpenUserDetails(<?php echo e($newCustNo); ?>)"
                                data-toggle="tooltip" data-placement="bottom" title="User Info"><span
                                    id="cstEmail<?php echo e($newCustNo); ?>"><?php echo e(!empty($data->emailID) ? $data->emailID : 'Add EmailID'); ?></span></a>
                        </strong>
                        <br />
                        <strong>Lan card no:</strong><?php echo $lanCardNo; ?><br />
                        <strong>Comp Name:</strong> <?php echo e($data->computerName); ?><br />
                        <div class="row">
                            <button class="btn btn-outline-primary btn-sm mx-1 createNotes"
                                data-custno="<?php echo e($custNo); ?>" data-notesfolder="<?php echo e($NotesFolder); ?>"
                                style="width: min-content;"><i class="fas fa-sticky-note"></i> <br>
                                <span> Create Notes </span>
                            </button>
                            <button type="" class="btn btn-outline-primary btn-sm mx-1 "
                                onclick="fnSendSMS('<?php echo e($data->CustMobile); ?>','<?php echo e($clCustMob2); ?>','<?php echo e($unlockCode); ?>','<?php echo e($SerialNo); ?>','HelpDesk No.: 09325102020, 02067440810, 02067440800','<?php echo e($DealerMobile); ?>','<?php echo e($LoggedUser); ?>')"
                                style="width: min-content;"><i class="fa fa-envelope-open-text"
                                    aria-hidden="true"></i><br>
                                <span> Send SMS
                                </span>
                            </button>
                            <button type="" class="btn btn-outline-primary btn-sm mx-1 "
                                onclick="fnSendEmail('<?php echo e($SerialNo); ?>','<?php echo e($unlockCode); ?>','<?php echo e($data->emailID); ?>')"
                                style="width: min-content;"><i class="fa fa-envelope" aria-hidden="true"></i><br>
                                <span>Send Email </span>
                            </button>
                            <button type="button" class="btn btn-outline-primary btn-sm mx-1" title="Send Renewal WMS"
                                onclick="fnSendReactEmail('<?php echo e($SerialNo); ?>','<?php echo e($custNo); ?>','<?php echo e($clCity); ?>' ,'<?php echo e($data->CustMobile); ?>','<?php echo e($custName); ?>')"
                                style="width: min-content;"><i class="fa fa-paper-plane" aria-hidden="true"></i><br>
                                <span>Send WMS
                                </span>
                            </button>
                            <a name="" id="" class="btn btn-outline-primary btn-sm mx-1 livehwbtn"
                                href="http://laptracknew.npav.net/viewInfo?srchTxt=<?php echo e($SerialNo); ?>" role="button"
                                target="_blank" style="width: auto">
                                <i class="fas fa-toolbox"></i>
                                <br>
                                <span>Live H/W</span>


                            </a>

                            
                            <?php
                                $now = Carbon\Carbon::now();
                                $cur_month = $now->format('M');
                                $cur_year = $now->year;
                                $SerialNo1 = $SerialNo;
                                //prev month and year
                                $prev_month = Carbon\Carbon::now()->subMonths(1)->format('M');
                                $prev_year = Carbon\Carbon::now()->subMonths(1)->format('Y');
                                $file =
                                    'E:\ACTIVATIONDATA\React\\' .
                                    $cur_month .
                                    '-' .
                                    $cur_year .
                                    '\\' .
                                    $SerialNo1 .
                                    '.txt';
                                $prev_file =
                                    'E:\ACTIVATIONDATA\React\\' .
                                    $prev_month .
                                    '-' .
                                    $prev_year .
                                    '\\' .
                                    $SerialNo1 .
                                    '.txt';
                                if (file_exists($file)) {
                                    $path = $file;
                                } elseif (file_exists($prev_file)) {
                                    $path = $prev_file;
                                } else {
                                    $path = '';
                                }
                            ?>
                            <?php if(file_exists($file) || file_exists($prev_file)): ?>
                                <button type="button"
                                    class="btn btn-outline-danger btn-sm mx-1 btn-icon-only reactReqs"
                                    style="width: min-content;" data-filepath="<?php echo e($path); ?>"
                                    data-serial-no="<?php echo e($SerialNo1); ?>">
                                    <strong>R</strong>
                                </button>
                            <?php endif; ?>


                            <br>

                            <span> <img class="cntloader d-none"
                                    src="<?php echo e(url('public/backend/assets/images/cntloader.gif')); ?>" alt=""
                                    class="hwCntLoader" style="width: 25%;margin: -30px 0;"> <strong
                                    class="liveHwCnt text-danger"> </strong> </span>
                        </div>
                    </td>
                    <td class="col-5" >
                        <div class="col-12" style="display: flex">
                            <div class="col-7">
                                <strong><span>Key:</span></strong>
                                <span><?php echo e($SerialNo); ?> <i class="fa fa-clipboard"></i></span>
                                <?php if($SpecialKeyMsg): ?>
                                    <strong class='text-danger'
                                        title="<?php echo e($SpecialKeyMsg); ?> | <?php echo e($addedBy); ?> | <?php echo e($indate); ?>">[<?php echo e($SpecialKeyMsg); ?>]</strong>
                                <?php endif; ?>
                                <?php if($packDays): ?>
                                    <strong class='text-danger'
                                        title="<?php echo e($packDays); ?>">[<?php echo e($packDays); ?>]</strong>
                                <?php endif; ?>
                                <?php echo $licExpired_div; ?>

                                <?php if($log_div): ?>
                                    <?php echo $log_div; ?>

                                <?php endif; ?>
                                <?php if($TopUp_div): ?>
                                    <?php echo $TopUp_div; ?>

                                <?php endif; ?>
                                <?php echo $b_div; ?>

                                <?php echo $pio_div; ?>

                                <br />
                                <strong>IC:</strong> <span><?php echo e($Install_Code); ?> <i class="fa fa-clipboard"></i> </span>
                                &nbsp;
                                <span class="badge badge-sm badge-success"
                                    title="IC based on <?php echo e($IC_basedOn); ?>"><?php echo e($IC_basedOn); ?></span>
                                <br />
                                <strong>UC:</strong>
                                <span <?php if($isLastUCCodeMatched == true): ?> class="highUc" <?php endif; ?>><?php echo $unlockCode_div; ?>

                                </span> | <?php if(in_array($unlockCode, $unlockcode_arr)): ?>
                                    <strong title="UC repeated <?php echo e($count_uc[$unlockCode]); ?> times. ">
                                        <?php echo e($count_uc[$unlockCode]); ?></strong>
                                <?php endif; ?>

                                <?php if($rowcnt_index > 0 && $search_by == 'lic'): ?>
                                    | <button class="btn-sm btn btn-outline-primary addSureBlockChkbx"
                                        data-serialno="<?php echo e($SerialNo); ?>" data-custno="<?php echo e($newCustNo); ?>"
                                        data-checked="true" title="Add to sure block manually"
                                        style="vertical-align: middle;" role="button">Block UC</button>
                                <?php endif; ?>

                                <br />
                                <strong>Installed Date:</strong><?php echo e(date('d/m/Y', strtotime($installDate))); ?><br />
                                <strong>Expiry Date:</strong> <?php echo e($ExpiryDate); ?>

                                <span class="rem-days" style="<?php echo e($style); ?>"> <strong>[<?php echo e($DaysRemain); ?>]
                                    </strong>
                                </span><br>
                                ------------------------------------- <br>

                                Activation:<?php echo e($AuthoriedByName); ?> | Install By: <?php echo e($installBy); ?><br />

                                <strong>DemoDt:</strong> <?php echo e(date('d-M-Y g:i A', strtotime($demoDate))); ?>

                                <?php if($PINMobileNoDiv): ?>
                                    <?php echo $PINMobileNoDiv; ?>

                                <?php endif; ?>
                                <?php if($fInDate): ?>
                                    <br />
                                    <?php if($search_by == 'lic'): ?>
                                        <?php if($searchresult_key == $required_index): ?>
                                            <strong>InDate:</strong>
                                        <?php else: ?>
                                            <strong title="Indate">ReactDt: </strong>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <strong>InDate: </strong>
                                    <?php endif; ?>
                                    <span class='indate text-danger'><strong><?php echo e($fInDate); ?></strong> </span>
                                <?php endif; ?>
                                <?php if($SUCDiv): ?>
                                    <?php echo $SUCDiv; ?>

                                <?php endif; ?>
                                <?php if($OnlineStatusDiv): ?>
                                    <?php echo $OnlineStatusDiv; ?>

                                <?php endif; ?>
                            </div>
                            <div class="col-5">
                                <div style="text-align: center;">
                                    <button type="button" class="btn btn-sm btn-outline-primary addRemark"
                                        data-custno="<?php echo e($custNo); ?>">
                                        <i class="fa fa-comment " aria-hidden="true"
                                            title="Add remark for this key."></i>
                                        Add Remark</button>
                                </div>
                                <?php if($newContent): ?>
                                    <div class="col-12"
                                        style="height: 250px;overflow-y: scroll;text-wrap: pretty;border: 1px solid #dee2e6;padding: 0 2px 0 4px ">
                                        <strong>Remark :</strong>
                                        <br>
                                        <?php
                                            $explode_text = explode(PHP_EOL, $newContent);
                                        ?>
                                        <?php $__currentLoopData = $explode_text; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key1 => $value1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php echo e($value1); ?> <br>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <img src="<?php echo e(asset('/public/backend/assets/images/line.gif')); ?>" class="img-responsive"
                            style="height:1;width:98%">
                    </td>
                    <td class="col-4">
                        <a href="javascript:void(0)" onclick="OpenUserDetails(<?php echo e($newCustNo); ?>)"
                            data-toggle="tooltip" data-placement="bottom"
                            title="User Info"><strong>Address:</strong></a><?php echo $Address_div ?? ''; ?><br />
                        <div class="row location-box">
                            <div class="col-md-6">
                                <strong>City</strong>: <?php echo e($clCity); ?><br />
                                <strong>Dist</strong>: <?php echo e($clDist); ?><br />
                                <strong>State</strong>: <?php echo e($clState); ?>

                            </div>
                            <div class="col-md-6">
                                <strong>Country</strong>: <?php echo e($clCountry); ?><br />
                                <strong>CorpID</strong>: <?php echo e(!empty($clCorpId) ? $clCorpId : 'N/A'); ?><br />
                                <strong>Ip</strong>: <?php echo e($BillNo); ?>

                            </div>
                        </div>
                        <strong>Dealer: </strong><?php echo wordwrap($Dealer, 40, '<br/>'); ?><br />
                        <?php if($DealerMobile): ?>
                            <strong>Mobile: </strong><?php echo e($DealerMobile); ?><br />
                        <?php endif; ?>
                        <?php if($DealerEmailID): ?>
                            <strong>Email: </strong><?php echo e($DealerEmailID); ?><br />
                        <?php endif; ?>
                        <strong>Dlr Code: </strong><?php echo e($dlrCode); ?><br />

                        <?php if(
                            $LoggedUser == 'sumeet' ||
                                $LoggedUser == 'tusharb' ||
                                $LoggedUser == 'sudhirg' ||
                                $LoggedUser == 'vikramkumar' ||
                                $LoggedUser == 'ganeshw'): ?>
                            <button class="btn btn-sm btn-primary fetchKey my-3" data-serialno=<?php echo e($SerialNo); ?>

                                style="display: none">Fetch New Reward Key</button>
                        <?php endif; ?>

                    </td>
                </tr>


                <?php
                    $rowcnt_index++;
                ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
        <?php if(
            !empty($searchresults_inactive) ||
                sizeOf($searchresults_inactive) > 0 ||
                $searchresults_inactive != '' ||
                $searchresults_inactive != null): ?>
            
            <?php $__currentLoopData = $searchresults_inactive; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key_inactive => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
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
                        if (
                            substr($search_txt, 0, 1) == 'X' ||
                            substr($search_txt, 0, 1) == 'L' ||
                            substr($search_txt, 0, 1) == 'P'
                        ) {
                            // Check In serialnums_zs3yr Table
                            $query = DB::table('serialnums_zs3yr')
                                ->select('SerialNo', 'PackDays')
                                ->where('SerialNo', $search_txt)
                                ->first();
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
                            $query = DB::table('serialnums_zssrv')
                                ->select('SerialNo')
                                ->where('SerialNo', $search_txt)
                                ->first();
                            if (!empty($query)) {
                                if ($query->SerialNo == $search_txt) {
                                    $ZsSrv1 = true;
                                }
                            }
                        } elseif (
                            strlen($search_txt) == 12 &&
                            substr($search_txt, -1, 1) == 'A' &&
                            substr($search_txt, 2, 1) == 'A'
                        ) {
                            // Check In SERIALNUMS_FXPCSKEYS Table
                            $query = DB::table('serialnums_fxpcskeys')
                                ->select('SerialNo')
                                ->where('SerialNo', $search_txt)
                                ->first();
                            if (!empty($query)) {
                                if ($query->SerialNo == $search_txt) {
                                    $FxPcKey1 = true;
                                }
                            }
                        }
                    }
                    $SpecialKeyMsg1 = '';
                    if (
                        $Zs3Yr1 == true ||
                        $ZsSrv1 == true ||
                        $FxPcKey1 == true ||
                        $AvgExpKey1 == true ||
                        $Is3YrSN1 == true ||
                        $AVPro3Yr1 == true
                    ) {
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
                ?>
                <tr style="vertical-align: bottom;">
                    <td class="text-center"> <strong title="Sr.No"> <?php echo e($key_inactive + 1); ?></strong></td>
                    </td>
                    <td>
                        <h6>Records from Serialnums Table</h6>
                        <strong>UC : </strong> <?php echo e($data->ActivationCode); ?>

                    </td>
                    <td><strong>Pack Days :</strong> <?php echo e($data->PackDays); ?>

                        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                        <strong>GenDate :</strong> <?php echo e($data->GenDate); ?>

                    </td>
                    <td>
                        <?php if(!empty($packDays1)): ?>
                            <strong>PackDays </strong> <small>[From serialnums_zs3yr table]</small> :
                            <?php echo e($packDays1); ?>

                        <?php else: ?>
                            <strong>KeyType :</strong>
                            <?php if(!empty($type)): ?>
                                <?php echo e($type); ?>

                            <?php endif; ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </tbody>
</table>
<br />
<div class="row">
    <?php if(!empty($searchresults) && !empty($searchresults[0])): ?>
        <?php
            $objrs = DB::table('ActHwMaster')
                ->where('CustomerNumber', '=', $searchresults[0]->customerNumber)
                ->where('SerialNo', '=', $searchresults[0]->SerialNo)
                ->orderBy('hwId', 'desc')
                ->select(
                    'SerialNo',
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
                    'HDDInstCode',
                    'LCInstCode',
                    'MBInstCode',
                    'Manufacturer',
                    'Model',
                )
                ->first();
        ?>
        <div class="col-md-6">
            <span class="span_heading">Hardware Details / Notes :</span>
            <div class="divHwDetails" id="Notes">
                <?php if(!empty($objrs)): ?>
                    <span class="hwDetailsColHead">Key
                        No:</span>
                    <span
                        onmouseover='matchWithReactRequest(this);'><?php echo e(!empty($objrs) ? $objrs->SerialNo : ''); ?></span><br />
                    <span class="hwDetailsColHead">InstCode:</span>
                    <span onmouseover='matchWithReactRequest(this);'><?php echo e($Install_Code); ?></span><br />
                    <span class="hwDetailsColHead">Lancard No
                        1:</span>
                    <span
                        onmouseover='matchWithReactRequest(this);'><?php echo e(!empty($objrs) ? $objrs->Lc1No : ''); ?></span><br />
                    <span class="hwDetailsColHead">Lancard No
                        2:</span>
                    <span
                        onmouseover='matchWithReactRequest(this);'><?php echo e(!empty($objrs) ? $objrs->Lc2No : ''); ?></span><br />
                    <span class="hwDetailsColHead">Lancard No
                        3:</span>
                    <span
                        onmouseover='matchWithReactRequest(this);'><?php echo e(!empty($objrs) ? $objrs->Lc3No : ''); ?></span><br />
                    <span class="hwDetailsColHead">Lancard-1
                        Name:</span>
                    <span
                        onmouseover='matchWithReactRequest(this);'><?php echo e(!empty($objrs) ? $objrs->Lc1Name : ''); ?></span><br />
                    <span class="hwDetailsColHead">Lancard-2
                        Name:</span>
                    <span
                        onmouseover='matchWithReactRequest(this);'><?php echo e(!empty($objrs) ? $objrs->Lc2Name : ''); ?></span><br />
                    <span class="hwDetailsColHead">Lancard-3
                        Name:</span>
                    <span
                        onmouseover='matchWithReactRequest(this);'><?php echo e(!empty($objrs) ? $objrs->Lc3Name : ''); ?></span><br />
                    <span class="hwDetailsColHead">Lancard-1
                        Ip:</span>
                    <span
                        onmouseover='matchWithReactRequest(this);'><?php echo e(!empty($objrs) ? $objrs->Lc1Ip : ''); ?></span><br />
                    <span class="hwDetailsColHead">Lancard-2
                        Ip:</span>
                    <span
                        onmouseover='matchWithReactRequest(this);'><?php echo e(!empty($objrs) ? $objrs->Lc2Ip : ''); ?></span><br />
                    <span class="hwDetailsColHead">Lancard-3
                        Ip:</span>
                    <span
                        onmouseover='matchWithReactRequest(this);'><?php echo e(!empty($objrs) ? $objrs->Lc3Ip : ''); ?></span><br />
                    <span class="hwDetailsColHead">HDD1:</span>
                    <span
                        onmouseover="matchWithReactRequest(this,'HDD1');"><?php echo e(!empty($objrs) ? $objrs->HDD1 : ''); ?></span><br />
                    <span class="hwDetailsColHead">HDD2:</span>
                    <span
                        onmouseover="matchWithReactRequest(this,'HDD2');"><?php echo e(!empty($objrs) ? $objrs->HDD2 : ''); ?></span><br />
                    <span class="hwDetailsColHead">HDDModels:</span>
                    <span
                        onmouseover="matchWithReactRequest(this,'HDDModels');"><?php echo e(!empty($objrs) ? $objrs->HDDModels : ''); ?></span><br />
                    <span class="hwDetailsColHead">CPUName:</span>
                    <span
                        onmouseover="matchWithReactRequest(this,'CPUName');"><?php echo e(!empty($objrs) ? $objrs->CPUName : ''); ?></span><br />
                    <span class="hwDetailsColHead">CPUSpeed:</span>
                    <span
                        onmouseover="matchWithReactRequest(this,'CPUSpeed');"><?php echo e(!empty($objrs) ? $objrs->CPUSpeed : ''); ?></span><br />
                    <span class="hwDetailsColHead">MachineName:</span>
                    <span
                        onmouseover="matchWithReactRequest(this);"><?php echo e(!empty($objrs) ? $objrs->MachineName : ''); ?></span><br />
                    <span class="hwDetailsColHead">MBID:</span>
                    <span
                        onmouseover="matchWithReactRequest(this,'MBID');"><?php echo e(!empty($objrs) ? $objrs->MBID : ''); ?></span><br />
                    <span class="hwDetailsColHead">OS:</span>
                    <span
                        onmouseover="matchWithReactRequest(this);"><?php echo e(!empty($objrs) ? $objrs->OS : ''); ?></span><br />
                    <span class="hwDetailsColHead">BITS:</span>
                    <span
                        onmouseover="matchWithReactRequest(this);"><?php echo e(!empty($objrs) ? $objrs->BITS : ''); ?></span><br />
                    <span class="hwDetailsColHead">CDVSN:</span>
                    <span
                        onmouseover="matchWithReactRequest(this,'CDVSN');"><?php echo e(!empty($objrs) ? $objrs->CDVSN : ''); ?></span><br />
                    <span class="hwDetailsColHead">DDVSN:</span>
                    <span
                        onmouseover="matchWithReactRequest(this,'DDVSN');"><?php echo e(!empty($objrs) ? $objrs->DDVSN : ''); ?></span><br />
                    <span class="hwDetailsColHead">HDDInstCode:</span>
                    <span
                        onmouseover="matchWithReactRequest(this,'HDDIC');"><?php echo e(!empty($objrs) ? $objrs->HDDInstCode : ''); ?></span><br />
                    <span class="hwDetailsColHead">LCInstCode:</span>
                    <span
                        onmouseover="matchWithReactRequest(this,'LCIC');"><?php echo e(!empty($objrs) ? $objrs->LCInstCode : ''); ?></span><br />
                    <span class="hwDetailsColHead">MBInstCode:</span>
                    <span
                        onmouseover="matchWithReactRequest(this,'MBIC');"><?php echo e(!empty($objrs) ? $objrs->MBInstCode : ''); ?></span><br />
                    <span class="hwDetailsColHead">Manufacturer:</span>
                    <span
                        onmouseover="matchWithReactRequest(this);"><?php echo e(!empty($objrs) ? $objrs->Manufacturer : ''); ?></span><br />
                    <span class="hwDetailsColHead">Model:</span>
                    <span onmouseover="matchWithReactRequest(this);"><?php echo e(!empty($objrs) ? $objrs->Model : ''); ?></span>
                    
                <?php endif; ?>
                <?php if(file_exists('E:/ACTIVATIONDATA/' . $NotesFolder . '/' . $custNo . '.log')): ?>
                    <?php
                        $content = file_get_contents('E:/ACTIVATIONDATA/' . $NotesFolder . '/' . $custNo . '.log', 'r');
                    ?>
                    <br>
                    <br>
                    <span class="text-danger" style="background-color: yellow;">------Notes------</span> <br>
                    <?php if($content): ?>
                        <?php
                            $explode_text = explode(PHP_EOL, $content);
                        ?>
                        <?php $__currentLoopData = $explode_text; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php echo e($value); ?> <br>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                <?php endif; ?>
                
            </div>
        </div>
        <div id="total_records">
            <strong> <?php echo e($SearchCount); ?></strong>
        </div>
        <div class="col-md-6">
            <span id="spnReactivate" style="display: none;" class="reactable-lic"> <button
                    class="btn btn-sm btn-outline-warning">REACTIVATE</button> </span>
            <span class="span_heading">Reactivation Request :</span>
            <?php
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
            ?>
            <div class="divHwDetails" id="div_ReactReq">
                <?php if($content_react): ?>
                    <?php
                        $explode_text_react = explode(PHP_EOL, $content_react);
                    ?>
                    <?php $__currentLoopData = $explode_text_react; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value_react): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo e($value_react); ?> <br>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
                
            </div>
        </div>
    <?php endif; ?>
</div>

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
                <?php
                    $now = Carbon\Carbon::now();
                    $cur_month = $now->format('M');
                    $cur_year = $now->year;
                    // $SerialNo1 = $SerialNo;
                    //prev month and year
                    $prev_month = Carbon\Carbon::now()->subMonths(1)->format('M');
                    $prev_year = Carbon\Carbon::now()->subMonths(1)->format('Y');
                    if (!empty($SerialNo)) {
                        $file = 'E:\ACTIVATIONDATA\React\\' . $cur_month . '-' . $cur_year . '\\' . $SerialNo . '.txt';
                        $prev_file =
                            'E:\ACTIVATIONDATA\React\\' . $prev_month . '-' . $prev_year . '\\' . $SerialNo . '.txt';
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
                ?>
                <div class="divHwDetails">
                    <?php if($content_react): ?>
                        <?php
                            $explode_text_react = explode(PHP_EOL, $content_react);
                        ?>
                        <?php $__currentLoopData = $explode_text_react; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value_react): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php echo e($value_react); ?> <br>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<?php /**PATH C:\inetpub\wwwroot\UserInfo2\resources\views/dashboard_tbl_pagination.blade.php ENDPATH**/ ?>