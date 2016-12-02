<?php

/******** general functions ********/

// get config value by a given item in default language (english)
function data_configValue($item){
	$result = "";
	$value = getColumnByLang("value");
	$query = "SELECT $value FROM config WHERE item = \"$item\"";
	$result = exec_scalar($query);
	return $result;
}

// get config value by a given item in one specfic language
function data_configValueInOneLang($item, $lang){
	$result = "";
	$value = "value".$lang;
	$query = "SELECT $value FROM config WHERE item = \"$item\"";
	$result = exec_scalar($query);
	return $result;
}

// get config value by a given item in all languages
function data_configValueInAllLang($item){
	$result = "";
	$query = "SELECT valueEN, valueTW, valueCN FROM config WHERE item = \"$item\"";
	while(list($valueEN, $valueTW, $valueCN) = mysql_fetch_array($resultset, MYSQL_NUM)){
		$result[] = array(
			"valueEN" => $valueEN,
			"valueTW" => $valueTW,
			"valueCN" => $valueCN
		);
	}
	return $result;
}

// get config value by a given item
function int_langConfigValue($value){
	$result = "";
	$query = "SELECT $value FROM config WHERE item = \"langbar\"";
	$result = exec_scalar($query);
	return $result;
}

// get the ID of the main category by URL
function int_mainCatID($page){
	$result = "";
	$query = "SELECT id FROM category WHERE abbr = \"$page\";";
	$result = exec_scalar($query);
	return $result;
}

// get the ID of the sub category by URL
function int_subCatID($page, $tab){
	$result = "";
	$query = "SELECT id FROM category WHERE abbr = \"$tab\" AND parent = (SELECT id FROM category WHERE abbr = \"$page\")";
	$result = exec_scalar($query);
	return $result;
}

// get the id by abbr
function int_catIDByAbbr($parentid, $abbr){
	$result = "";
	$query = "SELECT id FROM category WHERE abbr = \"$abbr\" AND parent = $parentid";
	$result = exec_scalar($query);
	return $result;
}

// to check is the tab is a valid tab
function int_tabExist($page, $tab){
	$result = "";
	$query = "SELECT count(id) FROM category WHERE abbr = \"$tab\" AND parent = (SELECT id FROM category WHERE abbr = \"$page\")";
	$result = exec_scalar($query);
	return $result;
}

// set a default tab if there is no tab set
function data_getDefaultTab($page){
	$result = "";
	$query = "SELECT abbr FROM category WHERE defaulttab = 1 AND parent = (SELECT id FROM category WHERE abbr = \"$page\")";
	$result = exec_scalar($query);
	return $result;	
}

// get the title of the content page by id
function data_getContentTitle($id){
	$result = "";
	$name = getColumnByLang("name");
	$query = "SELECT $name FROM category WHERE id = $id";
	$result = exec_scalar($query);
	return $result;	
}

// get the title of the content page by id
function data_contentInOneLang($id, $content){
	$result = "";
	$query = "SELECT $content FROM content WHERE parentid = $id";
	$result = exec_scalar($query);
	return $result;	
}

/********* header *********/

// get a list of the category
function data_mainCatList(){
	$result = "";
	$name = getColumnByLang("name");
	$query = "SELECT id, $name, abbr FROM category WHERE parent = 0;";
	$resultset = exec_reader($query);
	while(list($id, $name, $abbr) = mysql_fetch_array($resultset, MYSQL_NUM)){
		$result[] = array(
			"id" => $id,
			"name" => $name,
			"abbr" => $abbr
		);
	}
	return $result;
}

// get a list of sub-category
function data_subCatList($parentID){
	$result = "";
	$name = getColumnByLang("name");
	$query = "SELECT id, $name, abbr FROM category WHERE parent = $parentID;";
	$resultset = exec_reader($query);
	while(list($id, $name, $abbr) = mysql_fetch_array($resultset, MYSQL_NUM)){
		$result[] = array(
			"id" => $id,
			"name" => $name,
			"abbr" => $abbr
		);
	}
	return $result;
}

// get the title of the page by url
function data_pageTitle($url){
	$result = "";
	$value = getColumnByLang("name");
	$query = "SELECT $value FROM category WHERE abbr = \"$url\"";
	$result = exec_scalar($query);
	return $result;
}

// get the number of posts which are waiting for approval
function int_noOfWaitingPost(){
	$result = "";
	$query = "SELECT count(id) FROM messageboard WHERE approval=\"0\" AND shown=\"1\"";
	$result = exec_scalar($query);
	return $result;
}

?>