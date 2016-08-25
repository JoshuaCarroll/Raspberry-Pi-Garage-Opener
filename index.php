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
        <script type="text/javascript" src="md5.js"></script>
		<script type="text/javascript">
            var garageURL = "<?php echo Settings::$garageURL; ?>";
            
            $(document).ready(function() {
                $('#btnTrigger').click(function(e) {
                    var strUrl = garageURL + "trigger.php?u=" + $("#txtUsername").val() + "&p=" + CryptoJS.MD5($("#txtPassword").val());
                    $.getJSON(strUrl, function(data) {
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
                    });
                });
                
                $.getJSON(garageURL + "status.php", function(data){
                    $('#spnStatus').text(data.status);
                });
            });
            
            function logout() {
                document.cookie = "u=;expires=Wed 01 Jan 1970";
                document.cookie = "p=;expires=Wed 01 Jan 1970";
                document.cookie = "user=;expires=Wed 01 Jan 1970";
                location.reload();
            }
        </script>    
        
	</head>
	<body>
        <div id="divStatus">Garage is <span id="spnStatus"></span>.
        </div>
        <div id="divErrors"></div>
        <div id="divLogin">
<?php
    if ((isset($_COOKIE["u"])) && (isset($_COOKIE["p"]) && (isset($_COOKIE["name"])) {
        $user = $_COOKIE["u"];
        $pass = $_COOKIE["p"];
        $name = $_COOKIE["name"];
        
        echo '<input type="hidden" id="txtUsername" name="username" value="' . $user . '">&nbsp;';
        echo '<input type="hidden" id="txtPassword" name="password" value="' . $pass . '">';
        echo $name . "&nbsp;<button onclick='logout()'>Logout</button>";
    }
    else {
        echo '<input placeholder="Username" type="text" id="txtUsername" name="username">&nbsp;';
        echo '<input placeholder="Password" type="password" id="txtPassword" name="password">';
    }
?>
            
        </div>
		<div>
            <button id="btnTrigger"> </button>
		</div>
	</body>
</html>