<?php
define ('DB_USER', "root");
define ('DB_PASSWORD', "root");
define ('DB_DATABASE', "social_login");
define ('DB_HOST', "localhost");
GLOBAL $mysqli;
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
?>