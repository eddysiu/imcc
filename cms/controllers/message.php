<?php
// get a list of posts which are waiting for approval
function getWaitingList(){
	$list = "";
	$list = data_waitingList();
	return $list;
}

// get a list of posts which were approved
function getApprovedList(){
	$list = "";
	$list = data_approvedList();
	return $list;
}

// get a list of posts which were unapproved
function getUnapprovedList(){
	$list = "";
	$list = data_unapprovedList();
	return $list;
}

// check if the post is approved IN WAITING MODE ONLY
function isApproved($id, $approvedIDList){
	if (in_array($id, $approvedIDList)){
		return true;
	} else {
		return false;
	}
}

// update the post to become approved / unapproved
function approvePost(){
	$id = $_POST["id"];
	$parentid = $_POST["parentid"];
	$msgdate = $_POST["msgdate"];
	if (isset($_POST["approvedID"])){
		$approvedID = $_POST["approvedID"];
	} else {
		$approvedID = array();
	}
	
	for ($i = 0; $i < count($id); $i++){
		if (isApproved($id[$i], $approvedID)){
			$shown = 0;
			$approval = 1;
			$results[] = db_updateWaitingPost($id[$i], $shown, $approval);
			if ($parentid != "0"){
				// if it has a parent topic, update last reply
				$results[] = db_updateLastReply($msgdate[$i], $parentid[$i]);
			}
		} else {
			$shown = 0;
			$approval = 0;
			$results[] = db_updateWaitingPost($id[$i], $shown, $approval);
		}
	}
	
	if(in_array("-1", $results)){
		return false;
	} else {
		return true;
	}
}

// update post
function editPost(){
	$id = $_GET["id"];
	$name = $_POST["name"];
	$email = $_POST["email"];
	$title = $_POST["title"];
	$content = nl2br(addslashes(htmlspecialchars($_POST["content"])));
	
	$result = db_updatePost($id, $name, $email, $title, $content);
	
	return $result;
}

// update post status from app-->unapp
function unapprovePost(){
	$id = $_GET["id"];
	$approval = 0;
	$result = db_reapprovePost($id, $approval);
	return $result;
}

// update post status from unapp-->app
function reapprovePost(){
	$id = $_GET["id"];
	$parentid = getPostOneDetail($id, "parentid");
	$msgdate = getPostOneDetail($id, "msgdate");
	$approval = 1;
	
	$results[] = db_reapprovePost($id, $approval);
	
	if ($parentid != 0){
		$results[] = db_updateLastReply($msgdate, $parentid);
	}

	if(in_array("-1", $results)){
		return false;
	} else {
		return true;
	}
}

// get the details of the post for edit mode
function getPostDetails($id){
	$details;
	$details = data_postDetails($id);
	$details = $details[0];	// only need the first row
	return $details;
}

// get only one detail of the post
function getPostOneDetail($id, $column){
	$detail;
	$detail = data_postOneDetail($id, $column);
	return $detail;
}

// for content
function br2nl($string){
    return  preg_replace('/<br\\s*?\/??>/i', '', $string);
}

// get a list of reply id which belong to a specfic topic (for del)
function getTopicReplyIDs($id){
	$list = "";
	$list = data_getTopicReplyIDs($id);
	return $list;
}

// delete news
function delPost(){
	$id = $_GET["id"];
	$results[] = db_del($id);
	
	// del replies to prevent any error as well
	$replyIDs = getTopicReplyIDs($id);
	if ($replyIDs != ""){
		foreach ($replyIDs as $reply){
			$results[] = db_del($reply["id"]);
		}
	}

	if(in_array("-1", $results)){
		return false;
	} else {
		return true;
	}
}
?>