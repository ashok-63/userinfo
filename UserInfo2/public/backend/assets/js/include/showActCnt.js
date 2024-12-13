$(document).ready(function () {
    var startDate = $("#startDate").val();
    var endDate = $("#endDate").val();
    getActCount();

    $(document).on("click", "#showCount", function (e) {
        e.preventDefault();

        var startDate = $("#startDate").val();
        var endDate = $("#endDate").val();

        getActCount(startDate, endDate);
    });

    /***
     *
     * District Wise Counter
     *
     */

    $(document).on("click", ".DistrictWiseCnt", function (e) {
        e.preventDefault();

        var custState = $(this).data("custstate");
        var startDate = $("#startDate").val();
        var endDate = $("#endDate").val();

        // console.log(custState);
        // console.log(startDate);
        // console.log(endDate);

        districtWiseCnt(startDate, endDate, custState);
    });
});

function getActCount(startDate, endDate) {
    var startDate = $("#startDate").val();
    var endDate = $("#endDate").val();

    $.ajax({
        url: url + "/getStateWiseActCnt",
        method: "get",
        data: {
            startDate: startDate,
            endDate: endDate,
        },
        beforeSend: function () {
            $("#divLoading").show(); //show loader
        },
        success: function (data) {
            // console.log(data);
            $("#statewisecounter").empty().html(data);
            $("#statewisecnt").DataTable({
                info: false,
                paging: false,
                searching: false,
                layout: {
                    topStart: {
                        buttons: ["excel", "pdf", "print"],
                    },
                },
            });

            $(".dt-layout-row").addClass("mx-2");

            if (endDate == "") {
                var txt = "Showing Data of date >=" + startDate;
                $("#info").text(txt);
            } else {
                var txt = "Showing Data from " + startDate + " To " + endDate;
                $("#info").text(txt);
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

function districtWiseCnt(startDate, endDate, custState) {
    $.ajax({
        url: url + "/getDistrictWiseActCnt",
        method: "get",
        data: {
            startDate: startDate,
            endDate: endDate,
            custState: custState,
        },
        beforeSend: function () {
            $("#divLoading").show(); //show loader
        },
        success: function (data) {
            console.log(data);
            $(".DistrictWiseCntModel").modal("show");
            $("#DistrictWiseCntData").empty().html(data);

            if (endDate == "") {
                var txt = custState + ": Showing Data of date >=" + startDate;
                $("#info_dist").text(txt);
            } else {
                var txt =
                    custState +
                    ": Showing Data from " +
                    startDate +
                    " To " +
                    endDate;
                $("#info_dist").text(txt);
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
