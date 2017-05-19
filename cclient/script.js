$(document).ready(function () {
    $('#btnTrigger').click(function (e) {
        var strUrl = "triggerpuller.ashx";
        $.getJSON(strUrl, processResponse);
		button_clicked();
        return false;
    });

    $('#btnForce').click(function (e) {
        if (confirm("This is unsafe. Are you sure?")) {
            var strUrl = "triggerpuller.ashx?force=true";
            $.getJSON(strUrl, processResponse);
			button_clicked();
            return false;
        }
    });

    $.getJSON("statusgetter.ashx", function (data) {
        $('#spnStatus').text(data.status);
    });
});

function button_clicked() {
	if ($("#spnStatus").text() == "open") {
		$("#spnStatus").text("closing");
	}
	else if (status == "closed") {
		$("#spnStatus").text("opening");
	}
	
	setTimeout(function() {
		$.getJSON("statusgetter.ashx", function (data) {
			$('#spnStatus').text(data.status);
		});
	}, 15000);
}

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