$(document).ready(function (e) {
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
    $(document).on("submit", "#dealerRegForm", function (e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            url: url + "/dealerRegister",
            method: "post",
            data: $(this).closest("#dealerRegForm").serialize(),
            beforeSend: function () {
                $("#divLoading").show(); //show loader
            },
            success: function (data) {
                if (data.class == "success") {
                    Swal.fire("Success..!!!", data.msg, "success");
                } else {
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
    $(document).on("change", "#mobileNo", function (e) {
        e.preventDefault();
        var value = $(this).val();
        var type = "mob";
        checkDupl(value, type);
    });
    $(document).on("change", "#emailId", function (e) {
        e.preventDefault();
        var value = $(this).val();
        var type = "email";
        checkDupl(value, type);
    });
});
function checkDupl(value, type) {
    $.ajax({
        url: url + "/getDlrCode",
        method: "get",
        data: {
            value: value,
            type: type,
        },
        beforeSend: function () {
            $("#msg").empty();
            $("#checking").removeClass("d-none");
        },
        success: function (data) {
            $("#msg").empty().text(data);
        },
        complete: function () {
            // $("#msg").empty();
            $("#checking").addClass("d-none");
        },
        error: function (err) {
            console.log(err);
        },
    });
}
