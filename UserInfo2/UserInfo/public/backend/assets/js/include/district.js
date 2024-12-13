$(document).ready(function () {
    getData();

    $(document).on("submit", "#districtForm", function (e) {
        e.preventDefault();

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        $.ajax({
            url: url + "/addDistFormDate",
            method: "post",
            data: $(this).closest("#districtForm").serialize(),
            beforeSend: function () {
                $("#divLoading").show(); //show loader
            },
            success: function (data) {
                if (data.status == "success") {
                    getData();

                    Swal.fire("Success..!!!", data.message, "success");

                    $("#districtForm")[0].reset();
                } else {
                    Swal.fire("Error..!!!", data.message, "error");
                }

                $("#divLoading").hide(); //hide loader
            },
            error: function (err) {
                $("#divLoading").hide(); //hide loader
            },
        });
    });

    $(document).on(
        "click",
        ".btnEdit_contactdetails , .btnCancel_contactdetails",
        function (e) {
            e.preventDefault();
            $(this)
                .parents("td")
                .siblings("td.contact_details")
                .children("span")
                .toggleClass("d-none");
            $(this).parents("span").toggleClass("d-none");
            $(this).parents("span").siblings("span").toggleClass("d-none");
        }
    );

    $(document).on("click", ".btnSave_contactdetails", function (e) {
        var distid = $(this).data("did");

        var DISTRICT = $(this)
            .parents("td")
            .siblings("td.contact_details")
            .find("input[id=DISTRICT]")
            .val();

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        var token = $('meta[name="csrf-token"]').attr("content");

        $.ajax({
            url: url + "/updateDist",
            method: "post",
            data: {
                token: token,
                distid: distid,

                DISTRICT: DISTRICT,
            },
            beforeSend: function () {
                $("#divLoading").show(); //show loader
            },
            success: function (data) {
                if (data.status == "success") {
                    Swal.fire("Success..!!!", data.message, "success");
                } else {
                    Swal.fire("Error..!!!", data.message, "error");
                }
                getData();
                $("#divLoading").hide(); //hide loader
            },
            error: function (err) {
                console.log(err);
                // if error occured
                $("#divLoading").hide(); //hide loader
            },
        });
    });
});
function getData(page) {
    $.ajax({
        url: url + "/getAllDistricts",
        method: "get",
        data: {
            page: page,
        },
        beforeSend: function () {
            $("#divLoading").show(); //show loader
        },
        success: function (data) {
            // console.log(data);
            $("#distviewer").empty().html(data);
            $("#disttable").DataTable({
                pageLength: 100,
                stateSave: true,
            });

            $("#divLoading").hide(); //hide loader
        },
        error: function (err) {
            console.log(err);
            // if error occured
            $("#divLoading").hide(); //hide loader
        },
    });
}
