<?php

// get a complete list of the talks
function data_talkList($starttime, $type){
	global $currentYear;
	$result = "";
	$starttime = $starttime.":00";	// add second and the format becomes hh:mm:ss
	
	if (isEN()){
		$selectedColumn = "talk.titleEN, talk.subtitleEN, venue.venueEN";
	}
	
	if (isZH()){
		$selectedColumn = "talk.titleZH, talk.subtitleZH, venue.venueZH";
	}
	
	$query = "SELECT $selectedColumn FROM pathway_talk AS talk, pathway_venue AS venue WHERE talk.eventYear = \"$currentYear\" AND talk.starttime = \"$starttime\" AND type = \"$type\" AND venue.id = talk.venueID";
	
	$resultset = exec_reader($query);
	while(list($title, $subtitle, $venue) = mysql_fetch_array($resultset, MYSQL_NUM)){
		$result[] = array(
			"title" => $title,
			"subtitle" => $subtitle,
			"venue" => $venue
		);
	}
	return $result;
}

// get a list of the timeslots
function data_timeList($engType, $pthType){
	global $currentYear;
	$result = "";
	$query = "SELECT TIME_FORMAT(starttime, '%H:%i') AS starttime, TIME_FORMAT(endtime, '%H:%i') AS endtime FROM pathway_talk where eventYear = \"2015\" and (type = \"$engType\" OR type = \"$pthType\") group by starttime order by starttime;";
	$resultset = exec_reader($query);
	while(list($starttime, $endtime) = mysql_fetch_array($resultset, MYSQL_NUM)){
		$result[] = array(
			"starttime" => $starttime,
			"endtime" => $endtime
		);
	}
	return $result;
	
}

//////////////////////////////////////////

// get a list of event from the database
function data_eventList($belong){
	$result = "";
	$query = "SELECT id, type, name, time, venue FROM new_event WHERE unitid = \"$belong\" ORDER BY displayorder";
	$resultset = exec_reader($query);
	while(list($id, $type, $name, $time, $venue) = mysql_fetch_array($resultset, MYSQL_NUM)){
		$result[] = array(
			"id" => $id,
			"type" => $type,
			"name" => $name,
			"time" => $time,
			"venue" => $venue
		);
	}
	return $result;
}

// get a list of sub-event (sub-item) from the database
function data_subEventList($belong){
	$result = "";
	$query = "SELECT subevent.name, subevent.time, subevent.venue FROM new_subevent AS subevent, new_event AS event WHERE event.id = \"$belong\" AND subevent.belong = \"$belong\" ORDER BY subevent.displayorder";
	$resultset = exec_reader($query);
	while(list($name, $time, $venue) = mysql_fetch_array($resultset, MYSQL_NUM)){
		$result[] = array(
			"name" => $name,
			"time" => $time,
			"venue" => $venue
		);
	}
	return $result;
}
// get is there any general event under the faculty
function int_noOfGeneralEvents($abbr){
	$noOfEvents = 0;
	$query = "SELECT count(new_event.id) FROM new_event, new_unit WHERE new_unit.id = new_event.unitid AND new_unit.abbr = \"$abbr\" AND new_unit.id = new_unit.belong";
	$noOfEvents = exec_scalar($query);
	return $noOfEvents;
}

// get the unit ID by a given abbr
function int_unitID($abbr){
	$unitID = "";
	$query = "SELECT id FROM new_unit WHERE abbr = \"$abbr\"";
	$unitID = exec_scalar($query);
	return $unitID;
	
}

// get the total number of records under the whole faculty
function int_totalEventsUnderWholeUnit($id){
	$totalEvents = 0;
	$query = "SELECT count(id) FROM new_event WHERE new_event.unitid = \"$id\" OR new_event.unitid IN (SELECT id FROM new_unit WHERE belong=\"$id\" AND belong != id)";
	$totalEvents = exec_scalar($query);
	return $totalEvents;
	
}

// get a list of sub units by a given main id
function data_subUnitList($belong){
	$result = "";
	$query = "SELECT id, name FROM new_unit WHERE belong = \"$belong\" AND id != \"$belong\" ORDER BY displayorder, name";
	$resultset = exec_reader($query);
	while(list($id, $name) = mysql_fetch_array($resultset, MYSQL_NUM)){
		$result[] = array(
			"id" => $id,
			"name" => $name
		);
	}
	return $result;
}
?>