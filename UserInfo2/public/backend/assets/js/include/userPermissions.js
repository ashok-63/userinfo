$(document).ready(function () {
    getData();
    /**
     * Check All Row
     */
    $(document).on("click", ".checkAll", function (e) {
        if ($(this).prop("checked")) {
            $(this)
                .parents("td")
                .siblings("td")
                .find("input")
                .prop("checked", true);
        } else {
            $(this)
                .parents("td")
                .siblings("td")
                .find("input")
                .prop("checked", false);
        }
    });
    /**
     * Grant Access
     */
    $(document).on("click", ".grantAccess", function (e) {
        e.preventDefault();
        var username = $(this).data("username");
        var NewAct = $(this)
            .parents("td")
            .siblings("td")
            .find("#NewAct")
            .prop("checked")
            ? "1"
            : "0";
        var DlrScore = $(this)
            .parents("td")
            .siblings("td")
            .find("#DlrScore")
            .prop("checked")
            ? "1"
            : "0";
        var MyAct = $(this)
            .parents("td")
            .siblings("td")
            .find("#MyAct")
            .prop("checked")
            ? "1"
            : "0";
        var PriceList = $(this)
            .parents("td")
            .siblings("td")
            .find("#PriceList")
            .prop("checked")
            ? "1"
            : "0";
        var DlrReg = $(this)
            .parents("td")
            .siblings("td")
            .find("#DlrReg")
            .prop("checked")
            ? "1"
            : "0";
        var DlrActCount = $(this)
            .parents("td")
            .siblings("td")
            .find("#DlrActCount")
            .prop("checked")
            ? "1"
            : "0";
        var OnlinePurchasePDF = $(this)
            .parents("td")
            .siblings("td")
            .find("#OnlinePurchasePDF")
            .prop("checked")
            ? "1"
            : "0";
        var AndroidAct = $(this)
            .parents("td")
            .siblings("td")
            .find("#AndroidAct")
            .prop("checked")
            ? "1"
            : "0";
        var Articles = $(this)
            .parents("td")
            .siblings("td")
            .find("#Articles")
            .prop("checked")
            ? "1"
            : "0";
        var AddDays = $(this)
            .parents("td")
            .siblings("td")
            .find("#AddDays")
            .prop("checked")
            ? "1"
            : "0";
        var TechSupportNo = $(this)
            .parents("td")
            .siblings("td")
            .find("#TechSupportNo")
            .prop("checked")
            ? "1"
            : "0";
        var SendEmail = $(this)
            .parents("td")
            .siblings("td")
            .find("#SendEmail")
            .prop("checked")
            ? "1"
            : "0";
        var FindOrder = $(this)
            .parents("td")
            .siblings("td")
            .find("#FindOrder")
            .prop("checked")
            ? "1"
            : "0";
        var StateActCnt = $(this)
            .parents("td")
            .siblings("td")
            .find("#StateActCnt")
            .prop("checked")
            ? "1"
            : "0";
        var ActGraph = $(this)
            .parents("td")
            .siblings("td")
            .find("#ActGraph")
            .prop("checked")
            ? "1"
            : "0";
        var UpdDlrInfo = $(this)
            .parents("td")
            .siblings("td")
            .find("#UpdDlrInfo")
            .prop("checked")
            ? "1"
            : "0";
        var BlockKeys = $(this)
            .parents("td")
            .siblings("td")
            .find("#BlockKeys")
            .prop("checked")
            ? "1"
            : "0";
        var ScratchKeys = $(this)
            .parents("td")
            .siblings("td")
            .find("#ScratchKeys")
            .prop("checked")
            ? "1"
            : "0";
        var ReleaseKeys = $(this)
            .parents("td")
            .siblings("td")
            .find("#ReleaseKeys")
            .prop("checked")
            ? "1"
            : "0";
        var APKSMS = $(this)
            .parents("td")
            .siblings("td")
            .find("#APKSMS")
            .prop("checked")
            ? "1"
            : "0";
        var LastActs = $(this)
            .parents("td")
            .siblings("td")
            .find("#LastActs")
            .prop("checked")
            ? "1"
            : "0";
        var Kayako = $(this)
            .parents("td")
            .siblings("td")
            .find("#Kayako")
            .prop("checked")
            ? "1"
            : "0";
        var changeIP = $(this)
            .parents("td")
            .siblings("td")
            .find("#changeIP")
            .prop("checked")
            ? "1"
            : "0";
        var ManageUsers = $(this)
            .parents("td")
            .siblings("td")
            .find("#ManageUsers")
            .prop("checked")
            ? "1"
            : "0";
        var OTPmaster = $(this)
            .parents("td")
            .siblings("td")
            .find("#OTPmaster")
            .prop("checked")
            ? "1"
            : "0";
        var LoginHistory = $(this)
            .parents("td")
            .siblings("td")
            .find("#LoginHistory")
            .prop("checked")
            ? "1"
            : "0";
        var UserPermission = $(this)
            .parents("td")
            .siblings("td")
            .find("#UserPermission")
            .prop("checked")
            ? "1"
            : "0";
        var PndReq = $(this)
            .parents("td")
            .siblings("td")
            .find("#PndReq")
            .prop("checked")
            ? "1"
            : "0";
        var ConvertLic = $(this)
            .parents("td")
            .siblings("td")
            .find("#ConvertLic")
            .prop("checked")
            ? "1"
            : "0";

        // console.log(username);
        // return;
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        var token = $('meta[name="csrf-token"]').attr("content");
        $.ajax({
            url: url + "/grantAccess",
            method: "post",
            data: {
                token: token,
                username: username,
                NewAct: NewAct,
                DlrScore: DlrScore,
                OnlinePurchasePDF: OnlinePurchasePDF,
                DlrActCount: DlrActCount,
                DlrReg: DlrReg,
                PriceList: PriceList,
                MyAct: MyAct,
                DlrScore: DlrScore,
                BlockKeys: BlockKeys,
                ScratchKeys: ScratchKeys,
                ReleaseKeys: ReleaseKeys,
                APKSMS: APKSMS,
                LastActs: LastActs,
                Kayako: Kayako,
                changeIP: changeIP,
                ManageUsers: ManageUsers,
                LoginHistory: LoginHistory,
                UserPermission: UserPermission,
                AndroidAct: AndroidAct,
                Articles: Articles,
                AddDays: AddDays,
                TechSupportNo: TechSupportNo,
                SendEmail: SendEmail,
                FindOrder: FindOrder,
                StateActCnt: StateActCnt,
                ActGraph: ActGraph,
                UpdDlrInfo: UpdDlrInfo,
                OTPmaster: OTPmaster,
                PndReq: PndReq,
                ConvertLic: ConvertLic,
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
    });

    /**
     *
     * Sticky Columns Using Dynamic Width start
     *
     *  */
    // var Window_width = $(window).width();

    // var lastScrollLeft = 0;
    // $(window).scroll(function () {
    //     var documentScrollLeft = $(document).scrollLeft();
    //     if (lastScrollLeft != documentScrollLeft) {

    //             $(document).find("#usersTable .fixedCol").css("left", 0);

    //             $(".fixedCol").css({
    //                 position: "sticky",

    //                 left: 10,
    //             });

    //         lastScrollLeft = documentScrollLeft;
    //     }
    // });

    $(document).on("click", ".syncUsersBtn", function (e) {
        e.preventDefault();
        $.ajax({
            url: url + "/syncNewUsers",
            method: "get",
            data: {},
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
            },
            complete: function () {
                $("#divLoading").hide(); //hide loader
            },
            error: function (err) {
                console.log(err);
                // if error occured
            },
        });
    });
});
function getData(page) {
    $.ajax({
        url: url + "/getPermissionData",
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
                stateSave: true,
            });
            $("#usersTable_length").addClass("d-none");
            $("#usersTable_filter").css({
                position: "sticky",
                float: "left",
                left: "0%",
            });
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
