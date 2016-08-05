<?php
$server = "hemesathwd.com";
$db_name = "nathanh_fallout";
$db_user = "nathanh_fallout";
$db_pass = "alpha#99";


	mysql_connect($server, $db_user, $db_pass) or die("Could not connect to server!");
	mysql_select_db($db_name) or die("Could not connect to database!");
?>
