$(document).ready(function () {
    $('#btnTrigger').click(function (e) {
        var strUrl = "triggerpuller.ashx";
        $.getJSON(strUrl, processResponse);
        return false;
    });

    $.getJSON("statusgetter.ashx", function (data) {
        $('#spnStatus').text(data.status);
    });
});

function processResponse(data) {
    console.log(data);

    if ((data.status) && (data.status != "")) {
        $("#spnStatus").text(data.status);
    }

    if ((data.errorMessage) && (data.errorMessage != "")) {
        console.log("Error is not empty");
        $("#divErrors").show();
        $("#divErrors").text(data.errorMessage);
    }
    else {
        $("#divErrors").text("");
        $("#divErrors").hide();
    }

    console.log("Response is done being processed");
}  