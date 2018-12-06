<?php

require_once(__DIR__.'/config.php');

ini_set("display_errors","On");

session_start();

echo "<pre>";print_r($_SESSION);

?>