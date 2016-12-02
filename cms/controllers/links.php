<?php

// convert <br/> to break for edit mode
function convertToNewLine($list){
	if ($list != ""){
		$count = count($list);
		$breaks = array("<br>", "<br/>", "<br />");
		for ($i = 0; $i < $count; $i++){
			$list[$i]["local"] = str_ireplace($breaks, "\r\n", $list[$i]["local"]);
			$list[$i]["name"] = str_ireplace($breaks, "\r\n", $list[$i]["name"]);
			$list[$i]["url"] = str_ireplace($breaks, "\r\n", $list[$i]["url"]);
		}
	}
	return $list;
}

function editLink(){
	$allResult = true;
	$result = false;
        // get the data from the form
	$id = $_POST["id"];
        
	$local = $_POST["local"];
	$name = $_POST["name"];
	$url = $_POST["url"];
	
	
	$totalLink = count($id);
	
	for($i = 0; $i < $totalLink; $i++){
                if(!isset($local[$i])){
                    $local[$i] = "0";
                }
		$result = db_update($id[$i], $local[$i], $name[$i], $url[$i]);
		
		if ($result == -1){ // if any error occurs
			$allResult = false;
		}
        }
	
	return $allResult;
        
}

function delLink(){
	$allResult = true;
	$result = false;
	
	// get the data from the form
	if (isset($_POST["mainDel"])){
		$del = $_POST["mainDel"];
	}

	// del the link
	if (isset($del)){
		foreach ($del as $link){
			$result = db_delLink($link);
			if (!$result){ // if any error occurs
				$allResult = false;
			}
		}
	}
	
	return $allResult;
}

// process the form data: add new link
function addLink(){
	$allResult = true;
	$result = false;
	
	// get data from the form
	$local = $_POST["local"];
	$name = $_POST["name"];
	$url = $_POST["url"];
	$parentid = $_POST["parentid"];
	
	// if there is any empty record submitted from the form, remove them
	$totalLink = count($name);
	for ($i = 0; $i < $totalLink; $i++){
		// if all are empty except unitid (because it is gotten by the db) & local (compulsory) => empty record
		if (($name[$i] == "") || ($url[$i] == "")){
			unset($local[$i]);
			unset($name[$i]);
			unset($url[$i]);
		}
	}
	
	// re-ordering after removing some elements
	$local = array_values($local);
	$name = array_values($name);
	$url = array_values($url);
	$parentid = $parentid;

	// update the number of the total events
	$totalLink = count($name);

	for ($i = 0; $i < $totalLink; $i++){
		$result = db_addLink($local[$i], $name[$i], $url[$i], $parentid);
		if (!$result){ // if any error occurs
			$allResult = false;
		}
	}
	
	return $allResult;
}

?>