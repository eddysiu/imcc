<?php

function getNewsletterVol($tab){
	$vol = "";
	$parentID = getSubCatIDByURL($tab);
	$vol = data_newsletterVol($parentID);
	return $vol;
}

// convert <br/> to break for edit mode
function convertToNewLine($list){
	if ($list != ""){
		$count = count($list);
		$breaks = array("<br>", "<br/>", "<br />");
		for ($i = 0; $i < $count; $i++){
			$list[$i]["name"] = str_ireplace($breaks, "\r\n", $list[$i]["name"]);
			$list[$i]["url"] = str_ireplace($breaks, "\r\n", $list[$i]["url"]);
		}
	}
	return $list;
}

function editNewsletter(){
	$allResult = true;
	$result = false;
        // get the data from the form
	$id = $_POST["id"];
        
	$name = $_POST["name"];
	$url = $_POST["url"];
	
	
	$totalNewsletter = count($id);
	
	for($i = 0; $i < $totalNewsletter; $i++){

		$result = db_update($id[$i], $name[$i], $url[$i]);
		
		if ($result == -1){ // if any error occurs
			$allResult = false;
		}
        }
	
	return $allResult;
        
}

function delNewsletter(){
	$allResult = true;
	$result = false;
	
	// get the data from the form
	if (isset($_POST["mainDel"])){
		$del = $_POST["mainDel"];
	}

	// del the link
	if (isset($del)){
		foreach ($del as $newsletter){
			$result = db_delLink($newsletter);
			if (!$result){ // if any error occurs
				$allResult = false;
			}
		}
	}
	
	return $allResult;
}

// process the form data: add new link
function addNewsletter(){
	$allResult = true;
	$result = false;
	
	// get data from the form
	$name = $_POST["name"];
	$url = $_POST["url"];
	$parentid = $_POST["parentid"];
	
	// if there is any empty record submitted from the form, remove them
	$totalNewsletter = count($name);
	for ($i = 0; $i < $totalNewsletter; $i++){
		// if all are empty except unitid (because it is gotten by the db)  => empty record
		if (($name[$i] == "") || ($url[$i] == "")){
			unset($name[$i]);
			unset($url[$i]);
		}
	}
	
	// re-ordering after removing some elements
	$name = array_values($name);
	$url = array_values($url);
	$parentid = $parentid;

	// update the number of the total events
	$totalNewsletter = count($name);

	for ($i = 0; $i < $totalNewsletter; $i++){
		$result = db_addLink($name[$i], $url[$i], $parentid);
		if (!$result){ // if any error occurs
			$allResult = false;
		}
	}
	
	return $allResult;
}

function manageVolume(){
	if (isset($_GET["del"])){
		$del = $_GET["del"];
		if ($del == "true"){
			// delete mode
			$id = $_GET["id"];
			// remove the newsletter under the volume first
			$newsletterList = getNewsletterList($id);
			if (!empty($newsletterList)){
				foreach ($newsletterList as $newsletter){
					$results[] = db_delLink($newsletter["id"]);
				}
			}
			// remove volume
			$results[] = db_delVolume($id);
			
		}
	} else {
		// add/edit mode
		if (isset($_POST["newVolume"])){
			$newVolume = $_POST["newVolume"];
		}
		$id = $_POST["id"];
		$volume = $_POST["volume"];
		
		foreach ($newVolume as $new){
			if ($new != ""){
				// add new
				$tab = $_GET["tab"];
				$parentid = getSubCatIDByURL($tab);
				$results[] = db_addVolume($new, $parentid);
			}
		}
		
		for ($i = 0; $i < count($id); $i++){
			// update
			$results[] = db_updateVolume($id[$i], $volume[$i]);
		}
	}

	if(in_array("-1", $results)){
		return false;
	} else {
		return true;
	}
}

?>