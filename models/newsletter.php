<?php

// get a list of volume
function data_newsletterVol($parentID){
	$result = "";
	$name = getColumnByLang("name");
	$query = "SELECT id, $name FROM category WHERE parent = $parentID ORDER BY $name DESC";
	$resultset = exec_reader($query);
	while(list($id, $name) = mysql_fetch_array($resultset, MYSQL_NUM)){
		$result[] = array(
			"id" => $id,
			"name" => $name
		);
	}
	return $result;
}

// get a list of issues
function data_newsletterIssue($id){
	$result = "";
	$query = "SELECT name, url FROM newsletter WHERE parentid = $id ORDER BY name";
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