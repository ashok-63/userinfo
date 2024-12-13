$(document).ready(function () {
    $(document).on("submit", "#blockKeysForm", function (e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        var licNo = $("#licNo_blockkey").val();
        var reason = $("#reason").val();
        var password = $("#password").val();

        if (licNo.length == 0 || reason.length == 0 || password.length == 0) {
            Swal.fire(
                "Warning..!!!",
                "Please fill all required fields..!",
                "warning"
            );
        } else {
            $.ajax({
                url: url + "/blockKeysFormData",
                method: "post",
                data: $(this).closest("#blockKeysForm").serialize(),
                beforeSend: function () {
                    $("#divLoading").show(); //show loader
                },
                success: function (data) {
                    // console.log(data);
                    if (data.Status == "error") {
                        $(".info").addClass("d-none");
                        Swal.fire("Error..!!!", data.msg, "error");
                    }
                    if (data) {
                        $("#blockKeyData").empty().html(data);
                        $(".info").removeClass("d-none");
                    }
                    $("#divLoading").hide(); //hide loader
                },
                error: function (err) {
                    // if error occured
                    //     sweetAlert("Oops...", 'Something is Wrong. Please Try Again', "error");
                    $("#divLoading").hide(); //hide loader
                },
            });
        }
    });
});
