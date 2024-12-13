<div class=" ">
    
    <?php
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
    ?>
    <div class="row p-1">
        <div class="">
            <?php if($SalesEnq == '1'): ?>
                <a class="btn btn-md btn-outline-danger my-1" href="http://www.computergoa.com/sendenq/" target="_blank"
                    role="button">SalesEnq</a>
            <?php endif; ?>
            <?php if($NewAct == '1'): ?>
                <a class="btn btn-md btn-outline-primary my-1" href="<?php echo e(url('/NewAct')); ?>" target="blank"
                    role="button">NewAct</a>
            <?php endif; ?>
            <?php if($DlrScore == '1'): ?>
                <a class="btn btn-md btn-outline-success my-1 OpenDlrScoreModal" href="javascript:void(0)"
                    role="button">DlrScore</a>
            <?php endif; ?>
            <?php if($MyAct == '1'): ?>
                <a class="btn btn-md btn-outline-primary my-1 my_acts_menu" href="javascript:void(0)" role="button">My
                    Acts</a>
            <?php endif; ?>
            <?php if($PriceList == '1'): ?>
                <a class="btn btn-md btn-outline-primary my-1 " target="_blank" href="https://npav.net/buynow"
                    role="button">PriceList</a>
            <?php endif; ?>
            <?php if($DlrReg == '1'): ?>
                <a class="btn btn-md btn-outline-primary my-1" href="<?php echo e(url('DealReg')); ?>" target="_blank"
                    role="button">DlrReg</a>
            <?php endif; ?>
            <?php if($DlrActCount == '1'): ?>
                <a class="btn btn-md btn-outline-primary my-1 dlrActCount" href="javascript:void(0)"
                    role="button">DlrActCount</a>
            <?php endif; ?>
            <?php if($OnlinePurchasePDF == '1'): ?>
                <a href="https://npav.net/online-purchase-guide" class="btn btn-md btn-outline-primary my-1"
                    target="_blank">Online
                    Purchase PDF</a>
            <?php endif; ?>
            <?php if($AndroidAct == '1'): ?>
                <a class="btn btn-md btn-outline-primary my-1 " target="_blank"
                    href="http://npav.net/UserInfoMobile/NPMobileActivation.aspx" role="button">Android Act</a>
            <?php endif; ?>
            <?php if($Articles == '1'): ?>
                <a class="btn btn-md btn-outline-primary my-1 btnActicleToggle" href="javascript:void(0)"
                    role="button">Articles</a>
                <div class="btn-group dropdown arcticleDropdown">
                    <div tabindex="-1" role="menu" aria-hidden="true"
                        class="dropdown-menu-shadow dropdown-menu-hover-link dropdown-menu my-3 p-1">
                        <a href="<?php echo e(url('public/Articles/NP-MobileSec-Activation.pdf')); ?>" target="_blank"
                            class="btn btn-md btn-outline-danger my-1" style="width: max-content"> NP-Mobile Security
                            Activation</a>
                        <a href="<?php echo e(url('public/Articles/NP-React-Pin.pdf')); ?>" target="_blank"
                            class="btn btn-md btn-outline-danger my-1" style="width: max-content"> NP-React-Pin</a>
                    </div>
                </div>
            <?php endif; ?>
            <?php if($AddDays == '1'): ?>
                
                <a class="btn btn-md btn-outline-danger my-1 open_add_days" href="javascript:void(0)" role="button">Add
                    Days</a>
            <?php endif; ?>
            
            
            <?php if($TechSupportNo == '1'): ?>
                <a class="btn btn-md btn-outline-primary my-1 " data-bs-toggle="modal"
                    data-bs-target="#TechSupportModal" href="javascript:void(0)" role="button">Tech.Support Nos.</a>
            <?php endif; ?>
            <?php if($SendEmail == '1'): ?>
                <a class="btn btn-md btn-outline-primary my-1 open_sendemail_modal" href="javascript:void(0)"
                    role="button">Send Email</a>
            <?php endif; ?>
            

            <?php if($FindOrder == '1'): ?>
                <a href="https://indiaantivirus.com/autonew/SearchOrderNosdgyweh56DSGDSGFkklgf56.asp" target="_blank"
                    class="btn btn-md btn-outline-danger my-1">Find Order</a>
            <?php endif; ?>
            <?php if($StateActCnt == '1'): ?>
                <a href="<?php echo e(url('stateWiseActCount')); ?>" class="btn btn-md btn-outline-danger my-1" target="blank">State
                    Act
                    Count</a>
            <?php endif; ?>
            <?php if($ActGraph == '1'): ?>
                <a href="<?php echo e(url('actGraph')); ?>" target="blank" class="btn btn-md btn-outline-danger my-1">ActGraph</a>
            <?php endif; ?>
            <?php if($UpdDlrInfo == '1'): ?>
                <a href="http://activation.indiaantivirus.com/UpdateDlrInfo/?User=<?php echo e($loginUserName); ?>" target="_blank"
                    class="btn btn-md btn-outline-danger my-1">Update Dlr Info</a>
            <?php endif; ?>
            <?php if($BlockKeys == '1'): ?>
                <a href="<?php echo e(url('blockKeys')); ?>" target="blank" class="btn btn-md btn-outline-danger my-1">Block
                    Keys</a>
            <?php endif; ?>
            <?php if($ScratchKeys == '1'): ?>
                <a href="http://activation.indiaantivirus.com/licSearch/login.asp" target="_blank"
                    class="btn btn-md btn-outline-danger my-1">Scratch Keys</a>
            <?php endif; ?>
            <?php if($ReleaseKeys == '1'): ?>
                <a href="javascript:void(0)" class="btn btn-md btn-outline-danger my-1 releaseKey">Release Keys</a>
            <?php endif; ?>
            <?php if($APKSMS == '1'): ?>
                <a data-link="<?php echo e(url('dashboard')); ?>" class="btn btn-md btn-outline-primary my-1 apksms">APK SMS</a>
            <?php endif; ?>
            <?php if($LastActs == '1'): ?>
                <a class="btn btn-md btn-outline-primary my-1 last_acts_menu" data-link="<?php echo e(url('dashboard')); ?>">Last
                    Acts</a>
            <?php endif; ?>
            <?php if($changeIP == '1'): ?>
                <a class="btn btn-md btn-outline-danger my-1" href="<?php echo e(url('changeIP')); ?>" target="blank">Change IP
                </a>
            <?php endif; ?>
            <?php if($ManageUsers == '1'): ?>
                <a class="btn btn-md btn-outline-danger my-1" href="<?php echo e(url('allUsers')); ?>" target="blank">Manage Users
                </a>
            <?php endif; ?>
            <?php if($OTPmaster == '1'): ?>
                <a class="btn btn-md btn-outline-primary my-1" href="<?php echo e(url('viewSentOTP')); ?>" target="blank">OTP
                    Master
                </a>
            <?php endif; ?>
            <?php if($UserPermission == '1'): ?>
                <a class="btn btn-md btn-outline-danger my-1" href="<?php echo e(url('UserPermissions')); ?>" target="blank">User
                    Permissions
                </a>
            <?php endif; ?>
            <?php if($LoginHistory == '1'): ?>
                <a class="btn btn-md btn-outline-success my-1" href="<?php echo e(url('LoginHistory')); ?>" target="blank">Login
                    History
                </a>
            <?php endif; ?>
            <?php if($ConvertLic == '1'): ?>
                <a class="btn btn-md btn-outline-success my-1 "data-bs-toggle="modal"
                    data-bs-target="#ConvertLicModal" href="javascript:void(0)" target="blank">Convert LIC
                </a>
            <?php endif; ?>
            <?php if($cloudbkpKey == '1'): ?>
                <a class="btn btn-md btn-outline-primary my-1"
                    href="https://nptb.computerkolkata.com/nptb/ViewKeyInfo.aspx" target="blank">cloudbkpKey
                </a>
            <?php endif; ?>

            <?php if(
                $loginUserName == 'sumeet' ||
                    $loginUserName == 'tusharb' ||
                    $loginUserName == 'sudhirg' ||
                    $loginUserName == 'vikramkumar' ||
                    $loginUserName == 'ganeshw'): ?>
                <a class="btn btn-md btn-outline-primary my-1" href="<?php echo e(url('viewreactcnt')); ?>" target="blank">
                    View React Count
                </a>
            <?php endif; ?>

            <a class="btn btn-md btn-outline-primary my-1" href="<?php echo e(url('/skipKeys')); ?>" target="blank">K2State Skip
                Keys</a>

            <a class="btn btn-md btn-outline-primary my-1" href="<?php echo e(url('/h2lSkipKeys')); ?>" target="blank">H2L Skip
                Keys</a>

            <?php if($PndReq == '1'): ?>
                <a href="<?php echo e(url('/k2StatePolicy')); ?>" target="_blank"
                    class="btn btn-md btn-outline-danger my-1">K2State Policy</a>
            <?php endif; ?>
            <?php if(strtoupper($loginUserName) == 'TUSHARB' || strtoupper($loginUserName) == 'GANESHW'): ?>
                <a href="<?php echo e(url('/ucdllViewer')); ?>" target="_blank"
                    class="btn btn-md btn-outline-primary my-1">Unlock2024 Act</a>
            <?php endif; ?>
           
        </div>
    </div>
</div>
<?php /**PATH C:\inetpub\wwwroot\UserInfo2\resources\views/layouts/navigation-buttons.blade.php ENDPATH**/ ?>