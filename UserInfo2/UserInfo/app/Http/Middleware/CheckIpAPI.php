<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIpAPI
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $Ips = array(
            '65.21.141.126', '103.186.19.211', '::1', '103.186.19.208', "202.189.250.93");


        // dd($request->ip());
        if (in_array($request->ip(), $Ips)) {
            $response = $next($request);
            return $response;
        } else {
            return response()->json(['status' => false, 'msg' => 'ERROR-UNAUTHORIZED ACCESS#NPAV#']);
        }
    }
}
