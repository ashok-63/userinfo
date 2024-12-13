$(document).ready(function () {
    // $("#state,#district,#city").select2();







    /**
     * Auto Loading ---- Loading On By Default
     */
    $(document).on("click", "#autoLoading_btn", function (e) {
        e.preventDefault();
        var val = $(this).val();
        if (val == "Auto-Loading is ON") {
            loading = false;
        } else {
            loading = true;
        }
        makeAutoLoadingOFF(loading);
    });
    /**
     * View Key Details
     */
    $(document).on("click", "#viewKeyDetails", function (e) {
        e.preventDefault();
        var licNo = $("#txtLicense").val();
        if (licNo == "") {
            alert("Please Enter a Valid Key..!");
        } else {
            // sessionStorage.setItem("licNo", licNo);
            window.open(url + "/dashboard/" + licNo, "_blank");
        }
    });
    $(document).on("change", "#txtPlainHR", function (e) {
        e.preventDefault();
        resolvePlainHR();
    });
    /**
     * On Change Old Licence Key
     */
    $(document).on("change", "#txtOldLicense", function (e) {
        e.preventDefault();
        var oldLic = $(this).val();
        if (oldLic.length == 12) {
            oldLicDetails(oldLic);
        }
    });
    /**
     * On Change State
     */
    $(document).on("change", "#state", function (e) {
        e.preventDefault();
        var state = $(this).val();
        $.ajax({
            url: url + "/getDistrict",
            method: "get",
            data: {
                state: state,
            },
            success: function (data) {
                var option = "";
                $.each(data, function (k, v) {
                    option +=
                        "<option value=" +
                        v.DISTRICT +
                        ">" +
                        v.DISTRICT +
                        "</option>";
                });
                $("#district").empty().html(option);
            },
            error: function (err) {
                console.log(err);
            },
        });
    });
    /**
     * On Change District
     */
    $(document).on("change", "#district", function (e) {
        e.preventDefault();
        $("#city").val("");
        var district = $(this).val();
        $.ajax({
            url: url + "/getCity",
            method: "get",
            data: {
                district: district,
            },
            success: function (data) {
                var option = "";

                $.each(data, function (k, v) {
                    option += "<option value='" + v.City_Name + "'>";
                });

                $("#cities").empty().html(option);
            },
            error: function (err) {
                console.log(err);
            },
        });
    });

    /**
     * On Change City
     */
    $(document).on("change", "#city", function (e) {
        e.preventDefault();
        $("#txtDealer").val("");
        var city = $("#city").val();
        $.ajax({
            url: url + "/showCityDlr",
            method: "get",
            data: { city: city },
            success: function (data) {
                var option = "";
                $.each(data, function (k, v) {
                    option +=
                        "<option  value='" +
                        v.DlrCompany +
                        "' dlrmobile=" +
                        v.DlrMobile +
                        ">" +
                        v.dlrCode +
                        " | " +
                        v.DlrMobile +
                        "</option>";
                });
                $("#dealers").empty().html(option);
            },
            error: function (err) {
                console.log(err);
            },
        });
    });

    /**
     * on Change Engineer Name
     */
    $(document).on("change", "#selectEngName", function (e) {
        e.preventDefault();
        var val = $(this).val();
        var engArr = val.split("$");
        $("#txtInstEngg").val(engArr[0]);
        $("#txtInstEnggM").val(engArr[1]);
    });
    /**
     * On CHange Dealer Code
     */
    $(document).on("change", "#txtdlrcode", function (e) {
        e.preventDefault();
        var val = $(this).val();
        DealerInfo(val);
        loadInstEngg(val);
    });
    /**
     * On Change Serach By
     */
    $(document).on("change", "#searchBy", function (e) {
        e.preventDefault();
        var searchBy = $(this).val();
        $(document).find("#search_val").val("");
        $(document)
            .find("#search_val")
            .attr("placeholder", "Enter " + searchBy + " value..!");
    });
    $(document).on("submit", "#searchDealerDetails", function (e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            url: url + "/searchDealer",
            method: "POST",
            data: $("#searchDealerDetails").serialize(),
            beforeSend: function () {
                $("#searchDealerDetails")
                    .find("button")
                    .prop("disabled", "disabled");
                $(document)
                    .find(".fa-search , .fa-spinner")
                    .toggleClass("d-none");
            },
            success: function (data) {
                $("#dlrData").empty().html(data);
                $("#drlInfoTable").DataTable({
                    paging: true,
                    pageLength: 25,
                    order: [],
                });
            },
            complete: function () {
                $("#searchDealerDetails")
                    .find("button")
                    .prop("disabled", false);
                $(document)
                    .find(".fa-search , .fa-spinner")
                    .toggleClass("d-none");
            },
            error: function (err) {
                console.log(err);
            },
        });
    });
    /**
     * On Selected Dealer
     */
    $(document).on("click", ".selectedDlr", function (e) {
        e.preventDefault();
        var DlrCode = $(this).data("dlrcode");
        // console.log(DlrCode)
        $("#txtdlrcode").val(DlrCode);
        $("#findDlrModal").modal("hide");
        DealerInfo(DlrCode);
        loadInstEngg(DlrCode);
    });

    /**
     * On Change Radio Button
     */

    $(document).on("click", ".keyUsedAt", function () {
        var val = $(this).val();
        var prevCompanyVal = sessionStorage.getItem("prevCompanyName");
        var txtOldLicense = $("#txtOldLicense").val();
        if (val == "Office") {
            if (prevCompanyVal != "undefined" && txtOldLicense != "") {
                $("#txtCompany").val(prevCompanyVal);
            } else {
                $("#txtCompany").val("");
            }
        } else {
            $("#txtCompany").val(val);
        }
    });

    /**
     *
     */
    $(document).on("submit", "#registrationForm", function (e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            url: url + "/registerKeyForAct",
            method: "POST",
            data: $("#registrationForm").serialize(),
            beforeSend: function () {
                $("#registrationForm")
                    .find("button")
                    .prop("disabled", "disabled");
                $(document)
                    .find(".fa-search , .fa-spinner")
                    .toggleClass("d-none");
            },
            success: function (data) {
                // console.log(data);
                if (data) {
                    $("#response_div").empty().html(data);
                    $("#unlockCodeModal").modal("show");
                }
            },
            complete: function () {
                $("#registrationForm").find("button").prop("disabled", false);
                $(document)
                    .find(".fa-search , .fa-spinner")
                    .toggleClass("d-none");
            },
            error: function (err) {
                console.log(err);
            },
        });
    });
});
/**
 * Auto Loading ---- Loading On By Default
 */
function makeAutoLoadingOFF(loading) {
    if (loading == false) {
        $("#autoLoading_btn").toggleClass(
            "btn-outline-success btn-outline-danger"
        );
        $("#autoLoading_btn").attr("Value", "Auto-Loading is OFF");
        $("#btn_txt").empty().text("Auto-Loading is OFF");
    } else {
        $("#autoLoading_btn").toggleClass(
            "btn-outline-danger btn-outline-success"
        );
        $("#autoLoading_btn").attr("Value", "Auto-Loading is ON");
        $("#btn_txt").empty().text("Auto-Loading is ON");
    }
}
/**
 * Old License Details
 */
function oldLicDetails(oldLic) {
    // console.log(oldLic);
    $.ajax({
        url: url + "/LoadOldLicDetails",
        method: "GET",
        data: {
            oldLic: oldLic,
        },
        beforeSend: function () {
            $("#oldKeySpinner").show(); //show loader
        },
        success: function (data) {
            // console.log(data);
            if (data) {
                $("#txtPerson").val(data.ContactPerson);
                $("#txtCustMob").val(data.custMobile);
                $("#txtCompany").val(data.Name);
                $("#txtemail").val(data.emailID);
                sessionStorage.setItem("prevCompanyName", data.Name);
                $("#expDate").empty().text(data.ExpiryDate);
                if (data.DlrCode != null || data.DlrCode != "") {
                    $("#txtdlrcode").val(data.DlrCode);
                    DealerInfo(data.DlrCode);
                    loadInstEngg(data.DlrCode);
                }
                if (data.installCode != null || data.installCode != "") {
                    $("#txtIC1").val(data.installCode.split("-")[0]);
                    $("#txtIC2").val(data.installCode.split("-")[1]);
                    $("#txtIC3").val(data.installCode.split("-")[2]);
                    $("#txtIC4").val(data.installCode.split("-")[3]);
                    $("#txtIC5").val(data.installCode.split("-")[4]);
                }
                GetLast4sOfHRInstCode();
            }
        },
        complete: function () {
            $("#oldKeySpinner").hide(); //show loader
        },
        error: function (err) {
            console.log(err);
        },
    });
}
/**
 *
 * Dealer Info
 */
function DealerInfo(DlrCode) {
    $.ajax({
        url: url + "/DealerInfo",
        method: "GET",
        data: {
            DlrCode: DlrCode,
        },
        beforeSend: function () {
            // $("#oldKeySpinner").show(); //show loader
        },
        success: function (data) {
            if (data) {
                $("#txtDealer").val(data.DlrCompany);
                $("#txtdlrmob").val(data.DlrMobile);
                $("#city").val(data.DlrCity);
                $("#state option")
                    .filter(function () {
                        return $(this).html() == data.DlrState;
                    })
                    .prop("selected", true);
                $("#district").html(
                    "<option value=" +
                        data.DlrDistrict +
                        ">" +
                        data.DlrDistrict +
                        "</option>"
                );
                $("#city").html(
                    "<option value=" +
                        data.DlrCity +
                        ">" +
                        data.DlrCity +
                        "</option>"
                );
                $("#DealerInfoModal #dlrCode_m").text(data.dlrCode);
                $("#DealerInfoModal #dlrComp_m").text(data.DlrCompany);
                $("#DealerInfoModal #dlrPer_m").text(data.DlrPerson);
                $("#DealerInfoModal #dlrCont_m").text(data.DlrMobile);
                $("#DealerInfoModal #dlrAddr_m").text(data.DlrAddress);
            }
        },
        complete: function () {},
        error: function (err) {
            console.log(err);
        },
    });
}
function loadInstEngg(DlrCode) {
    $.ajax({
        url: url + "/enggInfo",
        method: "GET",
        data: {
            DlrCode: DlrCode,
        },
        beforeSend: function () {
            $("#txtInstEnggSpinner").show();
        },
        success: function (data) {
            if (data) {
                $("#enggNameddl").empty().html(data);
            }
        },
        complete: function () {
            $("#txtInstEnggSpinner").hide();
        },
        error: function (err) {
            console.log(err);
        },
    });
}
/**
 *
 *
 */
function fnFwBK(t) {
    return;
    if (t.value.length == 4) {
        switch (t.name) {
            case "txtIC1":
                $("#txtIC2").focus();
                break;
            case "txtIC2":
                $("#txtIC3").focus();
                break;
            case "txtIC3":
                $("#txtIC4").focus();
                break;
        }
    } else if (t.value.length == 0) {
        switch (t.name) {
            case "txtIC4":
                fnSetToEnd("txtIC3");
                break;
            case "txtIC3":
                fnSetToEnd("txtIC2");
                break;
            case "txtIC2":
                fnSetToEnd("txtIC1");
                break;
        }
    }
}
function fnSetToEnd(textControlID) {
    // var text = document.getElementById(textControlID);
    var text = $(document)
        .find("#" + textControlID)
        .val();
    if (text != null && text.length > 0) {
        if (text.createTextRange) {
            var FieldRange = text.createTextRange();
            FieldRange.moveStart("character", text.value.length);
            FieldRange.collapse();
            FieldRange.select();
        }
    }
}
/**
 *
 *  HR & NN - Plain to Formatted Text
 */
function resolvePlainHR() {
    var plainHR = $("#txtPlainHR").val();
    if (plainHR.substring(0, 2) == "NN") {
        resolvePlainNN();
        return;
    }
    if (plainHR.length >= 22 && plainHR.indexOf("-") != -1) {
        plainHR = plainHR.replace("HR-", "");
        var hrArr = plainHR.split("-");
        if (hrArr.length >= 4) {
            $("#txtIC1").val(hrArr[0]);
            $("#txtIC2").val(hrArr[1]);
            $("#txtIC3").val(hrArr[2]);
            $("#txtIC4").val(hrArr[3]);
            $("#txtIC5").val(hrArr[4]);
            GetLast4sOfHRInstCode();
        }
    }
}
function resolvePlainNN() {
    var plainNN = $("#txtPlainHR").val();
    if (plainNN.length >= 26 && plainNN.indexOf("-") != -1) {
        plainNN = plainNN.replace("NN-", "");
        var hrArr = plainNN.split("-");
        if (hrArr.length >= 4) {
            $("#txtICNN1").val(hrArr[0]);
            $("#txtICNN2").val(hrArr[1]);
            $("#txtICNN3").val(hrArr[2]);
            $("#txtICNN4").val(hrArr[3]);
            $("#txtICNN5").val(hrArr[4]);
            GetLast4sOfNNInstCode();
        }
    }
}
function GetLast4sOfNNInstCode() {
    var ic =
        "NN-" +
        $("#txtICNN1").val() +
        "-" +
        $("#txtICNN2").val() +
        "-" +
        $("#txtICNN3").val() +
        "-" +
        $("#txtICNN4").val();

    if (ic.length == 26 && ic.indexOf("NN-") == 0) {
        $("#txtICNN5").val(
            formatToLength_5(
                parseInt("0x" + GetLast4sOfInstCode(InstCode_DecimalToHex(ic)))
            )
        );
    }
    if ($("#txtICNN1").val().length == 5) {
        $("#txtIC1").val(
            formatToLength_4(
                eval($("#txtICNN1").val().replace(/^0+/, "")).toString(16)
            )
        );
    }
    if ($("#txtICNN2").val().length == 5) {
        $("#txtIC2").val(
            formatToLength_4(
                eval($("#txtICNN2").val().replace(/^0+/, "")).toString(16)
            )
        );
    }
    if ($("#txtICNN3").val().length == 5) {
        $("#txtIC3").val(
            formatToLength_4(
                eval($("#txtICNN3").val().replace(/^0+/, "")).toString(16)
            )
        );
    }
    if ($("#txtICNN4").val().length == 5) {
        $("#txtIC4").val(
            formatToLength_4(
                eval($("#txtICNN4").val().replace(/^0+/, "")).toString(16)
            )
        );
    }

    if ($("#txtICNN5").val().length == 5) {
        $("#txtIC5").val(
            formatToLength_4(
                eval($("#txtICNN5").val().replace(/^0+/, "")).toString(16)
            )
        );
    }
}
function GetLast4sOfHRInstCode() {
    var ic =
        "HR-" +
        $("#txtIC1").val() +
        "-" +
        $("#txtIC2").val() +
        "-" +
        $("#txtIC3").val() +
        "-" +
        $("#txtIC4").val();

    if (ic.length == 22 && ic.indexOf("HR-") == 0) {
        $("#txtIC5").val(GetLast4sOfInstCode(ic));
    }
    if ($("#txtIC1").val().length == 4) {
        $("#txtICNN1").val(
            formatToLength_5(parseInt("0x" + $("#txtIC1").val()))
        );
    }
    if ($("#txtIC2").val().length == 4) {
        $("#txtICNN2").val(
            formatToLength_5(parseInt("0x" + $("#txtIC2").val()))
        );
    }
    if ($("#txtIC3").val().length == 4) {
        $("#txtICNN3").val(
            formatToLength_5(parseInt("0x" + $("#txtIC3").val()))
        );
    }
    if ($("#txtIC4").val().length == 4) {
        $("#txtICNN4").val(
            formatToLength_5(parseInt("0x" + $("#txtIC4").val()))
        );
    }

    if ($("#txtIC5").val().length == 4) {
        $("#txtICNN5").val(
            formatToLength_5(parseInt("0x" + $("#txtIC5").val()))
        );
    }
}
function GetLast4sOfInstCode(instCode) {
    var txtIC = instCode;
    if (txtIC.length == 22 && txtIC.indexOf("HR-") == 0) {
        var n1, n2, n3, n4, n5, n6, n7, tot, arrIc;
        if (txtIC != "") {
            n6 = new String();
            n6 = txtIC.replace(/HR-/g, "");
            n6 = reverseval(n6);
            n6 = n6.replace(/ /g, "");
            n6 = n6.toUpperCase();
            arrIc = n6.split("-");
            if (txtIC.length > 22) {
                n5 = arrIc[0];
                //--------------------------------
                n5 = reverseval(n5); //Check sum entered by customer
                n5 = n5.substring(0, 4);
                n5 = n5.toUpperCase();
                //--------------------------------
                n4 = arrIc[1];
                n4 = parseInt("0x" + n4);
                n3 = arrIc[2];
                n3 = parseInt("0x" + n3);
                n2 = arrIc[3];
                n2 = parseInt("0x" + n2);
                n1 = arrIc[4];
                n1 = parseInt("0x" + n1);
            } else {
                n4 = arrIc[0];
                n4 = parseInt("0x" + n4);
                n3 = arrIc[1];
                n3 = parseInt("0x" + n3);
                n2 = arrIc[2];
                n2 = parseInt("0x" + n2);
                n1 = arrIc[3];
                n1 = parseInt("0x" + n1);
            }
            n7 = n1 + n2 + n3 + n4;
            tot = n7.toString(16).toUpperCase();
            tot = tot.substring(tot.length - 4);
            return tot;
        }
    } else {
        return "";
    }
}
function formatToLength_5(str) {
    var fStr = "" + str;
    if (fStr.length == 5) return fStr;
    else if (fStr.length == 4) return "0" + fStr;
    else if (fStr.length == 3) return "00" + fStr;
    else if (fStr.length == 2) return "000" + fStr;
    else if (fStr.length == 1) return "0000" + fStr;
    else return "00000";
}
function formatToLength_4(str) {
    var fStr = "" + str;
    if (fStr.length == 4) return fStr;
    else if (fStr.length == 3) return "0" + fStr;
    else if (fStr.length == 2) return "00" + fStr;
    else if (fStr.length == 1) return "000" + fStr;
    else return "0000";
}
function reverseval(value1) {
    var value = "";
    value = value1;
    var out = "",
        i = 0;
    for (i = 0; i <= value.length - 1; i++) out = value.charAt(i) + out;
    return out;
}
function InstCode_DecimalToHex(decInstCode) {
    decInstCode = decInstCode.replace("NN-", "");
    var aInstCode = decInstCode.split("-");
    var retInstCode = "";
    for (var i = 0; i < aInstCode.length; i++) {
        retInstCode =
            retInstCode +
            "-" +
            formatToLength_4(
                eval(aInstCode[i].replace(/^0+/, "")).toString(16)
            );
    }
    retInstCode = "HR" + retInstCode.toUpperCase();
    return retInstCode;
}

/**
 *
 *  On Input Dealer Company
 *
 */

function onInput() {
    var val = $("#txtDealer").val();

    var list = $(document).find("datalist[id='dealers']");

    var options = $(list).children();

    for (var i = 0; i < options.length; i++) {
        if (options[i].value == val) {
            var res = options[i].innerText.split(" | ");

            $("#txtdlrcode").val(res[0]);
            $("#txtdlrmob").val(res[1]);
            break;
        }
    }
}

function fnFwBKNN(t) {
    return;
    if (t.value.length == 5) {
        switch (t.name) {
            case "txtICNN1":
                $("#txtICNN2").focus();
                break;

            case "txtICNN2":
                $("#txtICNN3").focus();
                break;

            case "txtICNN3":
                $("#txtICNN4").focus();
                break;
        }
    } else if (t.value.length == 0) {
        switch (t.name) {
            case "txtICNN4":
                fnSetToEnd("txtICNN3");
                break;
            case "txtICNN3":
                fnSetToEnd("txtICNN2");
                break;
            case "txtICNN2":
                fnSetToEnd("txtICNN1");
                break;
        }
    }
}
