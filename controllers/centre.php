<?php

// get all items from research
function getResearchList(){
	$list = "";
	$list = data_researchList();
	return $list;
}

// get all items from paper
function getPaperList(){
	$list = "";
	$list = data_paperList();
	return $list;
}

?>