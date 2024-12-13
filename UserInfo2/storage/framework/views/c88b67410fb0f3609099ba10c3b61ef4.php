<!-- Modal -->
<div class="modal fade send-email-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 style="font-size: 18px;" class="modal-title" id="myLargeModalLabel">Send Email <label id="lblWeek">
                    </label></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="sendEmailForm" action="javascript:void(0)" method="POST" data-form-url="<?php echo e('sendEmail'); ?>">
                    <div class="form-group">
                        <label for="" class="col-form-label">Email:</label>
                        <input type="text" class="form-control" id="emailId" name="emailId">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Subject:</label>
                        <input type="text" class="form-control" id="ucSub" name="ucSub">
                    </div>
                    <div class="row col-md-12" style="margin-top: 6px;">
                        <div class="col-md-4">
                            <h6 class="viewTemplates" style="cursor: pointer;"> <i class="fa fa-file"><span
                                        class="padding">View Template</span></i> </h6>
                        </div>
                        <div class="col-md-4">
                            <h6 class="addTemplate" style="cursor: pointer;"> <i class="fa fa-file-upload"><span
                                        class="padding">Add Templates</span></i></h6>
                        </div>
                    </div>
                    <div class="form-group" style="margin-top: 6px;">
                        <textarea class="form-control" name="email_text" id="message-text" cols="60" rows="8"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Send</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!--Send SMS Modal Start-->
<div class="modal fade send-sms-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 500px !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 style="font-size: 18px;" class="modal-title" id="myLargeModalLabel">Send SMS <label id="lblWeek">
                    </label></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="sendSMSForm" action="javascript:void(0)" data-form-url="<?php echo e('sendSMS'); ?>" method="POST">
                    <div class="form-group">
                        <span>
                            <input name="rdoM" type="radio" value="user" checked="checked" />
                            <label for="" class="col-form-label">Mobile:</label>
                        </span>
                        <input type="text" class="form-control" id="custMobile" name="custMobile">
                    </div>
                    <div class="form-group">
                        <span> <input name="rdoM" type="radio" value="dlr" />
                            <label for="" class="col-form-label">Dlr Mobile:</label>
                        </span>
                        <input type="text" class="form-control" id="DlrMobile" name="DlrMobile">
                    </div>
                    
                    <div class="row col-md-12" style="margin-top: 6px;">
                        <div class="col-md-4">
                            <h6 class="viewTemplates" style="cursor: pointer">
                                <i class="fa fa-file"><span class="padding">View Template</span></i>
                            </h6>
                        </div>
                        <div class="col-md-4">
                            <h6 class="addTemplate" style="cursor: pointer">
                                <i class="fa fa-file-upload"><span class="padding">Add Templates</span></i>
                            </h6>
                        </div>
                    </div>
                    <div class="form-group" style="margin-top: 6px;">
                        <input type="hidden" name="templateid" id="templateid">
                        <textarea class="form-control" id="message_text_sms" name="message_text_sms" cols="60" rows="8"></textarea>
                        Text Counter : <span id="counter_sms"> </span>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Send</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!--Send SMS Modal END-->
<!--Send React Mail Modal Start-->
<div class="modal fade send-reactMail-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 500px !important;">
        <div class="modal-content">
            <div class="modal-header">
                <h4 style="font-size: 18px;" class="modal-title" id="myLargeModalLabel">Send Renewal WMS <label
                        id="lblWeek">
                    </label></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="">
                    <div class="form-group d-flex">
                        <span for="" class="col-form-label">Customer_No:</span>
                        <input type="text" class="border-0 form-control" id="custNo" name="custMobile"
                            readonly>
                    </div>
                    <div class="form-group d-flex">
                        <span for="" class="col-form-label">Name:</span>
                        <input type="text" class="border-0 form-control" id="custName" name="custName" readonly>
                    </div>
                    <div class="form-group d-flex">
                        <span for="" class="col-form-label">City:</span>
                        <input type="text" class="border-0 form-control" id="custCity" name="custCity" readonly>
                    </div>
                    <div class="form-group d-flex">
                        <span for="" class="col-form-label">LIC_Code:</span>
                        <input type="text" class="border-0 form-control" id="licCode" name="licCode" readonly>
                    </div>
                    <div class="form-group d-flex">
                        <span for="" class="col-form-label">Mobile:</span>
                        <input type="text" class="border-0 form-control" id="custMobile" name="custMobile"
                            readonly>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-form-label">Sender:</label>
                        <input type="text" class="form-control" id="sender" name="sender">
                    </div>
                    <div class="form-group" style="margin-top: 6px;">
                        <label for="" class="col-form-label">Comments</label>
                        <textarea class="form-control" id="comments" name="comments" cols="30" rows="4"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Send</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!--Send React Mail Modal END-->
<!-- tech support contact details modal content -->
<div id="TechSupportModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="TechSupportModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="padding: 10px 8px;">
                <h6 class="modal-title">Tech Support Number<i class="fa fa-phone"
                        style="font-size:20px; transform: rotate(180deg);margin-left: 10px;"></i></h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <span>020-67440800</span><br /><br />
                <span class="tech_title">Madhya Pradesh :</span> <span>7489504333</span><br />
                <span class="tech_title">Karnataka : </span><span>9379 592 666</span><br />
                <span class="tech_title">Andhra Pradesh : </span><span>9394180111</span><br />
                <span class="tech_title">Gujarat : </span><span>9978616728</span><br />
                <span class="tech_title">Uttar Pradesh :</span><span>9319556111</span><br /><br />
                <span class="tech_title">Maharashtra </span><br />
                <span>9271983681</span><br />
                <span>9373415157</span><br />
                <span>9823977433</span><br />
            </div><!-- /.modal-body -->
            <div class="modal-footer" style="padding: 3px 8px;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div id="reactRequestModal" class="modal fade" tabindex="-1" role="dialog"
    aria-labelledby="reactRequestModallLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="padding: 10px 8px;">
                <h6 class="modal-title">Reactivation Request</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="javascript:void(0)">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label" for="">Sender Name</label>
                        <input type="text" class="form-control" id="senderName" name="senderName">
                    </div>
                    <div class="form-group" style="margin-top: 6px;">
                        <label class="form-label" for="">Message</label>
                        <textarea class="form-control" id="message_text_sms" name="message_text_sms" cols="60" rows="8"></textarea>
                    </div>
                </div><!-- /.modal-body -->
                <div class="modal-footer" style="padding: 3px 8px;">
                    <button type="submit" class="btn btn-primary">Send</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<style>
    @media (min-width: 576px) {
        .col-sm-4 {
            width: 26.33333% !important;
        }
    }
</style>
<!-- Send WMS To Sales modal content -->
<div id="SendWMSToSalesModal" class="modal fade" tabindex="-1" role="dialog"
    aria-labelledby="SendWMSToSalesModalLabel" aria-hidden="true" data-bs-backdrop="static"
    data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="padding: 10px 8px;">
                <h6 class="modal-title">Send WMS To Sales Department</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="javascript:void(0)" class="form-inline" id="SendWMSToSales_form">
                <div class="modal-body">
                    <div class="mb-3 row">
                        <label for="lstUser" class="col-sm-6 col-form-label fix_div_width">User:</label>
                        <div class="col-sm-6 input_width">
                            <select class="form-control lstUser" name="lstUser" id="lstUser" required
                                style="width: 100%">
                                <option value="Dealer" selected="selected">Dealer</option>
                                <option value="Customer">Customer</option>
                            </select>
                        </div>
                    </div>
                    <div class="div_dealer">
                        <div class="mb-3 row">
                            <label for="lstDlrQueryType" class="col-sm-6 col-form-label fix_div_width">Query
                                Type:</label>
                            <div class="col-sm-6 input_width">
                                <select class="form-control lstDlrQueryType" name="lstDlrQueryType"
                                    id="lstDlrQueryType" required style="width: 100%">
                                    <option value="" selected="selected">Select Query Type</option>
                                    <option value="Dealer Code">Dealer Code</option>
                                    <option value="Dealer Certificate">Dealer Certificate</option>
                                    <option value="Dealer Score">Dealer Score</option>
                                    <option value="Dealer Scheme">Dealer Scheme</option>
                                    <option value="Purchase new packs">Purchase new packs</option>
                                    <option value="Renewal">Renewal</option>
                                    <option>Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="txtDlrName" class="col-sm-6 col-form-label fix_div_width">Dealer Name:</label>
                            <div class="col-sm-6 input_width">
                                <input type="text" class="form-control form-control-sm" id="txtDlrName"
                                    name="txtDlrName" value="" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="txtDlrMobile" class="col-sm-6 col-form-label fix_div_width">Dealer
                                Mobile:</label>
                            <div class="col-sm-6 input_width">
                                <input type="text" class="form-control form-control-sm" id="txtDlrMobile"
                                    name="txtDlrMobile" value="" required>
                            </div>
                        </div>
                    </div>
                    <div class="div_customer" style="display: none">
                        <div class="mb-3 row">
                            <label for="lstCustQueryType" class="col-sm-6 col-form-label fix_div_width">Query
                                Type:</label>
                            <div class="col-sm-6 input_width">
                                <select class="form-control lstCustQueryType" name="lstCustQueryType"
                                    id="lstCustQueryType" required style="width: 100%">
                                    <option value="" selected="selected">Select Query Type</option>
                                    <option value="Online Credit Card Purchase">Online Credit Card Purchase</option>
                                    <option value="Wants to Buy Pack">Wants to Buy Pack</option>
                                    <option value="Renewal">Renewal</option>
                                    <option>Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="txtCustName" class="col-sm-6 col-form-label fix_div_width">Customer
                                Name:</label>
                            <div class="col-sm-6 input_width">
                                <input type="text" class="form-control form-control-sm" id="txtCustName"
                                    name="txtCustName" value="" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="txtCustMobile" class="col-sm-6 col-form-label fix_div_width">Customer
                                Mobile:</label>
                            <div class="col-sm-6 input_width">
                                <input type="text" class="form-control form-control-sm" id="txtCustMobile"
                                    name="txtCustMobile" value="" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="lstRegion" class="col-sm-6 col-form-label fix_div_width">Region:</label>
                        <div class="col-sm-6 input_width">
                            <select class="form-control lstRegion" name="lstRegion" id="lstRegion" required
                                style="width: 100%">
                                <option value="" selected="selected">Select Region</option>
                                <option value="165">Ahmednagar Kolhapur Satara Sangli</option>
                                <option value="153">Andhra Pradesh Hyderabad</option>
                                <option value="113,225,225">Aurangabad Solapur Jalna Parabhani Latur Nanded Udgir
                                </option>
                                <option value="171,206">Bihar Nepal Jharkhand</option>
                                <option value="138,201,159">Delhi Punjab Haryna Uttarakhnd</option>
                                <option value="114,146,213">Gujarat, Ahmedabad, Baroda, Banaskantha,Palanpur, Rajkot,
                                    Junagadh</option>
                                <option value="42,198,230,241">Karnataka Belgum Bellary Bijapur Hubli</option>
                                <option value="227">Kerala</option>
                                <option value="140,203">Lucknow Kanpur UP</option>
                                <option value="164,233">MP Indore Bhopal Jabalpur Gwalior</option>
                                <option value="127,109,190,210,229">Mumbai</option>
                                <option value="104,221,200">Nagpur Vidarbha Raipur Chattisgadh Orissa</option>
                                <option value="178,212">Nashik Jalgaon Dhule Nandurbar</option>
                                <option value="97,144,149,158,231">Pune PCMC</option>
                                <option value="105,186">Rajasthan</option>
                                <option value="154,215,216">Tamilnadu</option>
                                <option value="126,197,202,234,235">WestBangal Assam</option>
                                <option value="122,162">Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="txtDesc" class="col-sm-6 col-form-label fix_div_width">Comments /
                            Details:</label>
                        <div class="col-sm-6 input_width">
                            <textarea name="txtDesc" cols="42" rows="4" id="txtDesc"></textarea>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="txtSender" class="col-sm-6 col-form-label fix_div_width">Sender:</label>
                        <div class="col-sm-6 input_width">
                            <input type="text" class="form-control form-control-sm" id="txtSender"
                                name="txtSender" value="" required>
                        </div>
                    </div>
                </div><!-- /.modal-body -->
                <div class="modal-footer" style="padding: 3px 8px;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<div id="DlrScoreModal" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" role="dialog" aria-labelledby="DlrScoreModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="padding: 10px 8px;">
                <h6 class="modal-title">Get Dealer Score</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="javascript:void(0)" class="form-inline" id="DlrScore_form">
                <div class="modal-body">
                    <div class="mb-3 row">
                        <label for="txtDlrCode" class="col-sm-6 col-form-label"
                            style="width: 22.33333% !important;">Dealer Code:</label>
                        <div class="col-sm-6 input_width">
                            <input type="text" class="form-control form-control-sm" id="txtDlrCode"
                                name="txtDlrCode" value="" required>
                        </div>
                    </div>
                </div><!-- /.modal-body -->
                <div class="modal-footer" style="padding: 3px 8px;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Get</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<div id="AddDaysModal" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" role="dialog" aria-labelledby="AddDaysModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="padding: 10px 8px;">
                <h6 class="modal-title">Add Days and Generate UnlockCode</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="javascript:void(0)" class="form-inline" id="AddDays_form"
                autocomplete="off">
                <div class="modal-body">
                    <div class="mb-3 row">
                        <label for="txtLic" class="col-sm-6 col-form-label add_days_cust">Lic No.:</label>
                        <div class="col-sm-6 input_width">
                            <input type="text" class="form-control form-control-sm" id="txtLic" name="txtLic"
                                value="" required>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <div class="col-sm-6 add_days_cust"></div>
                        <div class="col-sm-6">
                            <span><input type="checkbox" class="" id="chkCut" name="chkCut"
                                    value="True" readonly>
                                <label class="form-check-label" for="chkCut">Customer will activate
                                    online</label></span>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label for="txtComment" class="col-sm-6 col-form-label add_days_cust">Reason for
                            Reactivation:</label>
                        <div class="col-sm-6 input_width">
                            <textarea class="form-control" id="txtComment" name="txtComment" cols="30" rows="5"
                                onkeyup="fnTxtCounter();"></textarea>
                            <p><small>Character Limit:<span id="char_count" class="warning-msg"></span></small>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label for="txtAddDays" class="col-sm-6 col-form-label add_days_cust">Days Add:</label>
                        <div class="col-sm-6 input_width">
                            <input type="number" class="form-control form-control-sm" id="txtAddDays"
                                name="txtAddDays" value="" required>
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label for="txtPwd" class="col-sm-6 col-form-label add_days_cust">Admin Password:</label>
                        <div class="col-sm-6 input_width">
                            <input type="password" class="form-control form-control-sm" id="txtPwd"
                                name="txtPwd" value="" autocomplete="off" required>
                        </div>
                    </div>
                </div><!-- /.modal-body -->
                <div class="modal-footer" style="padding: 3px 8px;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade createNotesModal" id="createNotesModal" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 style="font-size: 18px;" class="modal-title" id="myLargeModalLabel">Create Note <label
                        id="lblWeek"> </label></h4>
                
            </div>
            <div class="modal-body">
                <form action="javascript:void(0)" method="post" id="createNoteForm"
                    data-form-url="<?php echo e('createNotes'); ?>">
                    <div class="form-group">
                        
                        <input type="hidden" class="form-control" id="custNo" name="custNo" value="">
                        <input type="hidden" class="form-control" id="fileURL" name="fileURL" value="">
                    </div>
                    <div class="form-group" style="margin-top: 6px;">
                        <label for="" class="col-form-label">Note</label>
                        <textarea class="form-control" id="notetext" name="notetext" cols="60" rows="8"
                            placeholder="Add Note Here..."></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save Notes</button>
                        <button type="button" class="btn btn-secondary notesModalClose">Close</button>
                        
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<div class="modal fade addRemarkModal" id="addRemarkModal" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 style="font-size: 18px;" class="modal-title" id="myLargeModalLabel">Add Remark <label
                        id="lblWeek"> </label></h4>
                
            </div>
            <div class="modal-body">
                <form action="javascript:void(0)" method="post" id="addRemarkForm"
                    data-form-url="<?php echo e('addRemark'); ?>">
                    <div class="form-group">
                        
                        <input type="hidden" class="form-control" id="custNo" name="custNo" value="">
                        <input type="hidden" class="form-control" id="fileURL" name="fileURL" value="">
                    </div>
                    <div class="form-group" style="margin-top: 6px;">
                        <label for="" class="col-form-label">Remark</label>
                        <textarea class="form-control" id="notetext" name="notetext" cols="60" rows="8"
                            placeholder="Add Note Here..."></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save Notes</button>
                        <button type="button" class="btn btn-secondary remarkModalClose">Close</button>
                        
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>








<div class="modal fade releaseKeyModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg releasekeyModal-dialog  modal-dialog-centered"
        style="max-width: 500px !important;">
        <div class="modal-content">
            <div class="modal-header releasekeyModal-header " style="cursor: all-scroll;">
                <h4 style="font-size: 18px;" class="modal-title" id="myLargeModalLabel">
                    Release Key <label id="lblWeek"> </label></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6>
                    Release and Activate License Number with pre-defined Inst Date.</h6>
                <form action="javascript:void(0)" method="post" id="releaseKeyForm"
                    data-form-url="<?php echo e('releaseKey'); ?>">
                    <div class="form-group">
                        <span class="text-danger">*</span>
                        <label for="" class="col-form-label">Lic No.</label>
                        <input type="text" class="form-control form-control-sm" id="licNo" name="licNo"
                            value="" maxlength="12" required>
                    </div>
                    <div class="form-group">
                        <span class="text-danger">*</span>
                        <label for="" class="col-form-label">Inst. Code</label>
                        <input type="text" class="form-control form-control-sm" id="instCode" name="instCode"
                            value="HR-" required size="30" maxlength="27">
                    </div>
                    <div class="form-group">
                        <span class="text-danger">*</span>
                        <label for="" class="col-form-label">Inst Date</label>
                        <input type="date" class="form-control form-control-sm instDate" id="instDate"
                            name="instDate" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-form-label">Customer Name</label>
                        <input type="text" class="form-control form-control-sm" id="custName" name="custName"
                            value="">
                    </div>
                    <div class="form-group">
                        <label for="" class="col-form-label">Cust Mobile</label>
                        <input type="text" class="form-control form-control-sm" id="custMobile" name="custMobile"
                            value="">
                    </div>

                    <div class="form-group">
                        <span class="text-danger">*</span>
                        <label for="" class="col-form-label">Reason</label>
                        <textarea name="relReason" id="relReason" cols="4" rows="4" class="form-control form-control-sm"></textarea>
                    </div>



                    <div class="form-group">
                        <span class="text-danger">*</span>
                        <label for="" class="col-form-label">Admin Password</label>
                        <input type="text" class="form-control form-control-sm" id="adminPassword"
                            name="adminPassword" value="" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<div class="modal fade dlrActCountModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 style="font-size: 18px;" class="modal-title" id="myLargeModalLabel">
                    Dealer Act Count <label id="lblWeek"> </label></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0)" method="get" id="dlrActCountForm"
                    data-form-url="<?php echo e('dlrActCount'); ?>">
                    <div class="form-group">
                        <label for="" class="col-form-label d-flex col-6">Dealer Code
                            <input type="text" class="form-control form-control-sm" id="dlrCode" name="dlrCode"
                                value="" maxlength="10" required>
                        </label>
                    </div>
                    <div class="form-group d-flex">
                        <div class="position-relative form-check m-2">
                            <label class="form-check-label">
                                <span class="p-1" style="font-size: 13px;"> 1 Year</span>
                                <input name="duration" type="radio" class="form-check-input"
                                    style="height: 17px; width: 17px;" value="1Yr" checked>
                            </label>
                        </div>
                        <div class="position-relative form-check m-2">
                            <label class="form-check-label">
                                <span class="p-1" style="font-size: 13px;"> 15 oct 2010 on words</span>
                                <input name="duration" type="radio" class="form-check-input"
                                    style="height: 17px; width: 17px;" value="15Oct">
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                        <button type="button" class="btn btn-secondary btn-sm"
                            data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
                <div id="dealerActCntResult"></div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<div class="modal fade templateModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true" style="left: 17%;">
    <div class="modal-dialog modal-lg templateModal-dialog modal-dialog-scrollable"
        style="max-width: 500px !important;">
        <div class="modal-content">
            <div class="modal-header templateModal-header " style="cursor: all-scroll;">
                <h4 style="font-size: 18px;" class="modal-title" id="myLargeModalLabel">
                    Template Messages </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="" id="templates_div">
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>



<div class="modal fade AddTemplateModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true" style="left: 17%;">
    <div class="modal-dialog modal-lg AddTemplateModal-dialog" style="max-width: 500px !important;">
        <div class="modal-content">
            <div class="modal-header AddTemplateModal-header " style="cursor: all-scroll;">
                <h4 style="font-size: 18px;" class="modal-title" id="myLargeModalLabel">
                    Add Template </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0)" method="post" id="addTemplateForm"
                    data-form-url="<?php echo e('addTemplate'); ?>">
                    <div class="form-group">
                        <label for="" class="col-form-label">Title </label>
                        <input type="text" class="form-control form-control-sm" id="title" name="title"
                            value="">
                    </div>
                    <div class="form-group">
                        <label for="" class="col-form-label">Template Id </label>
                        <input type="text" class="form-control form-control-sm" id="template_id"
                            name="template_id" value="">
                    </div>
                    <div class="form-group">
                        <label for="" class="col-form-label ">Text Message </label>
                        <textarea name="text_msg" class="form-control form-control-sm" id="text_msg" cols="5" rows="4"
                            required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                        <button type="button" class="btn btn-secondary btn-sm"
                            data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>



<div class="modal fade DistrictWiseCntModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg DistrictWiseCntModel-dialog">
        <div class="modal-content">
            <div class="modal-header DistrictWiseCntModel-header ">
                <h4 style="font-size: 18px;" class="modal-title" id="myLargeModalLabel">
                    District Wise Count </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="DistrictWiseCntData"></div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<!-- Add User modal -->
<div id="AddUserModal" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" role="dialog" aria-labelledby="AddUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="padding: 10px 8px;">
                <h6 class="modal-title">Add User </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="javascript:void(0)" class="form-inline" id="AddUsers_form"
                autocomplete="off">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="mb-3 row">
                        <label for="FullName" class="col-sm-6 col-form-label ">Full Name :</label>
                        <div class="col-sm-6 input_width">
                            <input type="text" class="form-control form-control-sm" id="FullName"
                                name="FullName" value="" required autocomplete="off">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="User_Name" class="col-sm-6 col-form-label ">Username :</label>
                        <div class="col-sm-6 input_width">
                            <input type="text" class="form-control form-control-sm" id="User_Name"
                                name="User_Name" value="" required autocomplete="off">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="Display_Name" class="col-sm-6 col-form-label ">Display_Name :</label>
                        <div class="col-sm-6 input_width">
                            <input type="text" class="form-control form-control-sm" id="Display_Name"
                                name="Display_Name" value="" required autocomplete="off">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="Password" class="col-sm-6 col-form-label ">Password :</label>
                        <div class="col-sm-6 input_width">
                            <input type="Password" class="form-control form-control-sm" id="Password"
                                name="Password" value="" required autocomplete="off">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="Mobile" class="col-sm-6 col-form-label ">Mobile :</label>
                        <div class="col-sm-6 input_width">
                            <input type="text" maxlength="10" class="form-control form-control-sm" id="Mobile"
                                name="Mobile" value="" autocomplete="off">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="Email" class="col-sm-6 col-form-label ">Email :</label>
                        <div class="col-sm-6 input_width">
                            <input type="text" class="form-control form-control-sm" id="Email" name="Email"
                                value="" autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="padding: 3px 8px;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.Add User Modal -->




<script>
    var max = 100;
    $('textarea#txtComment').keypress(function(e) {
        if (e.which < 0x20) {
            return; // Do nothing
        }
        if (this.value.length == max) {
            e.preventDefault();
        } else if (this.value.length > max) {
            // Maximum exceeded
            this.value = this.value.substring(0, max);
        }
    });

    function fnTxtCounter() {
        if ($('#txtComment').val() != "") {
            let charlength = $('#txtComment').val().length;
            $('#char_count').html(' ' + charlength + ' /100');
            if (charlength > 100) {
                alert("Character Limit Exceeded! Only 100 characters are allowed in comments.");
                return true;
            }
        } else {
            $('#char_count').html('0')
        }
    }
</script>
<?php /**PATH C:\inetpub\wwwroot\UserInfo2\resources\views/layouts/modal.blade.php ENDPATH**/ ?>