<?php

// get config value in one specfic language
function getConfigValueInOneLang($item, $lang){
	$result = "";
	$result = htmlspecialchars(data_configValueInOneLang($item, $lang));
	return $result;
}

// get config value in all languages
function getConfigValueInAllLang($item){
	$result = "";
	$result = htmlspecialchars(data_configValueInAllLang($item));
	return $result;
}

// get the language config from the db for view layout
function getlanguageEnable($item, $lang, $currentValue){
	$checked = "";
	$result = data_configValueInOneLang($item, $lang);
	if ($result == $currentValue){
		$checked = 'checked="checked"';
	}
	return $checked;
}

// covert <br/> to breakline (in this case convert to "" only)
function convertBrToBreakline($content){
	$content = str_replace("<br/>","",$content);
	return $content;
}

function updateDB($universityname, $title, $address, $email, $map, $tel, $weekday, $weekday_officehour, $weekend, $brochure, $disclaimer, $lang_tw, $lang_cn){
	$results;
	for ($i = 0; $i < 3; $i++){
		// $i = 0	English
		// $i = 1	Tranditional Chinese
		// $i = 2	Simplified Chinese
		switch ($i){
			case "0": 	$value = "valueEN"; break;
			case "1": 	$value = "valueTW"; break;
			case "2": 	$value = "valueCN"; break;
		}
		$results[] = db_update("universityname", $universityname[$i], $value);
		$results[] = db_update("title", $title[$i], $value);
		$results[] = db_update("address", $address[$i], $value);
		$results[] = db_update("email", $email[$i], $value);
		$results[] = db_update("googlemap", $map[$i], $value);
		$results[] = db_update("tel", $tel[$i], $value);
		$results[] = db_update("weekday", $weekday[$i], $value);
		$results[] = db_update("weekday_officehour", $weekday_officehour[$i], $value);
		$results[] = db_update("weekend", $weekend[$i], $value);
		$results[] = db_update("brochure", $brochure[$i], $value);
		$results[] = db_update("disclaimer", $disclaimer[$i], $value);
	}
	
	// for language bar
	$results[] = db_update("langbar", $lang_tw, "valueTW");
	$results[] = db_update("langbar", $lang_cn, "valueCN");
	
	if(in_array("-1", $results)){
		return false;
	} else {
		return true;
	}
}

?>