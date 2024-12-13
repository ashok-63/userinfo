<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class BlockKeysController extends Controller
{
    public function blockKeys(Request $request)
    {
        return view('blockKeys');
    }
    public function blockKeysFormData(Request $request)
    {
        $licNo = $request->licNo;
        $reason = $request->reason;
        $password = $request->password;
        $blockedDate = date('Y-m-d H:i:s');
        $lic_arr = preg_split("/\r\n|\n|\r/", $licNo);
        foreach ($lic_arr as $row) {
            if (strlen(trim($row)) != 12 && strpos(trim($row), "-") != 1) {
                return response()->json(['msg' => 'Invalid Licence Key..!', 'Status' => 'error']);
            }
        }
        $blocked = 0;
        $activated = 0;
        $notFound = 0;
        $cnt = 1;
        $output_msg = [];
        $temp_arr = [];
        if (!empty($password) && $password == 'blok2913') {
            $date = date('dMy');
            $text = "BLOCKED " . strtoupper($date) . " " . strtoupper(trim($reason));
            foreach ($lic_arr as $key) {
                $exolode_key = explode('-', trim($key));
                $checkActivationCode = DB::table('serialnums')
                    ->select('ActivationCode')
                    ->where('SerialInitial', $exolode_key[0])
                    ->where('SerialNo', $exolode_key[1])
                    ->first();
                if (!empty($checkActivationCode)) {
                    if (!empty($checkActivationCode->ActivationCode) && trim($checkActivationCode->ActivationCode) != '') {
                        $activated = $activated + 1;
                        $msg = "Already Activated";
                        $checkLicBlockLog = DB::table('licblocklog')->select('licNo')
                            ->where('licNo', trim($key))
                            ->first();
                        if (empty($checkLicBlockLog)) {
                            $insert_licblocklog = DB::table('licblocklog')->insert([
                                'licNo' => trim($key),
                                'remark' => 'Already Activated',
                                'reason' => trim($reason),
                                'blockedDate' => $blockedDate,
                            ]);
                        }
                    } else {
                        $blocked = $blocked + 1;
                        $msg = "Blocked";
                        $updateQry = DB::table('SerialNums')
                            ->where('SerialInitial', $exolode_key[0])
                            ->where('SerialNo', $exolode_key[1])
                            ->update([
                                'ActivationCode' => $text
                            ]);
                        $insert_licblocklog_block = DB::table('licblocklog')->insert([
                            'licNo' => trim($key),
                            'remark' => 'Blocked',
                            'reason' => trim($reason),
                            'blockedDate' => $blockedDate,
                        ]);
                    }
                } else {
                    $notFound = $notFound + 1;
                    $msg = "Not Found";
                }
                $output_msg = [
                    'licNo' => $key,
                    'msg' => $msg,
                ];
                array_push($temp_arr, $output_msg);
            }
            return view('blockKeyPaging', compact('temp_arr', 'notFound', 'activated', 'blocked'));
        } else {
            return response()->json(['msg' => 'Incorrect Password', 'Status' => 'error']);
        }
    }
    /**
     * Act Graph
     */
    public function actGraphView()
    {
        $allStates = DB::table('statemaster')->orderBy('stateName', 'ASC')->get();
        $allDists = DB::table('districtmaster')->orderBy('District', 'ASC')->get();
        return view('actGraph', compact('allStates', 'allDists'));
    }
    public function getDistricts(Request $request)
    {
        $allDists = DB::table('districtmaster')->where('sID', $request->stateId)->orderBy('District', 'ASC')->get();
        return $allDists;
    }
    public function getGraphData(Request $request)
    {
        $stateId = ($request->stateId);
        $distId = ($request->distId);
        $stateName = strtoupper(trim($request->stateName));
        $distName = strtoupper(trim($request->distName));
        $totalMonths = trim($request->totalMonths);
        $int_months = (int)$totalMonths - 1;
        $totActivations = 0;
        // dd($distName);
        $now = date('Y-m-d H:i:s');
        $temp_arr = [];
        $resultArr = [];
        $month_name_arr = [];
        // dd($stateId);
        if (empty($stateId) && empty($distId)) {
            return response()->json(['msg' => 'Please select state or district', 'Status' => 'error']);
        }
        if (!empty($stateId) && empty($distId)) {
            $saveData = $stateName;
        } elseif (empty($stateId) && !empty($distId)) {
            $saveData = $distName;
        } else {
            $saveData = $distName;
        }
        // dd($saveData);
        for ($i = 0; $i >= -$int_months; $i--) {
            $month_names = Carbon::now()
                ->addMonth($i)
                ->format('M');
            $year = Carbon::now()
                ->addMonth($i)
                ->format('y');
            $month = Carbon::now()
                ->addMonth($i)
                ->format('m');
            $year_full = Carbon::now()
                ->addMonth($i)
                ->format('Y');
            //Check in districtwiseactivationcounter table
            $checkForDist = DB::table('districtwiseactivationcounter')
                ->select('forMonth', 'actCounter')
                ->where('district', '=', $saveData)
                ->where('forMonth', '=', $month)
                ->where('forYear', '=', $year_full)
                ->first();
            if (!empty($checkForDist)) {
                $totActivations = $checkForDist->actCounter;
            } else {
                $qry = DB::table('customerlocation')
                    ->select(DB::raw('Count(LocationId) as totActivations'))
                    ->whereRaw('MONTH(InDate) = ' . $month)
                    ->whereRaw('YEAR(InDate) = ' . $year_full);
                if (!empty($stateId)) {
                    $qry->where('CustState', '=', $stateName);
                }
                if (!empty($distId)) {
                    $qry->where('CustDistrict', '=', $distName);
                }
                $checkInCustLocn = $qry->first();
                $totActivations = $checkInCustLocn->totActivations;
                if ($i > 0) {
                    $insertQry = DB::table('districtwiseactivationcounter')->insert([
                        'forMonth' => $month,
                        'forYear' => $year_full,
                        'district' => $saveData,
                        'actCounter' => $totActivations,
                        'indate' => $now
                    ]);
                }
            }
            $temp_arr = [
                'MonthName' => $month_names . '-' . $year,
                'totActivations' => $totActivations,
            ];
            array_push($resultArr, $temp_arr);
        }
        return   $resultArr;
    }
}
