                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                © <?php
                                    echo date('Y');
                                ?>
                                NPAV
                            </div>
                        </div>
                    </div>
                </footer>

                </div>
                </div>
                <div class="rightbar-overlay"></div>
                <!-- JAVASCRIPT -->
                

                <script src="<?php echo e(url('/')); ?>/public/backend/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
                <!-- Datatble Jquery-->
                

                <script src="<?php echo e(url('public/backend/assets/js/dataTables.js')); ?>"></script>
                <script src="<?php echo e(url('public/backend/assets/js/dataTables.buttons.js')); ?>"></script>
                <script src="<?php echo e(url('public/backend/assets/js/buttons.dataTables.js')); ?>"></script>
                <script src="<?php echo e(url('public/backend/assets/js/jszip.min.js')); ?>"></script>
                <script src="<?php echo e(url('public/backend/assets/js/pdfmake.min.js')); ?>"></script>
                <script src="<?php echo e(url('public/backend/assets/js/vfs_fonts.js')); ?>"></script>
                <script src="<?php echo e(url('public/backend/assets/js/buttons.html5.min.js')); ?>"></script>
                <script src="<?php echo e(url('public/backend/assets/js/buttons.print.min.js')); ?>"></script>


                <script src="<?php echo e(url('/')); ?>/public/backend/assets/libs/metismenu/metisMenu.min.js"></script>
                <script src="<?php echo e(url('public/backend/assets/libs/select2/js/select2.min.js')); ?>"></script>


                <script src="<?php echo e(url('public/backend/assets/js/jquery-ui.min.js')); ?>"></script>
                <script src="<?php echo e(url('public/backend/assets/js/jquery.toast.js')); ?>"></script>
                <script src="<?php echo e(url('public/backend/assets/js/flatpickr.js')); ?>"></script>

                <script src="<?php echo e(url('/')); ?>/public/backend/assets/js/custom.js"></script>
                <script>
                    var url = "<?php echo e(url('/')); ?>";
                    var current_user = "<?php echo e(auth()->user() ? auth()->user()->User_Name : ''); ?>";
                </script>


                </body>

                </html>
<?php /**PATH C:\inetpub\wwwroot\UserInfo2\resources\views/layouts/footer.blade.php ENDPATH**/ ?>