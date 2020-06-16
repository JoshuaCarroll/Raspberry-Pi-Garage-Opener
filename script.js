$(document).ready(function () {
	$.getJSON("server.php?action=status", processResponse);

	$('.btnTrigger').click(function (e) {
		button_click(this);
		return false;
    	});
});

var statusTimer = null;

function button_click(caller) {
	var action = $(caller).attr("data-action");

	if((action == "force") && (!confirm("Are you sure?\n\nThis can be dangerous if anything is under the door."))){ 
		return false;
	}

	$("#spnStatus").text(getVerb(action));

	statusTimer = setTimeout(function() {
		$.getJSON("server.php?action=status", function (data) {
		$('#spnStatus').text(data.status);
		statusTimer = null;
	});}, 15000);

	blink();

	$.getJSON("server.php?action=" + action);
}

function blink() {
	if (statusTimer) {
		$('#divStatus').fadeOut(500).fadeIn(500, blink);
	}
}

function getVerb(strAction) {
	switch (strAction) {
		case "open":
			return "opening";
		case "close":
		case "force":
			return "closing";
	}
}

function processResponse(data) {
	console.log("processResponse");
	console.log(data);

	if ((data.status) && (data.status != "")) {
		$("#spnStatus").text(data.status);
	}

	if ((data.errorMessage) && (data.errorMessage != "")) {
		$("#divErrors").show();
		$("#divErrors").text(data.errorMessage);
	}
	else {
		$("#divErrors").text("");
		$("#divErrors").hide();
	}

	console.log("Response is done being processed");
}
