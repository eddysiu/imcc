<?php

// get a list of gallery (e.g. special event)
function data_galleryList($id){
	$result = "";
	$name = getColumnByLang("name");
	$query = "SELECT $name, abbr FROM category WHERE parent = \"$id\"";
	$resultset = exec_reader($query);
	while(list($name, $abbr) = mysql_fetch_array($resultset, MYSQL_NUM)){
		$result[] = array(
			"name" => $name,
			"abbr" => $abbr
		);
	}
	return $result;
}

// get a list of album
function data_albumList($id){
	$result = "";
	$query = "SELECT title, date, organizer FROM album WHERE parent = \"$id\"";
	$resultset = exec_reader($query);
	while(list($title, $date, $organizer) = mysql_fetch_array($resultset, MYSQL_NUM)){
		$result[] = array(
			"title" => $title,
			"date" => $date,
			"organizer" => $organizer
		);
	}
	return $result;
}

// to check is the album is a valid album 
function int_albumExist($album){
	$result = "";
	$query = "SELECT count(id) FROM album WHERE date = \"$album\"";
	$result = exec_scalar($query);
	return $result;
}

// get the title, organizer and parentid
function data_albumDetails($album){
	$result = "";
	$query = "SELECT title, organizer, parent FROM album WHERE date = \"$album\"";
	$resultset = exec_reader($query);
	while(list($title, $organizer, $parent) = mysql_fetch_array($resultset, MYSQL_NUM)){
		$result[] = array(
			"title" => $title,
			"organizer" => $organizer,
			"parent" => $parent
		);
	}
	return $result;
}

// get the album catagory (e.g. seminar) by id
function data_albumCategory($parentid){
	$result = "";
	$name = getColumnByLang("name");
	$query = "SELECT $name FROM category WHERE id = \"$parentid\"";
	$result = exec_scalar($query);
	return $result;
}

?>