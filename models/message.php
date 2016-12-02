<?php

// get a list of approved topics
function data_topics(){
	$result = "";
	$query = "SELECT id, name, email, title, msgdate, lastreply FROM messageboard WHERE parentid = \"0\" AND approval = \"1\" ORDER BY lastreply DESC";
	$resultset = exec_reader($query);
	while(list($id, $name, $email, $title, $msgdate, $lastreply) = mysql_fetch_array($resultset, MYSQL_NUM)){
		$result[] = array(
			"id" => $id,
			"name" => $name,
			"email" => $email,
			"title" => $title,
			"msgdate" => $msgdate,
			"lastreply" => $lastreply
		);
	}
	return $result;
}

// get the number of reply
function int_noOfReply($id){
	$result = "";
	$query = "SELECT count(parentid) FROM messageboard WHERE parentid = \"$id\" AND approval = \"1\";";
	$result = exec_scalar($query);
	return $result;
}

// get the details of the topic
function data_topicDetails($id){
	$result = "";
	$query = "SELECT name, email, title, msgdate, content FROM messageboard WHERE id = \"$id\" AND approval = \"1\";";
	$resultset = exec_reader($query);
	while(list($name, $email, $title, $msgdate, $content) = mysql_fetch_array($resultset, MYSQL_NUM)){
		$result[] = array(
			"name" => $name,
			"email" => $email,
			"title" => $title,
			"msgdate" => $msgdate,
			"content" => $content
		);
	}
	return $result;
}

// get the replies of the topic
function data_topicReply($id){
	$result = "";
	$query = "SELECT name, email, title, msgdate, content FROM messageboard WHERE parentid = \"$id\" AND approval = \"1\";";
	$resultset = exec_reader($query);
	while(list($name, $email, $title, $msgdate, $content) = mysql_fetch_array($resultset, MYSQL_NUM)){
		$result[] = array(
			"name" => $name,
			"email" => $email,
			"title" => $title,
			"msgdate" => $msgdate,
			"content" => $content
		);
	}
	return $result;
}

// check is the topic id valid or not
function int_checkValidTopic($topicID){
	$result = "";
	$query = "SELECT count(id) FROM messageboard WHERE approval = \"1\" AND parentid = \"0\" AND id = \"$topicID\"";
	$result = exec_scalar($query);
	return $result;
}

function int_addNewPost($name, $email, $title, $content, $currentDatetime){
	$result = "";
	$query = "INSERT INTO messageboard (name, email, title, content, approval, shown, msgdate, lastreply, parentid) VALUES (\"$name\", \"$email\", \"$title\", \"$content\", \"0\", \"1\", \"$currentDatetime\", \"$currentDatetime\", \"0\") ";
	$result = exec_non_query($query);
	return $result;
}

function int_replyPost($name, $email, $title, $content, $currentDatetime, $parentid){
	$result = "";
	$query = "INSERT INTO messageboard (name, email, title, content, approval, shown, msgdate, parentid) VALUES (\"$name\", \"$email\", \"$title\", \"$content\", \"0\", \"1\", \"$currentDatetime\", \"$parentid\") ";
	$result = exec_non_query($query);
	return $result;
}
?>