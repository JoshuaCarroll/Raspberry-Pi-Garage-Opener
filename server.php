<?php 
	# This is an unneeded comment

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	include 'utilities.php';

	$error="";
	$status="";
	$action=$_GET['action'];

	if ($action != "") {
		$status=exec("/var/www/html/dev/garage.sh ".$action." 2>&1");
	}

	if ($action != "rss") {
		// Write out JSON object
		echo "{ ";
		echo "\"errorMessage\" : \"" . $error . "\", "; 
		echo "\"status\" : \"" . $status . "\", ";
	        echo "\"action\" : \"" . $action . "\" ";
		echo " }";
		///TODO: Write to a log
	}
	else {
?>
<?xml version="1.0" encoding="utf-8"?><rss version="2.0"> 
<channel>
<title>Garage status</title> 
<link>http:\/\/www.mywebsite.com</link>
<description></description>
<pubDate>Thu, 1 May 2008 17:03:32 -0800</pubDate>
<lastBuildDate>Thu, 1 May 2008 17:03:32 -0800</lastBuildDate>
<item><title><?= $status ?></title> <link>http:\/\/www.mywebsite.com</link>
<description>Garage status</description> <pubDate>Thu, 1 May 2008 17:03:32 -0800</pubDate>
</item></channel></rss>
<?php
	}

?>
