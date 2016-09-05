<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'utilities.php';

if ((isset($_COOKIE["u"])) && (isset($_COOKIE["p"]))) {
    $user = $_COOKIE["u"];
    $pass = $_COOKIE["p"];
}
elseif ((isset($_GET["u"])) && (isset($_GET["p"]))) {
    $user = $_GET["u"];
    $pass = $_GET["p"];
}

$strUrl = Settings::$garageURL . "trigger.php?u=" . $user . "&p=" . $pass;
$strResponse = file_get_contents($strUrl);
echo $strResponse;

?>