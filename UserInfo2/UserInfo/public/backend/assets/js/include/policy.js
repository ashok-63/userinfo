$(document).ready(function () {
    $(document).on("change", ".polAction", function (e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        var actionVal = $(this).val();
        var id = $(this).attr("id");

        if (id == "MH_Action") {
            var polName = $("#MH_PolName").val();
        } else if (id == "GJ_Action") {
            var polName = $("#GJ_PolName").val();
        } else if (id == "MP_Action") {
            var polName = $("#MP_PolName").val();
        } else if ((id = "#Dhule_Action")) {
            var polName = $("#Dhule_PolName").val();
        }else{
            var polName = $("#RJ_PolName").val();
        }

        if (actionVal.length == 0) {
            Swal.fire("Warning..!!!", "Select Policy..!", "warning");
        } else {
            Swal.fire({
                title: "Do you really want to update policy?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#ec4561",
                confirmButtonText: "Yes!",
                cancelButtonText: "No!",
                closeOnConfirm: false,
                closeOnCancel: false,
            }).then((result) => {
                if (result["isConfirmed"]) {
                    var token = $('meta[name="csrf-token"]').attr("content");

                    $.ajax({
                        url: url + "/updatePolicy",
                        method: "post",
                        data: {
                            token: token,
                            actionVal: actionVal,
                            polName: polName,
                        },
                        beforeSend: function () {
                            $("#divLoading").show(); //show loader
                        },
                        success: function (data) {
                            if (data.status == true) {
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
                        },
                        complete: function () {
                            $("#divLoading").hide(); //hide loader
                        },
                        error: function (err) {
                            // if error occured
                            $("#divLoading").hide(); //hide loader
                        },
                    });
                }
            });
        }
    });
});
