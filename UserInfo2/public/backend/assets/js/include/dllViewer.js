var page = 1;
$(document).ready(function () {
    getData(page);
    $(document).on('change','#selectedDate',function(e){
        e.preventDefault();
        var date = $(this).val();
        getData(page , date);
    })

});

$(document).on("click", "#indexTablePagination a", function (event) {
    event.preventDefault();
    $("li").removeClass("active");
    $(this).parent("li").addClass("active");
    var url = $(this).attr("href");
    var page = $(this).attr("href").split("page=")[1];

    getData(page);
});

function getData(page ,date) {
    $.ajax({
        url: url + "/getRecords",
        method: "get",
        data: {

            date: date,
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
