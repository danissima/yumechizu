<?php

$db_host = 'yumechizu';
$db_user = 'root';
$db_password = '';
$db_name = 'yume_chizu';

$mysqli = new mysqli($db_host, $db_user, $db_password, $db_name);
$mysqli->query("SET NAMES 'utf-8'");

if ($mysqli->connect__errno) {
	echo 'oshibka u tebya, dura4ok';
}

?>