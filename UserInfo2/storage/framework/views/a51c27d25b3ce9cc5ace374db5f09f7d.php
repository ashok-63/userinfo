<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Userinfo | <?php echo $__env->yieldContent('title'); ?> </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="" name="description">
    <meta content="" name="author">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo e(url('/public/backend/assets/images/favicon.png')); ?>">
    <link href="<?php echo e(url('public/backend/assets/css/font-awesome.min.css')); ?>" rel="stylesheet">
    <!-- Bootstrap Css -->
    <link href="<?php echo e(url('/')); ?>/public/backend/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet"
        type="text/css">
    <!-- Icons Css -->
    <link href="<?php echo e(url('/')); ?>/public/backend/assets/css/icons.min.css" rel="stylesheet" type="text/css">
    <!-- App Css-->
    <link href="<?php echo e(url('/')); ?>/public/backend/assets/css/app.min.css" id="app-style" rel="stylesheet"
        type="text/css">
    <link href="<?php echo e(url('/')); ?>/public/backend/assets/css/custom.css" id="app-style" rel="stylesheet"
        type="text/css">
    <!-- Select2 Css-->
    <link href="<?php echo e(url('public/backend/assets/libs/select2/css/select2.min.css')); ?>" rel="stylesheet" type="text/css">
    <!-- sweet alert Css-->
    <link href="<?php echo e(url('public/backend/assets/libs/sweetalert2/sweetalert2.min.css')); ?>" rel="stylesheet">
    <!-- Datatable Css-->
    <link href="<?php echo e(url('public/backend/assets/css/dataTables.bootstrap5.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(url('public/backend/assets/css/jquery.toast.css')); ?>" rel="stylesheet">
    
    <link rel="stylesheet" href="<?php echo e(url('public/backend/assets/css/dataTables.dataTables.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(url('public/backend/assets/css/buttons.dataTables.css')); ?>">
    <script src="<?php echo e(url('/')); ?>/public/backend/assets/libs/jquery/jquery.min.js"></script>
    <script src="<?php echo e(url('public/backend/assets/js/jquery.validate.min.js')); ?>"></script>
    <!-- sweet alert Js-->
    <script src="<?php echo e(url('public/backend/assets/libs/sweetalert2/sweetalert2.min.js')); ?>"></script>
    <link rel="stylesheet" href="<?php echo e(url('public/backend/assets/css/flatpickr.min.css')); ?>">
</head>

<body data-topbar="dark" data-layout="horizontal" data-layout-size="boxed" onkeydown="fnKey(event)";>
    <div id="divLoading" style="display: none">
        <p style="position: absolute; color: White; top: 30%; left: 38%;">
            Loading, please wait...
            <img src="<?php echo e(asset('public/backend/assets/images/loader.gif')); ?>">
        </p>
    </div>
    <div id="layout-wrapper">
        <?php echo $__env->make('layouts.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('layouts.modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH C:\inetpub\wwwroot\UserInfo2\resources\views/layouts/header.blade.php ENDPATH**/ ?>