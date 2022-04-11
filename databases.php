<?php

$server = "127.0.0.1";
$login = "root";
$pass = "root";
$name_db = "test_db";

$link = mysqli_connect($server, $login, $pass, $name_db) or die(mysql_error());

if ($link == False){
	echo "Не подключился";
}?>