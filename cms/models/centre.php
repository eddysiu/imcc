<?php
function db_update($parentid, $value, $valueColumn){
	$value = addslashes($value);
	$result = 0;
	$query = "UPDATE content SET $valueColumn = \"$value\" WHERE parentid = \"$parentid\"";
	$result = exec_non_query($query);
	return $result;
}


// get a list of pubs
function getPubList(){
	$list = "";
	$query = "SELECT id, type, value, displayorder FROM publication ORDER BY type, displayorder";
        $resultset = exec_reader($query);
	while(list($id, $type, $value, $displayorder) = mysql_fetch_array($resultset, MYSQL_NUM)){
		$list[] = array(
			"id" => $id,
			"type" => $type,
			"value" => $value,
			"displayorder" => $displayorder
		);
	}
	return $list;
}

// edit 

function db_updatePub($id, $type, $value, $displayorder){
	$value = addslashes($value);
	$result = 0;
	$query = "UPDATE publication SET type= \"$type\", value=\"$value\", displayorder=\"$displayorder\" WHERE id = $id;";
	$result = exec_non_query($query);
	return $result;
}

function db_delPub($id){
	$result = 0;
	$query = "DELETE FROM publication WHERE id = $id;";
	$result = exec_non_query($query);
	return $result;
}

function db_addPub($type, $value, $displayorder){
	$result = 0;
	$query = "INSERT INTO publication (type, value, displayorder) VALUES (\"$type\", \"$value\", \"$displayorder\");";
	$result = exec_non_query($query);
	return $result;
}
?>