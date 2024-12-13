<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
class DealerRegController extends Controller
{
    public function DealReg()
    {
        $states = DB::table('statemaster')->orderBy('StateName')->get();
        return view('DealerReg', compact('states'));
    }
    public function getDistrict(Request $request)
    {
        $state = $request->state;
        $state = explode("$$", $state);
        $district = DB::table('districtmaster')->where('sID', $state[0])->orderBy('DISTRICT')->get();
        return $district;
    }
    public function dealerRegister(Request $request)
    {
        try {
            if ($request->dealerCompany == '' || $request->dealerCompany == null) {
                return response()->json([
                    'class' =>  'error',
                    'msg' => 'Please Enter Company Name..!',
                ]);
            }
            if ($request->emailId == '' || $request->emailId == null) {
                return response()->json([
                    'class' =>  'error',
                    'msg' => 'Please Enter Email Id..!',
                ]);
            }
            if ($request->contactPerson == '' || $request->contactPerson == null) {
                return response()->json([
                    'class' =>  'error',
                    'msg' => 'Please Enter Dealer Conatct Person Name..!',
                ]);
            }
            if ($request->address == '' || $request->address == null) {
                return response()->json([
                    'class' =>  'error',
                    'msg' => 'Please Enter Dealer Address..!',
                ]);
            }
            if ($request->state == '' || $request->state == null) {
                return response()->json([
                    'class' =>  'error',
                    'msg' => 'Please Select State..!',
                ]);
            }
            if ($request->district == '' || $request->district == null) {
                return response()->json([
                    'class' =>  'error',
                    'msg' => 'Please Select District..!',
                ]);
            }
            if ($request->city == '' || $request->city == null) {
                return response()->json([
                    'class' =>  'error',
                    'msg' => 'Please Enter City Name..!',
                ]);
            }
            if ($request->mobileNo == '') {
                return response()->json([
                    'class' =>  'error',
                    'msg' => 'Please Enter Correct 10 Digit Mobile Number..!',
                ]);
            } else {
                if (strlen($request->mobileNo) != 10) {
                    return response()->json([
                        'class' =>  'error',
                        'msg' => 'Please Enter Correct 10 Digit Mobile Number..!',
                    ]);
                }
            }
            $firmName = str_replace(array(
                '\'',
                ',', ';', '\\', '/', ':', '*', '?', '"', '<', '>', '|', '+', '-', "#", "%", "=", "'", "$", "(", ")", "{", "}", "[", "]", "&", "^", "`", "!", "~", ".", "_", "@", '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '&'
            ), '', $request->dealerCompany);
            $firmName = substr(strtoupper($firmName), 0, 1);
            if ($firmName == '') {
                $firmName = 'X';
            }
            $strDLRCODE = DB::table('dealers')
                ->select('dlrCode')
                ->where('dlrCode', 'not like', '%_-0%')
                ->where('dlrCode', 'not like', '%_-99999%')
                ->whereRaw('LENGTH(dlrCode)!=8')
                ->where('dlrCode', 'like', '%' . $firmName . '%')
                ->orderByDesc('InDate')
                ->first();
            if ($strDLRCODE != null) {
                if ($strDLRCODE->dlrCode != "") {
                    $dlrCd = (int)substr($strDLRCODE->dlrCode, 2) + 1;
                } else {
                    $dlrCd = 1;
                }
            } else {
                $dlrCd = 1;
            }
            $dc = $firmName . "-" . $dlrCd;
            /**--------------------------------------------------------------------------------------*/
            $rsChkDuplicate = DB::table('Dealers')
                ->select('dlrCode')
                ->where('DlrMobile', 'like', '%' . trim($request->mobileNo) . '%')
                ->where('DlrEmail', 'like', '%' . trim($request->emailId) . '%')
                ->first();
            if ($rsChkDuplicate == null) {
                $state = explode("$$", $request->state);
                // dd($state[1]);
                DB::table('Dealers')->insert([
                    'DlrCompany' => strtoupper(trim($request->dealerCompany)),
                    'DlrPerson' => strtoupper(trim($request->contactPerson)),
                    'DlrMobile' => strtoupper(trim($request->mobileNo)),
                    'DlrAddress' => strtoupper(trim($request->address)),
                    'DlrPhone' => strtoupper(trim($request->landLineNo)),
                    'DlrEmail' => strtoupper(trim($request->emailId)),
                    'dlrCode' => $dc,
                    'DlrCity' => strtoupper(trim($request->city)),
                    'DlrDistrict' => strtoupper(trim($request->district)),
                    'DlrState' => strtoupper(trim($state[1])),
                    'DlrRating' => strtoupper(trim($request->dealerRating)),
                    'InDate' => now(),
                    'Ip' => $request->ip(),
                ]);
                $msg = "Dealer Added Successfully !! Dealer Code is : " . $dc;

                $client = new Client(['verify' => false]);
                $emailapi = 'http://portal2.npav.net/api/datamoveActTosrv14';

                try {
                    $request = $client->post($emailapi, [
                        'json' => [
                            'dlrCode'    => $dc,
                            'dlremail'      => $request->emailId,
                            'token'   => 'npavportal',
                        ]
                    ]);

                    $response_arr = json_decode($request->getBody(), true);

                } catch (\Exception $e) {
                    return response()->json($e->getMessage());
                }
            } else {
                $dc = $rsChkDuplicate->dlrCode;
                $msg = "Already Registered !! Dealer Code : " . $dc;
            }
            return response()->json([
                'class' =>  'success',
                'msg' => $msg,
            ]);

        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }
    public function getDlrCode(Request $request)
    {

        $query = DB::table('Dealers')
            ->select('dlrCode');

        if ($request->type == 'mob') {
            $query->where('DlrMobile', 'like', '%' . trim($request->value) . '%');
        }
        if ($request->type == 'email') {
            $query->where('DlrEmail', 'like', '%' . trim($request->value) . '%');;
        }

        $rsChkDuplicate = $query->first();

        if ($rsChkDuplicate != null) {
            $msg = "Dealer Code : " . $rsChkDuplicate->dlrCode;
        } else {
            $msg = "Not Registered - Please Register this Dealer !!";
        }
        return $msg;
    }
}
