<?php

// get gallery list (e.g. special events, others)
function getGalleryList($tab){
	$list = "";
	$id = getSubCatIDByURL($tab);
	$list = data_galleryList($id);
	return $list;
}

// get album list
function getAlbumList($abbr){
	$list = "";
	$id = getCatIDByAbbr($abbr);
	$list = data_albumList($id);
	return $list;
}

function isValidAlbum($album){
	$isValid = false;
	$existAlbum = int_albumExist($album);
	if ($existAlbum > 0) {
		$isValid = true;
	}
	return $isValid;
}

// get the title, organizer and parentid
function getAlbumDetails($album){
	$details = "";
	$details = data_albumDetails($album);
	return $details;
}

// get the album catagory (e.g. seminar) by id
function getAlbumCategory($parentid){
	$category = "";
	$category = data_albumCategory($parentid);
	return $category;
}

function getPhoto($album){
	$photoList = "";
	$path = displayTextInDiffLang("albumFolderPath")."$album/*.*";	// e.g. ./img/album/2009-01-01/*.*
	$photoList = glob($path); 
	// get the filename under the folder
	return $photoList;
}

function getBrochure(){
	$brochure = "";
	$brochure = data_configValue("brochure");
	return $brochure;
}

?>