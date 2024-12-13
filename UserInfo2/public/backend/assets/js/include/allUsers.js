$(document).ready(function () {
    var startDate = $("#startDate").val();
    var endDate = $("#endDate").val();
    getData();

    /** Toggle Pass */

    $(document).on("click", ".togglePass", function (e) {
        e.preventDefault();

        $(this).toggleClass("fa-eye  fa-eye-slash");

        var type = $(this).siblings("input").prop("type");

        if (type === "password") {
            $(this).siblings("input").prop("type", "text");
        } else {
            $(this).siblings("input").prop("type", "password");
        }
    });

    /** Change User Pass  */

    $(document).on("click", ".openChangePassModal", function (e) {
        e.preventDefault();
        var username = $(this).data("username");
        var id = $(this).data("id");
        var password = $(this).data("password");
        $("#ChangePassModal").modal("show");
        $(".username").val(username);
        $("#oldPass").val(password);
        $("#id").val(id);
    });

    $(document).on("submit", "#ChangePassForm", function (e) {
        e.preventDefault();

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        $.ajax({
            url: url + "/changeUserPass",
            method: "post",
            data: $(this).closest("#ChangePassForm").serialize(),
            beforeSend: function () {
                $("#divLoading").show(); //show loader
            },
            success: function (data) {
                if (data.class == "success") {
                    getData();
                    $("#ChangePassForm")[0].reset();
                    $("#ChangePassModal").modal("hide");
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

    /**
     * Status
     */

    $(document).on("click", ".Status", function (e) {
        // e.preventDefault();
        if (
            confirm(
                "Are you sure user set " +
                    ($(this).prop("checked") ? "active" : "inactive") +
                    " !"
            )
        ) {
            var username = $(this).data("username");
            var status = $(this).prop("checked") ? "1" : " ";
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
            });
            var token = $('meta[name="csrf-token"]').attr("content");

            $.ajax({
                url: url + "/updateUserStatus",
                method: "post",
                data: {
                    token: token,
                    username: username,
                    status: status,
                },
                beforeSend: function () {
                    $("#divLoading").show(); //show loader
                },
                success: function (data) {
                    // console.log(data);

                    if (data.class == "success") {
                        getData();
                        Swal.fire("Success..!!!", data.msg, "success");
                    } else {
                        Swal.fire("Error..!!!", data.msg, "error");
                    }

                    $("#divLoading").hide(); //hide loader
                },
                error: function (err) {
                    console.log(err);
                    // if error occured
                    $("#divLoading").hide(); //hide loader
                },
            });
        }
        getData();
    });

    /**
     * Edit Users
     */

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
        var User_Name = $(this).data("username");
        var Mobile = $(this)
            .parents("td")
            .siblings("td.contact_details")
            .find("input[id=Mobile]")
            .val();
        var Email = $(this)
            .parents("td")
            .siblings("td.contact_details")
            .find("input[id=Email]")
            .val();
        // console.log(Mobile)

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        var token = $('meta[name="csrf-token"]').attr("content");

        $.ajax({
            url: url + "/updateContactDetails",
            method: "post",
            data: {
                token: token,
                User_Name: User_Name,
                Mobile: Mobile,
                Email: Email,
            },
            beforeSend: function () {
                $("#divLoading").show(); //show loader
            },
            success: function (data) {
                if (data.class == "success") {
                    getData();
                    Swal.fire("Success..!!!", data.msg, "success");
                } else {
                    Swal.fire("Error..!!!", data.msg, "error");
                }

                $("#divLoading").hide(); //hide loader
            },
            error: function (err) {
                console.log(err);
                // if error occured
                $("#divLoading").hide(); //hide loader
            },
        });
    });

    $(document).on("click", ".btnDelete_user", function (e) {
        var User_Name = $(this).data("username");
        var id = $(this).data("id");



        Swal.fire({
            title: "Do you really want to delete this user ? Once user is deleted it can not be recovered.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#ec4561",
            confirmButtonText: "Yes, I am sure!",
            cancelButtonText: "No, cancel it!",
            closeOnConfirm: false,
            closeOnCancel: false,
        }).then((result) => {
            if (result["isConfirmed"]) {
                $.ajax({
                    url: url + "/deleteUser",
                    method: "get",
                    data: {
                        id: id,
                        User_Name: User_Name,
                    },
                    beforeSend: function () {
                        $("#divLoading").show(); //show loader
                    },
                    success: function (data) {
                        if (data.class == "success") {
                            getData();
                            Swal.fire("Success..!!!", data.msg, "success");
                        } else {
                            Swal.fire("Error..!!!", data.msg, "error");
                        }
                    },
                    complete: function () {
                        $("#divLoading").hide(); //hide loader
                    },
                    error: function (err) {
                        $("#divLoading").hide(); //hide loader
                    },
                });
            }
        });
    });

    /**
     * Add User
     */

    $(document).on("submit", "#AddUsers_form", function (e) {
        e.preventDefault();

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        $.ajax({
            url: url + "/AddUser",
            method: "post",
            data: $(this).closest("#AddUsers_form").serialize(),
            beforeSend: function () {
                $("#divLoading").show(); //show loader
            },
            success: function (data) {
                if (data.class == "success") {
                    getData();
                    $("#AddUserModal").modal("hide");
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
});

$(document).on("click", "#indexTablePagination a", function (event) {
    event.preventDefault();
    $("li").removeClass("active");
    $(this).parent("li").addClass("active");
    var url = $(this).attr("href");
    var page = $(this).attr("href").split("page=")[1];

    getData(page);
});

function getData(page) {
    $.ajax({
        url: url +"/getAllUsers",
        method: "get",
        data: {
            page: page,
        },
        beforeSend: function () {
            $("#divLoading").show(); //show loader
        },
        success: function (data) {
            // console.log(data);
            $("#statewisecounter").empty().html(data);

            $("#usersTable").DataTable({
                pageLength: 100,
                saveState: true,
            });

            $("#usersTable_length").addClass("d-none");
            $("input[type=search]").addClass("form-control");
            $("#divLoading").hide(); //hide loader
        },
        error: function (err) {
            console.log(err);
            // if error occured
            $("#divLoading").hide(); //hide loader
        },
    });
}
