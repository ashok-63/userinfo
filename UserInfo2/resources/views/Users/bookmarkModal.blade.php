<div id="ConvertLicModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="ConvertLicModal"
aria-hidden="true">
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header" style="padding: 8px 15px;">
            <h6 class="modal-title">Convert Lic From : E/X-To S-, A- To T- , S- To E-, T- To A-</h6>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div id="" class="p-3 col-12">
            <form action="javascript:void(0)" method="post" id="convertLicForm">
                @csrf
                <div class="row col-12 my-2">
                    <div class="col-4" style="text-align: center;">Enter LIC </div>
                    <div class="col-1"> : </div>
                    <div class="col-5">
                        <label for="">Enter each new key on new line...</label>
                        <textarea name="licNo" id="licNo" cols="4" rows="4" class="form-control form-control-sm"></textarea>
                        <strong style="font-weight: 600"> (Only E-,A-,S-,T-,X- keys are allowed)</strong>
                    </div>
                </div>
                <div class="row col-12 my-2">
                    <div class="col-4" style="text-align: center;">Corp Id </div>
                    <div class="col-1"> : </div>
                    <div class="col-4">
                        <input type="text" name="CorpId" id="CorpId"
                            class="form-control form-control-sm" placeholder="Corp Id">
                    </div>
                </div>
                <div class="row col-12 my-2">
                    <div class="col-4" style="text-align: center;">Reason </div>
                    <div class="col-1"> : </div>
                    <div class="col-4">
                        <textarea name="reason" id="reason" cols="5" rows="3" class="form-control form-control-sm"></textarea>
                    </div>
                </div>
                <div class="row col-12 my-2">
                    <div class="col-4" style="text-align: center;">Password </div>
                    <div class="col-1"> : </div>
                    <div class="col-4">
                        <input type="password" name="convertPass" id="convertPass"
                            class="form-control form-control-sm">
                    </div>
                </div>
                <div class="row col-12" style="flex-direction: row-reverse;">
                    <button type="reset" class=" btn btn-sm btn-warning col-1 mx-2 closeLicConvModal"
                        data-bs-dismiss="modal" aria-label="Close"> Close</button>
                    <button class="btn btn-sm btn-primary col-1" type="submit"> Convert</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
