<div class="topnav ">

    <nav class="navbar navbar-light navbar-expand-lg topnav-menu">
        <div class="collapse navbar-collapse" id="topnav-menu-content" style="justify-content: space-between">
            <ul class="navbar-nav">
                <li class="nav-item" id="">
                    <a class="" href="javascript:void(0)" id="">
                        <img src="<?php echo e(url('/')); ?>/public/backend/assets/images/imp/npav.gif" alt=""
                            height="40">
                    </a>
                </li>
            </ul>
            <div class=" mx-2 d-flex">
                <p class="text-white" style="font-size: 14px;"> Welcome: <?php echo e(auth()->user() ? auth()->user()->User_Name : ''); ?></p>
                <div class="dropdown d-inline-block">
                    <button type="button" class="btn  waves-effect mx-2" id="page-header-user-dropdown"
                        data-bs-toggle="dropdown" aria-haspopup="false" aria-expanded="false">
                        <i class="fa fa-lg fa-regular fa-user text-white"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end my-4" style="">
                        <a class="dropdown-item" href="javascript:void(0)"><i
                                class="mdi mdi-account-circle font-size-17 align-middle me-1"></i> Profile</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-danger" href="<?php echo e(url('logout')); ?>"><i
                                class="bx bx-power-off font-size-17 align-middle me-1 text-danger"></i> Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</div>
<?php /**PATH C:\inetpub\wwwroot\UserInfo2\resources\views/layouts/menu.blade.php ENDPATH**/ ?>