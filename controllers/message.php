<?php

// get topics
function getTopics(){
	$topics = "";
	$topics = data_topics();
	return $topics;
}

// get the display format of author
function getPostAuthor($name, $email){
/* 	$author = "";
	if ($email != ""){
		$author = "<a href=\"mailto: $email\">$name</a>";
	} else {
		$author = $name;
	} */
	return $name;
}

// get number of replies of the topic
function getNoOfReply($id){
	$reply = 0;
	$reply = int_noOfReply($id);
	return $reply;
}

// get the details of the topic (top post only)
function getTopicDetails($id){
	$details = "";
	$details = data_topicDetails($id);
	return $details;
}

// get the replies of the topic
function getTopicReply($id){
	$reply = "";
	$reply = data_topicReply($id);
	return $reply;
}

// check is it a valid topic id
function isValidTopic($topicID){
	$isValid = false;
	$result = int_checkValidTopic($topicID);
	if ($result > 0){
		$isValid = true;
	}
	return $isValid;
}

// check is it a valid new post (for submission(
function isValidNewPost($name, $email, $title, $content){
	$isValid = false;
	if (($name != "") && ($title != "") && ($content != "")){
		$isValid = true;
	}
	return $isValid;
}


function insertNewPost($name, $email, $title, $content){
	$result;
	$currentDatetime = date('Y-m-d H:i:s');
	$name = addslashes($name);
	$email = addslashes($email);
	$title = addslashes($title);
	$content = nl2br(addslashes($content));
	$result = int_addNewPost($name, $email, $title, $content, $currentDatetime);
	return $result;
}

function replyPost($name, $email, $title, $content, $parentid){
	$result;
	$currentDatetime = date('Y-m-d H:i:s');
	$name = addslashes($name);
	$email = addslashes($email);
	$title = addslashes($title);
	$content = addslashes($content);
	$result = int_replyPost($name, $email, $title, $content, $currentDatetime, $parentid);
	return $result;
}
?>