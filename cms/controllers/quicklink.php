<?php

// check if the link is shown or not
function isShown($id, $shownList){
	if (in_array($id, $shownList)){
		return true;
	} else {
		return false;
	}
}

function getLinkList(){
	$link = "";
	$link = data_link();
	return $link;
}

function manageQuicklinks(){
	if (isset($_GET["action"])){
		$action = $_GET["action"];
		if ($action == "del"){
			// delete mode
			$id = $_GET["id"];
			// remove the newsletter under the volume first
			$results[] = db_delLinks($id);
			
		}
	} else {
		// add/edit mode
		if (isset($_POST["newLink"])){
			$newLink = $_POST["newLink"];
			
			if (isset($_POST["newImg"])){
				$newImage = $_POST["newImg"];
			} else {
				$newImage = array();
			}
			
			if (isset($_POST["newOrder"])){
				$newOrder = $_POST["newOrder"];
			} else {
				$newOrder = array();
			}
			
			for ($i = 0; $i < count($newLink); $i++){
				if ($newLink[$i] != ""){
					// add new
					$link = $newLink[$i];
					$image = $newImage[$i];
					$order = $newOrder[$i];
					$results[] = db_addLink($link, $image, $order);
				}
			}
		}
		
		$id = $_POST["id"];
		$url = $_POST["link"];
		$image = $_POST["image"];
		$order = $_POST["order"];
		if (isset($_POST["shown"])){
			$shown = $_POST["shown"];
		} else {
			$shown = array();
		}
		
		for ($i = 0; $i < count($id); $i++){
			// update
			
			if (isShown($id[$i], $shown)){
				$shownValue = 1;
			} else {
				$shownValue = 0;
			}
			
			$results[] = db_updateLink($id[$i], $url[$i], $image[$i], $order[$i], $shownValue);
		}
	}

	if(in_array("-1", $results)){
		return false;
	} else {
		return true;
	}
}

?>