<?php

// get all volume of newsletter
function getNewsletterVol($tab){
	$vol = "";
	$parentID = getSubCatIDByURL($tab);
	$vol = data_newsletterVol($parentID);
	return $vol;
}

// get all issue of a volume
function getNewsletterIssue($id){
	$issue = "";
	$issue = data_newsletterIssue($id);
	return $issue;
}

?>