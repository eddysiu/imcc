<?php

// convert <br/> to break for edit mode
function convertToNewLine($list){
	if ($list != ""){
		$count = count($list);
		$breaks = array("<br>", "<br/>", "<br />");
		for ($i = 0; $i < $count; $i++){
			$list[$i]["starttime"] = str_ireplace($breaks, "\r\n", $list[$i]["starttime"]);
			$list[$i]["endtime"] = str_ireplace($breaks, "\r\n", $list[$i]["endtime"]);
                        $list[$i]["title"] = str_ireplace($breaks, "\r\n", $list[$i]["title"]);
                        $list[$i]["content"] = str_ireplace($breaks, "\r\n", $list[$i]["content"]);
		}
	}
	return $list;
}

function editNotice(){
	$allResult = true;
	$result = false;
        // get the data from the form
	$id = $_POST["id"];
	$startdate = $_POST["startdate"];
        $starttime = $_POST["starttime"];
	$enddate = $_POST["enddate"];
	$endtime = $_POST["endtime"];
        $title = $_POST["title"];
	$content = $_POST["content"];
	
	
	$totalNotice = count($id);
	
	for($i = 0; $i < $totalNotice; $i++){
            $starttime[$i] = $startdate[$i]." ".$starttime[$i]; 
            $endtime[$i] = $enddate[$i]." ".$endtime[$i]; 
            $result = db_update($id[$i], $starttime[$i], $endtime[$i], $title[$i], $content[$i]);
		
		if ($result == -1){ // if any error occurs
			$allResult = false;
		}
        }
	
	return $allResult;
        
}

function delNotice(){
	$allResult = true;
	$result = false;
	
	// get the data from the form
	if (isset($_POST["mainDel"])){
		$del = $_POST["mainDel"];
	}

	// del the link
	if (isset($del)){
		foreach ($del as $notice){
			$result = db_delNotice($notice);
			if (!$result){ // if any error occurs
				$allResult = false;
			}
		}
	}
	
	return $allResult;
}

// process the form data: add new link
function addNotice(){
	$allResult = true;
	$result = false;
	
	// get data from the form
	$startdate = $_POST["startdate"];
        $starttime = $_POST["starttime"];
	$enddate = $_POST["enddate"];
	$endtime = $_POST["endtime"];
	$title = $_POST["title"];
	$content = $_POST["content"];
	
	// if there is any empty record submitted from the form, remove them
/* 	$totalNotice = count($title);
	for ($i = 0; $i < $totalNotice; $i++){
		// if all are empty except unitid (because it is gotten by the db) & local (compulsory) => empty record
		if (($startdate[$i] == "") || ($starttime[$i] == "") || ($enddate[$i] == "")|| ($endtime[$i] == "")|| ($title[$i] == "")|| ($content[$i] == "")){
			unset($starttime[$i]);
                        unset($startdate[$i]);
			unset($endtime[$i]);
			unset($enddate[$i]);
                        unset($title[$i]);
                        unset($content[$i]);
		}
	}
	
	// re-ordering after removing some elements
	$starttime = array_values($starttime);
        $startdate = array_values($startdate);
	$enddate = array_values($enddate);
	$endtime = array_values($endtime);
	$title = array_values($title);
	$content = $content; */

	// update the number of the total events
	$totalNotice = count($title);

	for ($i = 0; $i < $totalNotice; $i++){
            $starttime[$i] = $startdate[$i]." ".$starttime[$i]; 
            $endtime[$i] = $enddate[$i]." ".$endtime[$i];
			$content[$i] = addslashes($content[$i]);
		$result = db_addNotice($starttime[$i], $endtime[$i], $title[$i], $content[$i]);
		if (!$result){ // if any error occurs
			$allResult = false;
		}
	}
	
	return $allResult;
}

?>