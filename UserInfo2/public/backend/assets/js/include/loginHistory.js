$(document).ready(function () {
    getData();
});

function getData(page) {
    $.ajax({
        url: url+"/getUserActivity",
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
                pageLength: 50,
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
