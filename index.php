<!DOCTYPE html>
<html>
	<head>
		<title>Garage Opener</title>
		<link rel="apple-touch-icon" href="apple-touch-icon-iphone.png" />
		<link rel="apple-touch-icon" sizes="72x72" href="apple-touch-icon-ipad.png" />
		<link rel="apple-touch-icon" sizes="114x114" href="apple-touch-icon-iphone-retina-display.png" />		
		<link rel="stylesheet" href="css/style.css" type="text/css">
		<meta name="apple-mobile-web-app-capable" content="yes">	
		<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>    
		<script type="text/javascript" src="js/script.js"></script>    

	</head>
	<body>
        <div id="divStatus">Garage is <span id="spnStatus"><?php
            
include "filename.php";
$fileReader = fopen($filename, "r+") or die("Unable to open file for reading.");
$status = trim(fread($fileReader,filesize($filename)));
fclose($fileReader);
echo $status;
            
?></span>.
        </div>
		<div>
            <button id="btnTrigger"> </button>
		</div>
	</body>
</html>