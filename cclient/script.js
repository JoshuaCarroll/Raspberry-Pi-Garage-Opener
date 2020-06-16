$(document).ready(function () {
    $('#btnTrigger').click(function (e) {
        button_clicked();
        var strUrl = "triggerpuller.ashx";
        $.getJSON(strUrl, processResponse);
        return false;
    });

    $('#btnForce').click(function (e) {
        if (confirm("This is unsafe. Are you sure?")) {
            button_clicked();
            var strUrl = "triggerpuller.ashx?force=true";
            $.getJSON(strUrl, processResponse);
            return false;
        }
    });

    $.getJSON("statusgetter.ashx", function (data) {
        $('#spnStatus').text(data.status);
    });
});

var statusTimer = null;

function button_clicked() {
	if ($("#spnStatus").text() == "open") {
		$("#spnStatus").text("closing");
	}
	else if ($("#spnStatus").text() == "closed") {
		$("#spnStatus").text("opening");
	}
	
	statusTimer = setTimeout(function() {
		$.getJSON("statusgetter.ashx", function (data) {
			$('#spnStatus').text(data.status);
			statusTimer = null;
		});
	}, 15000);
	blink();
}

function blink() {
	if (statusTimer) {
		$('#divStatus').fadeOut(500).fadeIn(500, blink);
	}
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