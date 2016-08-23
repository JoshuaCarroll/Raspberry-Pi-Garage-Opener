<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'utilities.php';

?><!DOCTYPE html>
<html>
	<head>
		<title>Garage Opener</title>
		<link rel="apple-touch-icon" href="apple-touch-icon-iphone.png" />
		<link rel="apple-touch-icon" sizes="72x72" href="apple-touch-icon-ipad.png" />
		<link rel="apple-touch-icon" sizes="114x114" href="apple-touch-icon-iphone-retina-display.png" />		
		<link rel="stylesheet" href="style.css" type="text/css">
		<meta name="apple-mobile-web-app-capable" content="yes">	
		<script type="text/javascript" src="jquery-1.10.2.min.js"></script>    
		<script type="text/javascript">
            var garageURL = "<?php echo Settings::$garageURL; ?>";
            
            $(document).ready(function() {
                $('#btnTrigger').click(function(e) {
                    var strUrl = garageURL + "trigger.php?u=" + $("#txtUsername").val() + "&p=" + $("#txtPassword").val();
                    $.get(strUrl, function(objResponse) {
                        $("#spnStatus").html(objResponse.status);
                        if (objResponse.error) {
                            $("#divErrors").html(objResponse.error);
                            $("#divErrors").show();
                        }
                        else {
                            $("#divErrors").html("");
                            $("#divErrors").hide();
                        }
                    });
                });
                
                $.getJSON(garageURL + "status.php", function(result){
                    $('#spnStatus').html = result.status;
                });
            });
        </script>    
        
	</head>
	<body>
        <div id="divStatus">Garage is <span id="spnStatus"></span>.
        </div>
        <div id="divErrors"></div>
        <div>
            <input watermark="Username" type="text" id="txtUsername" name="username"><br>
            <input watermark="Password" type="password" id="txtPassword" name="password">
        </div>
		<div>
            <button id="btnTrigger"> </button>
		</div>
	</body>
</html>