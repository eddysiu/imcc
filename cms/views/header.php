<?php

function displayMenu(){
	$mainCatList = getMainCatList();
	$waitForApproval = getNoOfWaitingPost();
	foreach ($mainCatList as $mainCat){
		if (($mainCat["name"] == "Contact Us")){
			// do not show "Contact Us" (as the related settings are in home (index.php))
			break;
		}
		if ($mainCat["name"] == "Home"){
			// provides hyper link for "Home"
			echo '			<li><a href="./index.php">General Setting</a></li>'."\n";
			echo '			<li><a href="./texteditor.php">Text Editor</a></li>'."\n";
			echo '			<li><a href="./quicklink.php">Quick Links</a></li>'."\n";
			echo '			<li><a href="./notice.php">Urgent Notice</a></li>'."\n";
			echo '			<li><a href="./message.php">Message Board ('.$waitForApproval.')</a></li>'."\n";
			echo '			<li><a href="./upload.php">Upload Files</a></li>'."\n";
		} else {
			echo "			<li>"."\n";
			echo '				'.$mainCat["name"]."\n";
			$subCatList = getSubCatList($mainCat["id"]);
			if ($subCatList != ""){
				echo '			<ul>'."\n";
				foreach ($subCatList as $subCat){
					echo '				<li><a href="./'.$mainCat["abbr"].'.php?tab='.$subCat["abbr"].'">'.$subCat["name"].'</a></li>'."\n";
				} // end sub cat foreach
				echo '			</ul>'."\n";
			} // end if
			echo "			</li>"."\n";
		} // end main cat foreach
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="UTF-8">
	<title><?php echo getTitle() ?></title>
	<link rel="icon" type="image/ico" href="../img/favicon.ico"/>
	<link href="./css/style.css" rel="stylesheet">
	<link href="./css/style_editor.css" rel="stylesheet">
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script type="text/javascript" src="./js/packed.js"></script> <!-- html editor -->
	<script type="text/javascript" src="./js/tinyeditor.js"></script> <!-- html editor -->
	<script>
	$(document).ready(function () {		
		// set two divs as the same height
		var heightArray = [$(".main").height(), 1100]
		$(".nav").height(Math.max.apply(Math, heightArray));
		$(".main").height(Math.max.apply(Math, heightArray));
	});
	
	function logout() {
		var xmlhttp;
		if (window.XMLHttpRequest) {
			xmlhttp = new XMLHttpRequest();
		}
		// code for IE
		else if (window.ActiveXObject) {
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		if (window.ActiveXObject) {
			// IE clear HTTP Authentication
			document.execCommand("ClearAuthenticationCache");
			window.location.href='http://www.imcc.polyu.edu.hk/';
		} else {
			xmlhttp.open("GET", './index.php', true, "logout", "logout");
			xmlhttp.send("");
			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState == 4) {window.location.href='http://www.imcc.polyu.edu.hk/';}
			}
		}
		return false;
	}
	</script>
</head>
<body>
<div class="container">
	<div class="header">
		<p style="float: right; padding: 55px 10px 10px 10px;">
			<a href="./guide.pdf" target="_blank">Help Documemnt</a>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="javascript:void(0)" onclick="logout();">Logout</a>
		<p><a href="./index.php"><img src="./img/logo.png" title="PolyU IMCC Website CMS"/></a>
	</div>
		
	<div class="nav">
		<ul>
<?php			displayMenu();	?>
		</ul>
	</div>
