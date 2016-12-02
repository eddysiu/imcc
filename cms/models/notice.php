<?php

// get a list of notices
function getNoticeList(){
	$list = "";
	$query = "SELECT id, starttime, endtime, title, content FROM alert";
        $resultset = exec_reader($query);
	while(list($id, $starttime, $endtime, $title, $content) = mysql_fetch_array($resultset, MYSQL_NUM)){
		$list[] = array(
			"id" => $id,
			"starttime" => $starttime,
			"endtime" => $endtime,
                        "title" => $title,
			"content" => $content
		);
	}
	return $list;
}

function db_update($id, $starttime, $endtime, $title, $content){
	$content = addslashes($content);
	$result = 0;
	$query = "UPDATE alert SET starttime= \"$starttime\", endtime=\"$endtime\", title=\"$title\", content=\"$content\" WHERE id = $id;";
	$result = exec_non_query($query);
	return $result;
}

function db_delNotice($id){
	$result = 0;
	$query = "DELETE FROM alert WHERE id = $id;";
	$result = exec_non_query($query);
	return $result;
}

function db_addNotice($starttime, $endtime, $title, $content){
	$result = 0;
	$query = "INSERT INTO alert (starttime, endtime, title, content) VALUES (\"$starttime\", \"$endtime\", \"$title\", \"$content\");";
	$result = exec_non_query($query);
	return $result;
}
?>