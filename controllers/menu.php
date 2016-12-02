<?php

// sub menu (left)
function getLeftSubMenu(){
	$subMenu = "";
	$catID = getMainCatIDByURL();
	$subMenu = getSubCatList($catID);
	return $subMenu;
}


?>