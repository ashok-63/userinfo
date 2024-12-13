<?php echo $__env->make('layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<div class="main-content">

    <div class="page-content">
        <?php echo $__env->yieldContent('content'); ?>
    </div>
    <!-- End Page-content -->
                
<?php echo $__env->make('layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\inetpub\wwwroot\UserInfo2\resources\views/master.blade.php ENDPATH**/ ?>