<?php

// get a list of local links
function data_localLinks($parentID){
	$result = "";
	$query = "SELECT name, url FROM link WHERE parentid = $parentID AND local = 1 ORDER BY name";
	$resultset = exec_reader($query);
	while(list($name, $url) = mysql_fetch_array($resultset, MYSQL_NUM)){
		$result[] = array(
			"name" => $name,
			"url" => $url
		);
	}
	return $result;
}
// get a list of non-local links
function data_nonLocalLinks($parentID){
	$result = "";
	$query = "SELECT name, url FROM link WHERE parentid = $parentID AND local = 0 ORDER BY name";
	$resultset = exec_reader($query);
	while(list($name, $url) = mysql_fetch_array($resultset, MYSQL_NUM)){
		$result[] = array(
			"name" => $name,
			"url" => $url
		);
	}
	return $result;
}

?>