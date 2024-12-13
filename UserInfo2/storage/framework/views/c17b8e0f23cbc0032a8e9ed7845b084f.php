<style>
    @media (min-width: 576px) {
        .col-sm-4 {
            width: 32.33333% !important;
        }
    }
</style>
<div id="genReactivateModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="genReactivateModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="padding: 8px 15px;">
                <h6 class="modal-title">Reactivate</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="javascript:void(0)" class="form-inline" id="gen_reactivate_form">
                <div class="modal-body">
                    <div class="mb-2 row">
                        <label for="txtLic" class="col-sm-4 col-form-label">
                            New installation code:</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control form-control-sm" id="txtIC" name="txtIC"
                                onblur="GetLast4sOfHRInstCode();" onkeyup="GetLast4sOfHRInstCode();" value="HR-"
                                size="27" maxlength="27" required>
                        </div>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" id="txtIC1" name="txtIC1"
                                size="4" maxlength="4" value="" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-6">
                            <input type="text" class="form-control form-control-sm" id="txtICNN" name="txtICNN"
                                onblur="GetLast4sOfNNInstCode()" onkeyup="GetLast4sOfNNInstCode();" value="NN-"
                                required>
                        </div>
                        <div class="col-sm-2">
                            <input type="text" class="form-control form-control-sm" id="txtICNN1" name="txtICNN1"
                                value="" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-6" id="DivICCnt" style="color:#990000;font-weight:800;display:none">
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-6">
                            <input type="checkbox" class="form-check-input" id="chkCut" name="chkCut"
                                style="margin-top: 5px;">
                            <label class="form-check-label" for="chkCut" style="font-size: 11px;">Customer will
                                activate online <strong class="text-danger"
                                    title="After reactivation previous uc
                                    will be blocked immediately"
                                    style="font-weight: bold;">[Sure
                                    Block]</strong> </label>
                            
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label for="txtLic" class="col-sm-4 col-form-label">
                            Reason for Reactivation:</label>
                        <div class="col-sm-8">
                            <textarea name="txtComment" cols="30" rows="4" id="txtComment" onkeyup="fnTxtCounter();"
                                onkeyup="fnTxtCounter();" required></textarea>
                            <p><small>Character Limit:<span id="char_count" class="warning-msg"></span></small>
                            </p>
                        </div>
                    </div>
                    <input type="hidden" name="lic" id="lic" value="<?php echo e($SerialNo); ?>">
                    <input type="hidden" name="user" id="user" value="<?php echo e($UserName); ?>">
                    <input type="hidden" name="CustomerNo" id="CustomerNo" value="<?php echo e($CustomerNo); ?>">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary waves-effect"
                        data-bs-dismiss="modal">Close</button>

                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<?php /**PATH C:\inetpub\wwwroot\UserInfo2\resources\views/gen_reactive_model.blade.php ENDPATH**/ ?>