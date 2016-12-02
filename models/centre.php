<?php

// get a list of research
function data_researchList(){
	$result = "";
	$query = "SELECT value FROM publication WHERE type=\"research\" ORDER BY displayorder";
	$resultset = exec_reader($query);
	while(list($item) = mysql_fetch_array($resultset, MYSQL_NUM)){
		$result[] = array(
			"item" => $item
		);
	}
	return $result;
}
// get a list of paper
function data_paperList(){
	$result = "";
	$query = "SELECT value FROM publication WHERE type=\"paper\" ORDER BY displayorder";
	$resultset = exec_reader($query);
	while(list($item) = mysql_fetch_array($resultset, MYSQL_NUM)){
		$result[] = array(
			"item" => $item
		);
	}
	return $result;
}
?>