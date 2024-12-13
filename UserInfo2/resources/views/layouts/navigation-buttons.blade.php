<div class=" ">
    {{-- <div class="container-fluid"> --}}
    @php
        $loginUserId = auth()->user()->id;
        $loginUserName = auth()->user()->User_Name;
        $getPermissions = DB::connection('mysql6')
            ->table('userpermissionmaster')
            ->where('User_Name', $loginUserName)
            ->first();
        if ($getPermissions) {
            $tbl_id = $getPermissions->tbl_id;
            $user_id = $getPermissions->user_id;
            // $loggedUserName = $getPermissions->User_Name;
            $SalesEnq = $getPermissions->SalesEnq;
            $SendEmail = $getPermissions->SendEmail;
            $SendSms = $getPermissions->SendSms;
            $SuppWMS = $getPermissions->SuppWMS;
            $NewAct = $getPermissions->NewAct;
            $DlrReg = $getPermissions->DlrReg;
            $ForSales = $getPermissions->ForSales;
            $DlrActCount = $getPermissions->DlrActCount;
            $MyAct = $getPermissions->MyAct;
            $TechSupportNo = $getPermissions->TechSupportNo;
            $FindOrder = $getPermissions->FindOrder;
            $RnwWMS = $getPermissions->RnwWMS;
            $ReactEmail = $getPermissions->ReactEmail;
            $ReactReq = $getPermissions->ReactReq;
            $DlrScore = $getPermissions->DlrScore;
            $OnlinePurchasePDF = $getPermissions->OnlinePurchasePDF;
            $PriceList = $getPermissions->PriceList;
            $PndReq = $getPermissions->PndReq;
            $AndroidAct = $getPermissions->AndroidAct;
            $Articles = $getPermissions->Articles;
            $LastActs = $getPermissions->LastActs;
            $APKSMS = $getPermissions->APKSMS;
            $ReleaseKeys = $getPermissions->ReleaseKeys;
            $ScratchKeys = $getPermissions->ScratchKeys;
            $BlockKeys = $getPermissions->BlockKeys;
            $UpdDlrInfo = $getPermissions->UpdDlrInfo;
            $ActGraph = $getPermissions->ActGraph;
            $StateActCnt = $getPermissions->StateActCnt;
            $AddDays = $getPermissions->AddDays;
            $Kayako = $getPermissions->Kayako;
            $changeIP = $getPermissions->changeIP;
            $ManageUsers = $getPermissions->ManageUsers;
            $OTPmaster = $getPermissions->OTPmaster;
            $LoginHistory = $getPermissions->LoginHistory;
            $UserPermission = $getPermissions->UserPermission;
            $ConvertLic = $getPermissions->ConvertLic;
            $cloudbkpKey = $getPermissions->cloudbkpKey;
        }
    @endphp
    <div class="row p-1">
        <div class="">
            @if ($SalesEnq == '1')
                <a class="btn btn-md btn-outline-danger my-1" href="http://www.computergoa.com/sendenq/" target="_blank"
                    role="button">SalesEnq</a>
            @endif
            @if ($NewAct == '1')
                <a class="btn btn-md btn-outline-primary my-1" href="{{ url('/NewAct') }}" target="blank"
                    role="button">NewAct</a>
            @endif
            @if ($DlrScore == '1')
                <a class="btn btn-md btn-outline-success my-1 OpenDlrScoreModal" href="javascript:void(0)"
                    role="button">DlrScore</a>
            @endif
            @if ($MyAct == '1')
                <a class="btn btn-md btn-outline-primary my-1 my_acts_menu" href="javascript:void(0)" role="button">My
                    Acts</a>
            @endif
            @if ($PriceList == '1')
                <a class="btn btn-md btn-outline-primary my-1 " target="_blank" href="https://npav.net/buynow"
                    role="button">PriceList</a>
            @endif
            @if ($DlrReg == '1')
                <a class="btn btn-md btn-outline-primary my-1" href="{{ url('DealReg') }}" target="_blank"
                    role="button">DlrReg</a>
            @endif
            @if ($DlrActCount == '1')
                <a class="btn btn-md btn-outline-primary my-1 dlrActCount" href="javascript:void(0)"
                    role="button">DlrActCount</a>
            @endif
            @if ($OnlinePurchasePDF == '1')
                <a href="https://npav.net/online-purchase-guide" class="btn btn-md btn-outline-primary my-1"
                    target="_blank">Online
                    Purchase PDF</a>
            @endif
            @if ($AndroidAct == '1')
                <a class="btn btn-md btn-outline-primary my-1 " target="_blank"
                    href="http://npav.net/UserInfoMobile/NPMobileActivation.aspx" role="button">Android Act</a>
            @endif
            @if ($Articles == '1')
                <a class="btn btn-md btn-outline-primary my-1 btnActicleToggle" href="javascript:void(0)"
                    role="button">Articles</a>
                <div class="btn-group dropdown arcticleDropdown">
                    <div tabindex="-1" role="menu" aria-hidden="true"
                        class="dropdown-menu-shadow dropdown-menu-hover-link dropdown-menu my-3 p-1">
                        <a href="{{ url('public/Articles/NP-MobileSec-Activation.pdf') }}" target="_blank"
                            class="btn btn-md btn-outline-danger my-1" style="width: max-content"> NP-Mobile Security
                            Activation</a>
                        <a href="{{ url('public/Articles/NP-React-Pin.pdf') }}" target="_blank"
                            class="btn btn-md btn-outline-danger my-1" style="width: max-content"> NP-React-Pin</a>
                    </div>
                </div>
            @endif
            @if ($AddDays == '1')
                {{-- <a class="btn btn-md btn-outline-danger my-1" target="blank"
                    href="http://activation.indiaantivirus.com/userinfo/genReactive_ad.asp" role="button">Add
                    Days</a> --}}
                <a class="btn btn-md btn-outline-danger my-1 open_add_days" href="javascript:void(0)" role="button">Add
                    Days</a>
            @endif
            {{-- @if ($ReactEmail == '1')
                <a class="btn btn-md btn-outline-primary my-1 " href="javascript:void(0)" role="button">ReactEmail</a>
            @endif --}}
            {{-- @if ($ReactReq == '1')
                <a class="btn btn-md btn-outline-primary my-1 " data-bs-toggle="modal" data-bs-target="#reactRequestModal"
                    href="javascript:void(0)" role="button">ReactReq</a>
            @endif --}}
            @if ($TechSupportNo == '1')
                <a class="btn btn-md btn-outline-primary my-1 " data-bs-toggle="modal"
                    data-bs-target="#TechSupportModal" href="javascript:void(0)" role="button">Tech.Support Nos.</a>
            @endif
            @if ($SendEmail == '1')
                <a class="btn btn-md btn-outline-primary my-1 open_sendemail_modal" href="javascript:void(0)"
                    role="button">Send Email</a>
            @endif
            {{-- @if ($Kayako == '1')
                <a class="btn btn-md btn-outline-primary my-1 " target="_blank"
                    href="http://support.indiaantivirus.com/staff/index.php?/Core/Default/" role="button">Kayako</a>
            @endif --}}

            @if ($FindOrder == '1')
                <a href="https://indiaantivirus.com/autonew/SearchOrderNosdgyweh56DSGDSGFkklgf56.asp" target="_blank"
                    class="btn btn-md btn-outline-danger my-1">Find Order</a>
            @endif
            @if ($StateActCnt == '1')
                <a href="{{ url('stateWiseActCount') }}" class="btn btn-md btn-outline-danger my-1" target="blank">State
                    Act
                    Count</a>
            @endif
            @if ($ActGraph == '1')
                <a href="{{ url('actGraph') }}" target="blank" class="btn btn-md btn-outline-danger my-1">ActGraph</a>
            @endif
            @if ($UpdDlrInfo == '1')
                <a href="http://activation.indiaantivirus.com/UpdateDlrInfo/?User={{ $loginUserName }}" target="_blank"
                    class="btn btn-md btn-outline-danger my-1">Update Dlr Info</a>
            @endif
            @if ($BlockKeys == '1')
                <a href="{{ url('blockKeys') }}" target="blank" class="btn btn-md btn-outline-danger my-1">Block
                    Keys</a>
            @endif
            @if ($ScratchKeys == '1')
                <a href="http://activation.indiaantivirus.com/licSearch/login.asp" target="_blank"
                    class="btn btn-md btn-outline-danger my-1">Scratch Keys</a>
            @endif
            @if ($ReleaseKeys == '1')
                <a href="javascript:void(0)" class="btn btn-md btn-outline-danger my-1 releaseKey">Release Keys</a>
            @endif
            @if ($APKSMS == '1')
                <a data-link="{{ url('dashboard') }}" class="btn btn-md btn-outline-primary my-1 apksms">APK SMS</a>
            @endif
            @if ($LastActs == '1')
                <a class="btn btn-md btn-outline-primary my-1 last_acts_menu" data-link="{{ url('dashboard') }}">Last
                    Acts</a>
            @endif
            @if ($changeIP == '1')
                <a class="btn btn-md btn-outline-danger my-1" href="{{ url('changeIP') }}" target="blank">Change IP
                </a>
            @endif
            @if ($ManageUsers == '1')
                <a class="btn btn-md btn-outline-danger my-1" href="{{ url('allUsers') }}" target="blank">Manage Users
                </a>
            @endif
            @if ($OTPmaster == '1')
                <a class="btn btn-md btn-outline-primary my-1" href="{{ url('viewSentOTP') }}" target="blank">OTP
                    Master
                </a>
            @endif
            @if ($UserPermission == '1')
                <a class="btn btn-md btn-outline-danger my-1" href="{{ url('UserPermissions') }}" target="blank">User
                    Permissions
                </a>
            @endif
            @if ($LoginHistory == '1')
                <a class="btn btn-md btn-outline-success my-1" href="{{ url('LoginHistory') }}" target="blank">Login
                    History
                </a>
            @endif
            @if ($ConvertLic == '1')
                <a class="btn btn-md btn-outline-success my-1 "data-bs-toggle="modal"
                    data-bs-target="#ConvertLicModal" href="javascript:void(0)" target="blank">Convert LIC
                </a>
            @endif
            @if ($cloudbkpKey == '1')
                <a class="btn btn-md btn-outline-primary my-1"
                    href="https://nptb.computerkolkata.com/nptb/ViewKeyInfo.aspx" target="blank">cloudbkpKey
                </a>
            @endif

            @if (
                $loginUserName == 'sumeet' ||
                    $loginUserName == 'tusharb' ||
                    $loginUserName == 'sudhirg' ||
                    $loginUserName == 'vikramkumar' ||
                    $loginUserName == 'ganeshw')
                <a class="btn btn-md btn-outline-primary my-1" href="{{ url('viewreactcnt') }}" target="blank">
                    View React Count
                </a>
            @endif

            <a class="btn btn-md btn-outline-primary my-1" href="{{ url('/skipKeys') }}" target="blank">K2State Skip
                Keys</a>

            <a class="btn btn-md btn-outline-primary my-1" href="{{ url('/h2lSkipKeys') }}" target="blank">H2L Skip
                Keys</a>

            @if ($PndReq == '1')
                <a href="{{ url('/k2StatePolicy') }}" target="_blank"
                    class="btn btn-md btn-outline-danger my-1">K2State Policy</a>
            @endif
            @if (strtoupper($loginUserName) == 'TUSHARB' || strtoupper($loginUserName) == 'GANESHW')
                <a href="{{ url('/ucdllViewer') }}" target="_blank"
                    class="btn btn-md btn-outline-primary my-1">Unlock2024 Act</a>
            @endif
           
        </div>
    </div>
</div>
