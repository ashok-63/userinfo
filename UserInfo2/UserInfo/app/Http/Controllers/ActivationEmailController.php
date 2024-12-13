<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use Exception;

class ActivationEmailController extends Controller
{
    function index(Request $request)
    {
        try {
            $lic_key = $request->lic_key;
            if (empty($lic_key)) {
                return response()->json([
                    'status' =>  false,
                    'message' => 'Invalid Lic Key',
                    'data' => (object) [],
                ]);
            }

            if (strlen($lic_key) != 12) {
                return response()->json([
                    'status' =>  false,
                    'message' => 'Invalid Lic Key',
                    'data' => (object) [],
                ]);
            }

            $InfoLicKeyDetails = DB::table('info')->select('SerialNo', 'contactPerson', 'Dealer', 'computerName', 'emailID', 'CustMobile', 'unlockCode', 'ExpiryDate', 'customernumber')->where('SerialNo', '=', $lic_key)->orderBy('customernumber', 'desc')->first();
            // return response()->json([$InfoLicKeyDetails]);
            if (!empty($InfoLicKeyDetails)) {
                // return response()->json($InfoLicKeyDetails->emailID);
                $send_email = $this->send_email($lic_key, $InfoLicKeyDetails->contactPerson, $InfoLicKeyDetails->computerName, $InfoLicKeyDetails->emailID, $InfoLicKeyDetails->CustMobile, $InfoLicKeyDetails->unlockCode, $InfoLicKeyDetails->ExpiryDate, trim($InfoLicKeyDetails->Dealer));
                if ($send_email) {
                    return response()->json([
                        'status' =>  true,
                        'message' => 'Send mail successfully.',
                        'data' => (object) [],
                    ]);
                }
            } else {
                return response()->json([
                    'status' =>  false,
                    'message' => 'Invalid Lic Key.',
                    'data' => (object) [],
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' =>  false,
                'message' => $e->getMessage(),
                'data' => (object) [],
            ]);
            // return response()->json($e->getMessage());
        }
    }

    function send_email($lic_key, $contactPerson, $computerName, $emailID, $mobile_no, $unlockCode, $ExpiryDate, $dealer_name)
    {
        $serial_initial = substr($lic_key, 0, 1);
        $type_txt = "Thank you for purchasing Net Protector AntiVirus (NPAV)";
        if ($serial_initial == 'G' || $serial_initial == 'H') {
            $type_txt = "Thank you for using Demo of Net Protector AntiVirus (NPAV)";
        }
        $emailTxt = '';
        $emailTxt .= "Dear " . $contactPerson;
        $emailTxt .= "<br/>" . $type_txt . "<br/>";
        $emailTxt .= "<br/>Your software has been activated successfully.";

        $emailTxt .= "<br/>This email include your account details,so please keep it safe";
        $emailTxt .= "<br/>Customer Name : " . $contactPerson;
        $emailTxt .= "<br/><b>License Number : " . $lic_key . "</b>";
        $emailTxt .= "<br/>Email id : " . $emailID;
        $emailTxt .= "<br/>Mobile  : " . $mobile_no;
        if (!empty($computerName)) {
            $emailTxt .= "<br/>Computer Name : " . $computerName;
        }

        $emailTxt .= "<br/>Unlock Code : " . $unlockCode;
        $emailTxt .= "<br/>Expiry Date : " . $ExpiryDate;
        if (!empty($dealer_name) || $dealer_name != '' || $dealer_name != NULL) {
            $emailTxt .= "<br/>Dealer Name : " . $dealer_name;
        }

        $emailTxt .= "<br/>";
        $emailTxt .= "<br/>For any further assistance please contact following :";
        $emailTxt .= "<br/><b>Technical Help Desk :</b><br/>";
        $emailTxt .= "09325102020 <br/>";
        $emailTxt .= "020-65601480 <br/>";
        $emailTxt .= "1800-200-6728<br/><br/>";
        $emailTxt .= "<b>Activation / Unlock Code Related :</b><br/>";
        $emailTxt .= "020-24455111 / 9850538545<br/>9225521515<br/><br/>";
        $emailTxt .= "<b>For Feedback / Comments :</b><br/>";
        $emailTxt .= "<a href=http://www.indiaantivirus.com/feedback.html>www.indiaantivirus.com/feedback.html</a><br/><br/>";

        $emailTxt .=  "<p class='text-left'>";
        $emailTxt .=  "Thanks and Regards,<br/>" .
            "<b>Net Protector Team</b><br/> " .
            "<b>Email :</b> <a href = 'mailto:help@npav.net'>help@npav.net</a>";
        $emailTxt .=  "</p>";

        $emailTxt .=  "<p class='text-left'>";
        $emailTxt .=  "<i>*** This is an automatically generated email, please do not reply. ***<i>";
        $emailTxt .=  "</p>";

        $client = new Client(['verify' => false]);

        $emailapi = 'https://portal2.npav.net/api/emailapi';
        try {
            $request = $client->post($emailapi, [
                'json' => [
                    'from' => 'support@npav.net',
                    'to' => $emailID,
                    'title' => 'NPAV Activation',
                    'subject' => 'Welcome to NPAV',
                    'body' => $emailTxt,
                ]
            ]);

            if ($request->getStatusCode() == 200) {
                return true;
            }
        } catch (\Throwable $e) {
            return false;
            // return $e->getMessage();
        }
    }
}
