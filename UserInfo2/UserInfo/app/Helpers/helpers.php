<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class Helpers
{

    public static function getKeyType($lic)
    {
        $Zs3Yr1 = false;
        $ZsSrv1 = false;
        $FxPcKey1 = false;
        $AvgExpKey1 = false;
        $Is3Yr1 = false;
        $Is3YrSN1 = false;
        $AVPro3Yr1 = false;
        $explode_lic = explode('-', $lic);
        if ($AvgExpKey1 == false) {
            if (substr($lic, 0, 1) == 'X' || substr($lic, 0, 1) == 'L' || substr($lic, 0, 1) == 'P') {
                // Check In serialnums_zs3yr Table
                $query = DB::table('serialnums_zs3yr')
                    ->select('SerialNo')
                    ->where('SerialNo', $lic)
                    ->first();
                if (!empty($query)) {
                    if ($query->SerialNo == $lic) {
                        if (substr($lic, 0, 1) == 'X') {
                            $Zs3Yr1 = true;
                        } elseif (substr($lic, 0, 1) == 'L') {
                            $AVPro3Yr1 = true;
                        } elseif (substr($lic, 0, 1) == 'P') {
                            $Is3YrSN1 = true;
                        }
                    }
                }
            } elseif (substr($lic, 0, 1) == 'S' || substr($lic, 0, 1) == 'T') {
                // Check In serialnums_zssrv Table
                $query = DB::table('serialnums_zssrv')
                    ->select('SerialNo')
                    ->where('SerialNo', $lic)
                    ->first();
                if (!empty($query)) {
                    if ($query->SerialNo == $lic) {
                        $ZsSrv1 = true;
                    }
                }
            } elseif (strlen($lic) == 12 && substr($lic, -1, 1) == 'A' && substr($lic, 2, 1) == 'A') {
                // Check In SERIALNUMS_FXPCSKEYS Table
                $query = DB::table('serialnums_fxpcskeys')
                    ->select('SerialNo')
                    ->where('SerialNo', $lic)
                    ->first();
                if (!empty($query)) {
                    if ($query->SerialNo == $lic) {
                        $FxPcKey1 = true;
                    }
                }
            }
        }
        $SpecialKeyMsg1 = "";
        if ($Zs3Yr1 == true || $ZsSrv1 == true || $FxPcKey1 == true || $AvgExpKey1 == true || $Is3YrSN1 == true || $AVPro3Yr1 == true) {
            if ($Zs3Yr1 == true) {
                $SpecialKeyMsg1 = "ZS 3 Yr";
            } elseif ($ZsSrv1 == true) {
                $SpecialKeyMsg1 = "Server With Z Security";
            } elseif ($FxPcKey1 == true) {
                $SpecialKeyMsg1 = "Multi 5PC/10PC";
            } elseif ($Is3YrSN1 == true) {
                $SpecialKeyMsg1 = "IS 3 Yr";
            } elseif ($AVPro3Yr1 == true) {
                $SpecialKeyMsg1 = "AVPro 3 Yr";
            } elseif ($AvgExpKey1 == true) {
                if ($Is3Yr = true) {
                    $SpecialKeyMsg1 = "3 Yr";
                } else {
                    $SpecialKeyMsg1 = "Avg. Exp.";
                }
            }
        }
        return $SpecialKeyMsg1;
    }
}
