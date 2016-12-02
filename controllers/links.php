<?php

// get all local links of that category (tab)
function getLocalLinks($id){
	$links = "";
	$links = data_localLinks($id);
	return $links;
}

// get all non-local links of that category (tab)
function getNonLocalLinks($id){
	$links = "";
	$links = data_nonLocalLinks($id);
	return $links;
}

// disclaimer
function getDisclaimer(){
	$name = "";
	$name = data_configValue("disclaimer");
	return $name;
}

?>