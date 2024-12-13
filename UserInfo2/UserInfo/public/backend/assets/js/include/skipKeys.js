$(document).ready(function () {
    $(document).on("submit", "#skipKeysForm", function (e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        var licNo = $("#LicNo").val();
        var reason = $("#reason").val();

        if (licNo.length == 0 || reason.length == 0) {
            Swal.fire(
                "Warning..!!!",
                "Please fill all required fields..!",
                "warning"
            );
        } else {
            $.ajax({
                url: url + "/skipKeysFormData",
                method: "post",
                data: $(this).closest("#skipKeysForm").serialize(),
                beforeSend: function () {
                    $("#divLoading").show(); //show loader
                },
                success: function (data) {
                    if (data.status == true) {
                        $("#skipKeysForm")[0].reset();

                        var msg = data.message;
                        var icon = "success";
                    } else {
                        var msg = data.message;
                        var icon = "error";
                    }

                    $.toast({
                        heading: msg,
                        icon: icon,
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

                    $("#divLoading").hide(); //hide loader
                },
                error: function (err) {
                    // if error occured
                    $("#divLoading").hide(); //hide loader
                },
            });
        }
    });

    $(document).on("submit", "#h2lSkipKeysForm", function (e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        var licNo = $("#h2l_licNo").val();
        var reason = $("#h2l_reason").val();

        if (licNo.length == 0 || reason.length == 0) {
            Swal.fire(
                "Warning..!!!",
                "Please fill all required fields..!",
                "warning"
            );
        } else {
            $.ajax({
                url: url + "/h2lSkipKeysInsert",
                method: "post",
                data: $(this).closest("#h2lSkipKeysForm").serialize(),
                dataType: "json",
                beforeSend: function () {
                    $("#divLoading").show(); //show loader
                },
                success: function (data) {
                    // console.log(data)
                    if (data.status == true) {
                        $("#h2lSkipKeysForm")[0].reset();

                        var msg = data.message;
                        var icon = "success";
                    } else {
                        var msg = data.message;
                        var icon = "error";
                    }
                    $("#h2lSkipKeysForm")[0].reset();
                    $.toast({
                        heading: msg,
                        icon: icon,
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

                    $("#divLoading").hide(); //hide loader
                },
                error: function (err) {
                    // if error occured
                    $("#divLoading").hide(); //hide loader
                },
            });
        }
    });
});
