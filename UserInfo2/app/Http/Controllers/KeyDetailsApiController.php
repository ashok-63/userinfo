<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KeyDetailsApiController extends Controller
{

    public function getKeyDetails(Request $request)
    {
        try {

            if ($request->licNo == '' || strlen($request->licNo) != 12) {
                return response()->json([
                    'status' => false,
                    'response' => 'Please enter valid key..!'
                ]);
            }

            $data = DB::connection('mysql')->table('INFO')
                ->select(
                    'INFO.CUSTOMERNUMBER AS CUSTNO',
                    DB::raw("SUBSTRING_INDEX(UPPER(INFO.NAME), 'MBID#:', 1) AS CUSTFIRM"),
                    DB::raw('(UPPER(INFO.CONTACTPERSON)) AS CUSTNAME'),
                    DB::raw('(UPPER(INFO.EMAILID)) AS CUSTEMAIL'),
                    DB::raw('(UPPER(INFO.CUSTMOBILE)) AS CUSTMOBILE'),
                    DB::raw('(UPPER(INFO.DLRCODE)) AS DLRCODE'),
                    DB::raw('(UPPER(INFO.EXPIRYDATE)) AS EXPIRYDATE'),
                    DB::raw('(UPPER(CUSTOMERLOCATION.CUSTCOUNTRY)) AS CUSTCOUNTRY'),
                    DB::raw('(UPPER(CUSTOMERLOCATION.CUSTSTATE)) AS CUSTSTATE'),
                    DB::raw('(UPPER(CUSTOMERLOCATION.CUSTDISTRICT)) AS CUSTDISTRICT'),
                    DB::raw('(UPPER(CUSTOMERLOCATION.CUSTCITY)) AS CUSTCITY'),
                )
                ->leftJoin('CUSTOMERLOCATION', 'CUSTOMERLOCATION.CUSTOMERNUMBER', '=', 'INFO.CUSTOMERNUMBER')
                ->where('INFO.SerialNo', $request->licNo)
                ->orderByDesc('CUSTNO')
                ->first();


            if ($data != null) {
                return response()->json([
                    'status' => true,
                    'response' => $data
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'response' => 'No data found..!'
                ]);
            }
        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'response' => $e->getMessage()
            ]);

        }
    }
}
