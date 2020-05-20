<?php
//whoever using this dbh, it should be defined 
if(!defined("IN_CODE")){
	die("not an entry point");
}

$server="server name (ex localhost)";
$login="user name (ex root)";
$password="password";
$dbname="database name";

//connect to mySQL database
$con= mysqli_connect($server, $login, $password, $dbname)
OR die('Could not connect to MySQL'.
		mysqli_connect_error());


?>
