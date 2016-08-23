<?php

// Database connection settings
class DbSettings {
    public static $Address = '127.0.0.1';
    public static $Username = 'root';
    public static $Password = 'tiger';
    public static $Schema = 'weather';
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
        $result = $con->query("SELECT Value FROM Settings WHERE Key = '$setting' ");
        if( !$result ) {
          $returnValue = "";
        }
        else {
          $returnValue = $result->fetch_object()->VALUE;
        }
    }
    return $returnValue;
}

// Database connection settings
class Settings {
    public static $garageURL = NULL;
    
    public function __construct() {
        if ( (!isset(self::$garageURL)) )  {
            self::initializeStStateArr();
        }
    }

    public static function initializeStStateArr() {
        if (!isset(self::$garageURL)) {
            self::$showMetricAndCelsiusMeasurements = getSetting("GarageURL");
        }
    }
}
Settings::initializeStStateArr();

?>