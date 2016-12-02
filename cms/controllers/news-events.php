<?php

// get a list of news
function getNews($tab){
	$news = "";
	$news = data_news($tab);
	return $news;
}

// check is it a link or HTML content
function isExpandableNews($id){
	$isExpandable = false;
	$newsIsExpandable = data_isExpandable($id);
	if ($newsIsExpandable > 0){
		$isExpandable = true;
	}
	return $isExpandable;
}

// get the content of news
function getNewsContent($id){
	$content = "";
	$content = data_newsContent($id);
	return $content;
}

// get the details of the new by id
function getNewsDetails($id){
	$details = "";
	$details = data_newsDetails($id);
	return $details;
}

// add news
function addNews(){
	// process the data
	$type = $_GET["tab"];
	$startDate = array_values(array_filter($_POST["startDate"]));
	$endDate = array_values(array_filter($_POST["endDate"]));
	$title = array_values(array_filter($_POST["title"]));
	$source = array_values(array_filter($_POST["source"]));
	$content = array_values(array_filter($_POST["content"]));
	
	// process the contentType and shown
	for ($i = 0; $i < 5; $i++){
		$contentTypeName = "contentType$i";
		$shownName = "shown$i";

		if (isset($_POST[$contentTypeName])){
			$contentType[] = $_POST[$contentTypeName][0];
			$shown[] = $_POST[$shownName][0];
		}
	}

	// insert to db
	for ($i = 0; $i < count($startDate); $i++){
		if (!isset($source[$i])){
			$source[$i] = "";
		}
		
		if ($contentType[$i] == "url"){
			$expandable = 0;
		}
		
		if ($contentType[$i] == "html"){
			$content[$i] = addslashes($content[$i]);
			$expandable = 1;
		}
		
		$results[] = db_add($startDate[$i], $endDate[$i], $type, $title[$i], $source[$i], $content[$i], $shown[$i], $expandable);
	}
	
	if(in_array("-1", $results)){
		return false;
	} else {
		return true;
	}
}

// update news
function editNews(){
	$id = $_GET["id"];
	$startDate = $_POST["startDate"];
	$endDate = $_POST["endDate"];
	$title = $_POST["title"];
	if (isset($_POST["source"])){
		$source = $_POST["source"];
	} else {
		$source = "";
	}
	$contentType = $_POST["contentType"];
	$shown = $_POST["shown"];
	
	if ($contentType == "url"){	// url
		$content = $_POST["contentURL"];
		$isExpand = 0;
	} else {	// html
		$content = addslashes($_POST["contentHTML"]);
		$isExpand = 1;
	}
	
	$result = db_update($id, $startDate, $endDate, $title, $source, $content, $isExpand, $shown);
	
	return $result;
}

// delete news
function delNews(){
	$id = $_GET["id"];
	$result = db_del($id);
	return $result;
}

?>