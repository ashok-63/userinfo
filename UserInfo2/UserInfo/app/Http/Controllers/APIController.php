<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;

class APIController extends Controller
{
    public function smsapi(Request $request)
    {
        // dd($request->all());
        $mobileNumber = $request->mobile;
        $msg = $request->msg;
        $templateid = $request->templateid;
        $senderId = $request->senderId;
        if ($mobileNumber != '' && $msg != '' && $templateid != '' && $senderId != '') {
            $authKey = "NPAVIN";
            //Your message to send, Add URL encoding here.
            $message = urlencode($msg);
            $password = "sumz48741289632";
            $username = "sumeetk";
            //Define route
            $route = "default";
            $postData = [
                'username' => $username,
                'password' => $password,
                'mobile' => $mobileNumber,
                'sendername' => $senderId,
                //'authkey' => $authKey,
                'message' => $message,
                //'route' => $route,
                'templateid' => $templateid,
            ];
            //API URL
            $url = "http://priority.muzztech.in/sms_api/sendsms.php?username=" . $username . "&password=" . $password . "&mobile=" . $mobileNumber . "&sendername=" . $senderId . "&message=" . $message . "&templateid=" . $templateid;
            // init the resource
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => false,
                //CURLOPT_POSTFIELDS => $postData,
                //,CURLOPT_FOLLOWLOCATION => true
            ]);
            //Ignore SSL certificate verification
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            //get response
            $output = curl_exec($ch);
            //Print error if any
            if (curl_errno($ch)) {
                return response()->json([
                    'Status' =>  false,
                    'Message' => 'Error Sending SMS..',
                ]);
            }
            curl_close($ch);
            if ($output) {
                return response()->json([
                    'Status' =>  true,
                    'Message' => 'Wow, SMS Sent Successfully..',
                ]);
            }
        } else {
            return response()->json([
                'Status' =>  false,
                'Message' => 'OOPS! Please Fill Required Field..',
            ]);
        }
    }
    /** Check IP is whitelisted or not | used in laptrack */
    public function IsIpWhitelisted(Request $request)
    {
        $getWhiteListedIps = DB::connection('mysql6')->table('ip_access')->where('ip_address', $request->ip)->where('isDeleted', 0)->count();
        if ($getWhiteListedIps == 0) {
            $getNewAddedIpViaOtp = DB::connection('mysql')->table('userinfo_ip')->select('IspIp')->where('IspIp', $request->ip)->count();
            if ($getNewAddedIpViaOtp == 0) {
                return false;
            } else {
                return true;
            }
        } else {
            return true;
        }
    }
    public function AddBookmark(Request $request)
    {
        $key = $request->KeyNo;
        // $user = auth()->user()->User_Name;
        $addKey = DB::connection('mysql6')->table('bookmarks')->insert([
            'key' => $key,
            'inDate' => now()
        ]);
        return 'Added';
    }
}
