<?php

// get a list of subjects (genre)
function data_subjects(){
	$result = "";
	$query = "SELECT id, name FROM cataloguegenre";
	$resultset = exec_reader($query);
	while(list($id, $name) = mysql_fetch_array($resultset, MYSQL_NUM)){
		$result[] = array(
			"id" => $id,
			"name" => $name
		);
	}
	return $result;
}

// get the details of a subject by id
function data_bookSubject($id){
	$result = "";
	$query = "SELECT genreid, name FROM cataloguegenre WHERE id = \"$id\"";
	$resultset = exec_reader($query);
	while(list($genreid, $name) = mysql_fetch_array($resultset, MYSQL_NUM)){
		$result[] = array(
			"genreid" => $genreid,
			"name" => $name
		);
	}
	return $result;
}

// get search result
function data_searchResult($condition){
	$result = "";
	$query = "SELECT callno, title, author, publisher, bookyear, edition, isbn, issn, noofcopy, genre FROM catalogue WHERE $condition ORDER BY genre, title;";
	$resultset = exec_reader($query);
	while(list($callno, $title, $author, $publisher, $year, $edition, $isbn, $issn, $noofcopy, $genre) = mysql_fetch_array($resultset, MYSQL_NUM)){
		$result[] = array(
			"callNo" => $callno,
			"title" => $title,
			"author" => $author,
			"publisher" => $publisher,
			"year" => $year,
			"edition" => $edition,
			"ISBN" => $isbn,
			"ISSN" => $issn,
			"noOfCopy" => $noofcopy,
			"genreID" => $genre
		);
	}
	return $result;
}

?>