<?php

// get a list of news
function data_news($tab){
	$result = "";
	$query = "SELECT id, startdate, enddate, title, source, content, expandable FROM news WHERE type = \"$tab\" ORDER BY startdate DESC, enddate DESC";
	$resultset = exec_reader($query);
	while(list($id, $start, $end, $title, $source, $content, $isExpand) = mysql_fetch_array($resultset, MYSQL_NUM)){
		$result[] = array(
			"id" => $id,
			"start" => $start,
			"end" => $end,
			"title" => $title,
			"source" => $source,
			"content" => $content,
			"isExpand" => $isExpand
		);
	}
	return $result;
}

// get the content of news by id
function data_newsContent($id){
	$result = "";
	$query = "SELECT content FROM news WHERE id = \"$id\";";
	$result = exec_scalar($query);
	return $result;
}
// get the content of news by id
function data_isExpandable($id){
	$result = "";
	$query = "SELECT expandable FROM news WHERE id = \"$id\";";
	$result = exec_scalar($query);
	return $result;
}

?>