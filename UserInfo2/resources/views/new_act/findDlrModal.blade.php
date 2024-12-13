<div id="findDlrModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="findDlrModalLabel" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header" style="padding: 8px 15px;">
                <h6 class="modal-title">Search Dealers</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col-12">
                    <form method="post" action="javascript:void(0)" class="form-inline" id="searchDealerDetails">
                        <div class="mb-2 row">
                            <label for="searchBy" class="col-2 col-form-label">
                                Search Dealer By:</label>
                            <div class="col-2">
                                <select name="searchBy" id="searchBy" class="form-control form-control-sm">
                                    <option value="dlrCode">DlrCode</option>
                                    <option value="DlrCompany">DlrCompany</option>
                                    <option value="DlrPerson">DlrPerson</option>
                                    <option value="DlrMobile">DlrMobile</option>
                                    <option value="DlrAddress">DlrAddress</option>
                                    <option value="DlrPhone">DlrPhone</option>
                                    <option value="DlrEmail">DlrEmail</option>
                                    <option value="DlrCity">DlrCity</option>
                                    <option value="DlrDistrict">DlrDistrict</option>
                                </select>
                            </div>
                            <div class="col-1 text-center">
                                <span style="vertical-align: sub; font-size:14px"> like </span>


                            </div>
                            <div class="col-5">
                                <input type="text" class="form-control form-control-sm" id="search_val"
                                    name="search_val" value="" size="40" maxlength="40" required
                                    placeholder="Enter DlrCode value..!">
                            </div>
                            <div class="col-1">

                                <button type="submit" class="btn btn-outline-primary btn-sm" title="Search">
                                    <span class="fa fa-search"> </span>
                                    <span class="fa fa-solid fa-spinner fa-spin d-none" style="font-size: 15px;">
                                    </span>
                                </button>


                            </div>
                        </div>
                    </form>
                </div>
                <hr>
                <div class="col-12 table-responsive mt-2" id="dlrData">
                </div>
            </div>
        </div>
    </div>
</div>
