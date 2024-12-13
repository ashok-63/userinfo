try {
    $(".select2").select2();
} catch (err) {
    console.log("s2 err");
}

$(".open_sendemail_modal").on("click", function () {
    $(".send-email-modal").modal("show");
});
/***Send Email Functionality start */
function fnSendEmail(SerialNo, unlockCode, emailID) {
    if (SerialNo != "") {
        lic = SerialNo;
    } else {
        lic = "X-XXXXXXXXXX";
    }
    if (unlockCode != "") {
        uc = unlockCode;
        ucSub = "Net Protector Unlock-Code";
    } else {
        uc = "XXXX-XXXX-XXXX-XXXX-XXXX-XXXX";
        ucSub = "Net Protector Reactivation Request";
    }
    if (emailID != "") {
        email = emailID;
    } else {
        email = "";
    }
    var msg =
        "Dear sir,\r\n\r\n" +
        "Your NPAV UNLOCK CODE is :" +
        uc +
        "\r\n" +
        "for NPAV Key No.: " +
        lic +
        "\r\n\r\n" +
        "Thanks and Regards,\r\nNPAV Reactivation Department\r\n020-67440810";
    $(".send-email-modal").modal("show");
    $(".send-email-modal #emailId").val(emailID);
    $(".send-email-modal #ucSub").val(ucSub);
    $(".send-email-modal #message-text").empty().text(msg);
}
$(document).on("submit", "#sendEmailForm", function (e) {
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    if (typeof page == "undefined") var page = 1;
    $.ajax({
        url: url + "/sendEmail",
        method: "POST",
        data: $("#sendEmailForm").serialize() + "&page=" + page,
        beforeSend: function () {
            $("#divLoading").show(); //show loader
        },
        success: function (data) {
            // console.log(data);
            if (data.Status == "success") {
                Swal.fire("Success..!!!", data.Message, "success");
            } else {
                Swal.fire("Error..!!!", data.Message, "error");
            }
            $("#sendEmailForm")[0].reset();
            $(".send-email-modal").modal("hide");
            $("#divLoading").hide(); //hide loader
        },
        error: function (err) {
            // if error occured
            //     sweetAlert("Oops...", 'Something is Wrong. Please Try Again', "error");
            $("#divLoading").hide(); //hide loader
        },
    });
});
/***Send Email Functionality end */
/***Send REact Email Functionality start*/
function fnSendReactEmail(SerialNo, custNo, clCity, CustMobile, custName) {
    // console.log({ SerialNo, custNo, clCity, CustMobile, custName });
    $(".send-reactMail-modal").modal("show");
    $(".send-reactMail-modal #custNo").val(custNo);
    $(".send-reactMail-modal #custName").val(custName);
    $(".send-reactMail-modal #custCity").val(clCity);
    $(".send-reactMail-modal #licCode").val(SerialNo);
    $(".send-reactMail-modal #custMobile").val(CustMobile);
}
/***Send REact Email Functionality end*/
/**Send SMS Functionality Start */
function fnSendSMS(
    CustMobile,
    clCustMob2,
    unlockCode,
    SerialNo,
    HelpDeskNo,
    DealerMobile,
    LoggedUser
) {
    // console.log(clCustMob2.length);
    if (clCustMob2.length != 0 && clCustMob2 != "N/A") {
        c2 = clCustMob2;
        $(".send-sms-modal #custMobile").val(CustMobile + "," + c2);
    } else {
        $(".send-sms-modal #custMobile").val(CustMobile);
    }
    var message_text_sms =
        "NPAV UNLOCK CODE:" +
        unlockCode +
        "," +
        "\r\n" +
        "Key No.:" +
        SerialNo +
        ", " +
        "\r\n" +
        HelpDeskNo +
        "";
    var templateid = "1207163309495356426";
    $(".send-sms-modal").modal("show");
    $(".send-sms-modal").modal({
        // backdrop: false,
        show: true,
    });
    $(".modal-dialog").draggable({
        handle: ".modal-header",
    });
    $(".modal-header").css("cursor", "all-scroll");
    $(".send-sms-modal #DlrMobile").val(DealerMobile);
    $(".send-sms-modal #templateid").empty().val(templateid);
    $(".send-sms-modal #message_text_sms").empty().text(message_text_sms);
    fnTextCounter();
}
$(document).on("change", "#sms_template", function (e) {
    e.preventDefault();
    var id = $("#sms_template").val();
    console.log({ id });
    if (id == "1") {
        message_text_sms =
            "NPAV: NetProtector Technical Service Center Nos: 020-67440800,9325102020, 9271983681 / 82 / 83 / 84, 9373415157, 9823977433";
    }
    if (id == "2") {
        message_text_sms =
            "NPAV: NetProtector Activation Dept No: 020-67440810 9225521515 9623935770. React: 020-67440810,8055776321";
    }
    if (id == "3") {
        message_text_sms =
            "Dear NPAV Dealer, To login any critical customer support call, Plz send SMS to 8055776318 with Cust Name, Mob No. and problem. Our Engineers will call them.";
    }
    if (id == "7") {
        message_text_sms =
            "9272707050: NetProtector HDFC Bank IFSC Code : HDFC0000427 A/C No.: 04272320002240 A/C Name: Biz Secure Labs Pvt Ltd. Branch: Laxmi road, Pune-30";
    }
    if (id == "8") {
        message_text_sms =
            "Now get Unlock Code on SMS. 24 Hr Service. Send License No.Installation Code to 9657009570 or 9890501163 to receive Unlock Code in return.- NPAV.";
    }
    if (id == "9") {
        message_text_sms =
            "Download and Run- www.computerdelhi.com/react.exe Submit Info,and Call 020-67440810, 8055776321 OR Send Lic No. SMS to 8055776321.Only 9.30Am to 9.00Pm";
    }
    if (id == "10") {
        message_text_sms =
            "NPAV: NetProtector Sales Dept No: 09272707050,09822882566 Sales Email : sales@indiaantivirus.com";
    }
    if (id == "12") {
        message_text_sms =
            "NPAV UPDATE SOLUTION : Download http://bizsl.bc.cdn.bitgravity.com/upgradeall.exe. Save in Pen drive. Run it on your own PC";
    }
    if (id == "13") {
        message_text_sms =
            "NPAV FAST UPDATE SOLUTION : Download and Run : www.computerdelhi.com/updfix.exe (type in Internet Address Bar) (Net Protector AntiVirus)";
    }
    if (id == "15") {
        message_text_sms =
            "Net Protector AntiVirus Lic No : X-XXXXXXXXXX For any technical help please call on 9271983681/82/83";
    }
    if (id == "16" || id == "101") {
        message_text_sms =
            "NPAV UNLOCK CODE : XXXX-XXXX-XXXX-XXXX-XXXX-XXXX, Key No.: X-XXXXXXXXXX HelpDesk No.: 02067440810 & 8055776321";
    }
    if (id == "17") {
        message_text_sms =
            "NPAV UNLOCK CODE : XXXX-XXXX-XXXX-XXXX-XXXX-XXXX, Key No.: X-XXXXXXXXXX, APK for Dealers: https://goo.gl/Ftc91Z";
    }
    if (id == "18" || id == "103") {
        message_text_sms =
            "Net Protector Mobile Security for Android : http://srv9.computerkolkata.com/np/android/npmobilesec.apk";
    }
    if (id == "19") {
        message_text_sms =
            "NPAV Setup Download : http://www.corpwebcontrol.com/np/installnp2019.exe";
    }
    if (id == "102") {
        message_text_sms =
            "Dear NPAV User,Your Net Protector Antivirus is going to expire in 7 days. Contact your Dealer on: XXXXXXXXXX / 9881344490 / 9326920222";
    }
    if (id == "0") {
        message_text_sms = "";
    }
    $(".send-sms-modal #message_text_sms").text(message_text_sms);
});
$(document).on("keyup", "#message_text_sms", function () {
    fnTextCounter();
});
function fnTextCounter() {
    if ($(".send-sms-modal #message_text_sms").val() != "") {
        let charlength = $(".send-sms-modal #message_text_sms").val().length;
        $(".send-sms-modal #counter_sms").html(" " + charlength + " /160");
        if (charlength > 160) {
            alert(
                "Character Limit Exceeded! Only 160 characters are allowed in one sms."
            );
            return true;
        }
    } else {
        $(".send-sms-modal #counter_sms").html("0");
    }
}
$(document).on("submit", "#sendSMSForm", function (e) {
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    if (typeof page == "undefined") var page = 1;
    $.ajax({
        url: url + "/sendSMS",
        method: "POST",
        data: $("#sendSMSForm").serialize(),
        beforeSend: function () {
            $("#divLoading").show(); //show loader
        },
        success: function (data) {
            // console.log(data);
            if (data.Status == "success") {
                Swal.fire("Success..!!!", data.Message, "success");
            } else {
                Swal.fire("Error..!!!", data.Message, "error");
            }
            $("#sendSMSForm")[0].reset();
            $(".send-sms-modal").modal("hide");
            $("#divLoading").hide(); //hide loader
        },
        error: function (err) {
            console.log(err);
            $("#divLoading").hide(); //hide loader
        },
    });
});
/**Send SMS Functionality END */
/**Create Note Functionality Start */

$(document).on("click", ".createNotes", function (e) {
    e.preventDefault();
    var custNo = $(this).data("custno");
    var notesfolder = $(this).data("notesfolder");
    var fileUrl = "E:\\ACTIVATIONDATA\\" + notesfolder + "\\" + custNo + ".log";

    var d = new Date();
    var n =
        "Date : " +
        d.toLocaleString("en-IN", { hour12: true }) +
        " | Added By :" +
        current_user;

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $.ajax({
        url: url + "/getFileContents",
        method: "get",
        data: {
            custNo: custNo,
            notesfolder: notesfolder,
        },
        beforeSend: function () {
            $("#divLoading").show(); //show loader
        },
        success: function (data) {
            $(".createNotesModal").modal("show");
            $(".createNotesModal #custNo").val(custNo);
            $(".createNotesModal #fileURL").val(fileUrl);

            if (data.hasOwnProperty("error") || data == "") {
                $(".createNotesModal #notetext").append(n.trim());
            } else {
                $(".createNotesModal #notetext").append(
                    $.trim(data) + "\r\n\r\n" + n.trim()
                );
            }

            $("#divLoading").hide(); //hide loader
        },
        error: function (err) {
            // if error occured
            $("#divLoading").hide(); //hide loader
        },
    });
});

$(document).on("click", ".notesModalClose", function (e) {
    e.preventDefault();

    $(".createNotesModal #notetext").text("");
    $(".createNotesModal").modal("hide");
});

//create note form submission
$(document).on("submit", "#createNoteForm", function (e) {
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    if (typeof page == "undefined") var page = 1;
    $.ajax({
        url: url + "/createNotes",
        method: "POST",
        data: $("#createNoteForm").serialize() + "&page=" + page,
        beforeSend: function () {
            $("#divLoading").show(); //show loader
        },
        success: function (data) {
            // console.log(data);
            if (data.hasOwnProperty("success")) {
                // alert(data.success);

                $.toast({
                    heading: data.success,
                    icon: "success",
                    showHideTransition: "slideUp",
                    allowToastClose: true,
                    hideAfter: 2000,
                    stack: false,
                    position: {
                        right: 5,
                        top: 10,
                    },
                    textAlign: "center",
                    loader: true,
                    loaderBg: "#9EC600",
                });

                $("#createNoteForm")[0].reset();
            }
            $(".notesModalClose").trigger("click");
            $("#divLoading").hide(); //hide loader
        },
        error: function (err) {
            // if error occured
            //     sweetAlert("Oops...", 'Something is Wrong. Please Try Again', "error");
            $("#divLoading").hide(); //hide loader
        },
    });
});
/**Create Note Functionality End */
$(".OpenSendWMSToSalesModal").on("click", function () {
    $(".lstUser").each(function () {
        try {
            $(this).select2({
                dropdownParent: $(this).parent(),
            });
        } catch (err) {
            console.log("s2err");
        }
    });

    $(document).on("select2:close", ".lstUser", function (e) {
        var evt = "scroll.select2";
        $(e.target).parents().off(evt);
        $(window).off(evt);
    });

    $(".lstDlrQueryType").each(function () {
        try {
            $(this).select2({
                dropdownParent: $(this).parent(),
            });
        } catch (err) {
            console.log("s2err");
        }
    });
    $(document).on("select2:close", ".lstDlrQueryType", function (e) {
        var evt = "scroll.select2";
        $(e.target).parents().off(evt);
        $(window).off(evt);
    });
    $(".lstRegion").each(function () {
        try {
            $(this).select2({
                dropdownParent: $(this).parent(),
            });
        } catch (err) {
            console.log("s2err");
        }
    });
    $(document).on("select2:close", ".lstRegion", function (e) {
        var evt = "scroll.select2";
        $(e.target).parents().off(evt);
        $(window).off(evt);
    });
    $(".lstCustQueryType").each(function () {
        try {
            $(this).select2({
                dropdownParent: $(this).parent(),
            });
        } catch (err) {
            console.log("s2err");
        }
    });
    $(document).on("select2:close", ".lstCustQueryType", function (e) {
        var evt = "scroll.select2";
        $(e.target).parents().off(evt);
        $(window).off(evt);
    });
    $("#SendWMSToSalesModal").modal("show");
});
$("#custom_datatable").DataTable({
    responsive: true,
    scrollCollapse: true,
    paging: false,
    searching: false,
    pageLength: 50,
    info: false,
});
$("li:not(.policyTabLi)")
    .not(".not_click")
    .on("click", function () {
        // remove classes from all
        $("li").children().removeClass("active_menu");
        // $('.navbar-nav li a').not('.dropdown-item').not('.arrow-none').addClass('nav-link')
        $(".navbar-nav li a").not(".dropdown-item").addClass("nav-link");
        // add class to the one we clicked
        $(this).children().not(".dropdown-menu").addClass("active_menu");
        $(this).children().removeClass("nav-link");
    });

try {
    $(".select2_search_by").select2({
        templateResult: function (option, container) {
            if ($(option.element).attr("data-select2-id") == "not apply") {
                $(container).css("display", "none");
            }
            return option.text;
        },
    });
} catch (err) {
    console.log("s2err");
}

$(document).on("change", "#lstUser", function (e) {
    let user_choice = $(this).val();
    if (user_choice == "Customer") {
        $(".div_customer").show();
        $(".div_dealer").hide();
    } else {
        $(".div_customer").hide();
        $(".div_dealer").show();
    }
});
$(".OpenDlrScoreModal").on("click", function () {
    $("#DlrScoreModal").modal("show");
});
$(".open_add_days").on("click", function () {
    $("#AddDaysModal").modal("show");
});
$(document).on("click", ".my_acts_menu", function () {
    // if (window.location.href.search("new_act") > 0) {
    //     window.location.href = $(".my_acts_menu").data("link");
    // }
    $("#search_by").val("myAct");
    $("#search_txt").val("View My Last 25 Activations");
    $("#btn-search").trigger("click");
});
$(document).on("click", ".apksms", function () {
    $("#search_by").val("apksms");
    $("#search_txt").val("View Last 25 APK SMS Activations");
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    if (typeof page == "undefined") var page = 1;
    $.ajax({
        url: url + "/SearchByKey",
        method: "GET",
        data: {
            search_by: "apksms",
            page: page,
        },
        beforeSend: function () {
            $("#divLoading").show(); //show loader
        },
        success: function (data) {
            if ($(".new_activation_div").length >= 1)
                $(".new_activation_div").remove();
            if ($(".hardware_details2").length >= 1)
                $(".hardware_details2").remove();
            $(".main_container").show();
            $("#table_data").empty().html(data);
            setTimeout(() => {
                $(".total_record_count").show();
                $("#DBcount").html($("#total_records").html());
                $("#total_records").hide();
            }, 1000);
            $("#custom_datatable").DataTable({
                info: false,
                paging: false,
                searching: false,
                pageLength: 50,
                order: [
                    [0, "desc"],
                    [1, "desc"],
                    [2, "desc"],
                ],
                // ordering:false
            });
            //    location.hash = page;
            $("#divLoading").hide(); //hide loader
        },
        error: function (err) {
            // if error occured
            //     sweetAlert("Oops...", 'Something is Wrong. Please Try Again', "error");
            $("#divLoading").hide(); //hide loader
        },
    });
});
$(document).on("click", ".last_acts_menu", function () {
    // window.location.href = url + "/dashboard";
    $("#search_by").val("lastAct");
    $("#search_txt").val("View My Last 25 Activations");
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    if (typeof page == "undefined") var page = 1;
    $.ajax({
        url: url + "/SearchByKey",
        method: "get",
        data: {
            search_by: "lastAct",
            page: page,
        },
        beforeSend: function () {
            $("#divLoading").show(); //show loader
        },
        success: function (data) {
            if ($(".new_activation_div").length >= 1)
                $(".new_activation_div").remove();
            if ($(".hardware_details2").length >= 1)
                $(".hardware_details2").remove();
            $(".main_container").show();
            $("#table_data").empty().html(data);
            setTimeout(() => {
                $(".total_record_count").show();
                $("#DBcount").html($("#total_records").html());
                $("#total_records").hide();
            }, 1000);
            $("#custom_datatable").DataTable({
                info: false,
                paging: false,
                searching: false,
                pageLength: 50,
                order: [
                    [0, "desc"],
                    [1, "desc"],
                    [2, "desc"],
                ],
                // ordering:false
            });
            //    location.hash = page;
            $("#divLoading").hide(); //hide loader
        },
        error: function (err) {
            // if error occured
            //     sweetAlert("Oops...", 'Something is Wrong. Please Try Again', "error");
            $("#divLoading").hide(); //hide loader
        },
    });
});
/**Release Key Functionality Start */
// $(document).find(".instDate").datepicker({ format: "dd-mm-yyyy" });
$(document).on("click", ".releaseKey", function (e) {
    e.preventDefault();
    $(".releaseKeyModel").modal("show");
    $(".releaseKeyModel").modal({
        // backdrop: false,
        show: true,
    });
    $(".releasekeyModal-dialog").draggable({
        handle: ".releasekeyModal-header",
    });
});
$(document).on("submit", "#releaseKeyForm", function (e) {
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    if (typeof page == "undefined") var page = 1;
    $.ajax({
        url: url + "/releaseKey",
        method: "POST",
        data: $("#releaseKeyForm").serialize() + "&page=" + page,
        beforeSend: function () {
            $("#divLoading").show(); //show loader
        },
        success: function (data) {
            // console.log(data);
            if (data.Status == "success") {
                Swal.fire("Success..!!!", data.msg, "success");
                $("#releaseKeyForm")[0].reset();
                $(".releaseKeyModel").modal("hide");
            } else if (data.Status == "error") {
                Swal.fire("Error..!!!", data.msg, "error");
            } else {
                $("#response_div").empty().html(data);
                $("#unlockCodeModal").modal("show");

                $("#response_div table").css("margin-left", "98px");
                $("#releaseKeyForm")[0].reset();
                $(".releaseKeyModel").modal("hide");
            }
            // $("#releaseKeyForm")[0].reset();
            // $(".releaseKeyModel").modal("hide");

            $("#divLoading").hide(); //hide loader
        },
        error: function (err) {
            // if error occured
            //     sweetAlert("Oops...", 'Something is Wrong. Please Try Again', "error");
            $("#divLoading").hide(); //hide loader
        },
    });
});
/**Release Key Functionality end */
//***Dealer Act Count function Start */
$(document).on("click", ".dlrActCount", function (e) {
    e.preventDefault();
    $(".dlrActCountModel").modal("show");
});
$(document).on("submit", "#dlrActCountForm", function (e) {
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    if (typeof page == "undefined") var page = 1;
    $.ajax({
        url: url + "/dlrActCount",
        method: "get",
        data: $("#dlrActCountForm").serialize() + "&page=" + page,
        beforeSend: function () {
            $("#divLoading").show(); //show loader
        },
        success: function (data) {
            // console.log(data);
            $("#dealerActCntResult").empty().html(data);
            $("#divLoading").hide(); //hide loader
        },
        error: function (err) {
            // if error occured
            //     sweetAlert("Oops...", 'Something is Wrong. Please Try Again', "error");
            $("#divLoading").hide(); //hide loader
        },
    });
});
//***Dealer Act Count function end */
/***Toggle Article Dropdown */
$(document).on("click", ".btnActicleToggle", function (e) {
    e.preventDefault();
    $(this)
        .siblings(".arcticleDropdown")
        .children(".dropdown-menu")
        .toggleClass("show");
});
/**View Templates */
$(document).on("click", ".viewTemplates", function (e) {
    e.preventDefault();
    // console.log($(this));
    $.ajax({
        url: url + "/getTemplates",
        method: "get",
        data: {},
        beforeSend: function () {
            // $("#divLoading").show(); //show loader
        },
        success: function (response) {
            // console.log(response);
            $(".templateModal").modal("show");
            $(".templateModal").modal({
                // backdrop: false,
                show: true,
            });
            $(".templateModal-dialog").draggable({
                handle: ".templateModal-header",
            });
            $("#templates_div").empty().html(response);
        },
        error: function (err) {
            // if error occured
            //     sweetAlert("Oops...", 'Something is Wrong. Please Try Again', "error");
            // $("#divLoading").hide(); //hide loader
        },
    });
});
/**Edit Template */
$(document).on("click", ".btnEdit", function (e) {
    e.preventDefault();
    $(this).parents(".viewTemplate").addClass("d-none");
    $(this)
        .parents(".viewTemplate")
        .siblings(".updateTemplate")
        .removeClass("d-none");
});
$(document).on("click", ".btnCancel", function (e) {
    e.preventDefault();
    $(this).parents(".updateTemplate").addClass("d-none");
    $(this)
        .parents(".updateTemplate")
        .siblings(".viewTemplate")
        .removeClass("d-none");
});
/**Add Teplate */
$(document).on("click", ".addTemplate", function (e) {
    e.preventDefault();
    $(".AddTemplateModal").modal("show");
    $(".AddTemplateModal").modal({
        // backdrop: false,
        show: true,
    });
    $(".AddTemplateModal-dialog").draggable({
        handle: ".AddTemplateModal-header",
    });
});
$(document).on("submit", "#addTemplateForm", function (e) {
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    if (typeof page == "undefined") var page = 1;
    $.ajax({
        url: url + "/addTemplate",
        method: "post",
        data: $("#addTemplateForm").serialize(),
        beforeSend: function () {
            $("#divLoading").show(); //show loader
        },
        success: function (data) {
            // console.log(data);
            if (data.class == "success") {
                Swal.fire("Success..!!!", data.msg, "success");
                $("#addTemplateForm")[0].reset();
                $(".AddTemplateModal").modal("hide");
            } else if (data.class == "error") {
                Swal.fire("Error..!!!", data.msg, "error");
            }
            $("#divLoading").hide(); //hide loader
        },
        error: function (err) {
            // if error occured
            //     sweetAlert("Oops...", 'Something is Wrong. Please Try Again', "error");
            $("#divLoading").hide(); //hide loader
        },
    });
});
/**Select Template */
$(document).on("click", ".btnSelectTemplate", function (e) {
    e.preventDefault();
    var templateTxt = $(this).data("text");
    var templateid = $(this).data("templateid");
    var title = $(this).data("title");
    // console.log($('.send-sms-modal #message_text_sms'));
    //for text msg
    $(".send-sms-modal #message_text_sms").empty().text(templateTxt);
    $(".send-sms-modal #templateid").empty().val(templateid);
    $(".send-sms-modal #sms_template").empty();
    //for email
    $(".send-email-modal #message-text").empty().text(templateTxt);
    $(".send-email-modal #ucSub").empty().val(title);
    $(".templateModal").modal("hide");
});
/**Edit Template */
$(document).on("submit", "#updTemplateFrm", function (e) {
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    // return true;
    if (typeof page == "undefined") var page = 1;
    $.ajax({
        url: url + "/updateTemplate",
        method: "post",
        data: $(this).closest("#updTemplateFrm").serialize(),
        beforeSend: function () {
            $("#divLoading").show(); //show loader
        },
        success: function (data) {
            // console.log(data);
            if (data.class == "success") {
                Swal.fire("Success..!!!", data.msg, "success");
                $(".template").modal("hide");
                $(".viewTemplates").trigger("click");
            } else if (data.class == "error") {
                Swal.fire("Error..!!!", data.msg, "error");
            }
            $("#divLoading").hide(); //hide loader
        },
        error: function (err) {
            // if error occured
            //     sweetAlert("Oops...", 'Something is Wrong. Please Try Again', "error");
            $("#divLoading").hide(); //hide loader
        },
    });
});
$(document).on("click", ".fa-clipboard", function (e) {
    e.preventDefault();

    var value = $.trim($(this).parents("span:eq(0)").text());

    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val(value).select();
    document.execCommand("copy");
    $.toast({
        heading: "Copied to clipboard!",
        icon: "success",
        showHideTransition: "slideUp",
        allowToastClose: true,
        hideAfter: 1000,
        stack: false,
        position: {
            right: 5,
            top: 10,
        },
        textAlign: "center",
        loader: true,
        loaderBg: "#9EC600",
    });
    $temp.remove();
});

////React Requests

$(document).on("click", ".reactReqs", function (e) {
    e.preventDefault();

    var path = $(this).data("filepath");

    var serialNo = $(this).data("serial-no");
    $(".reactReqsModal").modal("show");
});
function fnKey(t) {
    if (t.keyCode == 49 && t.altKey == true) {
        $("#txtLicense").focus();
    }
}

// sessionStorage.removeItem("licNo");
