<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection settings
class DbSettings {
    public static $Address = 'localhost';
    public static $Username = 'root';
    public static $Password = 'tiger';
    public static $Schema = 'garage';
}

// =======================================================
//  No configurable settings below this line
// =======================================================

function getSetting($setting) {
    $returnValue = "";

    $con = new mysqli(DbSettings::$Address,DbSettings::$Username,DbSettings::$Password,DbSettings::$Schema);

    if (mysqli_connect_errno()) {
        $returnValue = "ERROR";
    }
    else {
        if ($stmt = $con->prepare("SELECT `Value` FROM Settings WHERE `Key` = ?")) {
            $stmt->bind_param("s", $setting);
            $stmt->execute();
            $stmt->bind_result($outValue);

            while ($stmt->fetch())
            {
                $returnValue = $outValue;
                break; // Only one anyway. Just keeping the while for an example.
            }
        }
    }
    return $returnValue;

    $con->close();
}

// Database connection settings
class Settings {
    public static $garageURL = NULL;
    public static $IftttKey = NULL;
    public static $KnownIntermediaries = NULL;

    public function __construct() {
        if ( (!isset(self::$garageURL)) || (!isset(self::$IftttKey)) || (!isset(self::$KnownIntermediaries)))  {
            self::initializeStStateArr();
        }
    }

    public static function initializeStStateArr() {
        if (!isset(self::$garageURL)) {
            self::$garageURL = getSetting("GarageURL");
        }
        if (!isset(self::$IftttKey)) {
            self::$IftttKey = getSetting("IftttKey");
        }
        if (!isset(self::$KnownIntermediaries)) {
            self::$KnownIntermediaries = getSetting("KnownIntermediaries");
        }
    }
}
Settings::initializeStStateArr();

?>
