<?php 

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $allowed = false;
    $error = "";
    $response = "";

    // Check username, password, and time
    include 'utilities.php';

    $con = new mysqli(DbSettings::$Address,DbSettings::$Username,DbSettings::$Password,DbSettings::$Schema);

    // Check connection
    if (mysqli_connect_errno()) {
        $error = "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    else {
        // prepare and bind
        $stmt = $con->prepare('SELECT `id`,`FirstName`,`LastName`,`ValidStartTime`,`ValidEndTime`,`ValidStartDate`,`ValidEndDate`,`ValidDaysOfWeek`,`Password` FROM `Garage`.`Users` WHERE `Username` = ?;');
        $stmt->bind_param('s', $user);
        $user = $_GET['u'];
        $stmt->execute();
        $stmt->bind_result($outId, $outFirstName, $outLastName, $outValidStartTime, $outValidEndTime, $outValidStartDate, $outValidEndDate, $outValidDaysOfWeek, $outPassword);
        
        if ($stmt->fetch()) {
            //Check password
            if (md5($outPassword) != $_GET["p"]) {
                $error = "No record found with that username/password.";
            }
            else {
                // Check dates
                $str_date = $outValidStartDate;
                $startDate = DateTime::createFromFormat('m/d/Y', $str_date);

                $str_date = $outValidEndDate;
                $endDate = DateTime::createFromFormat('m/d/Y', $str_date);
                
                $str_time = $outValidStartTime;
                $startTime = DateTime::createFromFormat('H:i:s', $str_time);

                $str_time = $outValidEndTime;
                $endTime = DateTime::createFromFormat('H:i:s', $str_time);
            
                $todaysDate = date('m/d/Y');
            
                if ($startDate > $todaysDate) {     
                    $error = $startDate . " > " . $todaysDate . "  You are not approved for access until " . $startDate->format('l, M d, Y') . " at " . $startTime->format('g:i a') . ".";
                }
                else {
                    if ($todaysDate > $endDate) {
                        $error = "Your access expired on " . $endDate->format('l, M d, Y') . " at " . $endTime->format('g:i a') . ".";
                    }
                    else {
                        // Check time
                        $currentTime = date("H:i:s");
                        
                        if ( ($startTime > $currentTime) || ($endTime < $currentTime) ) {
                            $error = "You are only approved for access between " . $startTime->format('g:i a') . " and " . $endTime->format('g:i a') . ".";
                        }
                        else {
                            // Check days of week
                            $binMask = "";
                        
                            $dayMask = $outValidDaysOfWeek;
                        
                            for ($x=6; $x >= 0; $x--) {
                                if ($dayMask >= 2^x) {
                                    $dayMask = $dayMask - (2^x);
                                    $binMask = "1" . $binMask;
                                }
                                else {
                                    $binMask = "0" . $binMask;
                                }
                            }
                            
                            $dayNumber = date("w");
                            $strThisDayPermission = substr($binMask, $dayNumber, 1);
                            
                            if ($strThisDayPermission = 0) {
                                $error = "You are not approved for access on this day of the week.";
                            }
                            else {
                                $allowed = true;
                            }
                        }
                    }
                }
            }
        }
        else {
            $error = "No record found with that username.";
        }
    }

    if ($allowed == true) {
        include "filename.php";
        
        try {
            $fileReader = fopen($filename, "r+");
            $status = trim(fread($fileReader,filesize($filename)));
            fclose($fileReader);
        }
        catch (Exception $e) {
            $error = "Unable to open status file for reading. Door status incorrect. Continuing...";
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
            
            error_reporting(E_ALL);
            exec('gpio -g write 18 off');
            usleep(1000000);
            exec('gpio -g write 18 on');
        }
    }
    elseif ($error == "") {
        $error = "An unspecified error occurred.";
    }
        
        
    ///TODO: Write out JSON object    
    echo "{ ";
    echo "\"error\" : \"" . $error . "\","; 
    echo "\"status\" : \"" . $response . "\"";
    echo "}";
        
    ///TODO: Report action to IFTTT
?>