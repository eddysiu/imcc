<?php
// get a list of volume
function data_newsletterVol($parentID){
	$result = "";
	$name = getColumnByLang("name");
	$query = "SELECT id, $name FROM category WHERE parent = $parentID ORDER BY $name";
	$resultset = exec_reader($query);
	while(list($id, $name) = mysql_fetch_array($resultset, MYSQL_NUM)){
		$result[] = array(
			"id" => $id,
			"name" => $name
		);
	}
	return $result;
}

// get a list of newsletter
function getNewsletterList($parentid){
	$list = "";
        $query = "SELECT id, name, url FROM newsletter WHERE parentid = \"$parentid\"";
	$resultset = exec_reader($query);
	while(list($id, $name, $url) = mysql_fetch_array($resultset, MYSQL_NUM)){
		$list[] = array(
			"id" => $id,
			"name" => $name,
			"url" => $url
		);
	}
        return $list;
}

// edit
function db_update($id, $name, $url){
	//$value = addslashes($value);
	$result = 0;
	$query = "UPDATE newsletter SET name=\"$name\", url=\"$url\" WHERE id = $id;";
	$result = exec_non_query($query);
	return $result;
}

function db_delLink($id){
	$result = 0;
	$query = "DELETE FROM newsletter WHERE id = $id;";
	$result = exec_non_query($query);
	return $result;
}

function db_addLink($name, $url, $parentid){
	$result = 0;
	$query = "INSERT INTO newsletter (name, url, parentid) VALUES (\"$name\", \"$url\", \"$parentid\");";
	$result = exec_non_query($query);
    	return $result;
}

function db_addVolume($name, $parentid){
	$result = 0;
	$query = "INSERT INTO category (nameEN, nameTW, nameCN, parent, defaulttab) VALUES (\"$name\", \"$name\", \"$name\", \"$parentid\", \"0\");";
	$result = exec_non_query($query);
    return $result;
}

function db_updateVolume($id, $name){
	$result = 0;
	$query = "UPDATE category SET nameEN=\"$name\",  nameTW=\"$name\", nameCN=\"$name\" WHERE id = $id;";
	$result = exec_non_query($query);
    return $result;
}

function db_delVolume($id){
	$result = 0;
	$query = "DELETE FROM category WHERE id = $id;";
	$result = exec_non_query($query);
	return $result;
}
?>