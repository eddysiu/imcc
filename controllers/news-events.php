<?php

// get a list of news
function getNews($tab){
	$name = "";
	$name = data_news($tab);
	return $name;
}

// get the content of news
function getNewsContent($id){
	$content = "";
	$content = data_newsContent($id);
	return $content;
}

// for index
function isExpandableNews($id){
	$isExpandable = false;
	$newsIsExpandable = data_isExpandable($id);
	if ($newsIsExpandable > 0){
		$isExpandable = true;
	}
	return $isExpandable;
}

?>