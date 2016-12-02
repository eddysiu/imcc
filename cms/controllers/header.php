<?php
//the javascript is placed into ./view/header.php

date_default_timezone_set("Asia/Hong_Kong"); 

/*********** general functions **********/

// get current url path (e.g. localhost/imcc)
function getCurrentURL(){
	$pageURL = "";
	
	// get the page URL
	if ($_SERVER["SERVER_PORT"] != "80") {
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} else {
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}
	
	// if the pageURL does not contain the filename, then add the filename as well
	if (substr($pageURL, -4) != ".php"){
		$pageURL .= "/".getCurrentFilename();		//anyway add slash before the filename
	}
	
	// remove any double slash then
	$pageURL = str_replace("//", "/", $pageURL);
	
	return $pageURL;
}

// get current file name (e.g. index.php)
function getCurrentFilename() {
	return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
}

// for model: get the correct language column
function getColumnByLang($column){
	$result = "";
	if (isEN()){
		$result = $column."EN";
	}
	if (isTW()){
		$result = $column."TW";
	}
	if (isCN()){
		$result = $column."CN";
	}
	return $result;
}

// detect is it the English version
function isEN(){
	$isEN = false;
	
	$url = getCurrentURL();
	if ((strpos($url, "lang_tw") == false) && (strpos($url, "lang_cn") == false)){
		$isEN = true;
	}
	
	return $isEN;
}

// detect is it the Traditional Chinese version
function isTW(){
	$isTW = false;
	
	$url = getCurrentURL();
	if (strpos($url, "lang_tw") !== false){
		$isTW = true;
	}
	
	return $isTW;
}

// detect is it the Simplified Chinese version
function isCN(){
	$isCN = false;
	
	$url = getCurrentURL();
	if (strpos($url, "lang_cn") !== false){
		$isCN = true;
	}
	
	return $isCN;
}

// get different page titles
function getTitle(){
	$title = data_configValue("title");
	
	// get current page
	$title = data_configValue("title");
	$page = str_replace(".php","",getCurrentFilename());
	
	// if the page is index, then no need subtitle
	if (($page != "index") && ($page != "")){
		$subtitle = data_pageTitle($page);
	} else {
		$subtitle = "";
	}
	
	if ($subtitle != ""){
		$title .= ": " . $subtitle;
	}
	
	return $title;
}

// get the id of the main cat by url
function getMainCatIDByURL(){
	$id = "";
	$page = str_replace(".php", "", getCurrentFilename());
	$id = int_mainCatID($page);
	return $id;
}

// get the id of the sub cat by url
function getSubCatIDByURL($tab){
	$id = "";
	$page = str_replace(".php","",getCurrentFilename());
	$id = int_subCatID($page, $tab);
	return $id;
}

// get the id by abbr
function getCatIDByAbbr($abbr){
	$id = "";
	$parentid = getMainCatIDByURL();
	$id = int_catIDByAbbr($parentid, $abbr);
	return $id;
}

// check the current tab is valid or not
function isValidTab($tab){
	$isValid = false;
	$page = str_replace(".php","",getCurrentFilename());
	$existTab = int_tabExist($page, $tab);
	if ($existTab > 0) {
		$isValid = true;
	}
	return $isValid;
}

// set a default tab if there is no tab set
function getDefaultTab(){
	$tab = "";
	$page = str_replace(".php","",getCurrentFilename());
	$tab = data_getDefaultTab($page);
	return $tab;
}

// get the title of the page by tab
function getContentTitle($tab){
	$title = "";
	if ($tab == ""){	// case of "contact us" only
		$subCatID = getMainCatIDByURL();
	} else {
		$subCatID = getSubCatIDByURL($tab);
	}
	$title = data_getContentTitle($subCatID);
	return $title;
}

// correct relative path
function correctImgURL($url){
	if (substr($url, 0, 4) != "http"){	// if it is a relative path
		// firstly add "./" at the beginning if it is not
		if (substr($url, 0, 2) != "./"){
			$url = "./".$url;
		}
		$url = str_replace("./", "../", $url);
	}
	return $url;
}

// pass long text and convert the img url
function correctImgURLInText($text){
	// get an array which contains all image url
	preg_match_all('~<img.*?src=["\']+(.*?)["\']+~', $text, $urls);
	$urls = $urls[1];
	
	// replace text
	foreach ($urls as $url){
		$newURL = correctImgURL($url);
		$text = str_replace($url, $newURL, $text);
	}
	
	return $text;
}

// correct relative path
function correctPdfURL($url){
	if (substr($url, 0, 4) != "http"){	// if it is a relative path
		// firstly add "./" at the beginning if it is not
		if (substr($url, 0, 2) != "./"){
			$url = "./".$url;
		}

		$url = str_replace("./", "../", $url);
	}
	
	return $url;
}


//***************header functions*************

// get main category list
function getMainCatList(){
	$list = "";
	$list = data_mainCatList();
	return $list;
}

// get sub category list
function getSubCatList($parentID){
	$list = "";
	$list = data_subCatList($parentID);
	return $list;
}

// get the language config (e.g. enable zh_TW, unable zh_cn)
function getLangConfig($value){
	$config = "";
	$config = int_langConfigValue($value);
	return $config;
	
}

// get the number of posts which are waiting for approval (for message board (hyperlink in nav))
function getNoOfWaitingPost(){
	$no = 0;
	$no = int_noOfWaitingPost();
	return $no;
}


/************* action related *************/

// get current action (simply: add, edit and del)
function getCurrentAction(){
	if (isset($_GET["action"])){
		$action = $_GET["action"];
	} else {
		$action = "";
	}
	
	return $action;
}

/************ others ************/

?>