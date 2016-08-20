<?php 
    echo "PHP running";
    error_reporting(E_ALL);
    exec('gpio -g write 18 off');
    usleep(1000000);
    exec('gpio -g write 18 on');
?>

Done