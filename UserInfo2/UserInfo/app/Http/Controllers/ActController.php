<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ActController extends Controller
{
    public function index()
    {
        $states = DB::table('statemaster')->orderBy('StateName')->get();
        return view('new_act.new_act', compact('states'));
    }
    public function LoadOldLicDetails(Request $request)
    {
        try {
            $oldKeyDetails = DB::table('info')
                ->select('SerialNo', 'Name', 'ContactPerson', 'custMobile', 'installCode', 'DlrCode', 'ExpiryDate', 'emailID')
                ->where('SerialNo', $request->oldLic)
                ->orderByDesc('CustomerNumber')
                ->first();
            if ($oldKeyDetails != null) {
                $SerialNo = $oldKeyDetails->SerialNo;
                $Name = $oldKeyDetails->Name;
                $ContactPerson = $oldKeyDetails->ContactPerson;
                $custMobile = $oldKeyDetails->custMobile;
                $emailID = $oldKeyDetails->emailID;
                $installCode = $oldKeyDetails->installCode;
                $DlrCode = $oldKeyDetails->DlrCode;
                $ExpiryDate = $oldKeyDetails->ExpiryDate;
                $installCodeRev = strrev($installCode);
                if (strpos($installCode, '-', 0) > 0) {
                    $HexAdd = 0;
                    $instatestllCD = explode('-', $installCode);
                    foreach ($instatestllCD as $key => $instCD_val) {
                        $HexAdd = intval($HexAdd + hexdec($instCD_val));
                    }
                }
                $HexAdd = dechex($HexAdd);
                $HexAdd_length = strlen($HexAdd);
                $sub_HexAdd = substr($HexAdd, 1, $HexAdd_length - 1);
                $Install_Code = $installCodeRev . '-' . strtoupper($sub_HexAdd);
                return response()->json([
                    'SerialNo' => $SerialNo,
                    'Name' => $Name,
                    'ContactPerson' => $ContactPerson,
                    'custMobile' => $custMobile,
                    'installCode' => $Install_Code,
                    'DlrCode' => $DlrCode,
                    'emailID' => $emailID,
                    'ExpiryDate' => $ExpiryDate,
                ]);
            }
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }
    public function DealerInfo(Request $request)
    {
        try {
            $DlrCode = $request->DlrCode;
            $DlrInfo = DB::table('Dealers')
                ->select('DlrCompany', 'DlrMobile', 'DlrCity', 'DlrDistrict', 'DlrState', 'DlrPerson', 'DlrEmail', 'dlrCode', 'DlrAddress')
                ->where('dlrCode', $DlrCode)
                ->first();
            return $DlrInfo;
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }
    public function getCity(Request $request)
    {
        try {
            $strCity = DB::connection('location')
                ->table('City_Master')
                ->select(
                    DB::raw('DISTINCT City_Master.City_Name'),
                    'City_Master.District_Name',
                    'State_Master.st_Name'
                )
                ->leftJoin('State_Master', 'City_Master.stID', '=', 'State_Master.stID')
                ->whereNotNull('City_Master.City_Name')
                ->where('City_Master.District_Name', $request->district)
                ->orderBy('City_Master.City_Name')
                ->get();
            return $strCity;
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }
    public function showCityDlr(Request $request)
    {
        try {
            //    strSql = "SELECT DlrCompany, DlrMobile, dlrCode, DlrCompany,DlrAddress " & _
            //    "FROM Dealers WHERE DlrCompany<> '' "
            //    if Request("city") <> "" then
            //        strSql = StrSql & "AND Dealers.DlrCity='" & Request("city") & "' AND Dealers.DlrAddress Like '%" & Request("city") & "%' "
            //    end if
            //    if Request("dComp") <> "" then
            //        strSql = StrSql & "AND Dealers.DlrCompany Like '%" & Request("dComp") & "%' "
            //    end if
            //    strSql = strSql & " ORDER BY Dealers.DlrCompany;"
            $strSql = DB::table('Dealers')
                ->select(
                    'DlrCompany',
                    'DlrMobile',
                    'dlrCode',
                    'DlrAddress'
                )
                ->whereNotNull('DlrCompany')
                ->where('Dealers.DlrCity', $request->city)
                ->where('Dealers.DlrAddress', 'like', '%' . $request->city . '%')
                ->orderBy('Dealers.DlrCompany')
                ->get();
            return $strSql;
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }
    public function enggInfo(Request $request)
    {
        try {
            $enggDetails = DB::table('engMaster')
                ->select(
                    'MobileNo',
                    DB::raw('(CASE WHEN EngineersName = "" THEN "N/A" ELSE EngineersName END) AS EngineersName')
                )
                ->where('DlrCode',  trim($request->DlrCode))
                ->orderByDesc('HitCounter')
                ->get();
            $option = '<select name="selectEngName" id="selectEngName" class="form-control form-control-sm">
                       <option value="$">Engineer</option>';
            foreach ($enggDetails as $key => $value) {
                $option .= '<option value="' . trim($value->EngineersName) . '$' . $value->MobileNo . '">' . $value->EngineersName . '</option>';
            }
            return $option;
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }
    public function searchDealer(Request $request)
    {
        try {
            $value = explode(' ', $request->search_val);
            // $data = DB::table('Dealers')
            //     ->where('DlrNumber', '>', 0)
            //     ->where($request->searchBy, 'like', '%' . $value[0] . '%')
            //     ->get();
            $data = DB::table('Dealers')
                ->where('DlrNumber', '>', 0)
                ->where($request->searchBy, 'like', '%' . $value[0] . '%')
                ->get();
            return view('new_act.dlrInfoPaging ', compact('data'));
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }
    public function registerKeyForAct(Request $request)
    {
        try {
            if (!empty($request->state)) {
                if (str_contains($request->state, '$$')) {
                    $temp = explode('$$', $request->state);
                    $state = $temp[1];
                } else {
                    $state = $request->state;
                }
            } else {
                $state = "";
            }
            Log::info('Begin Execution');


            $client_u = new Client(['base_uri' => 'http://activation.indiaantivirus.com/act/unlockcodeAct.asp', 'verify' => false, 'http_errors' => false]);

            $response_uc = $client_u->request('POST', '', [
                'form_params'       => [
                    'txtlicense'    => $request->txtLicense,
                    'txtIC'         => $request->txtIC1,
                    'txtIC2'        => $request->txtIC2,
                    'txtIC3'        => $request->txtIC3,
                    'txtIC4'        => $request->txtIC4,
                    'txtIC1'        => $request->txtIC5,
                    'txtcompany'    => $request->txtCompany,
                    'txtperson'     => $request->txtPerson,
                    'cmbState'      => $state,
                    'cmbDistrict'   => $request->district,
                    'txtaddress'    => $request->city,
                    'txtsw'         => '',
                    'cmbNPFor'      => $request->cmbNPFor,
                    'txtphno'       => $request->txtphno,
                    'txtcustmob'    => $request->txtCustMob,
                    'txtemail'      => $request->txtemail,
                    'txtdealer'     => $request->txtdealer,
                    'txtdlrcode'    => $request->txtdlrcode,
                    'txtdlrmob'     => $request->txtdlrmob,
                    'txtOldLicense' => $request->txtOldLicense,
                    'txtNCountry'   => $request->txtNCountry,
                    'txtNCountry'   => $request->txtNCountry,
                    'txtCorpId'     => $request->txtCorpId,
                    'txtInstEngg'   => $request->txtInstEngg,
                    'txtInstEnggM'  => $request->txtInstEnggM,
                    'act-user'      => auth()->user()->User_Name
                ]
            ]);
            $result_uc = $response_uc->getBody();

            Log::info('Got Result UC ');

            $plainText = strip_tags($result_uc);


            Log::info("Plain Text : ");


            $temp = explode('Activation Code', trim($plainText));  //seperates string from hardcoded Activation Code text to get only unlockcode

            Log::info("temp Text : " );

            if (str_contains($plainText, 'Message Sent Successfuly ..')) {
                $srch_txt = 'Message Sent Successfuly ..';
                Log::info("srch_txt 1: " . $srch_txt);

            } elseif (str_contains($plainText, 'No SMS Sent')) {
                $srch_txt = 'No SMS Sent';

                Log::info("srch_txt 2: " . $srch_txt);
            }else{
                $srch_txt ='';
                Log::info("srch_txt 3: " . $srch_txt);

            }
            $new_unlockCode = trim(str_replace("\r\n", '', preg_replace("/&#?[a-z0-9]+;/i", "", (explode($srch_txt, end($temp))[0]))));


            Log::info("new_unlockCode : ");

            if (strlen($new_unlockCode) == 29) {
                $custmail = $request->txtemail;
                $txtLicense = $request->txtLicense;
                $sendmail =  $this->SendMail($new_unlockCode, $custmail, $txtLicense);

                Log::info("sendmail : " . ($sendmail));
            }

            Log::info("result_uc : ");

            return $result_uc;
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }
    public function SendMail($new_unlockCode, $custmail, $txtLicense)
    {
        try {
            $body = "Dear Sir/Mam,";
            $body .= "<br><br><b>Your NPAV UNLOCK CODE is : </b>" . $new_unlockCode;
            $body .= "<br><b>NPAV Key No.: </b>" . $txtLicense;
            $body .= "<br><br>Thanks and Regards,";
            $body .= "<br>NPAV Activation Department";
            $body .= "<br>020-67440810";
            $client = new Client(['verify' => false]);
            $response = $client->post('http://portal2.npav.net/api/emailapi', [
                'json' => [
                    'to'      => $custmail,
                    'from'    => 'support@npav.net',
                    'title'   => 'NPAV Activation Mail',
                    'subject' => 'NPAV Activation Mail',
                    'body'    => $body,
                ]
            ]);
            $send_email = $response->getBody();
            if ($send_email == true) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            return  response()->json($e->getMessage());
        }
    }
    /** Add District */
    public function AddDistrict()
    {
        $states = DB::table('statemaster')->orderBy('StateName')->get();
        return view('district.addDist', compact('states'));
    }
    public function getAllDistricts(Request $request)
    {
        $districts = DB::table('districtmaster')->select('districtmaster.*', 'statemaster.StateName')
            ->leftJoin('statemaster', 'statemaster.stID', '=', 'districtmaster.sID')
            ->get();
        return view('district.distPaging', compact('districts'));
    }
    public function addDistFormDate(Request $request)
    {
        try {
            $state = $request->state;
            $district = ucfirst($request->district);
            $validator = Validator::make($request->all(), [
                'state' => 'required|string',
                'district' => ['required', 'string', 'regex:/^[^\d]*$/'],
            ]);
            if ($validator->fails()) {
                $error = $validator->errors()->all();
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => $error[0]
                    ]
                );
            }
            $checkDist = DB::table('districtmaster')->where('sID', $state)->where('DISTRICT', $district)->exists();
            if ($checkDist == true) {
                return response()->json(['status' => 'error', 'message' => 'District Already Exist']);
            }
            $addDist = DB::table('districtmaster')->insert([
                'sID' => $state,
                'DISTRICT' => $district,
            ]);
            if ($addDist) {
                return response()->json(['status' => 'success', 'message' => 'District Added Successfully']);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Something went wrong']);
            }
        } catch (\Exception $e) {
            // return response()->json(['status' => 'error', 'message' => 'Server Error']);
            return  response()->json($e->getMessage());
        }
    }
    public function updateDist(Request $request)
    {
        try {
            $DISTRICT = $request->DISTRICT;
            $distid = $request->distid;
            $updDist = DB::table('districtmaster')->where('dID', $distid)->update([
                'DISTRICT' => $DISTRICT
            ]);
            if ($updDist) {
                return response()->json(['status' => 'success', 'message' => 'District Updated Successfully']);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Something went wrong']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Server Error']);
            // return  response()->json($e->getMessage());
        }
    }
}
