<?php

function getAddress(){
	$name = "";
	$name = data_configValue("address");
	return $name;
}

function getMap(){
	$name = "";
	$name = data_configValue("googlemap");
	return $name;
}

function getWeekday(){
	$name = "";
	$name = data_configValue("weekday");
	return $name;
}

function getWeekdayHour(){
	$name = "";
	$name = data_configValue("weekday_officehour");
	return $name;
}

function getWeekend(){
	$name = "";
	$name = data_configValue("weekend");
	return $name;
}

function getWeekendHour(){
	$name = "";
	$name = data_configValue("weekend_officehour");
	return $name;
}

function getBrochure(){
	$name = "";
	$name = data_configValue("brochure");
	return $name;
}

?>