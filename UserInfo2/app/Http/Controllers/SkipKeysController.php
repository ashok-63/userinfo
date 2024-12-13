<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Validation\Rules\Exists;

class SkipKeysController extends Controller
{
    public function skipKeys()
    {
        return view('skipKeys');
    }
    public function skipKeysFormData(Request $request)
    {
        $licNo = trim($request->licNo);
        $reason = trim($request->reason);
        if (empty($licNo) || empty($reason)) {
            return response()->json(['status' => false, 'message' => 'Please enter valid input']);
        }
        $licNo_arr = preg_split('/[\r\n,]+/', $licNo);
        $insert_Data = [];
        foreach ($licNo_arr as $key => $value) {
            $data = [];
            if ($value) {
                $CheckLicKey = DB::connection('actbatchregionvalidator')->table('tbl_k2state_pol_keyskip_tse')
                    ->where('lic_key', '=', $value)->exists();
                if (!$CheckLicKey) {
                    $data = [
                        'lic_key' => $value,
                        'reason' => $reason,
                        'username' => auth()->user()->User_Name,
                        'in_date' => Carbon::now()->toDateTimeString(),
                    ];
                    array_push($insert_Data, $data);
                }
            }
        }
        if (empty($insert_Data)) {
            return response()->json(['status' => false, 'message' => 'License key already exist']);
        }
        // dd($insert_Data);
        $InsertedId = DB::connection('actbatchregionvalidator')->table('tbl_k2state_pol_keyskip_tse')->insert($insert_Data);
        if (!empty($InsertedId)) {
            return response()->json([
                'status' =>  true,
                'message' => 'New Lic Key inserted successfully'
            ]);
        } else {
            return response()->json(['status' =>  false, 'message' => 'Something went wrong']);
        }
    }
    public function k2StatePolicy(Request $request)
    {
        $MahPol =  DB::connection('actbatchregionvalidator')->table('tbl_k2state_pol_onoff')->where('PolName', 'MHPOL010524')->value('Action');
        $GjPol =  DB::connection('actbatchregionvalidator')->table('tbl_k2state_pol_onoff')->where('PolName', 'GUJPOL030524')->value('Action');
        $RjPol =  DB::connection('actbatchregionvalidator')->table('tbl_k2state_pol_onoff')->where('PolName', 'RAJPOL210624')->value('Action');
        $MpPol =  DB::connection('actbatchregionvalidator')->table('tbl_k2state_pol_onoff')->where('PolName', 'MPPOL280624')->value('Action');
        $DhulePol =  DB::connection('actbatchregionvalidator')->table('tbl_k2state_pol_onoff')->where('PolName', 'DHULENANJAL2907')->value('Action');
        return view('k2state_policy.k2statePolicy', compact('MahPol', 'GjPol', 'RjPol', 'MpPol', 'DhulePol'));
    }
    public function updatePolicy(Request $request)
    {
        // dd($request->all());
        $PolName = $request->polName;
        $Action = $request->actionVal;
        $updatePolicy = DB::connection('actbatchregionvalidator')->table('tbl_k2state_pol_onoff')->where('PolName', $PolName)->update([
            'Action' => $Action,
            'in_date' => now(),
        ]);
        if ($updatePolicy) {
            return response()->json(['status' => true, 'message' => 'Policy Updated Sccessfully..!']);
        } else {
            return response()->json(['status' => false, 'message' => 'Failed to update policy..!']);
        }
    }
    public function h2lSkipKeys()
    {
        return view('h2lSkipKeys');
    }
    public function h2lSkipKeysInsert(Request $request)
    {
        try {
            $licNo = $request->h2l_licNo;
            $reason = $request->h2l_reason;
            $username = auth()->user()->User_Name;
            $token = "ZukcMfWyHwIhl2hK3kfoq2wmdbDIrDgREjR";
            $client_u = new Client(['base_uri' => 'https://buynow.npav.net/api/add_topup_hightolow_skipkeybytse', 'verify' => false, 'http_errors' => false]);
            $response_uc = $client_u->request('POST', '', [
                'form_params' => [
                    "token" => $token,
                    "licNo" => $licNo,
                    "reason" => $reason,
                    "username" => $username
                ]
            ]);
            $result_uc = $response_uc->getBody();
            return $result_uc;
        } catch (\Exception $e) {
            // return response()->json(['status' => false, 'message' => 'Server Error']);
            return response()->json([$e->getMessage()]);
        }
    }
    /**
     *
     *
     * DLL Viewer
     *
     */
    public function ucdllViewer()
    {
        return view('dllViewer.viewer');
    }
    public function monthWiseCnt()
    {
        return view('dllViewer.monthwise');
    }
    public function getRecords(Request $request)
    {
        $date = $request->date ? $request->date : date('Y-m-d');
        $keysArr = [];
        // $getKeys = DB::table('info_indates')->whereDate('InDate',  $date)->get();
        // $keysArr = $getKeys->pluck('SerialNo');
        // dd($getKeys);
        // $getKeyInfo = DB::table('info')
        //     ->select('customerNumber', 'computerName', 'SerialNo', 'installCode', 'Address', 'unlockCode', 'ExpiryDate', 'installDate')
        //     ->whereIn('SerialNo', $keysArr)
        //     ->where(function ($query) {
        //         $query->where('computerName', 'like', 'TUC%')
        //             ->orWhere('computerName', 'like', 'NUC%')
        //             ->orWhere('computerName', 'like', 'RUC%');
        //     })
        //     ->orderByDesc('customerNumber')
        //     ->get();
        // $getKeyCnt = DB::table('info')
        //     ->select(
        //         DB::raw('SUM(CASE WHEN computerName LIKE "TUC%" THEN 1 ELSE 0 END) as TUC_Count'),
        //         DB::raw('SUM(CASE WHEN computerName LIKE "NUC%" THEN 1 ELSE 0 END) as NUC_Count'),
        //         DB::raw('SUM(CASE WHEN computerName LIKE "RUC%" THEN 1 ELSE 0 END) as RUC_Count')
        //     )
        //     ->whereIn('SerialNo', $keysArr)
        //     ->first();
        $getKeyInfo = DB::table('info')
            ->join('info_indates', 'info.SerialNo', '=', 'info_indates.SerialNo')
            ->select('info.customerNumber', 'info.computerName', 'info.SerialNo', 'info.installCode', 'info.Address', 'info.unlockCode', 'info.ExpiryDate', 'info_indates.inDate as installDate')
            ->whereDate('info_indates.InDate', $date)
            ->where(function ($query) {
                $query->where('info.computerName', 'like', 'TUC%')
                    ->orWhere('info.computerName', 'like', 'NUC%')
                    ->orWhere('info.computerName', 'like', 'RUC%');
            })
            ->orderByDesc('info.customerNumber')
            ->get();
        $getKeyCnt = DB::table('info')
            ->join('info_indates', 'info.SerialNo', '=', 'info_indates.SerialNo')
            ->select(
                DB::raw('SUM(CASE WHEN info.computerName LIKE "TUC%" THEN 1 ELSE 0 END) as TUC_Count'),
                DB::raw('SUM(CASE WHEN info.computerName LIKE "NUC%" THEN 1 ELSE 0 END) as NUC_Count'),
                DB::raw('SUM(CASE WHEN info.computerName LIKE "RUC%" THEN 1 ELSE 0 END) as RUC_Count')
            )
            ->whereDate('info_indates.InDate', $date)
            ->first();
        return view('dllViewer.paging', compact('getKeyInfo', 'getKeyCnt'));
    }
    public function getMonthwiseCount(Request $request)
    {
        $date = $request->date ? $request->date : date('Y-m-d');
        $timestamp = strtotime($date);
        $startDate = date('Y-m-01', $timestamp);
        $endDate = date('Y-m-t', $timestamp);
        $getKeyCount = DB::table('info')
            ->select(
                DB::raw('DATE(InDate) as Date'),
                DB::raw('SUM(CASE WHEN computerName LIKE "TUC%" THEN 1 ELSE 0 END) as TUC_Count'),
                DB::raw('SUM(CASE WHEN computerName LIKE "NUC%" THEN 1 ELSE 0 END) as NUC_Count'),
                DB::raw('SUM(CASE WHEN computerName LIKE "RUC%" THEN 1 ELSE 0 END) as RUC_Count'),
                DB::raw('SUM(
                    CASE WHEN info.computerName LIKE "TUC%" THEN 1 ELSE 0 END +
                    CASE WHEN info.computerName LIKE "NUC%" THEN 1 ELSE 0 END +
                    CASE WHEN info.computerName LIKE "RUC%" THEN 1 ELSE 0 END
                ) as Total_Count')
            )
            ->join('info_indates', 'info.SerialNo', '=', 'info_indates.SerialNo')
            ->where('info_indates.InDate', '>=', $startDate)
            ->where('info_indates.InDate', '<=', $endDate)
            ->groupBy('Date')
            ->orderByDesc('Date')
            ->get();
        return view('dllViewer.monthwisePaging', compact('getKeyCount'));
    }
    /**
     *
     *
     * Duplicate Reward keys to dealer
     *
     *
     */
    public function isAllowedToRewardKey(Request $request)
    {
        $Lic = $request->lic;
        $checkKey = DB::connection('mysql3')->table('key_collision_master')->where('Lic', $Lic)->where('IsSent', false)->exists();
        return $checkKey;
    }
    public function fetchNewRewardKey(Request $request)
    {
        try {
            $oldLic = $request->oldLic;
            $SentToDlr = $request->SentToDlr;
            $DlrMobile = $request->DlrMobile;
            $checkDlrKey = DB::table('info')->where('SerialNo', $oldLic)->where('dlrCode', $SentToDlr)->exists();
            if ($checkDlrKey) {
                return response()->json(['Status' => 'error', 'Message' => 'This key is already activated by same dealer.']);
            } else {
                $fetchedKey = DB::connection('mysql3')->table('licbank')->where('Sent', false)->skip(10)->limit(1)->get();
                if ($fetchedKey) {
                    $NewKey = $fetchedKey[0]->Lic;
                    $NewKeyId = $fetchedKey[0]->Id;
                    DB::connection('mysql3')->table('licbank')->where('Id', $NewKeyId)->update([
                        'Sent' => true,
                        'SentDate' => now(),
                    ]);
                    $checkOldKey =  DB::connection('mysql3')->table('dlrsentmail')->where('sentlic', $oldLic)->where('Dlrcode', $SentToDlr)->first();
                    if (!empty($checkOldKey)) {
                        $oldKeyId = $checkOldKey->Id;
                        DB::connection('mysql3')->table('dlrsentmail')->where('Id', $oldKeyId)->update([
                            'sentlic' => $NewKey,
                            'SentDate' => now(),
                        ]);
                    }
                    $insertInSentKeyLog = DB::connection('mysql3')->table('key_collision_master')->where('Lic', $oldLic)->update([
                        'IsSent' => true,
                        'SentLic' => $NewKey,
                        'SentToDlr' => $SentToDlr,
                        'DlrMobile' => $DlrMobile,
                        'UpdDate' => now(),
                    ]);
                    return response()->json(['Status' => 'success', 'Message' => 'Key Fetched Successfully.', 'NewKey' => $NewKey]);
                } else {
                    return response()->json(['Status' => 'error', 'Message' => 'No key available']);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['Status' => 'error', 'Message' => 'Server Error']);
        }
    }
    /***  Fetch Reward Key API  | Update all unactivated duplicate keys  */
    public function updateDuplicateRewardKeys(Request $request)
    {
        try {
            $allUnsentDuplKeys = DB::connection('mysql3')->table('key_collision_master')->where('IsSent', false)->get();
            if ($allUnsentDuplKeys) {
                foreach ($allUnsentDuplKeys as $key => $value) {
                    $DlrCodes = explode(',', $value->DlrCode);
                    $oldLic = $value->Lic;
                    $checkDlrKey = DB::table('info')->where('SerialNo', $oldLic)->whereIn('dlrCode', $DlrCodes)->first();
                    if (!empty($checkDlrKey)) {
                        $act_dlrCode = $checkDlrKey->dlrCode;
                        if ($act_dlrCode != $DlrCodes[0]) {
                            $otherDlrCode = $DlrCodes[0];
                        } else {
                            $otherDlrCode = $DlrCodes[1];
                        }
                        if ($act_dlrCode) {
                            $fetchedKey = DB::connection('mysql3')->table('licbank')->where('Sent', false)->skip(10)->limit(1)->get();
                            if ($fetchedKey) {
                                $NewKey = $fetchedKey[0]->Lic;
                                $NewKeyId = $fetchedKey[0]->Id;
                                DB::connection('mysql3')->table('licbank')->where('Id', $NewKeyId)->update([
                                    'Sent' => true,
                                    'SentDate' => now(),
                                ]);
                                $checkOldKey =  DB::connection('mysql3')->table('dlrsentmail')->where('sentlic', $oldLic)->where('Dlrcode', $otherDlrCode)->first();
                                if (!empty($checkOldKey)) {
                                    $oldKeyId = $checkOldKey->Id;
                                    DB::connection('mysql3')->table('dlrsentmail')->where('Id', $oldKeyId)->update([
                                        'sentlic' => $NewKey,
                                        'SentDate' => now(),
                                    ]);
                                }
                                $insertInSentKeyLog = DB::connection('mysql3')->table('key_collision_master')->where('Lic', $oldLic)->update([
                                    'IsSent' => true,
                                    'SentLic' => $NewKey,
                                    'SentToDlr' => $otherDlrCode,
                                    // 'DlrMobile' => $DlrMobile,
                                    'UpdDate' => now(),
                                ]);
                            }
                        }
                    }
                }
                return true;
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
