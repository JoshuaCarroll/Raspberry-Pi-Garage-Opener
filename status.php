<?php
        
include "filename.php";
$fileReader = fopen($filename, "r+") or die("Unable to open file for reading.");
$status = trim(fread($fileReader,filesize($filename)));
fclose($fileReader);
echo $status;

?>