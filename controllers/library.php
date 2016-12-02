<?php

// get all subjects
function getAllSubjects(){
	$list = "";
	$list = data_subjects();
	return $list;
}

// check search error: at least one field is input
function hasError(){
	$hasError = true;
	
	$title = htmlspecialchars($_POST['title']);
	$author = htmlspecialchars($_POST['author']);
	$isbn = htmlspecialchars($_POST['isbn']);
	
	if (($title != "") || ($author != "") || ($isbn != "")) {
		$hasError = false;
	}
	
	return $hasError;
}

// get search result
function getSearchResult($title, $author, $isbn, $subject){
	$result = "";
	$condition = "";
	
	// process title
	if ($title != ""){
		// remove space before and after comma
		$pattern = '/\s*,\s*/';
		$replace = ',';
		$title = preg_replace($pattern, $replace, $title);
		
		// process more than 1 keyword
		$title = explode(",",$title);
		
		foreach ($title as $keyword){
			$condition .= "title LIKE \"%$keyword%\" AND ";
		}
	}
	
	// process author
	if ($author != ""){
		$author = trim($author);	// remove space
		$condition .= "author LIKE \"%$author%\" AND ";
	}
	
	// process ISBN, ISSN
	if ($isbn != ""){
		$condition .= "isbn LIKE \"%$isbn%\" OR ";
		$condition .= "issn LIKE \"%$isbn%\" AND ";
	}
	
	// process subjects (= genre)
	if ($subject != "all"){
		$condition .= "genre = \"$subject\" AND ";
	}
	
	// remove the last "AND "
	$condition = substr($condition, 0, -4);
	
	$result = data_searchResult($condition);
	
	return $result;
}

// get the details of the subject by genreid (for search result)
function getBookSubject($id){
	$subject = "";
	$details = data_bookSubject($id);
	if ($details[0]["genreid"] != ""){
		$subject .= $details[0]["genreid"]." ";	// e.g. 000
	}
	$subject .= $details[0]["name"];	// e.g. 000 Maritime Law
	return $subject;
}

?>