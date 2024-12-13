$(document).ready(function () {


    getData();


});

function getData() {
    $.ajax({
        url: url + "/compterNameWiseCnt",
        method: "get",
        data: {  },
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
