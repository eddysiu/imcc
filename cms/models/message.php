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

// get a list of posts which are waiting for approval
function data_waitingList(){
	$result = "";
	$query = "SELECT id, name, email, title, content, msgdate, parentid FROM messageboard WHERE approval = \"0\" AND shown = \"1\" ORDER BY msgdate";
	$resultset = exec_reader($query);
	while(list($id, $name, $email, $title, $content, $msgdate, $parentid) = mysql_fetch_array($resultset, MYSQL_NUM)){
		$result[] = array(
			"id" => $id,
			"name" => $name,
			"email" => $email,
			"title" => $title,
			"content" => $content,
			"msgdate" => $msgdate,
			"parentid" => $parentid
		);
	}
	return $result;
}

// get a list of posts which were approved
function data_approvedList(){
	$result = "";
	$query = "SELECT id, name, email, title, content, msgdate, parentid FROM messageboard WHERE approval = \"1\" AND shown = \"0\" ORDER BY msgdate";
	$resultset = exec_reader($query);
	while(list($id, $name, $email, $title, $content, $msgdate, $parentid) = mysql_fetch_array($resultset, MYSQL_NUM)){
		$result[] = array(
			"id" => $id,
			"name" => $name,
			"email" => $email,
			"title" => $title,
			"content" => $content,
			"msgdate" => $msgdate,
			"parentid" => $parentid
		);
	}
	return $result;
}

// get a list of posts which were unapproved
function data_unapprovedList(){
	$result = "";
	$query = "SELECT id, name, email, title, content, msgdate, parentid FROM messageboard WHERE approval = \"0\" AND shown = \"0\" ORDER BY msgdate";
	$resultset = exec_reader($query);
	while(list($id, $name, $email, $title, $content, $msgdate, $parentid) = mysql_fetch_array($resultset, MYSQL_NUM)){
		$result[] = array(
			"id" => $id,
			"name" => $name,
			"email" => $email,
			"title" => $title,
			"content" => $content,
			"msgdate" => $msgdate,
			"parentid" => $parentid
		);
	}
	return $result;
}

// update the post to become approved / unapproved
function db_updateWaitingPost($id, $shown, $approval){
	$result = "";
	$query = "UPDATE messageboard SET shown = \"$shown\", approval = \"$approval\" WHERE id = \"$id\"";
	$result = exec_non_query($query);
	return $result;
}

// update the last reply
function db_updateLastReply($msgdate, $parentid){
	$result = "";
	$query = "UPDATE messageboard SET lastreply = \"$msgdate\" WHERE id = \"$parentid\"";
	$result = exec_non_query($query);
	return $result;
}

// update the status
function db_reapprovePost($id, $approval){
	$result = "";
	$query = "UPDATE messageboard SET approval = \"$approval\" WHERE id = \"$id\"";
	$result = exec_non_query($query);
	return $result;
}

// get the details of the post for edit mode
function data_postDetails($id){
	$result = "";
	$query = "SELECT name, email, title, content, msgdate FROM messageboard WHERE id = \"$id\"";
	$resultset = exec_reader($query);
	while(list($name, $email, $title, $content, $msgdate) = mysql_fetch_array($resultset, MYSQL_NUM)){
		$result[] = array(
			"name" => $name,
			"email" => $email,
			"title" => $title,
			"content" => $content,
			"msgdate" => $msgdate
		);
	}
	return $result;
}

// update post
function db_updatePost($id, $name, $email, $title, $content){
	$result = 0;
	$query = "UPDATE messageboard SET name = \"$name\", email = \"$email\", title = \"$title\", content = \"$content\" WHERE id = \"$id\"";
	$result = exec_non_query($query);
	return $result;
}

// get only one detail of the post
function data_postOneDetail($id, $column){
	$result = "";
	$query = "SELECT $column FROM messageboard WHERE id = \"$id\";";
	$result = exec_scalar($query);
	return $result;
}

// get a list of reply id which belong to a specfic topic
function data_getTopicReplyIDs($id){
	$result = "";
	$query = "SELECT id FROM messageboard WHERE parentid = \"$id\";";
	$resultset = exec_reader($query);
	while(list($id) = mysql_fetch_array($resultset, MYSQL_NUM)){
		$result[] = array(
			"id" => $id
		);
	}
	return $result;
}

function db_del($id){
	$result = "";
	$query = "DELETE FROM messageboard WHERE id = $id;";
	$result = exec_non_query($query);
	return $result;
}
?>