<?php
function db_update($parentid, $value, $valueColumn){
	$value = addslashes($value);
	$result = 0;
	$query = "UPDATE content SET $valueColumn = \"$value\" WHERE parentid = \"$parentid\"";
	$result = exec_non_query($query);
	return $result;
}

function data_bookSubjectByBook($id){
	$result = "";
	$query = "SELECT genre FROM catalogue WHERE id = \"$id\"";
	$result = exec_scalar($query);
	return $result;
}

// get a list of subjects (genre)
function data_subjects(){
	$result = "";
	$query = "SELECT id, genreid, name FROM cataloguegenre";
	$resultset = exec_reader($query);
	while(list($id, $genreid, $name) = mysql_fetch_array($resultset, MYSQL_NUM)){
		$result[] = array(
			"id" => $id,
			"code" => $genreid,
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

// get all books under a subject
function data_books($id){
	$result = "";
	$query = "SELECT id, callno, title, author, publisher, bookyear, edition, isbn, issn, noofcopy FROM catalogue WHERE genre=\"$id\" ORDER BY title;";
	$resultset = exec_reader($query);
	while(list($id, $callno, $title, $author, $publisher, $year, $edition, $isbn, $issn, $noofcopy) = mysql_fetch_array($resultset, MYSQL_NUM)){
		$result[] = array(
			"id" => $id,
			"callNo" => $callno,
			"title" => $title,
			"author" => $author,
			"publisher" => $publisher,
			"year" => $year,
			"edition" => $edition,
			"ISBN" => $isbn,
			"ISSN" => $issn,
			"noOfCopy" => $noofcopy
		);
	}
	return $result;
}

// get details of one book
function data_bookDetails($id){
	$result = "";
	$query = "SELECT callno, title, author, publisher, bookyear, edition, isbn, issn, noofcopy FROM catalogue WHERE id=\"$id\"";
	$resultset = exec_reader($query);
	while(list($callno, $title, $author, $publisher, $year, $edition, $isbn, $issn, $noofcopy) = mysql_fetch_array($resultset, MYSQL_NUM)){
		$result[] = array(
			"callNo" => $callno,
			"title" => $title,
			"author" => $author,
			"publisher" => $publisher,
			"year" => $year,
			"edition" => $edition,
			"ISBN" => $isbn,
			"ISSN" => $issn,
			"noOfCopy" => $noofcopy
		);
	}
	return $result;
}

// add books
function db_addBook($callNo, $title, $author, $publisher, $year, $edition, $ISBN, $ISSN, $noOfCopy, $subject){
	$result = 0;
	$query = "INSERT INTO catalogue (callno, title, author, publisher, bookyear, edition, isbn, issn, noofcopy, genre) VALUES (\"$callNo\", \"$title\", \"$author\", \"$publisher\", \"$year\", \"$edition\", \"$ISBN\", \"$ISSN\", \"$noOfCopy\", \"$subject\");";
	$result = exec_non_query($query);
	return $result;
}

// edit book
function db_editBook($id, $callNo, $title, $author, $publisher, $year, $edition, $ISBN, $ISSN, $noOfCopy, $subject){
	$result = 0;
	$query = "UPDATE catalogue SET callno = \"$callNo\", title = \"$title\", author = \"$author\", publisher = \"$publisher\", bookyear = \"$year\", edition = \"$edition\", isbn = \"$ISBN\", issn = \"$ISSN\", noofcopy = \"$noOfCopy\", genre = \"$subject\" WHERE id = \"$id\"";
	$result = exec_non_query($query);
	return $result;
}

// delete
function db_del($id, $table){
	$result = "";
	$query = "DELETE FROM $table WHERE id = $id;";
	$result = exec_non_query($query);
	return $result;
}

// update subject
function db_updateSubject($id, $code, $subject){
	$subject = addslashes($subject);
	$result = 0;
	$query = "UPDATE cataloguegenre SET name = \"$subject\", genreid = \"$code\" WHERE id = \"$id\"";
	$result = exec_non_query($query);
	return $result;
}

// add new subject
function db_addNewSubject($code, $subject){
	$subject = addslashes($subject);
	$result = 0;
	$query = "INSERT INTO cataloguegenre (genreid, name) VALUES (\"$code\", \"$subject\");";
	$result = exec_non_query($query);
	return $result;
}

?>