@php
$status1 = false;
$Blkd_Dt = '';
$Upd_Dt = '';
$isRenewal = false;
$Cmnt = '';
if (!empty($UnlockCodeDetails)) {
    $Cmnt = $UnlockCodeDetails->reason;
    $Blkd_Dt = $UnlockCodeDetails->bDate;
    $Upd_Dt = $UnlockCodeDetails->uDate;
    $status1 = $UnlockCodeDetails->isDelete == true ? true : false;
}

if (!empty($rsTopup)) {
    $isRenewal = $rsTopup->RenewalDone == true ? true : false;
}

@endphp
<div id="BlockUnlockCodeModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="BlockUnlockCodeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="padding: 8px 15px;">
                <h6 class="modal-title">Block UnlockCode</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="javascript:void(0)" class="form-inline" id="unlockcode_form">
                <input type="hidden" name="customer_no" value="{{ $CustNo }}">

                <div class="modal-body">
                    <div class="mb-2 row">
                        <label for="txtUc" class="col-sm-3 col-form-label">Unlock Code:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm" id="txtUc" name="txtUc"
                                value="{{ $UnlockCode }}" {{ !empty($UnlockCode) ? 'readonly' : '' }} required>

                            <span class="style2">
                                @if (!empty($Blkd_Dt))
                                    Blocked on{{ $Blkd_Dt }}, Last Update :{{ $Upd_Dt }}
                                @else
                                    Not Blocked
                                @endif
                            </span>

                        </div>
                    </div>

                    <div class="mb-2 row">
                        <label for="txtLic" class="col-sm-3 col-form-label">Key:</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control form-control-sm" id="txtLic" name="txtLic"
                                value="{{ $SerialNo }}" {{ !empty($SerialNo) ? 'readonly' : '' }} required>
                        </div>

                        <div class="form-check col-sm-5">
                            <input type="checkbox" class="form-check-input" id="chkTopup" value="Yes"
                                {{ $isRenewal == true ? 'checked' : '' }} style="margin-top: 5px;" name="chkTopup">
                            <label class="form-check-label" for="chkTopup" style="font-size: 11px;">Topup/ Renewal
                                Done</label>
                        </div>
                    </div>

                    <div class="mb-2 row">
                        <label for="txtComment" class="col-sm-3 col-form-label">Comment:</label>
                        <div class="col-sm-8">
                            <textarea name="txtComment" cols="40" rows="4" id="txtComment" onkeyup="CharCounter();" required>{{ $Cmnt }}</textarea>
                            <p><small>Comment Character Limit:<span id="char_count" class="warning-msg"></span></small>
                            </p>
                        </div>
                    </div>

                    <div class="mb-2 row">
                        <label for="txtAdd" class="col-sm-3 col-form-label">Status:</label>
                        <div class="col-sm-8">
                            <label class="form-check-label">
                                <input class="form-check-input radio-inline" type="radio" name="rdoSt"
                                    id="rdoSt1" value="true" {{ $status1 == false ? 'checked' : '' }}>
                                Block </label>
                            <label class="form-check-label">
                                <input class="form-check-input radio-inline" type="radio" name="rdoSt"
                                    id="rdoSt2" value="false" {{ $status1 == true ? 'checked' : '' }}>
                                Unblock </label>
                        </div>

                    </div>

                    <div class="mb-2 row">
                        <label for="txtPwd" class="col-sm-3 col-form-label">Admin Password:</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control form-control-sm" id="txtPwd" name="txtPwd"
                                value="" required>
                        </div>
                    </div>

                </div><!-- /.modal-body -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<script>
    CharCounter();

    function CharCounter() {
        if ($('#txtComment').val() != "") {
            let charlength = $('#txtComment').val().length;
            $('#char_count').html(' ' + charlength + ' /255');
            if (charlength > 255) {
                alert("Comment Character Limit Exceeded! Only 255 characters are allowed in one sms.");
                return true;
            }
        } else {
            $('#char_count').html('0')
        }

    }
</script>
