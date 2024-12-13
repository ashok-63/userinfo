$(document).ready(function () {
    $(".datepickr").flatpickr({
        defaultDate: "today",
        // dateFormat: "Y-m-d",
        dateFormat: "D, d-M-Y",
        maxDate: "today",
    });

    var date = $("#date").val();
    getData(date);

    $(document).on("change", "#date", function (e) {
        e.preventDefault();
        var date = $("#date").val();
        getData(date);
    });
});

function getData(date) {
    $.ajax({
        url: url + "/getUserwiseReactCnt",
        method: "get",
        data: { date: date },
        beforeSend: function () {
            $("#divLoading").show(); //show loader
        },
        success: function (data) {
            // console.log(data);
            $("#dataviewer").empty().html(data);

            // $("#reactivationtable").DataTable({

            //     saveState: true,
            //     paging:false
            // });

            $("#divLoading").hide(); //hide loader
        },
        error: function (err) {
            console.log(err);
            // if error occured
            $("#divLoading").hide(); //hide loader
        },
    });
}
