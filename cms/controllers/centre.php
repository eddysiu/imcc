<?php

// get config value in one specfic language
function getContentInOneLang($tab, $lang){
	$result = "";
	$id = getCatIDByAbbr($tab);
	$lang = "content".$lang;
	$result = htmlspecialchars(data_contentInOneLang($id, $lang));
	return $result;
}

function updateDB($parentid, $contentEN, $contentTW, $contentCN){
	$results;
	
	$results[] = db_update($parentid, $contentEN, "contentEN");
	$results[] = db_update($parentid, $contentTW, "contentTW");
	$results[] = db_update($parentid, $contentCN, "contentCN");
	
	if(in_array("-1", $results)){
		return false;
	} else {
		return true;
	}
}


// convert <br/> to break for edit mode
function convertToNewLine($list){
	if ($list != ""){
		$count = count($list);
		$breaks = array("<br>", "<br/>", "<br />");
		for ($i = 0; $i < $count; $i++){
			$list[$i]["type"] = str_ireplace($breaks, "\r\n", $list[$i]["type"]);
			$list[$i]["value"] = str_ireplace($breaks, "\r\n", $list[$i]["value"]);
			$list[$i]["displayorder"] = str_ireplace($breaks, "\r\n", $list[$i]["displayorder"]);
		}
	}
	return $list;
}

function editPub(){
	$allResult = true;
	$result = false;
        // get the data from the form
	$id = $_POST["id"];
        
	$type = $_POST["type"];
	$value = $_POST["value"];
	$displayorder = $_POST["displayorder"];
	
	
	$totalPub = count($id);
	
	for($i = 0; $i < $totalPub; $i++){

		$result = db_updatePub($id[$i], $type[$i], $value[$i], $displayorder[$i]);
		
		if ($result == -1){ // if any error occurs
			$allResult = false;
		}
        }
	
	return $allResult;
        
}

function delPub(){
	$allResult = true;
	$result = false;
	
	// get the data from the form
	if (isset($_POST["mainDel"])){
		$del = $_POST["mainDel"];
	}

	// del the pub
	if (isset($del)){
		foreach ($del as $pub){
			$result = db_delPub($pub);
			if (!$result){ // if any error occurs
				$allResult = false;
			}
		}
	}
	
	return $allResult;
}

// process the form data: add new pub
function addPub(){
	$allResult = true;
	$result = false;
	
	// get data from the form
	$type = $_POST["type"];
	$value = $_POST["value"];
	$displayorder = $_POST["displayorder"];
	
	
	// if there is any empty record submitted from the form, remove them
	$totalPub = count($value);
	for ($i = 0; $i < $totalPub; $i++){
		// if all are empty except unitid (because it is gotten by the db) & type (compulsory) => empty record
		if (($value[$i] == "") || ($displayorder[$i] == "")){
			unset($type[$i]);
			unset($value[$i]);
			unset($displayorder[$i]);
		}
	}
	
	// re-ordering after removing some elements
	$type = array_values($type);
	$value = array_values($value);
	$displayorder = array_values($displayorder);
	

	// update the number of the total events
	$totalPub = count($value);

	for ($i = 0; $i < $totalPub; $i++){
		$result = db_addPub($type[$i], $value[$i], $displayorder[$i]);
		if (!$result){ // if any error occurs
			$allResult = false;
		}
	}
	
	return $allResult;
}

?>