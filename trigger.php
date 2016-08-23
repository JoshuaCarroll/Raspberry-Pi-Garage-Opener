<?php 
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
        $stmt = $dbConnection->prepare('SELECT `id`,`FirstName`,`LastName`,`ValidStartTime`,`ValidEndTime`,`ValidStartDate`,`ValidEndDate`,`ValidDaysOfWeek` FROM `Garage`.`Users` WHERE `Username` = ? AND `Password` = ?;');
        $stmt->bind_param('ss', $user, $pass);
        $user = $_GET['u'];
        $pass = $_GET['p'];
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = mysqli_fetch_array($result);

            // Check dates
            $str_date = $row["ValidStartDate"];
            $startDate = DateTime::createFromFormat('m/d/Y', $str_date);

            $str_date = $row["ValidEndDate"];;
            $endDate = DateTime::createFromFormat('m/d/Y', $str_date);
            
            $todaysDate = date('m/d/Y');
            
            if ($startDate > $todaysDate) {     
                $error = "You are not approved for access until " . $startDate . ".";
            }
            else {
                if ($todaysDate > $endDate) {
                    $error = "Your access has expired.";
                }
                else {
                    // Check time
                    $str_time = $row["ValidStartTime"];
                    $startTime = DateTime::createFromFormat('H:i:s', $str_time);

                    $str_time = $row["ValidEndTime"];;
                    $endTime = DateTime::createFromFormat('H:i:s', $str_time);
                    
                    $currentTime = date("H:i:s");
                    
                    if ( ($startTime > $currentTime) || ($endTime < $currentTime) ) {
                        $error = "You are not approved for access during this time of day.";
                    }
                    else {
                        // Check days of week
                        $binMask = "";
                        
                        $dayMask = $row["ValidDaysOfWeek"];
                        
                        for ($x=6; $x >= 0; $x--) {
                            if ($dayMask >= 2^x) {
                                $dayMask = $dayMask - (2^x);
                                $binMask = "1" . $binMask;
                            }
                            else {
                                $binMask = "0" . $binMask
                            }
                        }
                        
                        if (substr($binMask, date("N")-1, 1) = 0) {
                            $error = "You are not approved for access on this day of the week."
                        }
                        else {
                            $allowed = true;
                        }
                    }
                }
        }
        else {
            $error = "No record found with that username/password.";
        }
    }

    if ($allowed == true) {
        include "filename.php";
        
        try {
            $fileReader = fopen($filename, "r+")
            $status = trim(fread($fileReader,filesize($filename)));
            fclose($fileReader);
        }
        catch {
            $error = "Unable to open status file for reading.";
        }
        
        if ($error == "") {
            try {
                $fileWriter = fopen($filename, "w");

                if ($status == "open") {
                  fwrite($fileWriter, "closed");
                  $response "closed";
                }
                else {
                  fwrite($fileWriter, "open");
                  $response "open";
                }

                fclose($fileWriter);
            }
            catch {
                $error = "Unable to open status file for writing."
            }
            
            error_reporting(E_ALL);
            exec('gpio -g write 18 off');
            usleep(1000000);
            exec('gpio -g write 18 on');
        }
    }
    elseif ($error == "") {
        $error = "An unspecified error occurred."
    }
        
        
    ///TODO: Write out JSON object    
    
    if ($error != "") {
        
    }
        
    if ($response != "") {
        
    }
        
    ///TODO: Report action to IFTTT
?>