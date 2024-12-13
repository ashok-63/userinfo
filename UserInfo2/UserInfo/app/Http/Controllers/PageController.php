<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Http\Traits\EmailTrait;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class PageController extends Controller
{
    use EmailTrait;
    public function dashboard($KeyNo = null)
    {
        $keyNo = $KeyNo;
        return view('dashboard', compact('keyNo'));
    }
    public function SearchByKey(Request $request)
    {
        $loggedUser = auth()->user()->User_Name;
        $search_by = $request->search_by;
        $search_txt = trim($request->search_txt);
        $searchresults = [];
        $searchresults_inactive = [];
        $licKey = '';
        if ($search_by == 'lic') {
            $licKey = $search_txt;
        }
        if ($loggedUser == 'preetimam' || $loggedUser == 'tusharb') {
            $limit = 150;
        } else {
            $limit = 25;
        }
        switch ($search_by) {
            case "lic":


                $searchresults = DB::table("info")
                    ->select(
                        'customerNumber',
                        'old_customerNumber',
                        'Name',
                        'contactPerson',
                        'Address',
                        'emailID',
                        'computerName',
                        'AuthoBy',
                        'installDate',
                        'SerialNo',
                        'installCode',
                        'unlockCode',
                        'lanCardNo',
                        'ExpiryDate',
                        'Dealer',
                        'DealerEmailID',
                        'CustMobile',
                        'DealerMobile',
                        'City',
                        'dlrCode',
                        'installBy',
                        'demoDate',
                        'billNo',
                        'emailID'
                    )
                    ->where('SerialNo', '=', $search_txt)
                    ->orderBy('customerNumber', 'desc')
                    ->limit($limit)
                    ->get();
                /**If no data in info table for key then search in serialnums table */
                $explode = explode('-', $search_txt);
                if ($searchresults->isEmpty()) {
                    $searchresults_inactive = DB::table("serialnums")
                        ->where('SerialInitial', '=', $explode[0])
                        ->where('SerialNo', '=', $explode[1])
                        ->get();
                }

                // $start = microtime(true);
                // $searchresults = DB::select("CALL SearchCustomerInfo(?, ?)", [$search_txt, $limit]);
                // $end = microtime(true);
                // $execution_time = ($end - $start);
                // Log::info("Execution time of Stored Procedure: " . $execution_time . " seconds");

                break;
            case "ic":
                // $reverse = strrev($search_txt);
                // $explode = explode("-", $reverse);
                // $findstring = $explode[1] . "-" . $explode[2] . "-" . $explode[3] . "-" . $explode[4];
                // $searchresults = DB::table("info")->where('installCode', '=', $findstring)->orderBy('customerNumber', 'desc')->limit($limit)->get();
                $search_txt = strrev($search_txt);
                $parts = explode("-", $search_txt, 6); // limit the number of parts to 5
                $findstring = implode("-", array_slice($parts, 1, 4)); // extract and implode the relevant parts
                $searchresults = DB::table("info")
                    ->select(
                        'customerNumber',
                        'old_customerNumber',
                        'Name',
                        'contactPerson',
                        'Address',
                        'emailID',
                        'computerName',
                        'AuthoBy',
                        'installDate',
                        'SerialNo',
                        'installCode',
                        'unlockCode',
                        'lanCardNo',
                        'ExpiryDate',
                        'Dealer',
                        'DealerEmailID',
                        'CustMobile',
                        'DealerMobile',
                        'City',
                        'dlrCode',
                        'installBy',
                        'demoDate',
                        'billNo',
                        'emailID'
                    )
                    ->where('installCode', '=', $findstring)
                    ->orderBy('customerNumber', 'desc')
                    ->limit($limit)
                    ->get();
                break;
            case "lan":
                $searchresults = DB::table("info")
                    ->select(
                        'customerNumber',
                        'old_customerNumber',
                        'Name',
                        'contactPerson',
                        'Address',
                        'emailID',
                        'computerName',
                        'AuthoBy',
                        'installDate',
                        'SerialNo',
                        'installCode',
                        'unlockCode',
                        'lanCardNo',
                        'ExpiryDate',
                        'Dealer',
                        'DealerEmailID',
                        'CustMobile',
                        'DealerMobile',
                        'City',
                        'dlrCode',
                        'installBy',
                        'demoDate',
                        'billNo',
                        'emailID'
                    )
                    ->where('lanCardNo', '=', $search_txt)->orderBy('customerNumber', 'desc')->limit($limit)->get();
                break;
            case "uc":
                $searchresults = DB::table("info")
                    ->select(
                        'customerNumber',
                        'old_customerNumber',
                        'Name',
                        'contactPerson',
                        'Address',
                        'emailID',
                        'computerName',
                        'AuthoBy',
                        'installDate',
                        'SerialNo',
                        'installCode',
                        'unlockCode',
                        'lanCardNo',
                        'ExpiryDate',
                        'Dealer',
                        'DealerEmailID',
                        'CustMobile',
                        'DealerMobile',
                        'City',
                        'dlrCode',
                        'installBy',
                        'demoDate',
                        'billNo',
                        'emailID'
                    )
                    ->where('unlockCode', '=', $search_txt)->orderBy('customerNumber', 'desc')->limit($limit)->get();
                break;
            case "hdd":
                $hddKeys = [];
                $rsHwInfo = DB::table("acthwmaster")
                    ->where('HDD1', '=', $search_txt)->orWhere('HDD2', '=', $search_txt)->orderBy('hwId', 'desc')->limit($limit)->distinct('SerialNo')->get();
                foreach ($rsHwInfo as $key => $value) {
                    $hddKeys[] = $value->SerialNo;
                }
                $searchresults = DB::table("info")
                    ->select(
                        'customerNumber',
                        'old_customerNumber',
                        'Name',
                        'contactPerson',
                        'Address',
                        'emailID',
                        'computerName',
                        'AuthoBy',
                        'installDate',
                        'SerialNo',
                        'installCode',
                        'unlockCode',
                        'lanCardNo',
                        'ExpiryDate',
                        'Dealer',
                        'DealerEmailID',
                        'CustMobile',
                        'DealerMobile',
                        'City',
                        'dlrCode',
                        'installBy',
                        'demoDate',
                        'billNo',
                        'emailID'
                    )
                    ->whereIn('SerialNo', $hddKeys)
                    ->orderBy('customerNumber', 'desc')
                    ->limit($limit)
                    ->get();
                break;
            case "cn":
                $searchresults =
                    DB::table("info")
                    ->select(
                        'customerNumber',
                        'old_customerNumber',
                        'Name',
                        'contactPerson',
                        'Address',
                        'emailID',
                        'computerName',
                        'AuthoBy',
                        'installDate',
                        'SerialNo',
                        'installCode',
                        'unlockCode',
                        'lanCardNo',
                        'ExpiryDate',
                        'Dealer',
                        'DealerEmailID',
                        'CustMobile',
                        'DealerMobile',
                        'City',
                        'dlrCode',
                        'installBy',
                        'demoDate',
                        'billNo',
                        'emailID'
                    )
                    ->where('computerName', '=', $search_txt)
                    ->orderBy('customerNumber', 'desc')
                    ->limit($limit)
                    ->get();
                break;
            case "cNo":
                $searchresults = DB::table("info")
                    ->select(
                        'customerNumber',
                        'old_customerNumber',
                        'Name',
                        'contactPerson',
                        'Address',
                        'emailID',
                        'computerName',
                        'AuthoBy',
                        'installDate',
                        'SerialNo',
                        'installCode',
                        'unlockCode',
                        'lanCardNo',
                        'ExpiryDate',
                        'Dealer',
                        'DealerEmailID',
                        'CustMobile',
                        'DealerMobile',
                        'City',
                        'dlrCode',
                        'installBy',
                        'demoDate',
                        'billNo',
                        'emailID'
                    )
                    ->where('customerNumber', '=', $search_txt)->orderBy('customerNumber', 'desc')->limit($limit)->get();
                break;
            case "cp":
                $searchresults = DB::table("info")
                    ->select(
                        'customerNumber',
                        'old_customerNumber',
                        'Name',
                        'contactPerson',
                        'Address',
                        'emailID',
                        'computerName',
                        'AuthoBy',
                        'installDate',
                        'SerialNo',
                        'installCode',
                        'unlockCode',
                        'lanCardNo',
                        'ExpiryDate',
                        'Dealer',
                        'DealerEmailID',
                        'CustMobile',
                        'DealerMobile',
                        'City',
                        'dlrCode',
                        'installBy',
                        'demoDate',
                        'billNo',
                        'emailID'
                    )
                    ->where('contactPerson', '=', $search_txt)->orderBy('customerNumber', 'desc')->limit($limit)->get();
                break;
            case "cm":
                $distinctKeyNo = DB::table('info_email')->select('KeyNo')->where('MobileNo', $search_txt)->get();
                if ($distinctKeyNo) {
                    $keyNos = [];
                    foreach ($distinctKeyNo as $data) {
                        $keyNos[] = $data->KeyNo;
                    }
                }
                if (!empty($keyNos)) {
                    $searchresults = DB::table("info")
                        ->select(
                            'customerNumber',
                            'old_customerNumber',
                            'Name',
                            'contactPerson',
                            'Address',
                            'emailID',
                            'computerName',
                            'AuthoBy',
                            'installDate',
                            'SerialNo',
                            'installCode',
                            'unlockCode',
                            'lanCardNo',
                            'ExpiryDate',
                            'Dealer',
                            'DealerEmailID',
                            'CustMobile',
                            'DealerMobile',
                            'City',
                            'dlrCode',
                            'installBy',
                            'demoDate',
                            'billNo',
                            'emailID'
                        )
                        ->whereIn('SerialNo', $keyNos)->orderBy('customerNumber', 'desc')->limit($limit)->get();
                } else {
                    $custNumber = DB::table('CustomerLocation')->select('CustomerNumber')->where('CustMob2', $search_txt)->get();
                    if ($custNumber) {
                        $custNos = [];
                        foreach ($custNumber as $data) {
                            $custNos[] = $data->CustomerNumber;
                        }
                        $searchresults = DB::table("info")
                            ->select(
                                'customerNumber',
                                'old_customerNumber',
                                'Name',
                                'contactPerson',
                                'Address',
                                'emailID',
                                'computerName',
                                'AuthoBy',
                                'installDate',
                                'SerialNo',
                                'installCode',
                                'unlockCode',
                                'lanCardNo',
                                'ExpiryDate',
                                'Dealer',
                                'DealerEmailID',
                                'CustMobile',
                                'DealerMobile',
                                'City',
                                'dlrCode',
                                'installBy',
                                'demoDate',
                                'billNo',
                                'emailID'
                            )
                            ->whereIn('customerNumber', $custNos)->orderBy('customerNumber', 'desc')->limit($limit)->get();
                    }
                }
                break;
            case "ce":
                $distinctKeyNo = DB::table('info_email')->select('KeyNo')->where('EmailId', $search_txt)->get();
                if ($distinctKeyNo) {
                    $keyNos = [];
                    foreach ($distinctKeyNo as $data) {
                        $keyNos[] = $data->KeyNo;
                    }
                }
                if (!empty($keyNos)) {
                    $searchresults = DB::table("info")
                        ->select(
                            'customerNumber',
                            'old_customerNumber',
                            'Name',
                            'contactPerson',
                            'Address',
                            'emailID',
                            'computerName',
                            'AuthoBy',
                            'installDate',
                            'SerialNo',
                            'installCode',
                            'unlockCode',
                            'lanCardNo',
                            'ExpiryDate',
                            'Dealer',
                            'DealerEmailID',
                            'CustMobile',
                            'DealerMobile',
                            'City',
                            'dlrCode',
                            'installBy',
                            'demoDate',
                            'billNo',
                            'emailID'
                        )
                        ->whereIn('SerialNo', $keyNos)->orderBy('customerNumber', 'desc')->limit($limit)->get();
                } else {
                    $searchresults = DB::table("info")
                        ->select(
                            'customerNumber',
                            'old_customerNumber',
                            'Name',
                            'contactPerson',
                            'Address',
                            'emailID',
                            'computerName',
                            'AuthoBy',
                            'installDate',
                            'SerialNo',
                            'installCode',
                            'unlockCode',
                            'lanCardNo',
                            'ExpiryDate',
                            'Dealer',
                            'DealerEmailID',
                            'CustMobile',
                            'DealerMobile',
                            'City',
                            'dlrCode',
                            'installBy',
                            'demoDate',
                            'billNo',
                            'emailID'
                        )
                        ->where('SerialNo', $search_txt)->orderBy('customerNumber', 'desc')->limit($limit)->get();
                }
                break;
            case "add":
                $searchresults = DB::table("info")
                    ->select(
                        'customerNumber',
                        'old_customerNumber',
                        'Name',
                        'contactPerson',
                        'Address',
                        'emailID',
                        'computerName',
                        'AuthoBy',
                        'installDate',
                        'SerialNo',
                        'installCode',
                        'unlockCode',
                        'lanCardNo',
                        'ExpiryDate',
                        'Dealer',
                        'DealerEmailID',
                        'CustMobile',
                        'DealerMobile',
                        'City',
                        'dlrCode',
                        'installBy',
                        'demoDate',
                        'billNo',
                        'emailID'
                    )
                    ->where('Address', 'like', '%' . $search_txt . '%')->orderBy('customerNumber', 'desc')->limit($limit)->get();
                break;
            case "DlrCode":
                $searchresults = DB::table("info")
                    ->select(
                        'customerNumber',
                        'old_customerNumber',
                        'Name',
                        'contactPerson',
                        'Address',
                        'emailID',
                        'computerName',
                        'AuthoBy',
                        'installDate',
                        'SerialNo',
                        'installCode',
                        'unlockCode',
                        'lanCardNo',
                        'ExpiryDate',
                        'Dealer',
                        'DealerEmailID',
                        'CustMobile',
                        'DealerMobile',
                        'City',
                        'dlrCode',
                        'installBy',
                        'demoDate',
                        'billNo',
                        'emailID'
                    )
                    ->where('dlrCode', '=', $search_txt)->orderBy('customerNumber', 'desc')->select('customerNumber', 'old_customerNumber', 'Name', 'contactPerson', 'Address', 'emailID', 'computerName', 'AuthoBy', 'installDate', 'SerialNo', 'installCode', 'unlockCode', 'lanCardNo', 'ExpiryDate', 'Dealer', 'DealerEmailID', 'CustMobile', 'DealerMobile', 'City', 'dlrCode', 'installBy', 'demoDate', 'billNo', 'emailID')->orderBy('customerNumber', 'desc')->limit($limit)->get();
                break;
            case "DlrMob":
                $searchresults = DB::table("info")
                    ->select(
                        'customerNumber',
                        'old_customerNumber',
                        'Name',
                        'contactPerson',
                        'Address',
                        'emailID',
                        'computerName',
                        'AuthoBy',
                        'installDate',
                        'SerialNo',
                        'installCode',
                        'unlockCode',
                        'lanCardNo',
                        'ExpiryDate',
                        'Dealer',
                        'DealerEmailID',
                        'CustMobile',
                        'DealerMobile',
                        'City',
                        'dlrCode',
                        'installBy',
                        'demoDate',
                        'billNo',
                        'emailID'
                    )
                    ->where('DealerMobile', $search_txt)->orderBy('customerNumber', 'desc')->limit($limit)->get();
                break;
            case "Dlr":
                $searchresults = DB::table("info")
                    ->select(
                        'customerNumber',
                        'old_customerNumber',
                        'Name',
                        'contactPerson',
                        'Address',
                        'emailID',
                        'computerName',
                        'AuthoBy',
                        'installDate',
                        'SerialNo',
                        'installCode',
                        'unlockCode',
                        'lanCardNo',
                        'ExpiryDate',
                        'Dealer',
                        'DealerEmailID',
                        'CustMobile',
                        'DealerMobile',
                        'City',
                        'dlrCode',
                        'installBy',
                        'demoDate',
                        'billNo',
                        'emailID'
                    )
                    ->where('Dealer', '=', $search_txt)->orderBy('customerNumber', 'desc')->limit($limit)->get();
                break;
            case "myAct":
                $searchresults = DB::table("info")
                    ->select('customerNumber', 'old_customerNumber', 'Name', 'contactPerson', 'Address', 'emailID', 'computerName', 'AuthoBy', 'installDate', 'SerialNo', 'installCode', 'unlockCode', 'lanCardNo', 'ExpiryDate', 'Dealer', 'DealerEmailID', 'CustMobile', 'DealerMobile', 'City', 'dlrCode', 'installBy', 'demoDate', 'billNo')
                    ->where('AuthoBy', $loggedUser)
                    ->orderBy('customerNumber', 'DESC')
                    ->limit($limit)->get();
                break;
            case "fn":
                $searchresults = DB::table('info')->select('customerNumber', 'old_customerNumber', 'Name', 'contactPerson', 'Address', 'emailID', 'computerName', 'AuthoBy', 'installDate', 'SerialNo', 'installCode', 'unlockCode', 'lanCardNo', 'ExpiryDate', 'Dealer', 'DealerEmailID', 'CustMobile', 'Dealer', 'DealerMobile', 'City', 'dlrCode', 'installBy', 'demoDate', 'billNo', 'emailID')->where('Name', 'like', '%' . $search_txt . '%')->orderByDesc('customerNumber')->limit($limit)->get();
            case 'lastAct';
                $searchresults = DB::table("info")->select('customerNumber', 'old_customerNumber', 'Name', 'contactPerson', 'Address', 'emailID', 'computerName', 'AuthoBy', 'installDate', 'SerialNo', 'installCode', 'unlockCode', 'lanCardNo', 'ExpiryDate', 'Dealer', 'DealerEmailID', 'CustMobile', 'DealerMobile', 'City', 'dlrCode', 'installBy', 'demoDate', 'billNo')
                    ->orderBy('customerNumber', 'DESC')->limit($limit)->get();
                break;
            case 'apksms';
                $searchresults = DB::table("info")->select('customerNumber', 'old_customerNumber', 'Name', 'contactPerson', 'Address', 'emailID', 'computerName', 'AuthoBy', 'installDate', 'SerialNo', 'installCode', 'unlockCode', 'lanCardNo', 'ExpiryDate', 'Dealer', 'DealerEmailID', 'CustMobile', 'DealerMobile', 'City', 'dlrCode', 'installBy', 'demoDate', 'billNo')
                    ->where('customerNumber', '>', '8723045')
                    ->where('billno', 'sms')->orderBy('customerNumber', 'DESC')->limit($limit)->get();
                break;
            default:
                $searchresults = [];
                $searchresults_inactive = [];
        }
        $SearchCount = !empty($searchresults) ? count($searchresults) : 0;
        return view('dashboard_tbl_pagination', compact('searchresults', 'SearchCount', 'searchresults_inactive', 'search_txt', 'licKey', 'search_by'));
    }
    public function FetchHWDetails1(Request $request)
    {
        $CustNo = $request->customer_no;
        $SerialNo = $request->serial_no;
        $objrs = DB::table("ActHwMaster")
            ->where('CustomerNumber', '=', $CustNo)
            ->where('SerialNo', '=', $SerialNo)
            ->orderBy('hwId', 'desc')
            ->select('SerialNo', 'Lc1No', 'Lc2No', 'Lc3No', 'Lc1Name', 'Lc2Name', 'Lc3Name', 'Lc1Ip', 'Lc2Ip', 'Lc3Ip', 'HDD1', 'HDD2', 'HDDModels', 'CPUName', 'CPUSpeed', 'MachineName', 'MBID', 'OS', 'BITS', 'CDVSN', 'DDVSN', 'HDDInstCode', 'LCInstCode', 'MBInstCode', 'Manufacturer', 'Model')
            ->first();
        return view('hardware_details1_modal', compact('objrs'));
    }
    public function FetchHWDetails2($custNo, $lic)
    {
        $CustNo = $custNo;
        $SerialNo = $lic;
        if (empty($CustNo) || empty($SerialNo)) {
            echo '<h2>Invalid License or Customer Number!</h2>';
            die;
        } else {
            // return view('hardware_details2_bak', compact('CustNo', 'SerialNo'));
            $customerNumbers = DB::table('info')->select('CustomerNumber')->where('SerialNo', $SerialNo)->orderByDesc('CustomerNumber')->limit(5)->get();
            $custNo_arr = [];
            foreach ($customerNumbers as $key => $val) {
                $custNo_arr[] = $val->CustomerNumber;
            }
            // dd($custNo_arr);
            $data = DB::table('info')
                ->select(
                    'ActHwMaster.Lc1No',
                    'ActHwMaster.Lc2No',
                    'ActHwMaster.Lc3No',
                    'ActHwMaster.Lc1Name',
                    'ActHwMaster.Lc2Name',
                    'ActHwMaster.Lc3Name',
                    'ActHwMaster.Lc1Ip',
                    'ActHwMaster.Lc2Ip',
                    'ActHwMaster.Lc3Ip',
                    'ActHwMaster.HDD1',
                    'ActHwMaster.HDD2',
                    'ActHwMaster.HDDModels',
                    'ActHwMaster.CPUName',
                    'ActHwMaster.CPUSpeed',
                    'ActHwMaster.MachineName',
                    'ActHwMaster.MBID',
                    'ActHwMaster.OS',
                    'ActHwMaster.BITS',
                    'ActHwMaster.CDVSN',
                    'ActHwMaster.DDVSN',
                    'ActHwMaster.MBInstCode',
                    'ActHwMaster.Manufacturer',
                    'ActHwMaster.Model',
                    'ActHwMaster.HDDInstCode',
                    'ActHwMaster.LCInstCode',
                    DB::raw('DATE_FORMAT(ActHwMaster.InDate, "%d-%b-%Y %h:%i %p") as iDate2'),
                    'info.CustomerNumber',
                    'info.contactPerson',
                    'info.CustMobile',
                    'info.lanCardNo',
                    'info.installCode',
                    'info.unlockCode',
                )
                ->leftJoin('ActHwMaster', 'info.CustomerNumber', '=', 'ActHwMaster.CustomerNumber')
                // ->whereIn('ActHwMaster.CustomerNumber', $custNo_arr)
                ->where('info.SerialNo', '=', $SerialNo)
                // ->orderBy('ActHwMaster.hwId', 'desc')
                // ->limit(7)
                ->orderBy('info.CustomerNumber', 'desc')
                ->get();
            return view('hardware_details2', compact('CustNo', 'SerialNo', 'data'));
        }
    }
    public function FetchUserDetails(Request $request)
    {
        $CustNo = $request->customer_no;
        if (empty($CustNo)) {
            echo '<h2>Invalid Customer Number!</h2>';
            die;
        }
        $UserData = DB::table("info")->select('Name', 'contactPerson', 'CustMobile', 'emailID', 'Address', 'customerNumber')->where('customerNumber', '=', $CustNo)->first();
        return view('user_details', compact('UserData'));
    }
    public function UpdateUserDetails(Request $request)
    {
        $Name = preg_replace("/[^ \w]+/", '', $request->txtName);
        $ContactPersonName = preg_replace("/[^ \w]+/", '', $request->txtCp);
        $Mobile1 = preg_replace("/[^ \w]+/", '', $request->txtCustMob);
        // $Email = preg_replace("/[^ \w]+/", '', $request->txtEmail);
        $Email = $request->txtEmail;
        $Address = preg_replace("/[^ \w]+/", '', $request->txtAdd);
        $CustomerNo = $request->customer_no;
        DB::table('INFO')->where('customerNumber', '=', $CustomerNo)->update(array('Name' => $Name, 'contactPerson' => $ContactPersonName, 'CustMobile' => $Mobile1, 'emailID' => $Email, 'Address' => $Address));
        return response()->json(['msg' => 'User Information Updated Successfully.', 'class' => 'success']);
    }
    public function FetchUserMobDetails(Request $request)
    {
        $CustNo = $request->customer_no;
        $SerialNo = $request->serial_no;
        $MobNo = $request->mobile_no;
        if (empty($CustNo) || empty($SerialNo)) {
            echo '<h2>Invalid License or Customer Number!</h2>';
            die;
        }
        return view('update_user_mob', compact('CustNo', 'SerialNo', 'MobNo'));
    }
    public function UpdateUserMob(Request $request)
    {
        $CustNo = $request->CustNo;
        $SerialNo = $request->KeyNo;
        $MobNo = $request->txtMob2;
        if (empty($CustNo) || empty($SerialNo) || empty($MobNo)) {
            return response()->json(['msg' => 'Invalid Parameter', 'class' => 'error']);
        }
        $ContactData = DB::table("CustomerLocation")->where('CustomerNumber', '=', $CustNo)->where('SerialNo', '=', $SerialNo)->first();
        if (!empty($ContactData)) {
            DB::table('CustomerLocation')->where('SerialNo', '=', $SerialNo)
                ->where('CustomerNumber', '=', $CustNo)->update(array('CustMob2' => $MobNo));
        } else {
            DB::insert('insert into CustomerLocation (CustomerNumber,SerialNo,CustMob2) values (?, ?, ?)', [$CustNo,  $SerialNo, $MobNo]);
        }
        return response()->json(['msg' => 'Mobile No-2 Updated Successfully.', 'class' => 'success']);
    }
    public function FetchContactDetails(Request $request)
    {
        // $CustNo = $request->customer_no;
        $SerialNo = $request->serial_no;
        if (empty($SerialNo)) {
            echo '<h2>Invalid License Number!</h2>';
            die;
        }
        $ContactData = DB::connection('mysql2')->table("custinfo")->select((DB::raw('DATE_FORMAT(InDate, "%d-%b-%Y %h:%i %p") as cuDt')), 'newMobileNo', 'newEmailId')->where('keyNo', '=', $SerialNo)->orderBy('cID', 'desc')->first();
        return response()->json(['ContactData' => $ContactData]);
    }
    public function FetchReactivateDetails(Request $request)
    {
        $CustNo = $request->customer_no;
        $SerialNo = $request->serial_no;
        $UserName = $request->user_name;
        if (empty($CustNo) || empty($UserName) || empty($SerialNo)) {
            echo '<h2>Invalid Number of parameters!</h2>';
            die;
        }
        $ReactivateDetails = DB::table("info")
            ->select('CustMobile', 'emailID', 'CustCountry', 'CustState', 'CustDistrict', 'CustCity', 'info.SerialNo', 'CustomerLocation.CorpId', 'CountryMaster.CountryId', 'StateMaster.stID')
            ->leftJoin('CustomerLocation', 'CustomerLocation.SerialNo', '=', 'info.SerialNo')
            ->leftJoin('CountryMaster', 'CountryMaster.Country', '=', 'CustomerLocation.CustCountry')
            ->leftJoin('StateMaster', 'StateMaster.STATENAME', '=', 'CustomerLocation.CustState')
            ->where('info.SerialNo', '=', $SerialNo)
            ->first();
        $CountryData = DB::table("CountryMaster")
            ->select('CountryId', 'Country')
            ->orderBy('Country', 'asc')
            ->get();
        $StateData = DB::table("StateMaster")
            ->select('stID', 'STATENAME')
            ->where('CountryId', '=', $ReactivateDetails->CountryId)
            ->orderBy('STATENAME', 'asc')
            ->get();
        $DistrictData = DB::table("DistrictMaster")
            ->select('DISTRICT')
            ->where('sID', '=', $ReactivateDetails->stID)
            ->orderBy('DISTRICT', 'asc')
            ->get();
        return view('reactivate_model', compact('ReactivateDetails', 'CountryData', 'CustNo', 'UserName', 'StateData', 'DistrictData'));
    }
    public function FetchStateByCountry(Request $request)
    {
        $CountryId = $request->country_id;
        $StateName = $request->state_name;
        if (empty($CountryId)) {
            echo '<h2>Invalid Parameter!</h2>';
            die;
        }
        $CountryId = explode("$", $CountryId);
        $CountryId = $CountryId[0];
        $StateData = DB::table("StateMaster")
            ->select('stID', 'STATENAME')
            ->where('CountryId', '=', $CountryId)
            ->orderBy('STATENAME', 'asc')
            ->get();
        $state_option = '';
        if (!empty($StateData)) {
            foreach ($StateData as $key => $state) {
                $selected = '';
                if (!empty($StateName) && (strtoupper($state->STATENAME) == strtoupper($StateName))) {
                    $selected = 'selected';
                }
                $state_option .= '<option value="' . $state->stID . "$" . $state->STATENAME . '" ' . $selected . '>' . $state->STATENAME . '</option>';
            }
        }
        return response()->json(['state_option' => $state_option]);
    }
    public function FetchDistrictByState(Request $request)
    {
        $StateId = $request->state_id;
        $DistrictName = $request->district_name;
        if (empty($StateId)) {
            echo '<h2>Invalid Parameter!</h2>';
            die;
        }
        $StateId = explode("$", $StateId);
        $StateId = $StateId[0];
        $DistrictData = DB::table("DistrictMaster")
            ->select('DISTRICT')
            ->where('sID', '=', $StateId)
            ->orderBy('DISTRICT', 'asc')
            ->get();
        $district_option = '';
        if (!empty($DistrictData)) {
            foreach ($DistrictData as $key => $dist) {
                $selected = '';
                if (!empty($DistrictName) && (strtoupper($dist->DISTRICT) == strtoupper($DistrictName))) {
                    $selected = 'selected';
                }
                $district_option .= '<option value=' . $dist->DISTRICT . ' ' . $selected . '>' . $dist->DISTRICT . '</option>';
            }
        }
        return response()->json(['district_option' => $district_option]);
    }
    public function UpdateReactivate(Request $request)
    {
        $SerialNo = $request->txtLic;
        $CustomerNo = $request->customer_no;
        $UserName = $request->user_name;
        $Mobile1 = $request->txtMob1;
        $Mobile2 = $request->txtMob2;
        $EmailId = $request->txtEmail;
        $CountryName = trim($request->txtCountry);
        $State = trim($request->txtState);
        $District = trim($request->txtDist);
        $City = $request->txtCity;
        $CorpId = $request->txtCorpId;
        $ReactivateDetails = DB::table("CustomerLocation")
            ->select('LocationId')
            ->where('SerialNo', '=', $SerialNo)
            ->where('CustomerNumber', '=', $CustomerNo)
            ->first();
        if (empty($ReactivateDetails)) {
            DB::insert('insert into CustomerLocation (CustomerNumber,CustCountry,CustState,CustDistrict,CustCity,SerialNo,CorpId,InDate,CustMob2,DistriID) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [$CustomerNo, $CountryName, $State, $District, $City, $SerialNo, $CorpId, NOW(), $Mobile2, 0]);
        } else {
            DB::table('CustomerLocation')->where('SerialNo', '=', $SerialNo)
                ->where('CustomerNumber', '=', $CustomerNo)->update(array('CustCountry' => $CountryName, 'CustState' => $State, 'CustDistrict' => $District, 'CustCity' => $City, 'CorpId' => $CorpId, 'CustMob2' => $Mobile2));
        }
        return response()->json(['serial_no' => $SerialNo, 'UserName' => $UserName, 'CustomerNo' => $CustomerNo, 'class' => 'success']);
    }
    public function genReactive(Request $request)
    {
        $SerialNo = $request->SerialNo;
        $CustomerNo = $request->CustomerNo;
        $UserName = $request->UserName;
        if (empty($SerialNo) || empty($CustomerNo) || empty($UserName)) {
            return response()->json(['msg' => 'Invalid Parameter!', 'class' => 'error']);
        }
        return view('gen_reactive_model', compact('SerialNo', 'CustomerNo', 'UserName'));
    }
    public function getICcount(Request $request)
    {
        $IC_Code = $request->iccode;
        if (empty($IC_Code)) {
            return response()->json(['msg' => 'Invalid Parameter!', 'class' => 'error']);
        }
        $IC_Code = substr($IC_Code, -19);
        $IC_Count = DB::table('Info')->select('installCode AS ICcount')->where('installCode', '=', $IC_Code)->count();
        return response()->json(['data' => $IC_Count, 'class' => 'success']);
    }
    public function SaveReactiveDetails(Request $request)
    {
        $txtIC = $request->txtIC;
        $txtIC1 = $request->txtIC1;
        $txtICNN = $request->txtICNN;
        $txtICNN1 = $request->txtICNN1;
        $txtComment = $request->txtComment;
        $chkCut = !empty($request->chkCut) ? True : False;
        $user = $request->user;
        $lic = $request->lic;
        if ($txtIC == 'HR-D955-C11B-C9E1-974D') {
            return response()->json(['msg' => 'Bad LAN Card 0000-0000-0000.', 'class' => 'error']);
        }
        $rctUser = '';
        if (!empty($user)) {
            $rctUser = $user;
        }
        $varIsLicBlocked = $this->IsLicBlocked($lic);
        $isReactDoneOnline = false;
        if ($varIsLicBlocked == 'YES') {
            return response()->json(['msg' => 'This License is BLOCKED by NPAV.', 'class' => 'error']);
        }
        $rsINFO = DB::table("info")->where('SerialNo', '=', $lic)->orderBy('customerNumber', 'desc')->select('customerNumber', 'old_customerNumber', 'SerialNo', 'Name', 'contactPerson', 'Dealer', 'CustMobile', 'dlrCode', 'DealerMobile', 'Address', 'emailID', 'installCode', 'installDate')->orderBy('customerNumber', 'desc')->first();
        if (!empty($rsINFO)) {
            $Name = $rsINFO->Name;
            // Log::info("Name :" .$Name);
            $contactPerson = $rsINFO->contactPerson;
            $Address = $rsINFO->Address;
            $emailID = $rsINFO->emailID;
            $CustMobile = $rsINFO->CustMobile;
            $Dealer = $rsINFO->Dealer;
            $dlrCode = $rsINFO->dlrCode;
            $DealerMobile = $rsINFO->DealerMobile;
            $InstCode = $rsINFO->installCode;
            $old_customerNumber = $rsINFO->old_customerNumber;
            $customerNumber = $rsINFO->customerNumber;
            $installDate = $rsINFO->installDate;
            if (str_contains(strtoupper($Address), '_NPAV_BLOCK')) {
                return response()->json(['msg' => 'License can not be Reactivated, BLOCKED License !!!', 'class' => 'error']);
            }
            // Log::info("Address " .  $Address);
            if (!empty($old_customerNumber)) {
                $NotesFolder = "Notes";
            } else {
                $old_customerNumber = $customerNumber;
                $NotesFolder = "notesmy";
            }
            //Checking for same Installation Code
            $installCodeRev = strrev($InstCode);
            $instCD = explode("-", $InstCode);
            $HexAdd = 0;
            foreach ($instCD as $key => $instCD_val) {
                $HexAdd = intval($HexAdd + hexdec($instCD_val));
            }
            // die();
            $HexAdd = dechex($HexAdd);
            $HexAdd_length = strlen($HexAdd);
            $sub_HexAdd = substr($HexAdd, 1, $HexAdd_length - 1);
            $IcToMatch = 'HR-' . $installCodeRev . '-' . strtoupper($sub_HexAdd);
            if ($IcToMatch == $txtIC  && $chkCut != true) {
                return response()->json(['msg' => "Installation-Code is same, please click 'Activate Online' button.", 'class' => 'error']);
            }
            $add = '';
            if ($chkCut != true) {
                if (!empty($Name)) {
                    $firm = $this->fnRemoveHWInfo($this->TrimString($Name));
                }
                $firm = $firm . " React: " . $user;
                if (!empty($contactPerson)) {
                    $cp = $this->TrimString($contactPerson);
                    $add = "Reactivation :" . Carbon::now()->format('d/m/Y') . "<br>";
                    $add .= "Old Customer No. :" . $customerNumber . "<br>";
                } else {
                    $cp = '';
                }
                if (!empty($address)) {
                    $add .= $this->TrimString($Address);
                }
                $add .= "CLIP :" . $request->ip();
                $add .= "React Reason:" . $txtComment;
                $email = !empty($emailID) ? $this->TrimString($emailID) : '';
                $mob = !empty($CustMobile) ? $this->TrimString($CustMobile) : '';
                $Dealer = !empty($Dealer) ? $this->TrimString($Dealer) : '';
                $dlrCode = !empty($dlrCode) ? $this->TrimString($dlrCode) : '';
                $DealerMobile = !empty($DealerMobile) ? $this->TrimString($DealerMobile) : '';
            } else {
                $isReactDoneOnline = true;
                if (!empty($Address)) {
                    $add .= $this->TrimString($Address);
                }
                $add .= "CLIP :" . $request->ip();
                $add .= "React Reason:" . $txtComment;
                $Address = substr($add, 0, 254);
            }
            //adding operator name in reactoperators
            $NewComment = substr($txtComment, 0, 100);
            DB::insert('insert into reactoperators (keyNo,custNo,operatorName,indate,isOnlineDone,reactReason) values (?, ?, ?, ?, ?, ?)', [$lic, $customerNumber, $rctUser, NOW(), $isReactDoneOnline, $NewComment]);
            // Log::info("NewComment " .  $NewComment);
        }
        //working with file
        $file = "E:/ACTIVATIONDATA/ReactGrant.ini";
        if (file_exists($file)) {
            if (!empty($lic)) {
                $fFile = file_get_contents($file);
                $lic_key_new = str_replace("-", "_", $lic);
                $licRplD = $lic_key_new . "=DONE" . "\r\n";
                $licRpl = $lic_key_new . "=ALLOWED" . "\r\n";
                if (strpos($fFile, $licRplD)) { //if key present | Replace Done with Allowed
                    // file_put_contents($file, str_replace($licRplD, $licRpl, file_get_contents($file)), FILE_APPEND);
                    file_put_contents($file, str_replace($licRplD, $licRpl, file_get_contents($file)));
                } else {
                    if (!strpos($fFile, $licRpl)) { //if key not present | append line Allowed
                        file_put_contents($file, $licRpl, FILE_APPEND);
                    }
                }
            }
        } else {
            return response()->json(['msg' => "File does not exist..!", 'class' => 'error']);
        }
        //working on directory
        $parent_folder = 'E:/ACTIVATIONDATA/React/';
        $folder = $parent_folder . "done";
        if (!file_exists($folder)) mkdir($folder, 0777, true);
        if (!empty($lic)) {
            $PreviousMonth = Carbon::now()->subMonth()->format('M');
            $File_Year = Carbon::now()->subMonth()->format('Y');
            $month_filename = $parent_folder . Carbon::now()->format('M') . '-' . Carbon::now()->format('Y') . '/' . $lic . '.txt';
            $prev_month_filename = $parent_folder .  $PreviousMonth . '-' . $File_Year . '/' . $lic . '.txt';
            $lic_file_name = $folder . '/' . $lic . '.txt';
            if (file_exists($month_filename)) {
                if (file_exists($lic_file_name)) {
                    //delete file
                    unlink($lic_file_name);
                    //move file
                    rename($month_filename, $lic_file_name);
                }
            } else if (file_exists($prev_month_filename)) {
                if (file_exists($lic_file_name)) {
                    //delete file
                    unlink($lic_file_name);
                    //move file
                    rename($prev_month_filename, $lic_file_name);
                }
            }
        }
        //end
        $log_file = "E:/ACTIVATIONDATA/" . $NotesFolder . "/" . $old_customerNumber . ".log";
        $file_text = '';
        if (file_exists($log_file)) {
            $file_text .= PHP_EOL . '----------------------------------' . PHP_EOL;
            $file_text .= 'Reactivation date :' . Carbon::now()->format('d/m/Y') . PHP_EOL;
            $file_text .= 'Old Customer No. :' . $old_customerNumber . PHP_EOL;
            $file_text .= 'operator :' . $rctUser . PHP_EOL;
            $file_text .= 'Reactivation Reason :' . $txtComment . PHP_EOL;
            file_put_contents($log_file, $file_text, FILE_APPEND);
        }
        //Reactivation Counter
        //DayWise
        $sDate_for = Carbon::now()->format('d-M-Y');
        $rs_ReactCnt = DB::connection('mysql4')->table('dateWise')->select('date_for', 'OperatorName', 'rCount', 'InDate')->where('date_for', '=', $sDate_for)->where('OperatorName', '=', $rctUser)->first();
        if (empty($rs_ReactCnt)) {
            DB::connection('mysql4')->insert('insert into DateWise (Date_for,OperatorName,rCount,InDate) values (?, ?, ?, ?)', [$sDate_for, $rctUser, 1, NOW()]);
        } else {
            $rCount = $rs_ReactCnt->rCount;
            DB::connection('mysql4')->table('DateWise')->where('OperatorName', '=', $rctUser)->where('Date_for', '=', $sDate_for)->update(array('rCount' => $rCount + 1));
        }
        //MonthWise
        $sMonth_for = Carbon::now()->format('M-Y');
        $rs_ReactCnt1 = DB::connection('mysql4')->table('monthWise')->select('Month_for', 'OperatorName', 'rCount', 'InDate')->where('month_For', '=', $sMonth_for)->where('OperatorName', '=', $rctUser)->first();
        if (empty($rs_ReactCnt1)) {
            DB::connection('mysql4')->insert('insert into monthWise (Month_for,OperatorName,rCount,InDate) values (?, ?, ?, ?)', [$sMonth_for, $rctUser, 1, NOW()]);
        } else {
            $rCount = $rs_ReactCnt1->rCount;
            DB::connection('mysql4')->table('monthWise')->where('OperatorName', '=', $rctUser)->where('Month_for', '=', $sMonth_for)->update(array('rCount' => $rCount + 1));
        }
        if ($chkCut == true) {
            // Log::info("chkCut true" );
            return response()->json(['msg' => 'Customer will activate online', 'class' => 'success']);
        } else {
            $this->UnlockCode_Ad($chkCut, $lic, $txtIC, $firm, $cp, $add, $mob, $email, $Dealer, $dlrCode, $DealerMobile);
            // Log::info("Freekey " .  $lic);
            $client = new Client(['base_uri' => 'http://activation.indiaantivirus.com/freekey/MakeFreeKeyN.asp?txtKeyNo=' . $lic]);
            $response = $client->request('POST', '', [
                'form_params' => [
                    //'txtKeyNo' => $request->Key,
                ],
            ]);
            $result = $response->getBody();
            // Log::info("result fetched");
            if ($result == "#NPAV_OK# " . $lic . " free key successfully !") {
                // Log::info("result NPAV_OK");
                $client = new Client(['base_uri' => 'http://activation.indiaantivirus.com/UnlockCode.asp', 'verify' => false, 'http_errors' => false]);
                $response2 = $client->request('POST', '', [
                    'form_params' => [
                        'txtlicense' => $lic,
                        'txtic' => $txtIC,
                        'txtcompany' => $firm,
                        'txtperson' => $cp,
                        'txtaddress' => $add,
                        'txtcustmob' => $mob,
                        'txtemail' => $email,
                        'txtdealer' => $Dealer,
                        'txtdlrcode' => $dlrCode,
                        'txtdlrmob' => $DealerMobile,
                    ],
                ]);
                // Log::info("response2 fetched");
                $result2 = $response2->getBody();
                return $result2;
            } else {
                return response()->json(['msg' => "Server Error.", 'class' => 'error']);
            }
        }
    }
    /**
     *
     * Sure Block || req by preeti mam on 15/03/2024 | once reactivation is allowed then insert key in sureucblock table to block uc immediately
     *
     */
    public function sureBlockUc(Request $request)   //multiple UC Block
    {
        try {
            $lic = $request->lic;
            $CustomerNo = $request->CustomerNo;
            if ($lic != "" && $CustomerNo != '') {
                $rsINFO = DB::table("info")
                    ->select('unlockCode', 'customerNumber', 'Address')
                    ->where('SerialNo', '=', $lic)
                    ->where('customerNumber', '<=', $CustomerNo)
                    ->where('Address', 'not like', 'AUTO-REACT* %')
                    ->orderBy('customerNumber', 'desc')
                    ->get();
                $currentUC = DB::table("info")
                    ->where('SerialNo', '=', $lic)
                    ->orderBy('customerNumber', 'desc')
                    ->value('unlockCode');
                if (!empty($rsINFO)) {
                    $added = 0;
                    $error = 0;
                    $skipped = 0;
                    foreach ($rsINFO as $row) {
                        $uc = $row->unlockCode;
                        // if ($uc == $currentUC) {
                        //     $skipped++;
                        // } else {
                        $checkKey = DB::connection('mysql5')->table('sureucblock')->where('keyNo', $lic)->where('UnlockCode', $uc)->count();
                        if ($checkKey == 0) {
                            $saveinSureBloc = DB::connection('mysql5')->table('sureucblock')->insert([
                                'UnlockCode' => $uc,
                                'keyNo' => $lic,
                                'reason' => 'Reactivation Userinfo2 reactivate',
                                'inDate' => now(),
                                'lastBlockDate' => now(),
                                'blockCount' => 12,
                            ]);
                            if ($saveinSureBloc) {
                                /** Write key in SureUC block folder */
                                if (!file_exists('E:\ACTIVATIONDATA\SureUCBlock')) {
                                    mkdir('E:\ACTIVATIONDATA\SureUCBlock', 0755, true);
                                }
                                $fileURL = 'E:\ACTIVATIONDATA\SureUCBlock\sureucblockkeys.log';
                                $text = '';
                                $text = "--- LIC : " . $lic . " | UnlockCode : " . $uc . " | Blocked on :" . date('m/d/Y h:i:s A') . " \r\n";
                                if (file_exists($fileURL)) {
                                    file_put_contents($fileURL, $text, FILE_APPEND);
                                } else {
                                    fopen($fileURL, "w");
                                    file_put_contents($fileURL, $text, FILE_APPEND);
                                }
                                $added++;
                            } else {
                                $error++;
                            }
                        } else {
                            $skipped++;
                        }
                        // }
                    }
                    return 'Added : ' . $added . ' Skipped : ' . $skipped . ' Error : ' . $error;
                } else {
                    return 'Info not found..!';
                }
            } else {
                return 'Lic or CustomerNo is Empty..!';
            }
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }
    //Function to check if license is BLOCKED
    public function IsLicBlocked($licToCheck)
    {
        $SInitial = substr($licToCheck, 0, 1);
        $SNo = substr($licToCheck, -10);
        $Resp = "NO";
        //Check If Lic is blocked then Return YES
        $ActivationCode = DB::table('SerialNums')->select('ActivationCode')->where('SerialInitial', '=', $SInitial)->where('SerialNo', '=', $SNo)->first();
        if (!empty($ActivationCode) && str_contains(strtoupper($ActivationCode->ActivationCode), 'BLOCKED')) {
            $Resp = "YES";
        }
        return $Resp;
    }
    public function fnRemoveHWInfo($strToRemove)
    {
        $strResponse = $strToRemove;
        if (str_contains($strResponse, 'MBID#:')) {
            $length = (strpos($strResponse, "MBID#:") - 1);
            $strResponse = substr($strResponse, 0, $length);
        }
        if (str_contains($strResponse, 'HDD#:')) {
            $length = (strpos($strResponse, "HDD#:") - 1);
            $strResponse = substr($strResponse, 0, $length);
        }
    }
    public function UnlockCode_Ad($chkCut, $lic, $txtIC, $firm, $cp, $add, $mob, $email, $Dealer, $dlrCode, $DealerMobile)
    {
        $strlicense = strtoupper(substr($lic, 0, 12));
        $stric = strtoupper(substr($txtIC, 0, 27));
        $orgIc = $stric;
        $strcompany = substr($firm, 0, 100);
        $strperson = substr($cp, 0, 100);
        $straddress = substr($add, 0, 200);
        $strcustmob = substr($mob, 0, 50);
        $stremail = substr($email, 0, 20);
        $strdealer = substr($Dealer, 0, 100);
        $strDlrCode = strtoupper(substr($dlrCode, 0, 8));
        $strDlrMob = substr($DealerMobile, 0, 50);
    }
    public function FetchUnLockCodeDetails(Request $request)
    {
        $CustNo = $request->customer_no;
        $UnlockCode = $request->unlock_code;
        $SerialNo = $request->serial_no;
        if (empty($CustNo) || empty($UnlockCode || empty($SerialNo))) {
            echo '<h2>Invalid Number of parameters!</h2>';
            die;
        }
        $UnlockCodeDetails = DB::table('UCBlock')->select('reason', 'isDelete', DB::raw('DATE_FORMAT(blockedDate,"%d-%b-%Y %h:%i %p") AS bDate'), DB::raw('DATE_FORMAT(updateDate,"%d-%b-%Y %h:%i %p") AS uDate'))->where('unlockCode', '=', $UnlockCode)->first();
        $rsTopup = DB::table('serialnums')->select('RenewalDone')->where('ActivationCode', '=', $UnlockCode)->first();
        return view('unlockcode_model', compact('UnlockCodeDetails', 'rsTopup', 'UnlockCode', 'SerialNo', 'CustNo'));
    }
    public function UpdateUnlockCodeStatus(Request $request)
    {
        $AdminPassword = $request->txtPwd;
        if ($AdminPassword != '157QtpahB16GAMsk') {
            return response()->json(['msg' => 'Please Check your password!', 'class' => 'error']);
        }
        $sts = ($request->rdoSt == "true") ? false : true;
        if ($request->chkTopup == true) {
            $topDone = true;
            $bType = "T";
        } else {
            $topDone = false;
            $bType = "R";
        }
        $comment = $request->txtComment;
        $cmt = (!empty($comment)) ?  substr("M#" . $comment, 0, 200) : "M#";
        $LicKey = $request->txtLic;
        $keyNo = str_replace("=", "-", $LicKey);
        $UnlockCode = $request->txtUc;
        $rsUCB = DB::table('UCBlock')->select('*')->where('UnlockCode', '=', $UnlockCode)->first();
        $rsExpDt = DB::table('info')->select('ExpiryDate')->where('unlockCode', '=', $UnlockCode)->orderBy('customerNumber', 'desc')->first();
        $ExpiryDate = Carbon::createFromFormat('d/m/Y', $rsExpDt->ExpiryDate)->format('Y-m-d');
        if (!empty($rsUCB)) {
            DB::table('ucBlock')->where('unlockCode', '=', $UnlockCode)
                ->update([
                    'reason' => $cmt,
                    'expiryDate' => $ExpiryDate,
                    'isDelete' => $sts,
                    'updateDate' => Date('Y-m-d H:i:s'),
                    'blockType' => $bType
                ]);
            if ($sts == false) {
                $msg = "Blocked UC";
            } else {
                $msg = "UnBlocked UC";
            }
        } else {
            $rsChkUc = DB::table('serialnums')->where('ActivationCode', '=', $UnlockCode)->count();
            if ($rsChkUc <= 1) {
                DB::insert('insert into ucBlock (keyNo,unlockCode,reason,blockedDate,expiryDate,isDelete,updateDate,blockType) values (?, ?, ?, ?, ?, ?, ?, ?)', [$keyNo, $UnlockCode, $cmt, NOW(), $ExpiryDate, $sts, NOW(), $bType]);
                $msg = "Blocked UC";
            } else {
                $msg = $rsChkUc . ' ' . "Duplicate UC found in SerialNums, Can't Block !!";
            }
        }
        //Update Serialnums table for renewaldone
        $KeyNo = explode("-", $keyNo);
        DB::table('serialnums')->where('SerialInitial', '=', $KeyNo[0])->where('SerialNo', '=', $KeyNo[1])->update(array('RenewalDone' => $topDone));
        return response()->json(['msg' => $msg, 'class' => 'success']);
    }
    public function GetDlrScore(Request $request)
    {
        $DealerCode = $request->txtDlrCode;
        if (empty($DealerCode)) {
            return response()->json(['msg' => 'Invalid Parameter!', 'class' => 'error']);
        }
        //  $DealerDetails =[];
        $RewardLog = [];
        $DealerDetails = DB::connection('mysql3')
            ->table('InstallInfo.Dealers as d')
            ->leftJoin('DlrScoreMaster as s', 'd.DlrCode', '=', 's.DlrCode')
            ->select('d.DlrNumber', 'd.DlrCompany', 'd.DlrPerson', 'd.DlrMobile', 'd.DlrEmail', 'd.DlrCity', 'd.dlrCode', 'd.DlrAddress', 'd.dlrSchemeRatings', 'd.dlrSchemeAdminRemarks', 'd.DlrCity', 'd.DlrDistrict', 'd.DlrState', (DB::raw('DATE_FORMAT(d.InDate,"%d-%b-%Y %h:%i %p") as fInDate')), 's.CurrentDays', 's.TotalRewards', 's.isInMaharashtra', 's.mhSchemePacks', 's.25Apr14_25Jun14SchemeScore')
            ->where('d.DlrCode', '=', $DealerCode)
            ->first();
        if (empty($DealerDetails)) {
            return response()->json(['msg' => 'Invalid Dealer!', 'class' => 'error']);
        }
        // $RewardLog = DB::connection('mysql3')->table('DlrSentMail')->select((DB::raw('DATE_FORMAT(SentDate, "%d-%b-%Y %r") as SentDate')),'Id','EmailStatus','SentLic','DlrCode','SentType')->where('DlrCode', '=',$DealerCode)->orderBy('Id', 'desc')->paginate(10);
        return view('dealer_score_model', compact('DealerDetails', 'RewardLog'));
    }
    public function fetchRewardLog(Request $request)
    {
        $DealerCode = $request->dealer_code;
        // dd($DealerCode);
        $RewardLog = DB::connection('mysql3')
            ->table('DlrSentMail')
            ->select((DB::raw('DATE_FORMAT(SentDate, "%d-%b-%Y %r") as SentDate')), 'Id', 'EmailStatus', 'SentLic', 'DlrCode', 'SentType')
            ->where('DlrCode', '=', $DealerCode)
            ->orderBy('Id', 'desc')
            ->limit(100)
            ->get();
        return view('dealer_score_model_pagination', compact('RewardLog'));
    }
    public function SendRewardMail(Request $request)
    {
        $Id = $request->id;
        $DealerCode = $request->dlr_code;
        $SentLic = $request->sent_lic;
        if (empty($Id) || empty($DealerCode) || empty($SentLic)) {
            return response()->json(['msg' => 'Invalid Parameter!', 'class' => 'error']);
        }
        $DealerScore = DB::connection('mysql3')
            ->table('DlrScoreMaster')
            ->select('DlrEmail')
            ->where('DlrCode', '=', $DealerCode)
            ->first();
        $DealerEmail = !empty($DealerScore->DlrEmail) ? $DealerScore->DlrEmail : '';
        if (empty($DealerEmail)) {
            return response()->json(['msg' => 'Email ID not avaliable !', 'class' => 'error']);
        }
        $emailTxt = '';
        $emailTxt .= "<br/><b>Dear Esteemed NPAV Dealer,</b>";
        $emailTxt .=  "<br/>";
        $emailTxt .=  "<br/>Thank you for promoting and installing Net Protector - Total PC Protection.";
        $emailTxt .=  "<br/>";
        $emailTxt .=  "<br/>";
        $emailTxt .=  "<br/>We have started a new scheme to reward the dealers who install Net Protector.";
        $emailTxt .=  "<br/>";
        $emailTxt .=  "<br/>When activating Net Protector online, your dealer code is rewarded with NPAV Days, as per the chart.";
        $emailTxt .=  "<br/>Please always enter your Dealer Code while activating the pack. Please inform to your Engineers and Customers.";
        $emailTxt .=  "<br/>";
        $emailTxt .=  "<br/>After winning 365 Days, A 1 Year License will be sent to your registered email id.";
        $emailTxt .=  "<br/>This license you can sell to your any customers.";
        $emailTxt .=  "<br/>";
        $emailTxt .=  "<br/>The product CD and Pack will be couriered to the Stockist / Distributor of your region.";
        $emailTxt .=  "<br/>";
        $emailTxt .=  "<br/>---";
        $emailTxt .=  "<br/>";
        $emailTxt .=  "<br/><b>Congratulations!</b>";
        $emailTxt .=  "<br/>Your Dealer Code has been rewarded with a 1 Year License";
        $emailTxt .=  "<br/>";
        $emailTxt .=  "<br/><b>License Number : " . $SentLic;
        $emailTxt .=  "<br/>Your Dealer Code : " . $DealerCode;
        $emailTxt .=  "<br/>Registered email id : " . $DealerEmail . "</b>";
        $emailTxt .=  "<br/>";
        $emailTxt .=  "<br/>---";
        $emailTxt .=  "<br/>";
        $emailTxt .=  "<br/>Score Chart*";
        $emailTxt .=  "<br/>1 Year - 12 Days";
        $emailTxt .=  "<br/>3 Year - 24 Days";
        $emailTxt .=  "<br/>1 Year Server - 24 Days";
        $emailTxt .=  "<br/>3 Year Server - 36 Days";
        $emailTxt .=  "<br/>";
        $emailTxt .=  "<br/>* Scheme may change as per company policy from time to time.";
        $emailTxt .=  "<br/>";
        $emailTxt .=  "<br/>";
        $emailTxt .=  "Now Check your score and Get monthwise Renewal List by logging to your Dealer Portal.<br />";
        $emailTxt .=  "To login follow the link:<br /><br />";
        $emailTxt .=  "http://www.computerjaipur.com/DlrPortal/Login.aspx<br />";
        $emailTxt .=  "<br/>";
        $emailTxt .=  "<br/>";
        $emailTxt .=  "<br/>";
        $emailTxt .=  "<br/>Best Regards,";
        $emailTxt .=  "<br/><b>NetProtector AntiVirus Team</b>";
        $emailTxt .=  "<br/>sales@indiaantivirus.com";
        $templatename = "Dealer Portal NPAV";
        $this->templateforemail($emailTxt, $templatename);
        $fullmsg =  $this->message;
        $client = new Client(['verify' => false]);
        $request = $client->post('http://srv7.computerkolkata.com/email/send', [
            'json' => [
                'host' => 'mail.npav.net',
                'user' => 'support@npav.net',
                'pass' => 's3u2p1p0rt',
                'to' => $DealerEmail,
                'subject' => 'Congratulations! NPAV 1 Yr Key Reward !!',
                'body' => $fullmsg,
            ]
        ]);
        if ($request->getStatusCode() == 200) {
            DB::connection('mysql3')
                ->table('dlrsentmail')
                ->where('Id', '=', $Id)
                ->update(array('EmailStatus' => 'Sent'));
            return response()->json(['msg' => 'Email sent successfully !', 'class' => 'success']);
        } else {
            DB::connection('mysql3')
                ->table('dlrsentmail')
                ->where('Id', '=', $Id)
                ->update(array('EmailStatus' => 'Error'));
            return response()->json(['msg' => 'Error !', 'class' => 'error']);
        }
    }
    public function strReplace($str)
    {
        // return str_replace('/&|\=/', '', $str);
        $temp = str_replace('=', '', $str);
        $temp = str_replace('&', '', $str);
        return $temp;
    }
    public function AddDays(Request $request)
    {
        // dd($request->all());
        $LicNo = trim($request->txtLic);
        $Comment = $request->txtComment;
        $AddDays = $request->txtAddDays;
        $AdminPassword = $request->txtPwd;
        $CustomerCheck = !empty($request->chkCut) ? True : False;
        if (empty($LicNo) || empty($Comment) || empty($AddDays) || empty($AdminPassword)) {
            return response()->json(['msg' => 'Invalid Parameter!', 'class' => 'error']);
        }
        if ($AdminPassword != 'Hsp316rGjn276B') {
            return response()->json(['msg' => 'Please Check your password!', 'class' => 'error']);
        }
        if (strlen($LicNo) != 12) {
            return response()->json(['msg' => 'Invalid License (Length)!', 'class' => 'error']);
        }
        if ($AddDays < -365 || $AddDays > 30) {
            return response()->json(['msg' => 'Days should be only +- 30', 'class' => 'error']);
        }
        //Save Add Days Log
        $addDaysLog = DB::table('adddayslog')->insert([
            'KeyNo' => $LicNo,
            'Operator' => auth()->user()->User_Name,
            'DaysAdded' => $AddDays,
            'Indate' => NOW()
        ]);
        $InfoData = DB::table("info")->select('customerNumber', 'SerialNo', 'installCode', 'Name', 'contactPerson', 'Dealer', 'CustMobile', 'dlrCode', 'DealerMobile', 'emailID', 'Address', 'installDate')->where('SerialNo', '=', $LicNo)->orderBy('customerNumber', 'desc')->first();
        if (empty($InfoData)) {
            return response()->json(['msg' => 'License No. NOT FOUND !', 'class' => 'error']);
        }
        $oldCustNo = $InfoData->customerNumber;
        $installDate = $InfoData->installDate;
        $InstCode = $InfoData->installCode;
        $Address = $InfoData->Address;
        $firm = $this->strReplace($InfoData->Name);
        $contactPerson = $this->strReplace($InfoData->contactPerson);
        $email = $this->strReplace($InfoData->emailID);
        $CustMobile = $this->strReplace($InfoData->CustMobile);
        $Dealer = $this->strReplace($InfoData->Dealer);
        $dlrCode = $this->strReplace($InfoData->dlrCode);
        $DealerMobile = $this->strReplace($InfoData->DealerMobile);
        $add = '';
        if ($CustomerCheck != True) {
            $installCodeRev = strrev($InstCode);
            if (strpos($InstCode, '-', 0) > 0) {
                $instCD = explode("-", $InstCode);
                $HexAdd = 0;
                foreach ($instCD as $key => $instCD_val) {
                    $HexAdd = intval($HexAdd + hexdec($instCD_val));
                }
                $HexAdd = dechex($HexAdd);
                $HexAdd_length = strlen($HexAdd);
                $sub_HexAdd = substr($HexAdd, 1, $HexAdd_length - 1);
                $Install_Code = 'HR-' . $installCodeRev . '-' . strtoupper($sub_HexAdd);
            }
        } else {
            if (!empty($Address)) {
                $add .= $this->TrimString($Address);
            }
            $add .= " CLIP :" . $request->ip();
            $add .= " React Reason :" . $Comment;
            $Address = $add;
        }
        //working in ReactGrant.ini file
        if (file_exists("E:/ACTIVATIONDATA/ReactGrant.ini")) {
            if (!empty($LicNo)) {
                $file_content = File::get("E:/ACTIVATIONDATA/ReactGrant.ini");
                $licRplD = str_replace('-', '_', $LicNo) . "=DONE" . PHP_EOL;
                $licRpl = str_replace('-', '_', $LicNo) . "=ALLOWED" . PHP_EOL;
                if (strpos($file_content, $licRplD) > 0) {
                    fopen("E:/ACTIVATIONDATA/ReactGrant.ini", "w");
                    $temp =  str_replace($licRplD, $licRpl, $file_content);
                    file_put_contents('E:/ACTIVATIONDATA/ReactGrant.ini', $temp);
                } else {
                    if (strpos($file_content, $licRpl) == false) {
                        file_put_contents('E:/ACTIVATIONDATA/ReactGrant.ini', $licRpl, FILE_APPEND);
                    }
                }
            }
        }
        //working in react\done folder
        if (!File::exists("E:/ACTIVATIONDATA/React/done")) {
            File::makeDirectory("E:/ACTIVATIONDATA/React/done", true, true);
        }
        if (!empty($LicNo)) {
            $current_month = Carbon::now()->format('M');
            $current_year = Carbon::now()->format('Y');
            $sub_directory = 'E:/ACTIVATIONDATA/React/';
            $monthFolderPath = ($sub_directory . $current_month . "-" . $current_year);
            $filePath = $monthFolderPath . '/';
            if ((file_exists($filePath . $LicNo . '.txt'))) {
                if (file_exists('E:/ACTIVATIONDATA/React/done/' . $LicNo . '.txt')) {
                    unlink('E:/ACTIVATIONDATA/React/done/' . $LicNo . '.txt'); //delete file from done folder if already exist
                }
                //move file from monthwise folder to done folder
                rename($filePath . $LicNo . '.txt', 'E:/ACTIVATIONDATA/React/done/' . $LicNo . '.txt');
            }
        }
        //Working on log file
        $myfile = fopen("E:/ACTIVATIONDATA/Notes/" . $oldCustNo . ".log", "w");
        $text = '----------------------------------' . PHP_EOL;
        $text .= 'Reactivation date: ' . Date('d/m/Y') . PHP_EOL;
        $text .= 'Old Customer No. : ' . $oldCustNo . PHP_EOL;
        $text .= 'operator: ' . auth()->user()->Display_Name . PHP_EOL;
        $text .= 'Ractivation Reason: ' . $Comment . PHP_EOL;
        // $text;
        $writeFile =   file_put_contents("E:/ACTIVATIONDATA/Notes/" . $oldCustNo . ".log", $text);
        if ($writeFile == true) {
            $new_installDate = date('Y-m-d', strtotime($installDate . ' + ' . $AddDays . ' days'));
            /**API to get unlock code */
            $client = new Client(['base_uri' => 'http://activation.indiaantivirus.com/freekey/MakeFreeKeyN.asp?txtKeyNo=' . $LicNo]);
            $response = $client->request('POST', '', [
                'form_params' => [],
            ]);
            $result = $response->getBody();
            if ($result == "#NPAV_OK# " . $LicNo . " free key successfully !") {
                $client_u = new Client(['base_uri' => 'http://activation.indiaantivirus.com/UnlockCode_ad.asp', 'verify' => false, 'http_errors' => false]);
                $response_uc = $client_u->request('POST', '', [
                    'form_params' => [
                        'txtlicense' => $LicNo,
                        'txtic' => $Install_Code,
                        'txtcompany' => $firm,
                        'txtperson' => $contactPerson,
                        'txtaddress' => substr($add, 0, 200),
                        'txtcustmob' => $CustMobile,
                        'txtemail' => $email,
                        'txtdealer' => $Dealer,
                        'txtdlrcode' => $dlrCode,
                        'txtdlrmob' => $DealerMobile,
                        'txtAddDays' => $AddDays,
                    ]
                ]);
                $result_uc = $response_uc->getBody();
                dd($result_uc);
                $plainText = strip_tags($result_uc);
                $temp = explode('9370113599', trim($plainText));  //seperates string from hardcoded mobile number to get only unlockcode
                $new_unlockCode = preg_replace("/&#?[a-z0-9]+;/i", "", end($temp));
                return $result_uc;
            }
        } else {
            return response()->json(['msg' => 'Something went wrong..!', 'class' => 'error']);
        }
    }
    public function show_block_history($serial_no)
    {
        $rsInfo = DB::connection('mysql5')->table("ucblockedlog")->select('*', (DB::raw('DATE_FORMAT(InDate, "%d-%b-%Y %h:%i %p") as iDt')), (DB::raw('DATE_FORMAT(updateDate, "%d-%b-%Y %h:%i %p") as uDt')))->where('keyNo', '=', $serial_no)->orderBy('sID', 'asc')->get();
        $rsChkUc = DB::connection('mysql5')->table("ucchecklog")->select('*', (DB::raw('DATE_FORMAT(InDate, "%d-%b-%Y %h:%i %p") as iDt')), (DB::raw('DATE_FORMAT(updateDate, "%d-%b-%Y %h:%i %p") as uDt')))->where('keyNo', '=', $serial_no)->orderBy('sID', 'asc')->get();
        $KeyInfo = DB::connection('mysql5')->table("keyBlock")->select('keyNo', 'counter', 'isRemoved', 'removeReason', (DB::raw('DATE_FORMAT(addedDate, "%d-%b-%Y %h:%i %p") as addDt')), (DB::raw('DATE_FORMAT(updatedDate, "%d-%b-%Y %h:%i %p") as updDt')), (DB::raw('DATE_FORMAT(lastCounterDate, "%d-%b-%Y %h:%i %p") as hcDt')), (DB::raw('DATE_FORMAT(removedDate, "%d-%b-%Y %h:%i %p") as remDt')))->where('keyNo', '=', $serial_no)->orderBy('kId', 'asc')->get();
        return view('block_history', compact('rsInfo', 'rsChkUc', 'KeyInfo'));
    }
    public function ShowLog(Request $request)
    {
        $serial_no = $request->serial_no;
        if (empty($serial_no)) {
            return response()->json(['msg' => 'Invalid Parameter!', 'class' => 'error']);
        }
        $LogInfo = DB::table("trackautoreactmaster")->select('LicNo', 'ReactType', 'MatchedField', 'MatchedIn', 'SecretPIN', 'PINMobile', 'userInputMobile', 'WhyReactGiven', (DB::raw('DATE_FORMAT(ReactDate, "%d-%b-%Y %h:%i %p") as fReactDate ')))->where('LicNo', '=', $serial_no)->orderBy('AutoReactId', 'asc')->limit(10)->get();
        return view('show_log', compact('LogInfo'));
    }
    public function TrimString($str)
    {
        return preg_replace('/&|\=/', '', $str);
    }
    public function createNotes(Request $request)
    {
        $CustNo = $request->custNo;
        $text = $request->notetext;
        $fileURL = $request->fileURL;
        // dd($request->all());
        if (file_exists($fileURL)) {
            fopen($fileURL, "w");
            $saveText_edrive =   file_put_contents($fileURL, $text, FILE_APPEND);
        } else {
            fopen($fileURL, "w");
            $saveText_edrive =   file_put_contents($fileURL, $text, FILE_APPEND);
        }
        $filename = $CustNo   . '.log';
        $saveText_local =  Storage::disk('local')->put($filename, $text);
        if ($saveText_local == true && $saveText_edrive == true) {
            $content =  file_get_contents($fileURL, "r");
            return response()->json(['success' => 'Note Created Successfully.', 'Note' => $content]);
        }
        return response()->json(['error' => 'Something went wrong.', 'Note' => '']);
    }
    public function addRemark(Request $request)
    {
        $CustNo = $request->custNo;
        $text = $request->notetext;
        $fileURL = $request->fileURL;
        if (!file_exists('E:\ACTIVATIONDATA\Remark')) {
            mkdir('E:\ACTIVATIONDATA\Remark', 0755, true);
        }
        if (file_exists($fileURL)) {
            fopen($fileURL, "w");
            $saveText_edrive =   file_put_contents($fileURL, $text, FILE_APPEND);
        } else {
            fopen($fileURL, "w");
            $saveText_edrive =   file_put_contents($fileURL, $text, FILE_APPEND);
        }
        if ($saveText_edrive == true) {
            $content =  file_get_contents($fileURL, "r");
            return response()->json(['success' => 'Remark added successfully.', 'Note' => $content]);
        }
        return response()->json(['error' => 'Something went wrong.', 'Note' => '']);
    }
    public function sendEmail(Request $request)
    {
        $body = "<p>" . $request->email_text . "</p>";
        // $client = new Client();
        $client = new Client(['verify' => false]);
        $response = $client->post('http://portal2.npav.net/api/emailapi', [
            'form_params' => [
                "to" => $request->emailId,
                'from' => 'support@npav.net',
                'title' => 'NPAV Activation Mail',
                "subject" => $request->ucSub,
                "body" => $body
            ]
        ]);
        $send_email = $response->getBody();
        if (($send_email == TRUE)) {
            return response()->json([
                'Status' =>  "success",
                'Message' => 'Email sent successfully..!',
            ]);
        } else {
            return response()->json([
                'Status' =>  "error",
                'Message' => 'Failed to send Email..!',
            ]);
        }
    }
    public function sendSMS(Request $request)
    {
        if (empty($request->templateid)) {
            return response()->json([
                'Status' =>  "error",
                'Message' => 'Failed to send SMS. Invalid template id..!',
            ]);
        }
        $url = URL::to('/api/smsapi');
        $baseuri = $url;
        $msg = $request->message_text_sms;
        $templateid = $request->templateid;
        $mobile = $request->custMobile;
        $senderId = 'NPAVIN';
        $client = new Client(['verify' => false]);
        $response = $client->post($baseuri, [
            'form_params' => [
                'msg' => $msg,
                'templateid' => $templateid,
                'mobile' => $request->custMobile,
                'senderId' => $senderId
            ],
        ]);
        $send_sms = $response->getBody();
        if (($send_sms == TRUE)) {
            return response()->json([
                'Status' =>  "success",
                'Message' => 'SMS sent successfully..!',
            ]);
        } else {
            return response()->json([
                'Status' =>  "error",
                'Message' => 'Failed to send SMS..!',
            ]);
        }
    }
    /**
     *
     * Release Key
     *
     * */
    public function releaseKey(Request $request)
    {
        $licNo = $request->licNo;
        $instCode = $request->instCode;
        $instDate = $request->instDate;
        $custName = $request->custName;
        $custMobile = $request->custMobile;
        $adminPassword = $request->adminPassword;
        $relReason = $request->relReason;
        $updInstDate = date('d/m/Y', strtotime($instDate));
        $add =  substr($relReason, 0, 150) . " Correct Inst Date Is: " . $updInstDate . " Key released by : " . auth()->user()->User_Name;
        if ($adminPassword != 'Xfqp81v9Hmai52dG') {
            return response()->json(['msg' => 'Invalid Password.', 'Status' => 'error']);
        }
        if ($licNo == '' || strlen($licNo) != 12 || strpos($licNo, "-") != 1) {
            return response()->json(['msg' => 'Please Enter Valid Lic Number.', 'Status' => 'error']);
        }
        if (strlen($instCode) != 27) {
            return response()->json(['msg' => 'Invalid Installation Code (Length)!.', 'Status' => 'error']);
        }
        $licNoArr = explode('-', $licNo);
        $checkActivationCode = DB::connection('mysql')->table('SerialNums')
            ->select('ActivationCode')
            ->where('SerialInitial', $licNoArr[0])
            ->where('SerialNo', $licNoArr[1])
            ->first();
        if ($checkActivationCode) {
            $updateActivationCode = DB::connection('mysql')->table('SerialNums')
                ->where('SerialInitial', $licNoArr[0])
                ->where('SerialNo', $licNoArr[1])
                ->update([
                    'ActivationCode' => null,
                    'updateDate' => now()
                ]);
            $oldActCode = $checkActivationCode->ActivationCode;
            //working with file
            if (!file_exists("E:\ACTIVATIONDATA\Notes\ReleaseLic.txt")) {
                fopen("E:\ACTIVATIONDATA\Notes\ReleaseLic.txt", 'w');
            }
            $text = 'Date:' . Date("d/m/y") . ', Lic No:' . $licNo . ', Old ActCode: ' . $oldActCode . "\r\n";
            file_put_contents('E:\ACTIVATIONDATA\Notes\ReleaseLic.txt', $text, FILE_APPEND);
            $installDate = $instDate;
            $strinstallDate = explode("-", $installDate);
            $d = $strinstallDate[2]; //20
            $Y = $strinstallDate[0]; //2024
            $m = $strinstallDate[1];
            $strlicense = substr($licNo, 0, 12);
            $stric = substr($instCode, 0, 27);
            $strperson = substr($custName, 0, 100);
            $strcustmob = substr($custMobile, 0, 50);
            $tdate = $d;
            $tmonth = $m;
            $fnDate = $tdate . '/' . $tmonth . '/' . $Y;
            /**API to get unlock code */
            $client = new Client(['base_uri' => 'http://activation.indiaantivirus.com/freekey/MakeFreeKeyN.asp?txtKeyNo=' . $strlicense]);
            $response = $client->request('POST', '', [
                'form_params' => [],
            ]);
            $result = $response->getBody();
            if ($result == "#NPAV_OK# " . $strlicense . " free key successfully !") {
                /**---- Insert Release Lic Log in database table ----*/
                $addRelLicLog = DB::connection('mysql')->table('releaseliclog')->insert([
                    'indatetime' => now(),
                    'licNo' => $strlicense,
                    'instCode' => $stric,
                    'InstDate' => $Y . '-' . $tmonth . '-' . $tdate,
                    'CustName' => $strperson,
                    'CustMobile' => $strcustmob,
                    'Source' => 'P',
                    'UserInfoLogin' => auth()->user()->User_Name,
                ]);
                $client_u = new Client(['base_uri' => 'http://activation.indiaantivirus.com/UnlockCode_instDt.asp', 'verify' => false, 'http_errors' => false]);
                $response_uc = $client_u->request('POST', '', [
                    'form_params' => [
                        'txtlicense' => $strlicense,
                        'txtic' => $stric,
                        'txtcompany' => '',
                        'txtperson' => $strperson,
                        'txtaddress' => substr($add, 0, 200),
                        'txtcustmob' => $strcustmob,
                        'txtemail' => '',
                        'txtdealer' => '',
                        'txtdlrcode' => '',
                        'txtdlrmob' => '',
                        'txtUserInstDate' => $fnDate,
                        'txtphno' => '',
                    ]
                ]);
                $result_uc = $response_uc->getBody();
                $plainText = strip_tags($result_uc);
                $temp = explode('9370113599', trim($plainText));  //seperates string from hardcoded mobile number to get only unlockcode
                $new_unlockCode = preg_replace("/&#?[a-z0-9]+;/i", "", end($temp));
                return $result_uc;
            } else {
                return response()->json(['msg' => 'Something went wrong..!', 'Status' => 'error']);
            }
        } else {
            return response()->json(['msg' => 'Lic No. NOT FOUND ! Lic. release failed !.', 'Status' => 'error']);
        }
    }
    /***
     *
     * Dealer Act Count
     *
     * */
    public function dlrActCount(Request $req)
    {
        $date = Date('Y-m-d');
        $Date1yrPrev = date('Y-m-d', strtotime($date . " -1 year"));
        $dlrCode = $req->dlrCode;
        $duration = $req->duration;
        $sql = DB::connection('mysql')->table('info')->select(
            DB::raw('COUNT(customerNumber) AS CntCustNO'),
            DB::raw("SUM(IF(Left(SerialNo,2)='E-',1,0)) AS oYr"),
            DB::raw("sum(IF(Left(SerialNo,2)='A-',1,0)) AS tYr")
        )
            ->where('dlrCode', $dlrCode);
        if ($duration == '1Yr') {
            $sql->where('installDate', '>', $Date1yrPrev . ' 00:00:00')
                ->where('installDate', '<=', $date . ' 23:59:59');
            $fromDate = $Date1yrPrev;
            $toDate = $date;
        }
        if ($duration == '15Oct') {
            $sql->where('installDate', '>', '2010-10-15 00:00:00')
                ->where('installDate', '<=', $date . ' 23:59:59');
            $fromDate = '2010-10-15';
            $toDate = $date;
        }
        $count =  $sql->first();
        return view('dlrActCntPAgination', compact('count', 'fromDate', 'toDate'));
    }
    /***
     *
     * Get Suggested Keys
     *
     */
    public function getSuggestedKeys(Request $req)
    {
        $licNo = $req->licNo;
        $explodeLic = explode('-', $licNo);
        $getMatchedKey = DB::table('serialnums')
            ->select('SerialInitial', 'SerialNo')
            ->where('SerialInitial', $explodeLic[0])
            ->where('SerialNo', 'like', $explodeLic[1] . '%')
            ->limit(10)
            ->get();
        return  $getMatchedKey;
    }
    /**
     *
     * OTP For Remote Users
     *
     */
    public function sendOTPForm(Request $request)
    {
        $getMobileNo = DB::connection('mysql')->table('userinfo_login')->select('User', 'Mobile', 'Email')->where('User', $request->User_Name)->first();
        if ($getMobileNo != '') {
            if ($getMobileNo->Mobile != '') {
                $Mobile = $getMobileNo->Mobile;
                $Email = $getMobileNo->Email;


                $maskedEmail = substr($Email, 0, -10) . 'xxxx';
                $maskedMobile = substr($Mobile, 0, -4) . 'xxxx';


                $User = $getMobileNo->User;
                if (!empty($Mobile) || !empty($Email)) {
                    $otp = rand(100000, 999999);
                    $OtpTime = "10 mins";
                    $deleteOldOTP = DB::connection('mysql')->table('userinfo_otp')->whereDate('inDate', '!=', date('Y-m-d'))->delete();
                    $insertNewOTP = DB::connection('mysql')->table('userinfo_otp')->insert([
                        'User' => $User,
                        'Mobile' => $Mobile,
                        'Otp' => $otp,
                        'InDate' => date('Y-m-d H:i:s'),
                    ]);
                    if ($Email) {
                        $emailTxt = '';
                        $emailTxt .=  '<tr>
                            <td bgcolor="#ffffff" align="left" style="padding: 20px 30px 40px 30px; color: #666666; font-family: "Lato", Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                                <p style="margin: 10px;">Dear, ' . $User . '</p>
                            </td>
                        </tr>';
                        $emailTxt .=  '<tr>
                            <td bgcolor="#ffffff" align="left">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td bgcolor="#ffffff" align="center" style="padding: 20px 30px 60px 30px;">
                                            <table border="0" cellspacing="0" cellpadding="0">
                                                <tbody><tr>
                                                    <td align="center" style="border-radius: 155px;width: 500px;" bgcolor="#e9ffde">OTP for UserInfo Access is ' . $otp . ' (valid for 10 mins).<br>Do Not Share it with anyone!"</td>
                                                </tr>
                                            </tbody></table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td bgcolor="#ffffff" align="left" style="padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #666666; font-family: "Lato", Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                                <p style="margin: 10px;">Thank You,</p>
                                <p style="margin: 10px;"><strong>NetProtector AntiVirus Team</strong></p>
                                <p style="margin: 10px;">*** This is an automatically generated email, please do not reply. ***</p>
                            </td>
                        </tr>';
                        $client = new Client(['verify' => false]);
                        $response = $client->post('http://portal2.npav.net/api/emailapi', [
                            'json' => [
                                'to' => $Email,
                                'from' => 'support@npav.net',
                                'title' => 'Userinfo',
                                'subject' => 'UserInfo OTP Access',
                                'body' => $emailTxt,
                            ]
                        ]);
                        $send_email = $response->getBody();
                    }
                    if ($Mobile) {
                        // ---- SEND SMS CODE START ---- //
                        $baseuri = "http://portal2.npav.net/api/smsapi";
                        $templateid = 1207161529239880241;
                        $mobile = $Mobile;
                        $senderId = 'NPAVTS';
                        $client = new Client(['verify' => false]);
                        $response = $client->post($baseuri, [
                            'json' => [
                                'msg' => "Your NPAV OTP for UserInfo Access is: " . $otp . ". Valid for " . $OtpTime . ". Please do not share it with anyone!",
                                'templateid' => $templateid,
                                'mobile' => $mobile,
                                'senderId' => $senderId
                            ],
                        ]);
                        $send_sms = $response->getBody();
                        /*** Send Message On Whatsapp */
                        $baseuri_wp = "https://portal2.npav.net/api/v2/globalwatsappapi";
                        $mobile_wp = '91' . $Mobile;
                        $client_wp = new Client(['verify' => false]);
                        $response_wp = $client_wp->post($baseuri_wp, [
                            'json' => [
                                'msgtext' => "Your NPAV OTP for UserInfo Access is: " . $otp . ". Valid for " . $OtpTime . ". Please do not share it with anyone!",
                                'mobile' => $mobile_wp,
                                'type' => 4
                            ],
                        ]);
                        $send_wp = $response_wp->getBody();
                    }
                } else {
                    return response()->json([
                        'Status' =>  "error",
                        'Message' => 'Mobile Number or Email Not Registered..!',
                    ]);
                }
                if (($send_sms == TRUE) || ($send_email == TRUE)) {


                    if ($Mobile) {
                        $msg = "OTP sent on mobile no $maskedMobile ..!";
                    }
                    if ($Email) {
                        $msg = "OTP sent on email id $maskedEmail ..!";
                    }
                    if ($Mobile && $Email) {
                        $msg = "OTP sent on email id $maskedEmail and mobile no $maskedMobile..!";
                    }
                    return response()->json([
                        'Status' =>  "success",
                        'Message' => $msg,
                    ]);
                } else {
                    return response()->json([
                        'Status' =>  "error",
                        'Message' => 'Failed to send OTP..!',
                    ]);
                }
            } else {
                return response()->json([
                    'Status' =>  "error",
                    'Message' => 'Mobile No. not found..!',
                ]);
            }
        } else {
            return response()->json([
                'Status' =>  "error",
                'Message' => 'User not found..!',
            ]);
        }
    }
    public  function validateOPT(Request $request)
    {
        $User_Name = $request->User_Name;
        $OTP = $request->OTP;
        $uniqueBrowserId = $request->uniqueBrowserId;
        $ip = $request->ip();

        if ($User_Name == '' || strlen($User_Name) < 2 || strlen($User_Name) > 50) {
            return response()->json([
                'Status' =>  "error",
                'Message' => 'Invalid User..!',
            ]);
        }
        if ($OTP == '' || strlen($OTP) != 6 || !is_numeric($OTP)) {
            return response()->json([
                'Status' =>  "error",
                'Message' => 'Invalid OTP..!',
            ]);
        }
        $prevTime = DB::connection('mysql')->table('userinfo_otp')
            ->where('User', $User_Name)
            ->where('Otp', $OTP)
            ->orderByDesc('Id')
            ->first();

        if ($prevTime) {
            $prevInDate = $prevTime->InDate;
            $currentDate = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
            $diff_in_minutes = $currentDate->diffInMinutes($prevInDate);
            if ($diff_in_minutes <= 10) {
                $IspIp = $request->ip();
                $updateStatus = DB::connection('mysql')->table('userinfo_otp')->where('User', $User_Name)->where('Otp', $OTP)
                    ->update([
                        'Status' => true,
                        'StatusDate' => date('Y-m-d H:i:s'),
                    ]);
                $deleteOldIp = DB::connection('mysql')->table('userinfo_ip')->whereDate('inDate', '!=', date('Y-m-d'))->delete();

                // $checkIp = DB::connection('mysql')->table('userinfo_ip')->select('IspIp')->where('IspIp', $IspIp)->first();
                // if (empty($checkIp)) {
                //     $insertIp = DB::connection('mysql')->table('userinfo_ip')->insert([
                //         'IspIp' => $IspIp,
                //         'InDate' => date('Y-m-d h:i:s'),
                //     ]);

                /** Write in JSON File */
                $filePath = storage_path("/app/public/IpList_" . date('d_m_Y') . ".json");
                if (!File::exists($filePath)) {
                    File::put($filePath, json_encode([]));
                }
                $yesterdayFileName = storage_path("/app/public/IpList_" . Carbon::yesterday()->format('d_m_Y') . ".json");

                if (File::exists($yesterdayFileName)) {
                    File::delete($yesterdayFileName);
                }
                $newData = [
                    "browser_id" => $uniqueBrowserId,
                    "ip" => $ip
                ];

                try {
                    Session::flush();
                    Session::put('browser_id', $uniqueBrowserId);
                    $this->appendToJsonFile($filePath, $newData);
                } catch (\Exception $e) {
                }
                // }

                return response()->json([
                    'Status' =>  "success",
                    'Message' => 'Your IP Address Added Successfully. Please Login..!',
                ]);
            } else {
                return response()->json([
                    'Status' =>  "error",
                    'Message' => 'OTP Expired..!',
                ]);
            }
        } else {
            return response()->json([
                'Status' =>  "error",
                'Message' => 'OTP Not Valid..!',
            ]);
        }
    }



    public function appendToJsonFile($filePath, $newData)
    {
        // Check if the file exists
        if (!File::exists($filePath)) {
            // Create an empty array if the file does not exist
            $data = [];
        } else {
            // Get the contents of the JSON file
            $jsonString = File::get($filePath);
            // Decode the JSON string into a PHP array
            $data = json_decode($jsonString, true);
            // Check if the data is valid JSON
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Invalid JSON data');
            }
        }

        // Append the new data to the array
        $data[] = $newData;
        // Encode the updated array back to JSON
        $updatedJsonString = json_encode($data, JSON_PRETTY_PRINT);
        // Write the updated JSON back to the file
        File::put($filePath, $updatedJsonString);
    }

    public function viewSentOTP(Request $req)
    {
        $otp = DB::connection('mysql')->table('userinfo_otp')->orderByDesc('Id')->get();
        return view('Users.otpviewer', compact('otp'));
    }
    /**
     *
     * Change IP
     *
     *  */
    public  function changeIP(Request $req)
    {
        $allIps = DB::connection('mysql6')->table('ip_access')->where('isDeleted', 0)->get();
        return view('changeIP', compact('allIps'));
    }
    public function addNewIp(Request $req)
    {
        // print_r($req->constantIPs);
        $string1 = str_replace("\r\n", ",", $req->constantIPs);
        $constantIPs = explode(',', $string1);
        $string2 = str_replace("\r\n", ",", $req->changeIPs);
        $changeIPs = explode(',', $string2);
        $IP_array_merge = array_merge($constantIPs, $changeIPs);
        $cnt_a = 0;
        $cnt_e = 0;
        $getIP = false;
        foreach ($IP_array_merge as $key => $value) {
            if ($value != '') {
                $getIP = DB::connection('mysql6')->table('ip_access')->where('isDeleted', 0)->where('ip_address', $value)->first();
                if (empty($getIP)) {
                    $addIP = DB::connection('mysql6')->table('ip_access')->insert([
                        'ip_address' => $value,
                        'modified_at' => date('Y-m-d H:i:s'),
                        'addedBy' => auth()->user()->User_Name,
                    ]);
                    $cnt_a++;
                } else {
                    $cnt_e++;
                }
            }
        }
        if ($getIP == true) {
            return redirect('changeIP')->with("success", 'Success.New Added IPs:' . $cnt_a . '. Already Exist IPs:' . $cnt_e);
            // return 'Success.New Added IPs:' . $cnt_a . '. Already Exist IPs:' . $cnt_e;
        } else {
            return redirect('changeIP')->with("success", 'Success.New Added IPs:' . $cnt_a .  '. Already Exist IPs:' . $cnt_e);
            // return 'Success.Already Exist IPs:' . $cnt_e;
        }
    }
    /**
     *
     * Get Log File Contents
     *
     */
    public function getFileContents(Request $request)
    {
        try {
            $logPath = "E:\\ACTIVATIONDATA\\" . $request->notesfolder . '\\' . $request->custNo . '.log';
            if (file_exists($logPath)) {
                $file = fopen($logPath, "r");
                if (filesize($logPath) > 0) {
                    $fileContent = nl2br(fread($file, filesize($logPath)));
                    return $fileContent;
                } else {
                    return;
                }
            } else {
                return response()->json(['error' => 'File not found..!']);
            }
        } catch (\Exception $e) {
            return response()->json('Something went wrong..!');
            return response()->json($e->getMessage());
        }
    }
    /**
     *
     * Convert LIC
     *
     */
    public function convertLic(Request $request)
    {
        try {
            $licNos = $request->licNo;
            $reason = $request->reason;
            $pass = $request->convertPass;
            $CorpId = $request->CorpId;
            if ($reason == '') {
                return response()->json(["error" => "Please enter Reason !"]);
            }
            if ($pass != 'ag42B23resp') {
                return response()->json(["error" => "Invalid Password !"]);
            }
            if ($licNos == '') {
                return response()->json(["error" => "Please enter License Number !"]);
            }
            $otherInit = 0;
            $invalidLic = 0;
            $converted = 0;
            $convertedWithUc = 0;
            $licNtFound = 0;
            $licNos2 = str_replace(',', '', $licNos);
            $licNo_arr = explode(PHP_EOL, $licNos2);
            // dd($licNo_arr);
            foreach ($licNo_arr as $key => $licNo) {
                $licInit = '';
                $licNum = '';
                $tempInitial = '';
                if (substr($licNo, 0, 1) != 'E' &&  substr($licNo, 0, 1) != 'A' && substr($licNo, 0, 1) != 'S' && substr($licNo, 0, 1) != 'T' && substr($licNo, 0, 1) != 'X') {
                    // return response()->json(["error" => "Enter only 'E-' Or 'A-' Or 'S-' Or 'T-' License Number ! <br/> Other Key : " . $licNo]);
                    $otherInit++;
                }
                if (strlen($licNo) != 12   || substr($licNo, 1, 1) != '-') {
                    //  return response()->json(["error" => "Invalid License Number =>" . $licNo]);
                    $invalidLic++;
                }
                $licInit = substr($licNo, 0, 1);
                $licNum  = substr($licNo, 2, 10);
                if ($licInit == 'E') {
                    $tempInitial = "S";
                } elseif ($licInit == 'A') {
                    $tempInitial = "T";
                } elseif ($licInit == 'S') {
                    $tempInitial = "E";
                } elseif ($licInit == 'T') {
                    $tempInitial = "A";
                } elseif ($licInit == 'X') {
                    $tempInitial = "S";
                } else {
                    // return response()->json(["error" => "Enter only 'E-' Or 'A-' Or 'S-' Or 'T-' License Number ! Other Key : " . $licNo]);
                    $otherInit++;
                }
                $sql = DB::connection('mysql')->table('serialnums')->where('SerialInitial', $licInit)->where('SerialNo', $licNum)->first();
                if (!$sql == null) {
                    $path = storage_path() . '/app/ConvertLic.log';
                    $file_exists = File::exists($path);
                    $text = "--- " . $licNo . " => " . $tempInitial . "-" . $licNum . ", Reason:" . $reason . ", Date:" . date('m/d/Y h:i:s A') . " \r\n";
                    if ($file_exists) {
                        file_put_contents($path, $text, FILE_APPEND);
                    } else {
                        fopen($path, 'w');
                        file_put_contents($path, $text, FILE_APPEND);
                    }
                    DB::connection('mysql')->table('serialnums')->where('SerialInitial', $licInit)->where('SerialNo', $licNum)->update([
                        'SerialInitial' => $tempInitial,
                        'GenDate' => $sql->GenDate . ' ' . $reason,
                    ]);
                    $newSerialNo = $tempInitial . '-' . $licNum;
                    $update =   DB::table('info')->where('SerialNo', $licNo)->update([
                        'SerialNo' => $newSerialNo
                    ]);
                    /** Add To ConvertLicLog */
                    $convertLicLog = DB::table('convertliclog')->insert([
                        'licNo' => $licNo,
                        'inDateTime' => now(),
                        'reason' => substr($reason, 0, 250),
                        'userinfoLogin' => auth()->user()->User_Name,
                        'Source' => 'P',
                        'CorpId' => $CorpId,
                    ]);
                    if ($sql->ActivationCode == '') {
                        // return response()->json(['success' => 'Lic found, converted successfully !']);
                        $converted++;
                    } else {
                        // return response()->json(['success' => 'Lic found and ActCode was also present, converted successfully !']);
                        $convertedWithUc++;
                        $converted++;
                    }
                } else {
                    // return response()->json(["error" => "LIC not found =>" . $licNo]);
                    $licNtFound++;
                }
            }
            return response()->json([
                'success' =>
                'Converted Lic : ' . $converted . '<br/> Other Initial Lic : ' . $otherInit . '<br/> Lic Not Found : ' . $licNtFound . '<br/> Invalid Lic : ' . $invalidLic
            ]);
        } catch (\Exception $e) {
            return response()->json(["error" => $e->getMessage()]);
        }
    }
    public function convertLic_bak(Request $request)
    {
        try {
            $licNo = $request->licNo;
            $reason = $request->reason;
            $pass = $request->convertPass;
            $CorpId = $request->CorpId;
            if ($reason == '') {
                return response()->json(["error" => "Please enter Reason !"]);
            }
            if ($pass != 'ag42B23resp') {
                return response()->json(["error" => "Invalid Password !"]);
            }
            if ($licNo == '') {
                return response()->json(["error" => "Please enter License Number !"]);
            }
            // $licNo_arr = explode(',', $licNos);
            // dd($licNo_arr);
            // foreach ($licNo_arr as $key => $licNo) {
            $licInit = '';
            $licNum = '';
            $tempInitial = '';
            if (substr($licNo, 0, 1) != 'E' &&  substr($licNo, 0, 1) != 'A' && substr($licNo, 0, 1) != 'S' && substr($licNo, 0, 1) != 'T' && substr($licNo, 0, 1) != 'X') {
                return response()->json(["error" => "Enter only 'E-' Or 'A-' Or 'S-' Or 'T-' License Number !  Other Key : " . $licNo]);
            }
            if (strlen($licNo) != 12   || substr($licNo, 1, 1) != '-') {
                return response()->json(["error" => "Invalid License Number =>" . $licNo]);
            }
            $licInit = substr($licNo, 0, 1);
            $licNum  = substr($licNo, 2, 10);
            if ($licInit == 'E') {
                $tempInitial = "S";
            } elseif ($licInit == 'A') {
                $tempInitial = "T";
            } elseif ($licInit == 'S') {
                $tempInitial = "E";
            } elseif ($licInit == 'T') {
                $tempInitial = "A";
            } elseif ($licInit == 'X') {
                $tempInitial = "S";
            } else {
                return response()->json(["error" => "Enter only 'E-' Or 'A-' Or 'S-' Or 'T-' License Number ! Other Key : " . $licNo]);
            }
            $sql = DB::connection('mysql')->table('serialnums')->where('SerialInitial', $licInit)->where('SerialNo', $licNum)->first();
            if (!$sql == null) {
                $path = storage_path() . '/app/ConvertLic.log';
                $file_exists = File::exists($path);
                $text = "--- " . $licNo . " => " . $tempInitial . "-" . $licNum . ", Reason:" . $reason . ", Date:" . date('m/d/Y h:i:s A') . " \r\n";
                if ($file_exists) {
                    file_put_contents($path, $text, FILE_APPEND);
                } else {
                    fopen($path, 'w');
                    file_put_contents($path, $text, FILE_APPEND);
                }
                DB::connection('mysql')->table('serialnums')->where('SerialInitial', $licInit)->where('SerialNo', $licNum)->update([
                    'SerialInitial' => $tempInitial,
                    'GenDate' => $sql->GenDate . ' ' . $reason,
                ]);
                $newSerialNo = $tempInitial . '-' . $licNum;
                $update =   DB::table('info')->where('SerialNo', $licNo)->update([
                    'SerialNo' => $newSerialNo
                ]);
                /** Add To ConvertLicLog */
                $convertLicLog = DB::table('convertliclog')->insert([
                    'licNo' => $licNo,
                    'inDateTime' => now(),
                    'reason' => substr($reason, 0, 250),
                    'userinfoLogin' => auth()->user()->User_Name,
                    'Source' => 'P',
                    'CorpId' => $CorpId,
                ]);
                if ($sql->ActivationCode == '') {
                    return response()->json(['success' => 'Lic found, converted successfully !']);
                } else {
                    return response()->json(['success' => 'Lic found and ActCode was also present, converted successfully !']);
                }
            } else {
                return response()->json(["error" => "LIC not found =>" . $licNo]);
            }
            // }
            // return response()->json(['success' => 'Lic found, converted successfully !']);
        } catch (\Exception $e) {
            return response()->json(["error" => $e->getMessage()]);
        }
    }
    /**
     *
     * View React Count
     *
     */
    public function viewreactcnt(Request $request)
    {
        try {
            return view('reactCnt.viewreactcnt');
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }
    public function getUserwiseReactCnt(Request $request)
    {
        try {
            if ($request->date) {
                $date = date('Y-m-d', strtotime($request->date));
            } else {
                $date = date('Y-m-d');
            }
            $data = DB::connection('mysql4')->table('datewise')->select(
                'Id',
                'Date_for',
                'OperatorName',
                'rCount',
                DB::raw("DATE_FORMAT(InDate,'%d-%b %h:%i %p') as InDate"),
                DB::raw("DATE(Indate) as ind"),
            )->whereDate('InDate', $date)
                ->orderByDesc('rCount')
                ->get();
            return view('reactCnt.reactPaging', compact('data', 'date'));
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }
    public function viewreactcntkeys($date = null, $operator = null)
    {
        $data =   DB::table('reactoperators')->select(
            'keyNo',
            'operatorName',
            'reactReason',
            'indate as ind',
            DB::raw('replace(keyNo,substring(keyNo,length(keyNo)-3,4),"XXXX") as keysn'),
            DB::raw('DATE_FORMAT(indate,"%d-%b %h:%i %p") AS InDate'),
            DB::raw('case when isOnlineDone=true then "Online"  else "Offline" end as isOnlineDone')
        )
            ->whereDate('indate', $date)
            ->where('operatorName', $operator)
            ->orderByDesc('ind')->get();
        $count = $data->count();
        return view('reactCnt.reactKeysCntPaging', compact('data', 'date', 'operator', 'count'));
    }
    public function stats($Lic = null)
    {
        $customerNumbers = DB::table('info')->select('CustomerNumber')->where('SerialNo', $Lic)->orderByDesc('CustomerNumber')->limit(30)->get();
        $custNo_arr = [];
        foreach ($customerNumbers as $key => $val) {
            $custNo_arr[] = $val->CustomerNumber;
        }
        $data = DB::table('info')
            ->select(
                'ActHwMaster.Lc1No',
                'ActHwMaster.Lc2No',
                'ActHwMaster.Lc3No',
                'ActHwMaster.Lc1Name',
                'ActHwMaster.Lc2Name',
                'ActHwMaster.Lc3Name',
                'ActHwMaster.Lc1Ip',
                'ActHwMaster.Lc2Ip',
                'ActHwMaster.Lc3Ip',
                'ActHwMaster.HDD1',
                'ActHwMaster.HDD2',
                'ActHwMaster.HDDModels',
                'ActHwMaster.CPUName',
                'ActHwMaster.CPUSpeed',
                'ActHwMaster.MachineName',
                'ActHwMaster.MBID',
                'ActHwMaster.OS',
                'ActHwMaster.BITS',
                'ActHwMaster.CDVSN',
                'ActHwMaster.DDVSN',
                'ActHwMaster.MBInstCode',
                'ActHwMaster.Manufacturer',
                'ActHwMaster.Model',
                'ActHwMaster.HDDInstCode',
                'ActHwMaster.LCInstCode',
                DB::raw('DATE_FORMAT(ActHwMaster.InDate, "%d-%b-%Y %h:%i %p") as iDate2'),
                'info.CustomerNumber',
                'info.contactPerson',
                'info.CustMobile',
                'info.lanCardNo',
                'info.installCode',
                'info.unlockCode',
            )
            ->leftJoin('ActHwMaster', 'info.CustomerNumber', '=', 'ActHwMaster.CustomerNumber')
            // ->whereIn('ActHwMaster.CustomerNumber', $custNo_arr)
            ->where('info.SerialNo', '=', $Lic)
            // ->orderBy('ActHwMaster.hwId', 'desc')
            ->orderBy('info.CustomerNumber', 'desc')
            ->get();
        dd($data);
    }
    public function fetchCorpDetails(Request $request)
    {
        $corpDetails = DB::connection('mysql7')
            ->table('mylic as m')
            ->select('c.corpid', 'emailID', 'c.Mobile as Mobile', 'c.DlrCode as DlrCode', 'c.FirmName as FirmName', 'c.cState as cState', 'c.District as District', 'c.City as City')
            ->leftJoin('corporatemaster as c', 'm.corpid', '=', 'c.corpid')
            ->where('m.serialno', $request->search_txt)
            ->first();
        return  $corpDetails;
    }
    public function liveHwCount(Request $req)
    {
        $client = new \GuzzleHttp\Client(['base_uri' => 'http://laptracknew.npav.net/']);
        $res = $client->request('GET', 'api/hwDetails?srchTxt=' . $req->srchTxt);
        $count =  $res->getBody();
        return $count;
    }
    /***
     *
     * For Testing
     *
     */
    public function writeTestKey(Request $req)
    {
        $LicNo = $req->keyNo;
        $add = '';
        if (file_exists("E:/ACTIVATIONDATA/ReactGrant.ini")) {
            if (!empty($LicNo)) {
                $file_content = File::get("E:/ACTIVATIONDATA/ReactGrant.ini");
                $licRplD = str_replace('-', '_', $LicNo) . "=DONE" . PHP_EOL;
                $licRpl = str_replace('-', '_', $LicNo) . "=ALLOWED" . PHP_EOL;
                if (strpos($file_content, $licRplD) > 0) {
                    fopen("E:/ACTIVATIONDATA/ReactGrant.ini", "w");
                    $temp =  str_replace($licRplD, $licRpl, $file_content);
                    $add = file_put_contents('E:/ACTIVATIONDATA/ReactGrant.ini', $temp);
                } else {
                    if (strpos($file_content, $licRpl) == false) {
                        file_put_contents('E:/ACTIVATIONDATA/ReactGrant.ini', $licRpl, FILE_APPEND);
                    }
                    $add = true;
                }
                if ($add) {
                    return 'Added#NPAV';
                } else {
                    return 'Not Added#NPAV';
                }
            } else {
                return 'Invalid Key#NPAV';
            }
        }
    }
    public function readReactKey(Request $req)
    {
        $LicNo = $req->keyNo;
        $add = '';
        if (file_exists("E:/ACTIVATIONDATA/ReactGrant.ini")) {
            if (!empty($LicNo)) {
                $file_content = File::get("E:/ACTIVATIONDATA/ReactGrant.ini");
                $licRplD = str_replace('-', '_', $LicNo) . "=DONE" . PHP_EOL;
                $licRpl = str_replace('-', '_', $LicNo) . "=ALLOWED" . PHP_EOL;
                if (strpos($file_content, $licRplD) > 0) {
                    return 'Done#Npav';
                } elseif (strpos($file_content, $licRpl) > 0) {
                    return 'Allowed#Npav';
                } else {
                    return 'Not Found#Npav';
                }
            } else {
                return 'Invalid Key#NPAV';
            }
        }
    }
    /**
     *
     * Computer Name Count
     *
     */
    public function  compNameCount(Request $request)
    {
        return view('reactCnt.compNameCount');
    }
    public function  compterNameWiseCnt(Request $request)
    {
        $indates = DB::table('info_indates')
            ->whereDate('Indate', '>=', '2024-04-30')
            ->pluck('CustomerNumber')
            ->toArray();
        $count = DB::table('info')->whereIn('customerNumber', $indates)
            ->select(
                'computerName',
                DB::raw("SUM(IF(computerName='TUC:2024-04-30',1,0)) AS TUC_CNT"),
                DB::raw("SUM(IF(computerName='NUC:2024-04-30',1,0)) AS NUC_CNT"),
                DB::raw("SUM(IF(computerName='RUC:2024-04-30',1,0)) AS RUC_CNT"),
            )
            ->where('computerName', '!=', '')
            ->whereNotNull('computerName')
            ->get();
        // dd($count);
        return view('reactCnt.compNameCount');
    }
    /**
     *
     * Add To Bookmark
     *
     */
    public function addToBookMark(Request $request)
    {
        $key = $request->search_txt;
        $user = auth()->user()->User_Name;
        try {
            $addKey = DB::connection('mysql6')->table('bookmarks')->updateOrInsert(
                [
                    'key' => $key
                ],
                [
                    'AddedBy' => $user,
                    'inDate' => now()
                ]
            );
            if ($addKey) {
                return response()->json(['success' => true, 'message' => 'Record inserted successfully.'], 200);
            } else {
                return response()->json(['success' => false, 'message' => 'Operation did not affect any records.'], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }
    public function viewBookMarks()
    {
        $getKeys = DB::connection('mysql6')->table('bookmarks')->orderByDesc('id')->get();
        return $getKeys;
    }
}
