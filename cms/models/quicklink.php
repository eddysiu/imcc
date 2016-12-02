<?php
// get a list of volume
function data_link(){
	$result = "";
	$query = "SELECT id, image, url, displayorder, shown FROM quicklink ORDER BY displayorder";
	$resultset = exec_reader($query);
	while(list($id, $image, $url, $order, $shown) = mysql_fetch_array($resultset, MYSQL_NUM)){
		$result[] = array(
			"id" => $id,
			"image" => $image,
			"url" => $url,
			"order" => $order,
			"shown" => $shown
		);
	}
	return $result;
}

function db_addLink($link, $image, $order){
	$result = 0;
	$query = "INSERT INTO quicklink (url, image, displayorder, shown) VALUES (\"$link\", \"$image\", \"$order\", \"1\");";
	$result = exec_non_query($query);
    return $result;
}

function db_updateLink($id, $url, $image, $order, $shown){
	$result = 0;
	$query = "UPDATE quicklink SET url=\"$url\",  image=\"$image\", displayorder=\"$order\", shown=\"$shown\" WHERE id = $id;";
	$result = exec_non_query($query);
    return $result;
}

function db_delLinks($id){
	$result = 0;
	$query = "DELETE FROM quicklink WHERE id = $id;";
	$result = exec_non_query($query);
	return $result;
}
?>