$(document).ready(function () {
    $(document).on("change", "#search_by", function (e) {
        e.preventDefault();
        var search_byVal = $(this).val();
        if (search_byVal == "lic") {
            $(this)
                .parents(".selectBoxDiv")
                .siblings(".inputBoxDiv")
                .children()
                .children("input")
                .attr("list", "keylist");
            $(document).on("keyup", ".search_txt", function (e) {
                e.preventDefault();
                var licNo = $(this).val();

                if (licNo && licNo.length > 5) {
                    getSuggestedKeys(licNo);
                }
            });
        } else {
            $(this)
                .parents(".selectBoxDiv")
                .siblings(".inputBoxDiv")
                .children()
                .children("input")
                .removeAttr("list");
        }
    });
    /*** If Key Is passed through URL  */
    var keyNo = $("#search_txt").val();
    if (keyNo) {
        $("#btn-search").trigger("click");
    }

    /** Add Remark  */

    $(document).on("click", ".addRemark", function (e) {
        e.preventDefault();
        var custNo = $(this).data("custno");
        var notesfolder = "Remark";
        var fileUrl =
            "E:\\ACTIVATIONDATA\\" + notesfolder + "\\" + custNo + ".log";

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
                // console.log(data)
                $(".addRemarkModal").modal("show");
                $(".addRemarkModal #custNo").val(custNo);
                $(".addRemarkModal #fileURL").val(fileUrl);

                if (data.hasOwnProperty("error") || data == "") {
                    $(".addRemarkModal #notetext").append(n.trim());
                } else {
                    $(".addRemarkModal #notetext").append(
                        $.trim(data) +
                            "\r\n" +
                            "--------------------------------" +
                            "\r\n" +
                            n.trim()
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

    $(document).on("click", ".remarkModalClose", function (e) {
        e.preventDefault();

        $(".addRemarkModal #notetext").text("");
        $(".addRemarkModal").modal("hide");
    });

    $(document).on("submit", "#addRemarkForm", function (e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        if (typeof page == "undefined") var page = 1;
        $.ajax({
            url: url + "/addRemark",
            method: "POST",
            data: $("#addRemarkForm").serialize() + "&page=" + page,
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

                    $("#addRemarkForm")[0].reset();
                }
                $(".remarkModalClose").trigger("click");
                $("#divLoading").hide(); //hide loader
            },
            error: function (err) {
                // if error occured
                //     sweetAlert("Oops...", 'Something is Wrong. Please Try Again', "error");
                $("#divLoading").hide(); //hide loader
            },
        });
    });

    /**
     * BookMarks
     */

    $(document).on("click", "#addToBookMarks", function (e) {
        e.preventDefault();
        var search_txt = $("#search_txt").val();

        if (search_txt == "") {
            return;
        }

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        var token = $('meta[name="csrf-token"]').attr("content");
        $.ajax({
            url: url + "/addToBookMark",
            type: "POST",
            data: {
                token: token,
                search_txt: search_txt,
            },
            beforeSend: function () {
                $("#addToBookMarks").prop("disabled", true);
                $(".spinner").toggleClass("d-none");
            },
            success: function (data) {
                if (data == true) {
                    $.toast({
                        heading: "Bookmark Added..!",
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
                }
            },
            complete: function () {
                $("#addToBookMarks").removeAttr("disabled");
                $(".spinner").toggleClass("d-none");
            },
            error: function (err) {
                console.log(err);
            },
        });
    });

    $(document).on("click", "#bookMarkedKeys", function (e) {
        e.preventDefault();

        $.ajax({
            url: url + "/viewBookMarks",
            type: "GET",
            data: {},
            beforeSend: function () {
                $("#divLoading").show(); //show loader
            },
            success: function (data) {
                if (data) {
                    console.log(data);
                    var tr = "";
                    $.each(data, function (i, item) {
                        tr += "<tr>";
                        tr += "<td>" + parseInt(i + 1) + "</td>";
                        tr += "<td>" + item.Key + "</td>";
                        tr += "<td>" + item.AddedBy + "</td>";
                        tr += "<td>" + item.inDate + "</td>";
                        tr += "</tr>";
                    });

                    $("#bookMarksTbl tbody").empty().html(tr);
                    $("#bookMarksTbl").DataTable().destroy();
                    $("#bookMarksTbl").DataTable({
                        paging: true,
                        searching: true,
                        pageLength: 20,
                    });
                    $("#BookMarkModal").modal("show");
                }
            },
            complete: function () {
                $("#divLoading").hide();
            },
            error: function (err) {
                console.log(err);
            },
        });
    });

    /**
     * Search In UPD2UC
     */

    $(document).on("click", "#searchInUpd2Uc", function (e) {
        e.preventDefault();
        var search_txt = $("#search_txt").val();
        var search_by = $("#search_by").val();

        if (search_txt == "" || search_by != "lic") {
            return;
        }

        var url = "https://upd2uc.mallab.net/sureucblock?key=" + search_txt;
        window.open(url, "_blank");
    });

    /**
     * Fetch Reward Key
     */

    $(document).on("click", ".fetchKey", function (e) {
        e.preventDefault();

        var serialno = $(this).data("serialno");

        $("#newKeyViewer").empty();

        $("#rewardKeyModal").modal("show");
        $("#oldLic").val(serialno);
    });

    $(document).on("submit", "#fetchNewRewardKeyForm", function (e) {
        e.preventDefault();

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        $.ajax({
            url: url + "/fetchNewRewardKey",
            method: "POST",
            data: $("#fetchNewRewardKeyForm").serialize(),

            beforeSend: function () {
                $("#divLoading").show(); //show loader
            },
            success: function (data) {
                Swal.fire(data.Status, data.Message, data.Status);

                if (data.Status == "success") {
                    var newKey = data.NewKey;

                    $("#newKeyViewer")
                        .empty()
                        .html("New Reward Key : <h3>" + newKey + "</h3>");

                    $(".fetchKey").remove();
                }
            },
            complete: function () {
                $("#divLoading").hide(); //hide loader
            },
            error: function (err) {
                // if error occured
                $("#divLoading").hide(); //hide loader
            },
        });
    });
});

$(document).on("input", ".search_txt", function (e) {
    e.preventDefault();
    var licNo = $(this).val();
    var searchBy = $("#search_by").val();

    if (searchBy == "lic" && licNo.length > 6) {
        getSuggestedKeys(licNo);
    }
});

function getSuggestedKeys(licNo) {
    $.ajax({
        url: url + "/getSuggestedKeys",
        method: "get",
        data: {
            licNo: licNo,
        },
        success: function (data) {
            // console.log(data);
            var datalist = "";
            $.each(data, function (k, v) {
                datalist +=
                    " <option value=" +
                    v.SerialInitial +
                    "-" +
                    v.SerialNo +
                    ">";
            });
            $("datalist[id=keylist]").empty().html(datalist);
        },
        error: function (err) {
            // if error occured
        },
    });
}

$("#btn-search").on("click", function () {
    var _token = $("input[name=_token]").val();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    if (typeof page == "undefined") var page = 1;

    if ($("#search_txt").val() == "") {
        alert(
            "Please Enter " +
                $("#search_by option:selected").text() +
                " to search !"
        );

        return false;
    }
    if ($("#search_by option:selected").text() == "Key Number") {
        if ($("#search_txt").val().length != "12") {
            alert("Please enter correct License Number!");
            return false;
        }
    }
    // return true
    SearchData(page);
});

// $(document).on("change", "#search_txt", function (e) {
//     e.preventDefault();
//     if (typeof page == "undefined") var page = 1;

//     $("#btn-search").trigger("click");
//     // SearchData(page);
// });

$(document).on("keypress", "#search_txt", function (e) {
    if (e.which == 13) {
        if (typeof page == "undefined") var page = 1;
        $("#btn-search").trigger("click");
        // SearchData(page);
    }
});

function SearchData(page) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    var search_txt = $("#search_txt").val();
    var search_by = $("#search_by").val();

    $.ajax({
        url: url + "/SearchByKey",
        method: "get",
        data: {
            search_txt: search_txt,
            search_by: search_by,
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
                stateSave: false,
                ordering: false,
            });

            $("#divLoading").hide(); //hide loader
            if (search_by == "lic") {
                fetchLiveHW(search_txt);
                fetchCorpDetails(search_txt);
                showFetchBtn(search_txt);
            }
        },
        error: function (err) {
            $("#divLoading").hide(); //hide loader
        },
    });
}

function fetchCorpDetails(search_txt) {
    $.ajax({
        url: url + "/fetchCorpDetails",
        method: "get",
        data: {
            search_txt: search_txt,
        },
        success: function (data) {
            var html = "";
            if (data) {
                html +=
                    "<span class='highUc'> CorpId :" +
                    data.corpid +
                    "</span> | Email : " +
                    data.emailID +
                    " | Mob:" +
                    data.Mobile +
                    " | FirmName : " +
                    data.FirmName +
                    " | City : " +
                    data.City +
                    " | DlrCode: " +
                    data.DlrCode +
                    "";

                $(document).find(".react-btn").removeClass("d-none");
            } else {
                console.log("No Data Found");
            }
            $(document).find("#corpDetails").empty().html(html);
        },
        error: function (err) {
            console.log(err);
        },
    });
}

function fetchLiveHW(search_txt) {
    $.ajax({
        url: url + "/liveHwCount",
        method: "get",
        data: {
            srchTxt: search_txt,
        },
        dataType: "JSON",
        beforeSend: function () {
            $(".cntloader").removeClass("d-none");
        },
        success: function (data) {
            var txt = "";
            if (data) {
                txt += "--------------------------<br>";
                txt += "Total Update Count : " + data.TotalCount;
                txt += " | Diff. Machine Count : " + data.Machinewise;
            }

            $(".liveHwCnt").empty().html(txt);
        },
        complete: function () {
            $(".cntloader").addClass("d-none");
        },
        error: function (err) {
            console.log(err);
        },
    });
}

function OpenHwDetails(customer_no, serial_no) {
    var _token = $("input[name=_token]").val();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $.ajax({
        url: url + "/FetchHWDetails1",
        method: "POST",
        data: { customer_no: customer_no, serial_no: serial_no },
        beforeSend: function () {
            $("#divLoading").show(); //show loader
        },
        success: function (data) {
            $(".hw_modal_body").empty().html(data);
            $("#HW1Modal").modal("show");
            $("#divLoading").hide(); //hide loader
        },
        error: function (err) {
            // if error occured
            $("#divLoading").hide(); //hide loader
        },
    });
}

function OpenSecondHwDetails(customer_no, serial_no) {
    var _token = $("input[name=_token]").val();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $.ajax({
        url: url + "/FetchHWDetails2",
        method: "POST",
        data: {
            customer_no: customer_no,
            serial_no: serial_no,
        },
        beforeSend: function () {
            $("#divLoading").show(); //show loader
        },
        success: function (data) {
            // $('.main_container').empty().html(data)
            $(".main_container").hide();
            if ($(".hardware_details2").length >= 1)
                $(".hardware_details2").remove();
            $(".page-content").append(data);
            $("#divLoading").hide(); //hide loader
        },
        error: function (err) {
            // if error occured
            $("#divLoading").hide(); //hide loader
        },
    });
}

function OpenUserDetails(customer_no) {
    var _token = $("input[name=_token]").val();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $.ajax({
        url: url + "/FetchUserDetails",
        method: "POST",
        data: {
            customer_no: customer_no,
        },
        beforeSend: function () {
            $("#divLoading").show(); //show loader
        },
        success: function (data) {
            $(".user_details_modal_body").empty().html(data);
            $("#UserModal").modal("show");
            $("#divLoading").hide(); //hide loader
        },
        error: function (err) {
            // if error occured
            $("#divLoading").hide(); //hide loader
        },
    });
}

function OpenUserMobDetails(customer_no, serial_no, mobile_no) {
    var _token = $("input[name=_token]").val();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $.ajax({
        url: url + "/FetchUserMobDetails",
        method: "POST",
        data: {
            customer_no: customer_no,
            serial_no: serial_no,
            mobile_no: mobile_no,
        },
        beforeSend: function () {
            $("#divLoading").show(); //show loader
        },
        success: function (data) {
            $(".user_details_modal_body").empty().html(data);
            $("#UpdateUserMobModal").modal("show");
            $("#divLoading").hide(); //hide loader
        },
        error: function (err) {
            // if error occured
            $("#divLoading").hide(); //hide loader
        },
    });
}

$(document).on("click", ".OpenContactDetails", function () {
    var _token = $("input[name=_token]").val();
    let temp_this = $(this);
    let serial_no = $(this).data("serial-no");
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $.ajax({
        url: url + "/FetchContactDetails",
        method: "POST",
        data: {
            // customer_no:customer_no,
            serial_no: serial_no,
        },
        beforeSend: function () {
            $("#divLoading").show(); //show loader
        },
        success: function (data) {
            let contact_data = data.ContactData;
            let contact_details = temp_this
                .parent()
                .parent()
                .find(".contact_details");
            contact_details.show();
            if (contact_data) {
                contact_details
                    .find(".contact_mob")
                    .html(contact_data.newMobileNo);
                contact_details
                    .find(".contact_email")
                    .html(contact_data.newEmailId);
                contact_details.find(".contact_date").html(contact_data.cuDt);
            } else {
                contact_details.html(
                    '<strong style="color:red">No Details Found.</strong>'
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

$(document).on("click", ".close-icon", function () {
    $(this).parent().hide();
});

$(document).on("change", "#search_by", function () {
    src_by_val = $(this).val();
    if (src_by_val == "ic") {
        $(".txtICDiv").show();
        $("#search_txt").val("HR-");
    } else {
        $(".txtICDiv").hide();
        $("#search_txt").val("");
        $("#txtIC").val("");
    }
});

$(document).on("keyup", "#search_txt", function () {
    search_val = $(this).val();
    if (search_val.length >= "22" && search_val.includes("HR-")) {
        let n1 = "";
        let n2 = "";
        let n3 = "";
        let n4 = "";
        let arrIc = $(this)
            .val()
            .replace("HR-", "")
            .split("")
            .reverse()
            .join("")
            .replace(" ", "")
            .toUpperCase()
            .split("-");
        if (search_val.length > "22") {
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
        let n7 = n1 + n2 + n3 + n4;
        let tot = n7.toString(16).toUpperCase();
        tot = tot.substring(tot.length - 4);
        $("#txtIC").val(tot);
    }
});

$("#search_by").click(function (e) {
    e.stopPropagation();
});

function fnOpenPIODetails() {}

$(document).on("click", ".pio_details", function () {
    let lic = $(this).data("serial_no");
    window.open(
        "http://pio.npav.net/Anonymous/Dealer/KeyActivation?keyno=" + lic,
        "PIODetails",
        "menubar=no,scrollbars=no,top=380,left=130,height=250,width=" +
            screen.availWidth
    );
});

$(document).on("click", ".reactivate_details", function () {
    let serial_no = $(this).data("serial_no");
    let user_name = $(this).data("user_name");
    let customer_no = $(this).data("customer_no");
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $.ajax({
        url: url + "/FetchReactivateDetails",
        method: "POST",
        data: {
            customer_no: customer_no,
            serial_no: serial_no,
            user_name: user_name,
        },
        beforeSend: function () {
            $("#divLoading").show(); //show loader
        },
        success: function (data) {
            $(".reactive_modal_body").empty().html(data);
            // $("#ReactivateModal").show();

            try {
                $(".select2_modal").each(function () {
                    $(this).select2({
                        dropdownParent: $(this).parent(), // fix select2 search input focus bug
                    });
                });
            } catch (err) {
                console.log("s2err");
            }

            // fix select2 bootstrap modal scroll bug
            $(document).on("select2:close", ".select2_modal", function (e) {
                var evt = "scroll.select2";
                $(e.target).parents().off(evt);
                $(window).off(evt);
            });
            $("#ReactivateModal").modal("show");
            // $(".country").trigger("change");
            $("#divLoading").hide(); //hide loader
        },
        error: function (err) {
            // if error occured
            $("#divLoading").hide(); //hide loader
        },
    });
});

$(document).on("change", ".country", function (e) {
    e.preventDefault();
    // console.log("changes");
    let country_id = $(this).val();
    let state_name = $("#txtState").val();

    try {
        var country_name = $(this).select2("data")[0].text()
            ? $(this).select2("data")[0].text()
            : "";
    } catch (err) {
        var country_name = $(".country option:selected").text()
            ? $(".country option:selected").text()
            : "";
    }

    // let country_name = $(this).find("option:selected").text();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $.ajax({
        url: url + "/FetchStateByCountry",
        method: "POST",
        data: {
            country_id: country_id,
            state_name: state_name,
        },
        beforeSend: function () {
            $("#divLoading").show(); //show loader
        },
        success: function (data) {
            let state_data = data.state_option;
            $("#lstState").empty().html(state_data);
            $("#txtCountry").val(country_name);

            try {
                $(".state").each(function () {
                    $(this).select2({
                        dropdownParent: $(this).parent(), // fix select2 search input focus bug
                    });
                });
            } catch (err) {
                console.log("s2err");
            }

            // fix select2 bootstrap modal scroll bug
            $(document).on("select2:close", ".state", function (e) {
                var evt = "scroll.select2";
                $(e.target).parents().off(evt);
                $(window).off(evt);
            });
            $(".state").trigger("change");
            $("#divLoading").hide(); //hide loader
        },
        error: function (err) {
            // if error occured
            $("#divLoading").hide(); //hide loader
        },
    });
});

$(document).on("change", ".state", function (e) {
    e.preventDefault();
    let state_id = $(this).val();
    let district_name = $("#txtDist").val();

    try {
        var state_name = $(this).select2("data")[0].text()
            ? $(this).select2("data")[0].text()
            : "";
    } catch (err) {
        var state_name = $(".state option:selected").text()
            ? $(".state option:selected").text()
            : "";
    }

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $.ajax({
        url: url + "/FetchDistrictByState",
        method: "POST",
        data: {
            state_id: state_id,
            district_name: district_name,
        },
        beforeSend: function () {
            $("#divLoading").show(); //show loader
        },
        success: function (data) {
            let district_data = data.district_option;
            $("#lstDistrict").empty().html(district_data);
            $("#txtState").val(state_name);

            try {
                $(".district").each(function () {
                    $(this).select2({
                        dropdownParent: $(this).parent(), // fix select2 search input focus bug
                    });
                });
            } catch (err) {
                console.log("s2err");
            }

            // fix select2 bootstrap modal scroll bug
            $(document).on("select2:close", ".district", function (e) {
                var evt = "scroll.select2";
                $(e.target).parents().off(evt);
                $(window).off(evt);
            });
            $(".district").trigger("change");
            $("#divLoading").hide(); //hide loader
        },
        error: function (err) {
            // if error occured
            $("#divLoading").hide(); //hide loader
        },
    });
});

$(document).on("change", ".district", function (e) {
    try {
        var district_name = $(this).select2("data")[0].text()
            ? $(this).select2("data")[0].text()
            : "";
    } catch (err) {
        var district_name = $(".district option:selected").text()
            ? $(".district option:selected").text()
            : "";
    }

    $("#txtDist").val(district_name);
    if ($("#txtCity").val() == "") $("#txtCity").val(district_name);
});

$(document).on("submit", "#update_reactivate_form", function (e) {
    e.preventDefault();
    var _token = $("input[name=_token]").val();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    if ($("#update_reactivate_form").valid()) {
        $.ajax({
            url: url + "/UpdateReactivate",
            method: "POST",
            data: $("#update_reactivate_form").serialize(),
            beforeSend: function () {
                $("#divLoading").show(); //show loader
            },
            success: function (data) {
                // Swal.fire('Good job!',data.msg,data.class)
                // $("#ReactivateModal").modal("hide");
                if (data) {
                    let CustomerNo = data.CustomerNo;
                    let UserName = data.UserName;
                    let SerialNo = data.serial_no;
                    genReactive(CustomerNo, UserName, SerialNo);
                }
                // $("#divLoading").hide(); //hide loader
            },
            error: function (err) {
                // if error occured
                $("#divLoading").hide(); //hide loader
            },
        });
    }
});

function genReactive(CustomerNo, UserName, SerialNo) {
    var _token = $("input[name=_token]").val();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $.ajax({
        url: url + "/genReactive",
        method: "POST",
        data: {
            CustomerNo: CustomerNo,
            UserName: UserName,
            SerialNo: SerialNo,
        },
        beforeSend: function () {
            $("#divLoading").show(); //show loader
        },
        success: function (data) {
            // Swal.fire('Good job!',data.msg,data.class)

            $(".gen_reactive_modal_body").empty().html(data);
            $("#ReactivateModal").modal("hide");
            $("#genReactivateModal").modal("show");
            $("#divLoading").hide(); //hide loader
        },
        error: function (err) {
            // if error occured
            $("#divLoading").hide(); //hide loader
        },
    });
}

$(document).on("click", ".block_unlockcode", function () {
    let unlock_code = $(this).data("unlock_code");
    let customer_no = $(this).data("customer_no");
    let serial_no = $(this).data("serial_no");
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $.ajax({
        url: url + "/FetchUnLockCodeDetails",
        method: "POST",
        data: {
            customer_no: customer_no,
            unlock_code: unlock_code,
            serial_no: serial_no,
        },
        beforeSend: function () {
            $("#divLoading").show(); //show loader
        },
        success: function (data) {
            $(".block_unlockcode_modal_body").empty().html(data);
            $("#BlockUnlockCodeModal").modal("show");
            $("#divLoading").hide(); //hide loader
        },
        error: function (err) {
            // if error occured
            $("#divLoading").hide(); //hide loader
        },
    });
});

$(document).on("submit", "#unlockcode_form", function (e) {
    e.preventDefault();
    var _token = $("input[name=_token]").val();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    if ($("#unlockcode_form").valid()) {
        $.ajax({
            url: url + "/UpdateUnlockCodeStatus",
            method: "POST",
            data: $("#unlockcode_form").serialize(),
            beforeSend: function () {
                $("#divLoading").show(); //show loader
            },
            success: function (data) {
                if (data.class == "success") {
                    Swal.fire("Good job!", data.msg, data.class);
                } else {
                    Swal.fire("Error..!!!", data.msg, data.class);
                }

                var keyNo = $("#search_txt").val();
                if (keyNo) {
                    $("#btn-search").trigger("click");
                }

                $("#BlockUnlockCodeModal").modal("hide");
                $("#divLoading").hide(); //hide loader
            },
            error: function (err) {
                // if error occured
                $("#divLoading").hide(); //hide loader
            },
        });
    }
});

$(document).on("submit", "#DlrScore_form", function (e) {
    e.preventDefault();
    var _token = $("input[name=_token]").val();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    if ($("#DlrScore_form").valid()) {
        $.ajax({
            url: url + "/GetDlrScore",
            method: "POST",
            data: $("#DlrScore_form").serialize(),
            beforeSend: function () {
                $("#divLoading").show(); //show loader
            },
            success: function (data) {
                // Swal.fire('Good job!',data.msg,data.class)
                if (data.class == "error") {
                    Swal.fire("Error..!!!", data.msg, data.class);
                } else {
                    $("#DlrScoreModal").modal("hide");
                    $(".dealer_score_modal_body").empty().html(data);
                }
                $("#dealerScoreModal").modal("show");
                $("#divLoading").hide(); //hide loader
            },
            error: function (err) {
                // if error occured
                $("#divLoading").hide(); //hide loader
            },
        });
    }
});

/** Copy Dealer Details */

$(document).on("click", ".CopyDealerDetails", function (e) {
    e.preventDefault();

    // value = $(".modal_custom_box")

    //     .text()
    //     .replaceAll(/\s/g, "")
    //     .replaceAll("|", "\n\n")
    //     .trim();

    var value = $(".modal_custom_box")
        .clone() // Clone the modal_custom_box element
        .find(".skip") // Find all elements with class 'skip' within the cloned element
        .remove() // Remove these elements and their descendants from the cloned element
        .end() // Return to the original modal_custom_box element
        .text() // Get the text content of the modified modal_custom_box element
        .replaceAll(/\s+/g, " ") // Replace multiple spaces with a single space
        .replaceAll(/\|/g, "\n\n") // Replace '|' with double newline
        .trim(); // Trim any leading or trailing whitespace

    var textarea = document.createElement("textarea");
    textarea.textContent = value;
    document.body.appendChild(textarea);

    var selection = document.getSelection();
    var range = document.createRange();
    //  range.selectNodeContents(textarea);
    range.selectNode(textarea);
    selection.removeAllRanges();
    selection.addRange(range);

    document.execCommand("copy");
    selection.removeAllRanges();

    document.body.removeChild(textarea);

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
});

/** Copy Dealer Details */

$(document).on("submit", "#AddDays_form", function (e) {
    e.preventDefault();
    var _token = $("input[name=_token]").val();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    if ($("#AddDays_form").valid()) {
        $.ajax({
            url: url + "/AddDays",
            method: "POST",
            data: $("#AddDays_form").serialize(),
            beforeSend: function () {
                $("#divLoading").show(); //show loader
            },
            success: function (data) {
                console.log(data);
                if (data.class == "success") {
                    Swal.fire("Good job!", data.msg, data.class);
                } else if (data.class == "error") {
                    Swal.fire("Warning!", data.msg, "warning");
                } else {
                    $("#response_div").empty().html(data);
                    $("#unlockCodeModal").modal("show");
                    $("#response_div table").css("margin-left", "98px");
                }
                $("#AddDaysModal").modal("hide");
                $("#divLoading").hide(); //hide loader
            },
            error: function (err) {
                // if error occured
                $("#divLoading").hide(); //hide loader
            },
        });
    }
});

function open_new_act() {
    var _token = $("input[name=_token]").val();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $.ajax({
        url: url + "/new_act",
        method: "GET",
        data: {},
        beforeSend: function () {
            $("#divLoading").show(); //show loader
        },
        success: function (data) {
            $(".main_container").hide();
            if ($(".new_activation_div").length >= 1)
                $(".new_activation_div").remove();
            if ($(".hardware_details2").length >= 1)
                $(".hardware_details2").remove();
            $(".new_activation_div").show();
            $(".page-content").append(data);
            $("#divLoading").hide(); //hide loader
        },
        error: function (err) {
            // if error occured
            $("#divLoading").hide(); //hide loader
        },
    });
}

$(document).on("click", "#chkCut", function () {
    $("#gen_reactivate_form #txtIC").prop("readonly", true);
    $("#gen_reactivate_form #txtIC").css("background", "#dddddd");
});

$(document).on("click", ".hr_code_text", function () {
    $(this).toggle();
    $(".hr_code_input").toggle();
});

$(document).on("submit", "#convertLicForm", function (e) {
    e.preventDefault();
    var _token = $("input[name=_token]").val();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $.ajax({
        url: url + "/convertLic",
        method: "POST",
        data: $("#convertLicForm").serialize(),
        beforeSend: function () {
            $("#divLoading").show(); //show loader
        },
        success: function (data) {
            // console.log(data);
            if (data.hasOwnProperty("success")) {
                Swal.fire("Success", data.success, "info");
                // $("#convertLicForm")[0].reset();
                // $("#ConvertLicModal").modal("hide");
            } else {
                Swal.fire("Error", data.error, "error");
            }

            $("#divLoading").hide(); //hide loader
        },
        error: function (err) {
            // if error occured
            $("#divLoading").hide(); //hide loader
        },
    });
});

$(document).on("click", ".closeLicConvModal", function (e) {
    e.preventDefault();
    $("#convertLicForm")[0].reset();
    $("#ConvertLicModal").modal("hide");
});

function GetLast4sOfNNInstCode() {
    let ic = $("#gen_reactivate_form #txtICNN").val();
    if (ic.length >= 26 && ic.indexOf("NN-") == 0) {
        $("#gen_reactivate_form #txtICNN1").val(
            formatToLength_5(
                parseInt("0x" + GetLast4sOfInstCode(InstCode_DecimalToHex(ic)))
            )
        );
        $("#gen_reactivate_form #txtIC").val(InstCode_DecimalToHex(ic));
        $("#gen_reactivate_form #txtIC1").val(
            eval($("#gen_reactivate_form #txtICNN1").val().replace(/^0+/, ""))
                .toString(16)
                .toUpperCase()
        );
    }
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

function GetLast4sOfHRInstCode() {
    let ic = $("#gen_reactivate_form #txtIC").val();
    if (ic.length >= 22 && ic.indexOf("HR-") == 0) {
        $("#gen_reactivate_form #txtIC1").val(
            formatToLength_4(GetLast4sOfInstCode(ic))
        );
        $("#gen_reactivate_form #txtICNN").val(InstCode_HexToDecimal(ic));
        $("#gen_reactivate_form #txtICNN1").val(
            formatToLength_5(
                parseInt("0x" + $("#gen_reactivate_form #txtIC1").val())
            )
        );
    }
}

function GetLast4sOfInstCode(instCode) {
    if (instCode.length >= "22" && instCode.indexOf("HR-") == 0) {
        let n1 = "";
        let n2 = "";
        let n3 = "";
        let n4 = "";
        let n6 = instCode
            .replace("HR-", "")
            .split("")
            .reverse()
            .join("")
            .replace(" ", "")
            .toUpperCase();
        let arrIc = n6.split("-");
        if (instCode.length > "22") {
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
        let n7 = n1 + n2 + n3 + n4;
        let tot = n7.toString(16).toUpperCase();
        tot = tot.substring(tot.length - 4);
        getICcount(n6);
        return tot;
    }
}

function formatToLength_4(str) {
    var fStr = "" + str;
    if (fStr.length == 4) return fStr;
    else if (fStr.length == 3) return "0" + fStr;
    else if (fStr.length == 2) return "00" + fStr;
    else if (fStr.length == 1) return "000" + fStr;
    else return "0000";
}

function InstCode_HexToDecimal(hexInstCode) {
    hexInstCode = hexInstCode.replace("HR-", "");
    var aInstCode = hexInstCode.split("-");
    var retInstCode = "";
    for (var i = 0; i < aInstCode.length; i++) {
        retInstCode =
            retInstCode + "-" + formatToLength_5(parseInt("0x" + aInstCode[i]));
    }
    retInstCode = "NN" + retInstCode.toUpperCase();
    return retInstCode;
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

function getICcount(iccode) {
    var _token = $("input[name=_token]").val();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $.ajax({
        url: url + "/getICcount",
        method: "POST",
        data: {
            iccode: iccode,
        },
        beforeSend: function () {
            // $("#divLoading").show(); //show loader
        },
        success: function (data) {
            if (data.class == "success") {
                $("#DivICCnt").show();
                $("#DivICCnt").html("IC Counter :" + data.data);
            } else {
                $("#DivICCnt").hide();
            }
            // $("#divLoading").hide(); //hide loader
        },
        error: function (err) {
            // if error occured
            // $("#divLoading").hide(); //hide loader
        },
    });
}

$(document).on("click", ".addSureBlockChkbx", function (e) {
    Swal.fire({
        title: "Do you really want to block all unlock codes?\n [Note : Current UC will not be blocked.]",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#ec4561",
        confirmButtonText: "Yes, block it.",
        cancelButtonText: "No, cancel it!",
        closeOnConfirm: false,
        closeOnCancel: false,
    }).then((result) => {
        if (result["isConfirmed"]) {
            var checked = $(this).data("checked");
            var custno = $(this).data("custno");
            var serialno = $(this).data("serialno");
            fnSureBlock(serialno, custno, checked);
        }
    });
});

function fnTxtCounter() {
    if ($("#gen_reactivate_form #txtComment").val() != "") {
        let charlength = $("#txtComment").val().length;
        $("#char_count").html(" " + charlength + " /100");
        if (charlength > 100) {
            alert(
                "Character Limit Exceeded! Only 100 characters are allowed in one sms."
            );
            return true;
        }
    } else {
        $("#char_count").html("0");
    }
}

$(document).on("submit", "#gen_reactivate_form", function (e) {
    // e.preventDefault();
    var _token = $("input[name=_token]").val();
    var lic = $("#lic").val();
    var CustomerNo = $("#CustomerNo").val();

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    if ($("#gen_reactivate_form").valid()) {
        $.ajax({
            url: url + "/SaveReactiveDetails",
            method: "POST",
            data: $("#gen_reactivate_form").serialize(),
            beforeSend: function () {
                $("#divLoading").show(); //show loader
            },
            success: function (data) {
                $("#divLoading").hide(); //hide loader
                if (data.class == "success") {
                    Swal.fire("Good job!", data.msg, data.class);
                    fnSureBlock(lic, CustomerNo, "false");
                } else if (data.class == "error") {
                    Swal.fire("Warning!", data.msg, "warning");
                } else {
                    $("#response_div").empty().html(data);
                    $("#unlockCodeModal").modal("show");
                    $("#response_div table").css("margin-left", "98px");
                    fnSureBlock(lic, CustomerNo, "false");
                }
                $("#genReactivateModal").modal("hide");
                // $("#divLoading").hide(); //hide loader
            },

            error: function (err) {
                // if error occured
                $("#divLoading").hide(); //hide loader
            },
        });
    }
});

function fnSureBlock(lic, CustomerNo, checked) {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    var _token = $('meta[name="csrf-token"]').attr("content");
    $.ajax({
        url: url + "/sureBlockUc",
        method: "POST",
        data: {
            token: _token,
            lic: lic,
            CustomerNo: CustomerNo,
        },
        beforeSend: function () {
            //  $("#divLoading").show(); //show loader
        },
        success: function (data) {
            // if (checked == "true") {
            $.toast({
                heading: data,
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
            // }
        },
        error: function (err) {
            console.log(err);
        },
    });
}

$(document).on("click", ".show_log", function (e) {
    $.ajax({
        url: url + "/show_log",
        method: "get",
        data: {
            serial_no: $(this).data("serial_no"),
        },
        beforeSend: function () {
            $("#divLoading").show(); //show loader
        },
        success: function (data) {
            $(".show_log_modal_body").empty().html(data);
            $("#ShowLogModal").modal("show");
            $("#divLoading").hide(); //hide loader
        },
        error: function (err) {
            // if error occured
            $("#divLoading").hide(); //hide loader
        },
    });
});

var gblReactReq = "";
function matchWithReactRequest(fld, fldType) {
    var txtToFind = fld.innerHTML;
    var txtReplaceBy =
        '<span class="txtMatchedWith"><a id="test">' +
        txtToFind +
        "</a></span>";
    if (gblReactReq == "") {
        gblReactReq = document.getElementById("div_ReactReq").innerHTML;
    }
    if (gblReactReq.indexOf(txtToFind) != -1) {
        var regExp = new RegExp(txtToFind);
        //var regExp = /'+txtToFind+'g/;
        document.getElementById("div_ReactReq").innerHTML = gblReactReq.replace(
            regExp,
            txtReplaceBy
        );
        self.location.hash = "";
        //self.document.location.hash = "#test";
        fld.className = "txtMatched";
        if (
            fldType == "HDD1" ||
            fldType == "HDD2" ||
            fldType == "CDVSN" ||
            fldType == "DDVSN"
        ) {
            document.getElementById("spnReactivate").style.display = "block";
        }
    } else {
        fld.className = "txtNotMatched";
    }
}

function showFetchBtn(lic) {
    $.ajax({
        url: url + "/isAllowedToRewardKey",
        method: "get",
        data: {
            lic: lic,
        },
        beforeSend: function () {},
        success: function (data) {
            if (data) {
                $(".fetchKey").show();
            } else {
                $(".fetchKey").hide();
            }
        },
        error: function (err) {
            console.log(err);
        },
    });
}
