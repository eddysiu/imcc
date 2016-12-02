<?php
function db_update($parentid, $value, $valueColumn){
	$value = addslashes($value);
	$result = 0;
	$query = "UPDATE content SET $valueColumn = \"$value\" WHERE parentid = \"$parentid\"";
	$result = exec_non_query($query);
	return $result;
}

// get a list of album category (e.g. open ceremony)
function db_listOfAlbumCat(){
	$result = "";
	$query = "SELECT id, nameEN FROM category WHERE parent = \"14\"";
	$resultset = exec_reader($query);
	while(list($id, $name) = mysql_fetch_array($resultset, MYSQL_NUM)){
		$result[] = array(
			"id" => $id,
			"name" => $name
		);
	}
	return $result;
}

// get a list of album
function db_listOfAlbum(){
	$result = "";
	$query = "SELECT id, date, title, organizer, parent	FROM album ORDER BY parent, date";
	$resultset = exec_reader($query);
	while(list($id, $date, $title, $organ, $parent) = mysql_fetch_array($resultset, MYSQL_NUM)){
		$result[] = array(
			"id" => $id,
			"date" => $date,
			"title" => $title,
			"organ" => $organ,
			"parent" => $parent
		);
	}
	return $result;
}

function db_addNewAlbum($newCat, $newDate, $newName, $newOrgan){
	$result = 0;
	$query = "INSERT INTO album (date, title, organizer, parent) VALUES (\"$newDate\", \"$newName\", \"$newOrgan\", \"$newCat\");";
	$result = exec_non_query($query);
	return $result;
}

function db_updateAlbum($id, $cat, $name, $organ){
	$result = 0;
	$query = "UPDATE album SET title = \"$name\", organizer = \"$organ\", parent = \"$cat\" WHERE id = \"$id\"";
	$result = exec_non_query($query);
	return $result;
}

function db_del($id){
	$result = "";
	$query = "DELETE FROM album WHERE id = $id;";
	$result = exec_non_query($query);
	return $result;
}


?>