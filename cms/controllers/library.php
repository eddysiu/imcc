<?php

// get config value in one specfic language
function getContentInOneLang($tab, $lang){
	$result = "";
	$id = getCatIDByAbbr($tab);
	$lang = "content".$lang;
	$result = htmlspecialchars(data_contentInOneLang($id, $lang));
	return $result;
}

function updateDB($parentid, $contentEN, $contentTW, $contentCN){
	$results;
	
	$results[] = db_update($parentid, $contentEN, "contentEN");
	$results[] = db_update($parentid, $contentTW, "contentTW");
	$results[] = db_update($parentid, $contentCN, "contentCN");
	
	if(in_array("-1", $results)){
		return false;
	} else {
		return true;
	}
}

// -------- for online catalogue ---------

function br2nl($string){
	$string = trim(preg_replace('/\s\s+/', '', $string));
	$string = preg_replace('/<br\\s*?\/??>/i', "\n", $string);
    return $string;
}

// get all subjects
function getSubjectList(){
	$list = "";
	$list = data_subjects();
	return $list;
}

// get all books under a subject
function getBookList($id){
	$list = "";
	$list = data_books($id);
	return $list;
}

// get details of one book
function getBookDetails($id){
	$details = "";
	$details = data_bookDetails($id);
	$details = $details[0];	// only need the first row
	return $details;
}

// get the subject of the current book
function getCurrentBookSubject($id){
	$subject = "";
	$subject = data_bookSubjectByBook($id);
	return $subject;
}

// get the details of the subject by genreid (for search result)
function getBookSubject($id){
	$subject = "";
	$details = data_bookSubject($id);
	$subject = $details[0]["name"];
	return $subject;
}

// add books
function addBooks(){
	// process the data
	$subject = $_POST["subject"];
	$callNo = (isset($_POST["callNo"])?$_POST["callNo"]:array());
	$title = $_POST["title"];
	$author = (isset($_POST["author"])?$_POST["author"]:array());
	$publisher = (isset($_POST["publisher"])?$_POST["publisher"]:array());
	$year = (isset($_POST["year"])?$_POST["year"]:array());
	$edition = (isset($_POST["edition"])?$_POST["edition"]:array());
	$ISBN = (isset($_POST["ISBN"])?$_POST["ISBN"]:array());
	$ISSN = (isset($_POST["ISSN"])?$_POST["ISSN"]:array());
	$noOfCopy = (isset($_POST["noOfCopy"])?$_POST["noOfCopy"]:array());
	
	// insert to db
	for ($i = 0; $i < count($title); $i++){
		if ($title[$i] != ""){
			$title[$i] = addslashes(htmlspecialchars($title[$i]));
			
			if (!isset($callNo[$i])){
				$callNo = "";
			} else {
				$callNo = $callNo[$i];
			}
			
			if (!isset($author[$i])){
				$author = "";
			} else {
				$author = nl2br(addslashes(htmlspecialchars($author[$i])));
			}
			
			if (!isset($publisher[$i])){
				$publisher = "";
			} else {
				$publisher = nl2br(addslashes(htmlspecialchars($publisher[$i])));
			}
			
			if (!isset($year[$i])){
				$year = "";
			} else {
				$year = $year[$i];
			}
			
			if (!isset($edition[$i])){
				$edition = "";
			} else {
				$edition = $edition[$i];
			}
			
			if (!isset($ISBN[$i])){
				$ISBN = "";
			} else {
				$ISBN = $ISBN[$i];
			}
			
			if (!isset($ISSN[$i])){
				$ISSN = "";
			} else {
				$ISSN = $ISSN[$i];
			}
			
			if (!isset($noOfCopy[$i])){
				$noOfCopy = "";
			} else {
				$noOfCopy = $noOfCopy[$i];
			}
		
			$results[] = db_addBook($callNo, $title[$i], $author, $publisher, $year, $edition, $ISBN, $ISSN, $noOfCopy, $subject[$i]);
		}
	}
	
	if(in_array("-1", $results)){
		return false;
	} else {
		return true;
	}
}

// edit books
function editBook(){
	// process the data
	$id = $_GET["id"];
	$subject = $_POST["subject"];
	$callNo = (isset($_POST["callNo"])?$_POST["callNo"]:"");
	$title = addslashes(htmlspecialchars($_POST["title"]));
	$author = (isset($_POST["author"])?(nl2br(addslashes(htmlspecialchars($_POST["author"])))):"");
	$publisher = (isset($_POST["publisher"])?(nl2br(addslashes(htmlspecialchars($_POST["publisher"])))):"");
	$year = (isset($_POST["year"])?$_POST["year"]:"");
	$edition = (isset($_POST["edition"])?$_POST["edition"]:"");
	$ISBN = (isset($_POST["ISBN"])?$_POST["ISBN"]:"");
	$ISSN = (isset($_POST["ISSN"])?$_POST["ISSN"]:"");
	$noOfCopy = (isset($_POST["noOfCopy"])?$_POST["noOfCopy"]:"");
	
	$result = db_editBook($id, $callNo, $title, $author, $publisher, $year, $edition, $ISBN, $ISSN, $noOfCopy, $subject[0]);

	return $result;
}

// update subjects
function updateSubjects(){
	if (isset($_POST["newSubject"])){
		$newSubject = $_POST["newSubject"];
		$newCode = $_POST["newCode"];
	}
	
	$id = $_POST["id"];
	$code = $_POST["code"];
	$subject = $_POST["subject"];
	
	for ($i = 0; $i < count($id); $i++){
		$results[] = db_updateSubject($id[$i], $code[$i], $subject[$i]);
	}
	
	if (isset($newSubject)){
		for ($i = 0; $i < count($newSubject); $i++){
			if (($newSubject[$i] != "") || ($newCode[$i] != "")){
				$results[] = db_addNewSubject($newCode[$i], $newSubject[$i]);
			}
		}
	}
	
	if(in_array("-1", $results)){
		return false;
	} else {
		return true;
	}	
}

// delete book/subject
function del(){
	$id = $_GET["id"];
	$type = $_GET["type"];
	
	if ($type == "book"){
		$results[] = db_del($id, "catalogue");
	}
	
	if ($type == "subject"){
		// delete all books under this subject first
		$bookList = data_books($id);
		if (!empty($bookList)){
			foreach ($bookList as $book){
				$bookid = $book["id"];
				$results[] = db_del($bookid, "catalogue");
			}
		}
		$results[] = db_del($id, "cataloguegenre");
	}
	
	
	if(in_array("-1", $results)){
		return false;
	} else {
		return true;
	}
}
?>