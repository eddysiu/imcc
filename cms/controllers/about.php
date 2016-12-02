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

/************ for gallery ************/

// get a list of album category (e.g. open ceremony)
function getListOfAlbumCat(){
	$list = "";
	$list = db_listOfAlbumCat();
	return $list;
}

// get a list of album
function getListOfAlbum(){
	$list = "";
	$list = db_listOfAlbum();
	return $list;
}

// update and insert new albums (create folder)
function updateAlbum(){
	// process new album
	if (isset($_POST["newAlbumCat"])){
		// if there are any new albums
		$newAlbumCat = $_POST["newAlbumCat"];
		$newAlbumDate = $_POST["newAlbumDate"];
		$newAlbumName = $_POST["newAlbumName"];
		if (isset($_POST["newAlbumOrgan"])){
			$newAlbumOrgan = $_POST["newAlbumOrgan"];
		}
		
		for ($i = 0; $i < count($newAlbumCat); $i++){
			$newCat = $newAlbumCat[$i];
			$newDate = $newAlbumDate[$i];
			$newName = $newAlbumName[$i];
			if (isset($newAlbumOrgan)){
				$newOrgan = $newAlbumOrgan[$i];
			} else {
				$newOrgan = "";
			}
			
			if ($newCat != ""){
				// create new album folders first
				$newPath = "../img/album/$newDate";
				$newPathDL = "../img/album/$newDate/download";
				$newPathLarge = "../img/album/$newDate/enlarge";
				
				if (!mkdir($newPath, 0755, true)) {
					die("Error! Please contact administorator.");
				}
				if (!mkdir($newPathDL, 0755, true)) {
					die("Error! Please contact administorator.");
				}
				if (!mkdir($newPathLarge, 0755, true)) {
					die("Error! Please contact administorator.");
				}
				$results[] = db_addNewAlbum($newCat, $newDate, $newName, $newOrgan);
			}
		}
	} // end new albums part
	
	// update currentAlbums
	$albumID = $_POST["albumID"];
	$albumCat = $_POST["albumCat"];
	$albumName = $_POST["albumName"];
	$albumOrgan = $_POST["albumOrgan"];
	
	for ($i = 0; $i < count($albumID); $i++){
		$id = $albumID[$i];
		$cat = $albumCat[$i];
		$name = $albumName[$i];
		$organ = $albumOrgan[$i];
		$results[] = db_updateAlbum($id, $cat, $name, $organ);
	}
		
 	if(in_array("-1", $results)){
		return false;
	} else {
		return true;
	}
}

// del albums (and also all files)
function delAlbum(){
	$id = $_GET["id"];
	$date = $_GET["date"];
	
	$path = "../img/album/$date";
	$pathDL = "../img/album/$date/download";
	$pathLarge = "../img/album/$date/enlarge";
	
	// remove files
	$files = glob("$pathLarge/*"); // get all file names
	foreach($files as $file){ // iterate files
		if(is_file($file)){
			unlink($file); // delete file
		}
	}
	
	$files = glob("$pathDL/*"); // get all file names
	foreach($files as $file){ // iterate files
		if(is_file($file)){
			unlink($file); // delete file
		}
	}
	
	$files = glob("$path/*"); // get all file names
	foreach($files as $file){ // iterate files
		if(is_file($file)){
			unlink($file); // delete file
		}
	}
	
	// remove folder
	if (!rmdir($pathDL)){
		die("Error! Please contact administrator.");
	}
	if (!rmdir($pathLarge)){
		die("Error! Please contact administrator.");
	}
	if (!rmdir($path)){
		die("Error! Please contact administrator.");
	}
	
	// remove from db
	$result = db_del($id);
	
	return $result;
	
}
?>