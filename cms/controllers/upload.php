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

function uploadFiles(){
	$tab = $_GET["tab"];
	
	if ($tab != "gallery"){
		switch ($tab){
			case "news": $path = "../upload/news/"; break;
			case "newsletter": $path = "../upload/newsletter/shipping/"; break;
			case "publication": $path = "../upload/publication/"; break;
			case "others": $path = "../upload/pdf/"; break;
		}
	} else {
		$gallery = $_GET["gallery"];
		$type = $_GET["type"];
		switch ($type){
			case "small": $path = "../img/album/$gallery/"; break;
			case "medium": $path = "../img/album/$gallery/enlarge/"; break;
			case "large": $path = "../img/album/$gallery/download/"; break;
		}
	}
	$count = 0;
	
	for ($i = 0; $i < count($_FILES['upload']['name']); $i++){
		$newpath = $path.$_FILES['upload']['name'][$i];
		if (move_uploaded_file($_FILES["upload"]["tmp_name"][$i], $newpath)){
			$count++;
		}
	}
	
	return $count;
}

// get a list of album
function getListOfAlbum(){
	$list = "";
	$list = db_listOfAlbum();
	return $list;
}

// delete file
function del(){
	$tab = $_GET["tab"];
	$filename = $_GET["filename"];
	
	if ($tab != "gallery"){
		switch ($tab){
			case "news": $path = "../upload/news/"; break;
			case "newsletter": $path = "../upload/newsletter/shipping/"; break;
			case "publication": $path = "../upload/publication/"; break;
			case "others": $path = "../upload/pdf/"; break;
		}
	} else {
		$gallery = $_GET["gallery"];
		$type = $_GET["type"];
		switch ($type){
			case "small": $path = "../img/album/$gallery/"; break;
			case "medium": $path = "../img/album/$gallery/enlarge/"; break;
			case "large": $path = "../img/album/$gallery/download/"; break;
		}
	}
	
	$file = $path."$filename";
	
	if(is_file($file)){
		return unlink($file); // delete file
	} else {
		return false;
	}
}
?>