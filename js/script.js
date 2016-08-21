$(document).ready(function() {
	$('#btnTrigger').click(function(e) {
        $.get("trigger.php", function(data) {
            $("#spnStatus").html(data);
        });
	});
});
