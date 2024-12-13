<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CheckRenewalAPIController extends Controller
{
    public function index(Request $request)
    {
        $lic_key = $request->lic_key;
        $token = $request->token;
        $CurrentDate = Carbon::now()->format('Y-m-d');
        $check_token = hash('md5', 'RenewalPHP' . $CurrentDate);
        // return response()->json($check_token);
        if ($check_token != $token) {
            return response()->json([
                'Status' =>  false,
                'Message' => 'Invalid Token',
            ]);
        }
        if (empty($lic_key)) {
            return response()->json([
                'Status' =>  false,
                'Message' => 'Please enter lic key',
            ]);
        }
        if (strlen($lic_key) != 12) {
            return response()->json([
                'Status' =>  false,
                'Message' => 'Invalid Licence Key.',
            ]);
        }
        $LeftSerialNo = substr($lic_key, 0, 1);
        $RightSerialNo = substr($lic_key, -10);
        $LicKeyDetails = DB::table("SERIALNUMS")->where('SerialInitial', '=', $LeftSerialNo)->where('RenewalDone', '=', true)->where('SERIALNO', '=', $RightSerialNo)->select('RenewalDone')->first();
        if (!empty($LicKeyDetails)) {
            return response()->json([
                'Status' =>  true,
                'Message' => 'Renewal done.',
            ]);
        }
        return response()->json([
            'Status' =>  false,
            'Message' => 'Renewal not done.',
        ]);
    }
}
