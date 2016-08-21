<?php 
    include "filename.php";
    
    $fileReader = fopen($filename, "r+") or die("Unable to open file for reading.");
    $status = trim(fread($fileReader,filesize($filename)));
    fclose($fileReader);

    $fileWriter = fopen($filename, "w") or die("Unable to open file for writing.");

    if ($status == "open") {
      fwrite($fileWriter, "closed");
      echo "closed";
    }
    else {
      fwrite($fileWriter, "open");
      echo "open";
    }

    fclose($fileWriter);


    error_reporting(E_ALL);
    exec('gpio -g write 18 off');
    usleep(1000000);
    exec('gpio -g write 18 on');
?>