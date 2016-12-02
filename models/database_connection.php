<?php
// database config
$database = "imcc";
$user = "root";
// $password = "";
$password = "admin@IMCClms";
$hostname = 'localhost';
$port = 3306;

// connect to the database
$conn = mysql_connect($hostname, $user, $password, $port) or die ('Error connecting to MySQL!');
mysql_select_db($database,$conn);
mysql_query("SET NAMES UTF8");
date_default_timezone_set('Asia/Hong_Kong');

// return a result set from the database
function exec_reader($query) {
	global $conn;
	$resultset = mysql_query($query, $conn);
	return $resultset;
}

// return the number of affected rows from the database
function exec_non_query($query) {
	global $conn;
	$resultset = mysql_query($query, $conn);
	$result = mysql_affected_rows();
	return $result;
}

// return a single value from the database
function exec_scalar($query) {
	global $conn;
	$resultset = mysql_query($query, $conn);
	
	$result = 0;
	if (mysql_error() != "") {
		$result = -1;
	} else {
		$fields = mysql_fetch_row($resultset);
		$result = $fields[0];
	}
	return $result;
}
?>