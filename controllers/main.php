<?php

// get the "News and Event" title
function getIndexNewsTitle(){
	$title = "";
	$title = data_indexNewsTitle();
	return $title;
}

// get a list of news which is shown in index page
function getNews(){
	$name = "";
	$name = data_news();
	return $name;
}

// get the content of the news
function getNewsContent($id){
	$content = "";
	$content = data_newsContent($id);
	return $content;
}

// get quick links
function getQuickLinks(){
	$links = "";
	$links = data_quickLinks();
	return $links;
}

?>