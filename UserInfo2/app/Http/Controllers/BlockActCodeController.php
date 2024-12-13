<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlockActCodeController extends Controller
{
    /**
     * Block Keys
     */
    const ERROR_INVALID_KEY = 'ERROR-INVALID KEY#NPAV#';
    const ERROR_KEY_NOT_EXIST = 'ERROR-KEY NOT EXIST#NPAV#';
    const ERROR_NOT_BLOCKED = 'ERROR-NOT BLOCKED#NPAV#';
    const SUCCESS_BLOCKED = 'OK-BLOCKED#NPAV#';
    const IP_NOT_FOUND = 'ERROR-UNAUTHORIZED ACCESS#NPAV#';
    const SERVER_ERROR = 'ERROR-SERVER ERROR#NPAV#';
    const ACTIVATED_KEY = 'OK-KEY IS ACTIVATED#NPAV#';
    const NOT_ACTIVATED_KEY = 'OK-KEY IS NOT ACTIVATED#NPAV#';
    public function blockKey(Request $request)
    {
        try {
            $keyNo = trim($request->keyNo);
            $blkReason = substr(trim($request->blockReason), 0, 13);

            if (strlen($keyNo) != 12 || substr($keyNo, 1, 1) != '-') {
                return  response()->json(['status' => false, 'msg' => self::ERROR_INVALID_KEY]);
            } else {
                $serialInit = substr($keyNo, 0, 1);
                $serialNo = substr($keyNo, 2, 10);
                $checkKey = DB::table('SerialNums')
                    ->where('SerialInitial', $serialInit)
                    ->where('SerialNo', $serialNo)
                    ->first();
                if (!empty($checkKey)) {

                    $text = "Blocked " . strtoupper(date('dMy')) . " " . $blkReason;
                    $updateQry = DB::table('SerialNums')
                        ->where('SerialInitial', $serialInit)
                        ->where('SerialNo', $serialNo)
                        ->update([
                            'ActivationCode' => strtoupper($text),
                            'updateDate' => now()
                        ]);
                    $insert_licblocklog_block = DB::table('licblocklog')->insert([
                        'licNo' => trim($keyNo),
                        'remark' => 'Blocked',
                        'reason' => trim($request->blockReason),
                        'blockedDate' => now(),
                    ]);
                    if ($updateQry) {
                        return  response()->json(['status' => true, 'msg' => self::SUCCESS_BLOCKED]);
                    } else {
                        return  response()->json(['status' => false, 'msg' => self::ERROR_NOT_BLOCKED]);
                    }
                } else {
                    return  response()->json(['status' => false, 'msg' => self::ERROR_KEY_NOT_EXIST]);
                }
            }
        } catch (\Exception $e) {
            // return  response()->json($e->getMessage());
            return  response()->json(['status' => false, 'msg' => self::SERVER_ERROR]);
        }
    }
    /**
     * Check If key is activated or not
     */
    public function checkLicKeyActivationStatus(Request $request)
    {
        try {
            $keyNo = trim($request->keyNo);
            if (strlen($keyNo) != 12 || substr($keyNo, 1, 1) != '-') {
                return  response()->json(['status' => false, 'msg' => self::ERROR_INVALID_KEY]);
            } else {
                $serialInit = substr($keyNo, 0, 1);
                $serialNo = substr($keyNo, 2, 10);

                $checkKey = DB::table('SerialNums')
                    ->where('SerialInitial', $serialInit)
                    ->where('SerialNo', $serialNo)
                    ->first();

                if (!empty($checkKey)) {
                    $actCode = trim($checkKey->ActivationCode);
                    $expDate = $checkKey->expiryDate;

                    if (($actCode == "" || $actCode == null) && ($expDate == null)) {
                        return  response()->json(['status' => true, 'msg' => self::NOT_ACTIVATED_KEY]);
                    } else {
                        return  response()->json(['status' => false, 'msg' => self::ACTIVATED_KEY]);
                    }
                } else {
                    return  response()->json(['status' => false, 'msg' => self::ERROR_KEY_NOT_EXIST]);
                }
            }
        } catch (\Exception $e) {
            // return  response()->json($e->getMessage());
            return  response()->json(['status' => false, 'msg' => self::SERVER_ERROR]);
        }
    }



    /**
     * Check Uc Block
     */
    public function  checkUcBlock(Request $request)
    {


        $rsUCB = DB::table('UCBlock')
            ->where('unlockCode', '=', $request->unlockCode)
            ->where('isDelete', '=', false)
            ->select('ucId')
            ->first();


        if (!empty($rsUCB)) {

            return  response()->json(['status' => true, 'msg' => 'Blocked UC']);
        } else {
            return  response()->json(['status' => false, 'msg' => 'UC not blocked']);
        }
    }
}
