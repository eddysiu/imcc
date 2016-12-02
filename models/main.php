<?php

// get the "News and Event" title
function data_indexNewsTitle(){
	$result = "";
	$name = getColumnByLang("name");
	$query = "SELECT $name FROM category WHERE abbr = \"news-events\"";
	$result = exec_scalar($query);
	return $result;	
}

// get a list of news
function data_news(){
	$result = "";
	$query = "SELECT id, startdate, enddate, title, source, content, expandable FROM news WHERE shown = \"1\" ORDER BY startdate DESC, enddate DESC";
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

// get quick link
function data_quickLinks(){
	$result = "";
	$query = "SELECT image, url FROM quicklink WHERE shown = \"1\" ORDER BY displayorder LIMIT 4";
	$resultset = exec_reader($query);
	while(list($img, $url) = mysql_fetch_array($resultset, MYSQL_NUM)){
		$result[] = array(
			"img" => $img,
			"url" => $url
		);
	}
	return $result;
}

?>