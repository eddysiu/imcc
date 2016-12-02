<?php
// get a list of album
function db_listOfAlbum(){
	$result = "";
	$query = "SELECT date, title	FROM album ORDER BY date";
	$resultset = exec_reader($query);
	while(list($date, $title) = mysql_fetch_array($resultset, MYSQL_NUM)){
		$result[] = array(
			"date" => $date,
			"title" => $title
		);
	}
	return $result;
}

?>