$(document).ready(function () {
    try {
        $(".select2").select2();
    } catch (err) {
        console.log("s2 err");
    }

    /**Get District on Change States */
    $(document).on("change", "#state", function (e) {
        var stateId = $(this).val();
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            url: url + "/getDistricts",
            method: "get",
            data: {
                stateId: stateId,
            },
            success: function (data) {
                // console.log(data);
                var options = "";
                var options = "<option value=''>Select District</option>";
                $.each(data, function (key, value) {
                    options +=
                        "<option value=" +
                        value.dID +
                        ">" +
                        value.DISTRICT +
                        "</option>";
                });
                $("#dist").empty().html(options);
            },
            error: function (err) {
                console.log(err);
            },
        });
    });
    $(document).on("click", ".showBtn", function (e) {
        e.preventDefault();
        var stateName = $("#state :selected").text();
        var stateId = $("#state").val();
        var distName = $("#dist :selected").text();
        var distId = $("#dist").val();
        var totalMonths = $("#totalMonths").val();
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        $.ajax({
            url: url + "/getGraphData",
            method: "get",
            data: {
                stateName: stateName,
                distName: distName,
                totalMonths: totalMonths,
                stateId: stateId,
                distId: distId,
            },
            beforeSend: function () {
                $("#divLoading").show(); //show loader
            },
            success: function (data) {
                // console.log(data);
                if (data.Status == "error") {
                    Swal.fire("Error..!!!", data.msg, "error");
                }
                if (data.Status != "error") {
                    var tr = "";
                    var total = 0;
                    var montharr = new Array();
                    var countarr = new Array();
                    $.each(data, function (k, v) {
                        total += v.totActivations;
                        tr +=
                            "<tr><td>" +
                            v.MonthName +
                            "</td><td>" +
                            v.totActivations +
                            "</td></tr>";
                        montharr.push(v.MonthName);
                        countarr.push(v.totActivations);
                    });
                    tr += "<tr><th>Total</th><th>" + total + "</th></tr>";
                    $("#tbody").empty().html(tr);
                    $("#responseData").removeClass("d-none");
                    $("#graph").empty().html(' <canvas id="myChart"></canvas>');
                    const ctx = document.getElementById("myChart");
                    var myChart = new Chart(ctx, {
                        type: "bar",
                        data: {
                            labels: montharr,
                            datasets: [
                                {
                                    label: "Monthly Activations",
                                    data: countarr,
                                    borderWidth: 0.5,
                                },
                            ],
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true,
                                },
                            },
                        },
                    });
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
