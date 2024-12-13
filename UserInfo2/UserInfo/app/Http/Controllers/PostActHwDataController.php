<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostActHwDataController extends Controller
{
    public function postDataToActHw(Request $request)
    {
        try {

            $txtSecurityTkn = $request->txtSecurityTkn;


            if ($txtSecurityTkn != '44a2830ce0bca3fc891e093d6405de6a') {
                return response()->json(['Status' => false, 'Message' => 'Invalid token..!']);
            }

            $txtLicense = $request->txtLicense;
            $txtOldLicense = $request->txtOldLicense;
            $txtExpDate = $request->txtExpDate;
            $txtIC = $request->txtIC;
            $txtCompany = $request->txtCompany;
            $txtPerson = $request->txtPerson;
            $txtEmail = $request->txtEmail;
            $txtAddress = $request->txtAddress;
            $txtPhno = $request->txtPhno;
            $txtCustMob = $request->txtCustMob;
            $txtSw = $request->txtSw;
            $txtDealer = $request->txtDealer;
            $txtHDDNumber = $request->txtHDD;
            $txtDlrMob = $request->txtDlrMob;
            $txtDlrCode = $request->txtDlrCode;
            $txtNCountry = $request->txtNCountry;
            $txtNState = $request->txtNState;
            $txtNDistrict = $request->txtNDistrict;
            $txtNCity = $request->txtNCity;
            $txtCorpId = $request->txtCorpId;
            $txtLc1No = $request->txtLc1No;
            $txtLc2No = $request->txtLc2No;
            $txtLc3No = $request->txtLc3No;
            $txtLc1Name = $request->txtLc1Name;
            $txtLc2Name = $request->txtLc2Name;
            $txtLc3Name = $request->txtLc3Name;
            $txtLc1Ip = $request->txtLc1Ip;
            $txtLc2Ip = $request->txtLc2Ip;
            $txtLc3Ip = $request->txtLc3Ip;
            $txtHDD1 = $request->txtHDD1;
            $txtHDD2 = $request->txtHDD2;
            $txtHDDModels = $request->txtHDDModels;
            $txtCPUName = $request->txtCPUName;
            $txtCPUSpeed = $request->txtCPUSpeed;
            $txtMachineName = $request->txtMachineName;
            $txtMBID = $request->txtMBID;
            $txtOS = $request->txtOS;
            $txtBITS = $request->txtBITS;
            $txtCDVSN = $request->txtCDVSN;
            $txtDDVSN = $request->txtDDVSN;
            $txtInstallationCode = $request->txtINSTALLATIONCODE;
            $txtManufacturer = $request->txtManufacturer;
            $txtModel = $request->txtModel;
            $txtMBInstCode = $request->txtMBInstCode;
            $txtActivatedThrough = $request->txtActivatedThrough;
            $txtHDDInstCode = $request->txtHDDInstCode;
            $txtLCInstCode = $request->txtLCInstCode;
            $txtAuthoBy = $request->txtAuthoBy;
            $txtInstalledBy = $request->txtInstalledBy;
            $reverse = strrev($txtIC);
            $explode = explode("-", $reverse);
            $findstringIc = $explode[1] . "-" . $explode[2] . "-" . $explode[3] . "-" . $explode[4];
            $getLatestCustNo = DB::table('info')->where('SerialNo', $txtLicense)->where('installCode', $findstringIc)->orderByDesc('customerNumber')->value('customerNumber');
            $updateLatestRec = DB::table('info')->where('customerNumber', $getLatestCustNo)->update([
                'Name' => $txtCompany,
                'contactPerson' => $txtPerson,
                'Address' => $txtAddress,
                'emailID' => $txtEmail,
                // 'computerName' => $txtMachineName,
                // 'softwareName' => $txtSw,
                'AuthoBy' => $txtAuthoBy,
                'installBy' => $txtInstalledBy,
                'SerialNo' => $txtLicense,
                // 'lanCardNo' => $txtLc1No,
                // 'SoftwareCode' => $txtSw,
                // 'ExpiryDate' => $txtExpDate,
                'Dealer' => $txtDealer,
                'CustMobile' => $txtCustMob,
                'DealerMobile' => $txtDlrMob,
                'dlrCode' => $txtDlrCode,
                'CorpID' => $txtCorpId
            ]);

            // Insert or update in ActHwMaster table
            $insertActHwMaster = DB::table('ActHwMaster')->updateOrInsert(
                ['CustomerNumber' => $getLatestCustNo, 'SerialNo' => $txtLicense], // Condition to find existing record
                [
                    // These are the fields to be updated or inserted
                    'Lc1No' => $txtLc1No,
                    'Lc2No' => $txtLc2No,
                    'Lc3No' => $txtLc3No,
                    'Lc1Name' => $txtLc1Name,
                    'Lc2Name' => $txtLc2Name,
                    'Lc3Name' => $txtLc3Name,
                    'Lc1Ip' => $txtLc1Ip,
                    'Lc2Ip' => $txtLc2Ip,
                    'Lc3Ip' => $txtLc3Ip,
                    'HDD1' => $txtHDD1,
                    'HDD2' => $txtHDD2,
                    'HDDModels' => $txtHDDModels,
                    'CPUName' => $txtCPUName,
                    'CPUSpeed' => $txtCPUSpeed,
                    'MachineName' => $txtMachineName,
                    'MBID' => $txtMBID,
                    'OS' => $txtOS,
                    'BITS' => $txtBITS,
                    'CDVSN' => $txtCDVSN,
                    'DDVSN' => $txtDDVSN,
                    'MBInstCode' => $txtMBInstCode,
                    'Manufacturer' => $txtManufacturer,
                    'Model' => $txtModel,
                    'InDate' => now(),
                    'HDDInstCode' => $txtHDDInstCode,
                    'LCInstCode' => $txtLCInstCode
                ]
            );

            // Insert or update in CustomerLocation table
            $addCustomerLocation = DB::table('CustomerLocation')->updateOrInsert(
                ['CustomerNumber' => $getLatestCustNo, 'SerialNo' => $txtLicense], // Condition to find existing record
                [
                    // These are the fields to be updated or inserted
                    'CustCountry' => $txtNCountry,
                    'CustState' => $txtNState,
                    'CustDistrict' => $txtNDistrict,
                    'CustCity' => $txtNCity,
                    'CorpId' => $txtCorpId,
                    'InDate' => now()
                ]
            );


            return response()->json(['Status' => true, 'Message' => 'Data added successfully..!']);
        } catch (\Exception $e) {
            return response()->json(['Status' => false, 'Message' => 'Server Error']);
        }
    }
}
