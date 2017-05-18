<?php
        
#include "filename.php";
#$fileReader = fopen($filename, "r+") or die("Unable to open file for reading.");
#$status = trim(fread($fileReader,filesize($filename)));
#fclose($fileReader);

$status = "unknown";

$gpioValue = exec('gpio -g read 22');

if ($gpioValue == "0") {
	$status = "open";
}
elseif ($gpioValue == "1") {
	$status = "closed";
}

echo "{ \"status\" : \"" . $status . "\" }";

?>