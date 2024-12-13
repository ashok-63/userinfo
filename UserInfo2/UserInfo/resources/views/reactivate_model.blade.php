<style>
    @media (min-width: 576px) {
        .col-sm-3 {
            width: 22.33333% !important;
        }
    }
</style>
<div id="ReactivateModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="ReactivateModalLabel"
    aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="padding: 8px 15px;">
                <h6 class="modal-title">Before Reactivate, Confirm Customer Details ...</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="javascript:void(0)" class="form-inline" id="update_reactivate_form">
                <input type="hidden" name="customer_no" value="{{ $CustNo }}">
                <input type="hidden" name="user_name" value="{{ $UserName }}">

                <div class="modal-body">
                    <div class="mb-2 row">
                        <label for="txtLic" class="col-sm-3 col-form-label">Key Number:</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control form-control-sm" id="txtLic" name="txtLic"
                                value="{{ $ReactivateDetails->SerialNo }}" required readonly>
                        </div>
                    </div>

                    <div class="mb-2 row">
                        <label for="txtMob1" class="col-sm-3 col-form-label">Mobile1:</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control form-control-sm" id="txtMob1" name="txtMob1"
                                value="{{ $ReactivateDetails->CustMobile }}" required>
                        </div>
                    </div>

                    <div class="mb-2 row">
                        <label for="txtMob2" class="col-sm-3 col-form-label">Mobile2:</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control form-control-sm" id="txtMob2" name="txtMob2"
                                value="">
                        </div>
                    </div>

                    <div class="mb-2 row">
                        <label for="txtEmail" class="col-sm-3 col-form-label">Email Id:</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control form-control-sm" id="txtEmail" name="txtEmail"
                                value="{{ $ReactivateDetails->emailID }}">
                        </div>
                    </div>

                    <div class="mb-2 row">
                        <label for="txtCountry" class="col-sm-3 col-form-label">Country:</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control form-control-sm" id="txtCountry" name="txtCountry"
                                value="{{ $ReactivateDetails->CustCountry }}" required>
                        </div>
                        <div class="col-sm-4">
                            <select class="form-control country select2_modal" name="lstCountry" id="lstCountry" required
                                style="width: 100%">
                                <option value="">Select Country</option>
                                @foreach ($CountryData as $country)
                                    @php
                                        if (strtoupper($country->Country) == strtoupper($ReactivateDetails->CustCountry)) {
                                            $selected = 'selected';
                                        } else {
                                            $selected = '';
                                        }
                                    @endphp
                                    <option value="{{ $country->CountryId . '$' . $country->Country }}"
                                        {{ $selected }}>
                                        {{ $country->Country }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-2 row">
                        <label for="txtState" class="col-sm-3 col-form-label">State:</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control form-control-sm" id="txtState" name="txtState"
                                value="{{ $ReactivateDetails->CustState }}" required>
                        </div>
                        <div class="col-sm-4">
                            <select class="form-control state select2_modal" name="lstState" id="lstState" required
                                style="width: 100%">

                                <option value="">Select State</option>
                                @foreach ($StateData as $state)
                                    @php
                                        if (strtoupper($state->STATENAME) == strtoupper($ReactivateDetails->CustState)) {
                                            $selected = 'selected';
                                        } else {
                                            $selected = '';
                                        }
                                    @endphp
                                    <option value="{{ $state->stID . '$' . $state->STATENAME }}" {{ $selected }}>
                                        {{ $state->STATENAME }}</option>
                                @endforeach
                            </select>

                            </select>
                        </div>
                    </div>

                    <div class="mb-2 row">
                        <label for="txtDist" class="col-sm-3 col-form-label">District:</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control form-control-sm" id="txtDist" name="txtDist"
                                value="{{ $ReactivateDetails->CustDistrict }}" required>
                        </div>
                        <div class="col-sm-4">
                            <select class="form-control district select2_modal" name="lstDistrict" id="lstDistrict" required
                                style="width: 100%">
                                <option value="">Select District</option>
                                @foreach ($DistrictData as $Dist)
                                    @php
                                        if (strtoupper($Dist->DISTRICT) == strtoupper($ReactivateDetails->CustDistrict)) {
                                            $selected = 'selected';
                                        } else {
                                            $selected = '';
                                        }
                                    @endphp
                                    <option value="{{ $Dist->DISTRICT }}" {{ $selected }}>
                                        {{ $Dist->DISTRICT }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label for="txtCity" class="col-sm-3 col-form-label">City:</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control form-control-sm" id="txtCity" name="txtCity"
                                value="{{ $ReactivateDetails->CustCity }}" required>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label for="txtCorpId" class="col-sm-3 col-form-label">CorpId:</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control form-control-sm" id="txtCorpId"
                                name="txtCorpId" value="{{ $ReactivateDetails->CorpId }}">
                        </div>
                    </div>
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
