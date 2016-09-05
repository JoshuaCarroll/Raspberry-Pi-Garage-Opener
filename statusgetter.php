<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'utilities.php';

$strUrl = Settings::$garageURL . "status.php";
$strResponse = file_get_contents($strUrl);
echo $strResponse;

?>