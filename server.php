<?php 
	# This is an unneeded comment

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    include 'utilities.php';

	
	$status = "unknown";

	$gpioValue = exec('gpio -g read 22');

	if ($gpioValue == "1") {
		$status = "open";
		$iftttStatus = "closed";
	}
	elseif ($gpioValue == "0") {
		$status = "closed";
		$iftttStatus = "opened";
	}

	$delay = 1000000;

	if ($_GET['force'] == "true") {
		$delay = 15000000;
	}

	error_reporting(E_ALL);
	exec('gpio -g write 18 off');
	usleep($delay);    
	exec('gpio -g write 18 on');
    
        
    // Write out JSON object    
    echo "{ ";
    echo "\"errorMessage\" : \"" . $error . "\", "; 
    echo "\"status\" : \"" . $status . "\", ";
    echo " }";
        
    // Report action to IFTTT
	$iftttPhrase = "Someone " . $iftttStatus . " the garage door.";
    
    if (Settings::$IftttKey != "") {
        $strApiUrl = "https://maker.ifttt.com/trigger/garage_activated/with/key/" . Settings::$IftttKey . "?value1=" . urlencode($iftttPhrase);
        file_get_contents($strApiUrl);
    }

    ///TODO: Write to a log

?>