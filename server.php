<?php 

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    include 'utilities.php';
    include "filename.php";

    try {
        $fileReader = fopen($filename, "r+");
        $status = trim(fread($fileReader,filesize($filename)));
        fclose($fileReader);
    }
    catch (Exception $e) {
        $error = "Unable to open status file for reading. Door status incorrect. Moving on...";
    }

    if ($error == "") {
        try {
            $fileWriter = fopen($filename, "w");

            if ($status == "open") {
              fwrite($fileWriter, "closed");
              $response = "closed";
            }
            else {
              fwrite($fileWriter, "open");
              $response = "open";
            }

            fclose($fileWriter);
        }
        catch (Exception $e) {
            $error = "Unable to open status file for writing. Door status incorrect. Continuing...";
        }

        $delay = 1000000;
        
        if ($_GET['force'] == "true") {
            $delay = 15000000;
        }
        
        error_reporting(E_ALL);
        exec('gpio -g write 18 off');
        usleep($delay);    
        exec('gpio -g write 18 on');
    }
        
    // Write out JSON object    
    echo "{ ";
    echo "\"errorMessage\" : \"" . $error . "\", "; 
    echo "\"status\" : \"" . $response . "\", ";
    echo " }";
        
    // Report action to IFTTT
    $value1 = "activated";
    $value2 = "someone";
    $value3 = $error;
    
    if (Settings::$IftttKey != "") {
        $strApiUrl = "https://maker.ifttt.com/trigger/garage_activated/with/key/" . Settings::$IftttKey . "?value1=" . urlencode($value1) . "&value2=" . urlencode($value2) . "&value3=" . urlencode($value3);
        file_get_contents($strApiUrl);
    }

    ///TODO: Write to a log

?>