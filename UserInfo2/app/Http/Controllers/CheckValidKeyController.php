<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class CheckValidKeyController extends Controller
{
    const ERROR_INVALID_KEY = 'ERROR-INVALID KEY#NPAV#';
    const VALID_KEY = 'OK-VALID KEY#NPAV#';
    const EXPIRED = 'ERROR-KEY EXPIRED#NPAV#';
    const ERROR_KEY_NOT_EXIST = 'ERROR-KEY NOT EXIST#NPAV#';
    const ERROR_NOT_BLOCKED = 'ERROR-NOT BLOCKED#NPAV#';
    const BLOCKED = 'ERROR-KEY BLOCKED#NPAV#';
    const IP_NOT_FOUND = 'ERROR-UNAUTHORIZED ACCESS#NPAV#';
    const SERVER_ERROR = 'ERROR-SERVER ERROR#NPAV#';
    const ACTIVATED_KEY = 'OK-KEY IS ACTIVATED#NPAV#';
    const NOT_ACTIVATED_KEY = 'OK-KEY IS NOT ACTIVATED#NPAV#';
    const YES = 'YES#NPAV#';
    const NO = 'NO#NPAV#';

    public function IsKeyValid(Request $request)
    {
        try {
            $IPAddress =  $request->ip();
            $keyNo = trim($request->keyNo);
            $Ips = ["103.186.19.208", "65.21.141.126", "::1", "127.0.0.1", "202.189.250.93", "202.189.250.91"];
            if (!in_array($IPAddress, $Ips)) {
                return response()->json([
                    'status' =>  false,
                    'msg' => self::NO,
                    'data' => self::IP_NOT_FOUND,
                ]);
            }
            if (strlen($keyNo) != 12 || substr($keyNo, 1, 1) != '-') {
                return  response()->json(['status' => false, 'msg' => self::NO, 'data' => self::ERROR_INVALID_KEY]);
            } else {
                $serialInit = substr($keyNo, 0, 1);
                $serialNo = substr($keyNo, 2, 10);

                $checkKey = DB::table('SerialNums')
                    ->where('SerialInitial', $serialInit)
                    ->where('SerialNo', $serialNo)
                    ->first();

                if (!empty($checkKey)) {
                    $actCode = strtoupper(trim($checkKey->ActivationCode));
                    if (Str::contains($actCode, 'BLOCKED')) {
                        return response()->json(['status' => false, 'msg' => self::NO, 'data' => self::BLOCKED]);
                    }
                    $checkInfo = DB::table('info')->where('SerialNo', $keyNo)->orderByDesc('customerNumber')->first();
                    if (!empty($checkInfo)) {
                        $expDate = $checkInfo->ExpiryDate;
                        $currentDate = Carbon::now();
                        $otherDate = Carbon::createFromFormat('d/m/Y', $expDate);
                        if ($currentDate->gt($otherDate)) {
                            return response()->json(['status' => false, 'msg' => self::NO, 'data' => self::EXPIRED]);
                        } else {
                            return response()->json(['status' => true, 'msg' => self::YES, 'data' => self::VALID_KEY]);
                        }
                    } else {
                        return  response()->json(['status' => true, 'msg' => self::YES, 'data' => self::NOT_ACTIVATED_KEY]);
                    }
                } else {
                    return  response()->json(['status' => false,  'msg' => self::NO, 'data' => self::ERROR_KEY_NOT_EXIST]);
                }
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' =>  false,
                'message' => self::SERVER_ERROR,
                // 'data' => $e->getMessage()
            ]);
        }
    }
}
