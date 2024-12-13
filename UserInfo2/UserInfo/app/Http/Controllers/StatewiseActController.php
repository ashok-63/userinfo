<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class StatewiseActController extends Controller
{
    public function stateWiseActCount()
    {
        return view('stateWiseActCnt.stateWiseActCnt');
    }
    public function getStateWiseActCnt(Request $request)
    {
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $query = DB::connection('mysql')->table('customerlocation')
            ->select(
                'CustState',
                DB::raw("(SUM(IF(distriId = 0, 1, 0))) AS act"),
                DB::raw("(SUM(IF(distriId = 9999, 1, 0))) AS react"),
                DB::raw("count(custState) as cnt")
            );
        // ->whereDate('InDate', '>=', $startDate);
        if (!empty($startDate)) {
            $query->where('InDate', '>=', $startDate . ' 00:00:00');
        }
        if (!empty($endDate)) {
            $query->where('InDate', '<=', $endDate . ' 23:59:59');
        }
        $query->groupBy('CustState')
            ->orderByDesc('cnt');
        $getStateWiseActCnt =   $query->get();
        // dd($getStateWiseActCnt);
        return view('statewiseActCnt.pagination', compact('getStateWiseActCnt'));
    }
    public function getDistrictWiseActCnt(Request $request)
    {
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        $custState = $request->custState;
        $query = DB::connection('mysql')->table('customerlocation')
            ->select(
                'custDistrict',
                DB::raw("(SUM(IF(distriId = 0, 1, 0))) AS act"),
                DB::raw("(SUM(IF(distriId = 9999, 1, 0))) AS react"),
                DB::raw("count(custDistrict) as cnt")
            )
            ->where('custState', '=', $custState);
        if (!empty($startDate)) {
            $query->where('InDate', '>=', $startDate . ' 00:00:00');
        }
        if (!empty($endDate)) {
            $query->where('InDate', '<=', $endDate . ' 23:59:59');
        }
        $query->groupBy('custDistrict')
            ->orderByDesc('cnt');
        $getDistrictWiseActCnt =   $query->get();
        // dd($getDistrictWiseActCnt);
        return view('distCntModal', compact('getDistrictWiseActCnt'));
    }
}
