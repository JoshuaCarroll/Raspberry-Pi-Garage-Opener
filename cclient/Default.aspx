<%@ Page Language="C#" AutoEventWireup="true" CodeFile="Default.aspx.cs" Inherits="cclient_Default" %>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<title>Garage Opener</title>
		<link rel="apple-touch-icon" href="../apple-touch-icon-iphone.png" />
		<link rel="apple-touch-icon" sizes="72x72" href="../apple-touch-icon-ipad.png" />
		<link rel="apple-touch-icon" sizes="114x114" href="../apple-touch-icon-iphone-retina-display.png" />		
		<link rel="stylesheet" href="../style.css" type="text/css">
		<meta name="apple-mobile-web-app-capable" content="yes">	
		<script type="text/javascript" src="../jquery-1.10.2.min.js"></script>
		<script type="text/javascript">
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
        </script>    
        
	</head>
	<body>
        <form id="form1" runat="server">
        <div id="divStatus">Garage is <span id="spnStatus"></span>.
        </div>
        <div id="divErrors"></div>
		<div id="divTrigger">
            <button id="btnTrigger"> </button>
		</div>
    </form>
	</body>
</html>