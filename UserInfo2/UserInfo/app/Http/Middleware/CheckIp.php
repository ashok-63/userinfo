<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;

class CheckIp
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $filePath = storage_path("/app/public/IpList_" . date('d_m_Y') . ".json");
        $result = false;
        if (File::exists($filePath)) {
            $json_string = file_get_contents($filePath);
            $data = json_decode($json_string, true);
            $search_ip = $request->ip();
            $search_browser_id = Session::get('browser_id');
            function searchCombination($data, $search_ip, $search_browser_id)
            {
                foreach ($data as $item) {
                    if ($item['ip'] == $search_ip && $item['browser_id'] == $search_browser_id) {
                        return true;
                    }
                }
                return false;
            }
            $result = searchCombination($data, $search_ip, $search_browser_id);
        }
        
        if ($result) {
            $response = $next($request);
            $response->headers->set('Cache-Control', 'nocache, no-store, max-age=0, must-revalidate');
            $response->headers->set('Pragma', 'no-cache');
            $response->headers->set('Expires', 'Sun, 02 Jan 1990 00:00:00 GMT');
            return $response;
        } else {
            return response()->view('SendOTP');
        }
    }
    public function handle__(Request $request, Closure $next)
    {
        $getWhiteListedIps = [];
        $getWhiteListedIps = DB::connection('mysql6')->table('ip_access')->where('isDeleted', 0)->get();
        $IspIp = [];
        foreach ($getWhiteListedIps as $data) {
            $IspIp[] = $data->ip_address;
        };
        $getNewAddedIpViaOtp = DB::connection('mysql')->table('userinfo_ip')->select('IspIp')->where('IspIp', $request->ip())->first();
        if (in_array($request->ip(), $IspIp)) {
            $response = $next($request);
            $response->headers->set('Cache-Control', 'nocache, no-store, max-age=0, must-revalidate');
            $response->headers->set('Pragma', 'no-cache');
            $response->headers->set('Expires', 'Sun, 02 Jan 1990 00:00:00 GMT');
            return $response;
        } elseif ($getNewAddedIpViaOtp) {
            $response = $next($request);
            $response->headers->set('Cache-Control', 'nocache, no-store, max-age=0, must-revalidate');
            $response->headers->set('Pragma', 'no-cache');
            $response->headers->set('Expires', 'Sun, 02 Jan 1990 00:00:00 GMT');
            return $response;
        } else {
            return response()->view('SendOTP');
        }
    }
}
