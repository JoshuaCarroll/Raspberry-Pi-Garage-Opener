<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<title>Garage Opener</title>
		<link rel="apple-touch-icon" href="apple-touch-icon-iphone.png" />
		<link rel="apple-touch-icon" sizes="72x72" href="apple-touch-icon-ipad.png" />
		<link rel="apple-touch-icon" sizes="114x114" href="apple-touch-icon-iphone-retina-display.png" />		
		<link rel="stylesheet" href="style.css" type="text/css">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<script type="text/javascript" src="jquery.js"></script>
		<script type="text/javascript" src="script.js"></script>
	</head>
	<body>
        	<form id="form1" runat="server">
        	<div id="divStatus">Garage is <span id="spnStatus"></span>.</div>
        	<div id="divErrors"></div>
		<div id="divTrigger">
        		<button class="btnTrigger" id="btnOpen" data-action="open">Open</button>
			<button class="btnTrigger" id="btnClose" data-action="close" >Close</button>
		</div>
        	<div id="divForce">
			<button id="btnForce" class="btnTrigger"  data-action="force">Force</button>
		</div>
		</form>
	</body>
</html>
