<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;
use Carbon\Carbon;

class LicDetailsController extends Controller
{
    function fetch_lic_details(Request $request)
    {
        try {
            $email_id = $request->email_id;
            $mobile_no = $request->mobile_no;
            $token = $request->token;
            $IPAddress =  $request->ip();
            $Ips = ["103.186.19.208", "65.21.141.126", "::1", "127.0.0.1" ,"202.189.250.93"];

            // $Ips = [];
            if (!in_array($IPAddress, $Ips)) {
                return response()->json([
                    'status' =>  false,
                    'message' => 'Unauthorised access !',
                    'data' => (object) [],
                ]);
            }

            if (empty($email_id)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Please enter valid email id',
                    'data' => (object) [],
                ]);
            }

            if (empty($mobile_no) && strlen($mobile_no) != 10) {
                return response()->json([
                    'status' =>  false,
                    'message' => 'Invalid Mobile No',
                    'data' => (object) [],
                ]);
            }

            if (empty($token) && $token != 'Jr2cTCfcd5eJFxao7LobtdoYkTzZPd') {
                return response()->json([
                    'status' => false,
                    'message' => 'Please enter valid token',
                    'data' => (object) [],
                ]);
            }

            $InfoLicKeyDetails = DB::connection('mysql')
                ->table('info')
                ->select('SerialNo', 'contactPerson', 'emailID', 'CustMobile', 'ExpiryDate', 'Address')
                ->where('SerialNo', 'not regexp', ['F', 'G', 'N', 'O'])
                // ->whereDate('installDate', '>=', '2020-01-01 00:00:00')
                ->where(DB::raw("STR_TO_DATE(ExpiryDate, '%d/%m/%Y')"), '>=',  Carbon::now()->format('Y-m-d'))
                ->where(function ($query) use ($email_id, $mobile_no) {
                    $query->where('CustMobile', '=', $mobile_no)
                        ->orWhere('emailID', '=', $email_id);
                })
                ->orderBy('customernumber', 'desc')->skip(0)->take(1)
                ->first();

            // dd($InfoLicKeyDetails);

            if (!empty($InfoLicKeyDetails)) {
                return response()->json([
                    'status' => true,
                    'message' => 'License details show sucessfully',
                    'data' => $InfoLicKeyDetails,
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Customer details not found',
                    'data' => (object) [],
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' =>  false,
                'message' =>  $e->getMessage(),
                'data' => (object) []
            ]);
        }
    }
}
