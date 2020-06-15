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

	// Write out JSON object
	echo "{ ";
	echo "\"errorMessage\" : \"" . $error . "\", "; 
	echo "\"status\" : \"" . $status . "\", ";
        echo "\"action\" : \"" . $action . "\" ";
	echo " }";

	///TODO: Write to a log

?>
