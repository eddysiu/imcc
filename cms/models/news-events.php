<?php
function db_add($startDate, $endDate, $type, $title, $source, $content, $shown, $expandable){
	$result = 0;
	$query = "INSERT INTO news (startdate, enddate, type, title, source, content, shown, expandable) VALUES (\"$startDate\", \"$endDate\", \"$type\", \"$title\", \"$source\", \"$content\", \"$shown\", \"$expandable\");";
	$result = exec_non_query($query);
	return $result;
}

function db_update($id, $startDate, $endDate, $title, $source, $content, $isExpand, $shown){
	$result = 0;
	$query = "UPDATE news SET startdate = \"$startDate\", enddate = \"$endDate\", title = \"$title\", source = \"$source\", content = \"$content\", shown = \"$shown\", expandable = \"$isExpand\" WHERE id = \"$id\"";
	$result = exec_non_query($query);
	return $result;
}

function db_del($id){
	$result = "";
	$query = "DELETE FROM news WHERE id = $id;";
	$result = exec_non_query($query);
	return $result;
}

// get a list of news
function data_news($tab){
	$result = "";
	$query = "SELECT id, startdate, enddate, title, source, content, expandable, shown FROM news WHERE type = \"$tab\" ORDER BY startdate DESC, enddate DESC";
	$resultset = exec_reader($query);
	while(list($id, $start, $end, $title, $source, $content, $isExpand, $isShown) = mysql_fetch_array($resultset, MYSQL_NUM)){
		$result[] = array(
			"id" => $id,
			"start" => $start,
			"end" => $end,
			"title" => $title,
			"source" => $source,
			"content" => $content,
			"isExpand" => $isExpand,
			"isShown" => $isShown,
		);
	}
	return $result;
}

// check is it a link or HTML code
function data_isExpandable($id){
	$result = "";
	$query = "SELECT expandable FROM news WHERE id = \"$id\";";
	$result = exec_scalar($query);
	return $result;
}

// get the details of the news by id
function data_newsDetails($id){
	$result = "";
	$query = "SELECT startdate, enddate, title, source, content, expandable, shown FROM news WHERE id = \"$id\"";
	$resultset = exec_reader($query);
	while(list($start, $end, $title, $source, $content, $isExpand, $isShown) = mysql_fetch_array($resultset, MYSQL_NUM)){
		$result[] = array(
			"start" => $start,
			"end" => $end,
			"title" => $title,
			"source" => $source,
			"content" => $content,
			"isExpand" => $isExpand,
			"isShown" => $isShown,
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
?>