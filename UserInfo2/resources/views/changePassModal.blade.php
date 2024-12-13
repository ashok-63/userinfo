<style>
    @media (min-width: 576px) {
        .col-sm-4 {
            width: 32.33333% !important;
        }
    }
</style>
<div id="ChangePassModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="ChangePassModal"
    aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header" style="padding: 8px 15px;">
                <h6 class="modal-title">Change Pass</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="javascript:void(0)" class="form-inline" id="ChangePassForm">
                <div class="modal-body">
                    <div class="mb-2 row">
                        <label for="txtLic" class="col-sm-4 col-form-label">Username</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm username" value="" readonly>

                            <input type="hidden" class="username" id="username" name="username" value="">
                            <input type="hidden" id="id" name="id" value="">

                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label for="txtLic" class="col-sm-4 col-form-label">Old Pass</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm" id="oldPass" name="oldPass"
                                value="">
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label for="txtLic" class="col-sm-4 col-form-label">New Pass</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm" id="newPass" name="newPass"
                                value="" autocomplete="false" >
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>

    </div>

</div>
