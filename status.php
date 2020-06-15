<?php

$status = exec("/var/www/html/dev/garage.sh status 2>&1");

echo "{ \"status\" : \"" . $status . "\"}";

?>
