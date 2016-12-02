<?php

// get a list of links
function getLinkList($parentid){
	$list = "";
	$query = "SELECT id, local, name, url FROM link WHERE parentid = \"$parentid\" ORDER BY local DESC, name";
        $resultset = exec_reader($query);
	while(list($id, $local, $name, $url) = mysql_fetch_array($resultset, MYSQL_NUM)){
		$list[] = array(
			"id" => $id,
			"local" => $local,
			"name" => $name,
			"url" => $url
		);
	}
	return $list;
}

// edit 
function db_update($id, $local, $name, $url){
	//$value = addslashes($value);
	$result = 0;
	$query = "UPDATE link SET local= \"$local\", name=\"$name\", url=\"$url\" WHERE id = $id;";
	$result = exec_non_query($query);
	return $result;
}

function db_delLink($id){
	$result = 0;
	$query = "DELETE FROM link WHERE id = $id;";
	$result = exec_non_query($query);
	return $result;
}

function db_addLink($local, $name, $url, $parentid){
	$result = 0;
	$query = "INSERT INTO link (local, name, url, parentid) VALUES (\"$local\", \"$name\", \"$url\", \"$parentid\");";
	$result = exec_non_query($query);
	return $result;
}
?>