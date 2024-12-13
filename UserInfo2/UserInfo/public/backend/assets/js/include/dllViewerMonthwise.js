
$(document).ready(function () {
    getData();
    $(document).on('change','#selectedDate',function(e){
        e.preventDefault();
        var date = $(this).val();
        getData( date);
    })

});

function getData(date) {
    $.ajax({
        url: url + "/getMonthwiseCount",
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
