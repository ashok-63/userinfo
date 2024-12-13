@extends('master')

@section('content')
<style>
    .page_title{
        font-family: Verdana, Tahoma, Helvetica, Arial, sans-serif;
        font-size: 18px;
        background-color: #D5DCFF;
    }
    .style1{
        color: #4754AD;
    }
    .brdTbl
{
	border:solid #A4B8D0 1px;
	border-collapse:collapse;
}
.brdCell
{
	border:solid #A4B8D0 1px;
	border-collapse:collapse;
}
body,td,th {
	font-size: 11px;
}
.style11 {border: solid #A4B8D0 1px; border-collapse: collapse; font-weight: bold; }
.style12 {
	color: #993333;
	font-weight: bold;
}
.style13 {
	color: #99335A;
	font-weight: bold;
}
h5{
    font-family: Verdana, Arial, Helvetica, sans-serif !important;
}
.Uc {
	color: #FFFFFF;
	font-weight: bold;
	background-color:#FF0000;
    display: inline-block;
    width: 15px;
    text-align: center;
}
.key {
	color: #FFFFFF;
	font-weight: bold;
	background-color:#006400;
    display: inline-block;
    width: 15px;
    text-align: center;
}
.Uckey {
	color: #000000;
	font-weight: bold;
	background-color:#FFFF00;
    display: inline-block;
    width: 15px;
    text-align: center;
}
.SUc {
	color: #FFFFFF;
	font-weight: bold;
	background-color:#B75B00;
    display: inline-block;
    width: 15px;
    text-align: center;
}
.RKey {
	color: #FFFFFF;
	font-weight: bold;
	background-color:#0033FF;
    display: inline-block;
    width: 15px;
    text-align: center;
}
.Fb {
	color: #000000;
	font-weight: bold;
	background-color:#FFD7D7;
    display: inline-block;
    width: 90px;
    text-align: center;
	}

.table-bordered th {
    font-weight: 550;
    font-size: 11px! important;
}

.table-bordered td {
    font-size: 9px! important;
}
</style>
<div class="container-fluid mt-1 main_container">
    <div class="row">
        <div class="col-md-12 page_title mb-1">
            <span class="style1">&nbsp;UC Block History  of</span> <span class="style2 lic_no"></span>
        </div>
        <div class="col-md-12 mb-1">
            <span class="Uc">U</span> : Unlock Code is in Blocked List.&nbsp;&nbsp;<span class="key">K</span> : Key Number is in block list.&nbsp;&nbsp;<span class="Uckey">V</span> : Same UC and Key  is running on different PC's.&nbsp;&nbsp;<span class="SUc">S</span> : Sure Block.&nbsp;&nbsp; <span class="RKey">R</span> : Key contains RRR,&nbsp;&nbsp;<span class="Fb">Final Block</span>
        </div>
        <hr>
        <div class="col-md-12">
            <span class="style13"><h5>Unlockcode Block Status</h5></span>

            <table class="table table-bordered">
                <thead>
                  <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Unlockcode</th>
                    <th scope="col">Machine Name/OS/CPU Name</th>
                    <th scope="col">Login Name/IP</th>
                    <th scope="col">InDate</th>
                    <th scope="col">HC/Update Date</th>
                  </tr>
                </thead>
                <tbody>
                    @php
                        $i = 0;
                        $cntr=1;
                        $sameUCOn2Pc=false;
                        $foundUc="";
                        $clscls="";
                        if (!empty($rsInfo) && !empty($rsInfo[0])) { 
                        foreach ($rsInfo as $key => $RSInfo) {
                            $blockReason = $RSInfo->blockReason;
                               if ($blockReason == 'V') {
                                $sameUCOn2Pc=true;
                                $foundUc = $blockReason;
                                $cls="Uckey";
                              }else if ($blockReason == 'U') {
                                    $cls="Uc";
                              }else if ($blockReason == 'K') {
                                    $cls="key";
                              }else if ($blockReason == 'S') {
                                    $cls="SUc";
                              }else if ($blockReason == 'R') {
                                    $cls="RKey";
                              }
                             $row_bg_color = ($RSInfo->isFinalBlocked==true)?'style="background-color:#FFD7D7"':'';
                              echo '<tr '.$row_bg_color.'>
                                <td>'.($key+1).'<br><span class='.$cls.'>'.$blockReason.'</span>'.'</td>
                                <td>'.$RSInfo->unlockcode.'<br>'.$RSInfo->keyNo.'</td>
                                <td>'.$RSInfo->machineName.'<br>'.$RSInfo->os.'<br>'.$RSInfo->cpuName.'</td>
                                <td>'.$RSInfo->loginName.'<br>'.$RSInfo->ip.'</td>
                                <td>'.$RSInfo->iDt.'</td>
                                <td>'.$RSInfo->hitCounter.'<br>'.$RSInfo->uDt.'</td>
                            </tr>';
                         }
                        }else{
                            echo '<tr><td  colspan="6" style="text-align: center;">No Data Available</td></tr>';
                        }
                        @endphp
                       
                 
                </tbody>
              </table>

        </div>

        <div class="col-md-12">
            <span class="style13"><h5>Key Block Status</h5></span>
            <table class="table table-bordered">
                <thead>
                  <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Key No</th>
                    <th scope="col">HC</th>
                    <th scope="col">Added Date</th>
                    <th scope="col">Update Date</th>
                    <th scope="col">Last HC Date</th>
                    <th scope="col">Removed</th>
                    <th scope="col">Reason</th>
                    <th scope="col">Removed Date</th>
                  </tr>
                </thead>
                <tbody>
                    @php
                     if (!empty($KeyInfo) && !empty($KeyInfo[0])) { 
                       foreach ($KeyInfo as $key => $KeyInfo) {
                       $Status = ($KeyInfo->isRemoved==true)?'YES':'NO';
                        echo '<tr '.$row_bg_color.'>
                                <td>'.($key+1).'</td>
                                <td>'.$KeyInfo->keyNo.'</td>
                                <td>'.$KeyInfo->counter.'</td>
                                <td>'.$KeyInfo->addDt.'</td>
                                <td>'.$KeyInfo->updDt.'</td>
                                <td>'.$KeyInfo->hcDt.'</td>
                                <td>'.$Status.'</td>
                                <td>'.$KeyInfo->removeReason.'</td>
                                <td>'.$KeyInfo->remDt.'</td>
                            </tr>';
                       }
                    }else{
                            echo '<tr><td colspan="9" style="text-align: center;">No Data Available</td></tr>';
                        }
                    @endphp
                </tbody>
            </table>
        </div>
       
        @if ($sameUCOn2Pc == true)
        <div class="col-md-12">
            <span class="style13"><h5>Same Unlockcode and key number is running on different Pc's</h5></span>
            <table class="table table-bordered">
                <thead>
                  <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Unlockcode /Key No</th>
                    <th scope="col">Machine Name/OS/CPU Name</th>
                    <th scope="col">Login Name/IP</th>
                    <th scope="col">In Date</th>
                    <th scope="col">HC/Update Date</th>
                  </tr>
                </thead>
                <tbody>
                    @php
                         $ChkUc = DB::connection('mysql5')->table("ucchecklog")->select('*',(DB::raw('DATE_FORMAT(InDate, "%d-%b-%Y %h:%i %p") as iDt')),(DB::raw('DATE_FORMAT(updateDate, "%d-%b-%Y %h:%i %p") as uDt')))->where('unlockcode', '=',$foundUc)->orderBy('sID', 'asc')->get();

                       foreach ($ChkUc as $key => $KUCInfo) {
                        echo '<tr>
                                <td>'.($key+1).'</td>
                                <td>'.$KUCInfo->unlockcode.'<br>'.$KUCInfo->keyNo.'</td>
                                <td>'.$KUCInfo->machineName.'<br>'.$KUCInfo->os.'<br>'.$KUCInfo->cpuName.'</td>
                                <td>'.$KUCInfo->loginName.'<br>'.$KUCInfo->ip.'</td>
                                <td>'.$KUCInfo->iDt.'</td>
                                <td>'.$KUCInfo->hitCounter.'<br>'.$KUCInfo->uDt.'</td>
                            </tr>';
                       }
                    @endphp
                </tbody>
            </table>
        </div>
        @endif

        @if (!empty($rsChkUc))
        <div class="col-md-12">
            <span class="style13"><h5>Scheduled Unlockcode Checking [Not in BLOCK list]</h5></span>
            <table class="table table-bordered">
                <thead>
                  <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Unlockcode /Key No</th>
                    <th scope="col">Machine Name/OS/CPU Name</th>
                    <th scope="col">Login Name/IP</th>
                    <th scope="col">In Date</th>
                    <th scope="col">HC/Update Date</th>
                  </tr>
                </thead>
                <tbody>
                    @php
                       foreach ($rsChkUc as $key => $KUCInfo) {
                        echo '<tr>
                                <td>'.($key+1).'</td>
                                <td>'.$KUCInfo->unlockcode.'<br>'.$KUCInfo->keyNo.'</td>
                                <td>'.$KUCInfo->machineName.'<br>'.$KUCInfo->os.'<br>'.$KUCInfo->cpuName.'</td>
                                <td>'.$KUCInfo->loginName.'<br>'.$KUCInfo->ip.'</td>
                                <td>'.$KUCInfo->iDt.'</td>
                                <td>'.$KUCInfo->hitCounter.'<br>'.$KUCInfo->uDt.'</td>
                            </tr>';
                       }
                    @endphp
                </tbody>
            </table>
        </div>               
        @endif

    </div>
</div>
<script>
query_string =[];
let url = window.location.href;
query_string = url.split("/");
$('.lic_no').text(query_string[6])
</script>
@endsection('content')