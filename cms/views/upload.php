<?php
$action = getCurrentAction();

// get the current tab
if (isset($_GET["tab"])){
	$tab = $_GET["tab"];
} else {
	$tab = "";
}

// detect form is submitted or not
function formIsSubmitted(){
	$action = getCurrentAction();
	$isSubmitted = false;
	if ((isset($_POST["submit"])) || ($action == "del")){
		$isSubmitted = true;
	}
	return $isSubmitted;
}

if (!formIsSubmitted()){
	// ------------------------ if the form is NOT submitted ---------------
?>
	<div class="main">
		<p><h1>Upload Files</h1>
		<p><a href="./upload.php?tab=gallery" class="largeButton">Gallery Photos</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="./upload.php?tab=news" class="largeButton">News</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="./upload.php?tab=newsletter" class="largeButton">Newsletter</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="./upload.php?tab=publication" class="largeButton">Publication</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="./upload.php?tab=others" class="largeButton">Others</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<p>&nbsp;
		
<?php
	if ($tab != ""){
		// set path
		if ($tab == "gallery"){
			/****** gallery mode *****/
			if ((!isset($_GET["gallery"])) && (!isset($_GET["type"]))){
				echo "		<p>Please select the album and the type of the photos:"."\n";
				$albums = getListOfAlbum();
				if ($albums != ""){
					echo "		<table width='100%' cellpadding='2' border='0'>"."\n";
					foreach ($albums as $album){
						$date = $album["date"];
						$title = $album["title"];
						echo "			<tr>"."\n";
						echo "				<td>$date</td>"."\n";
						echo "				<td>$title</td>"."\n";
						echo "				<td><a href=\"./upload.php?tab=$tab&amp;action=upload&amp;gallery=$date&amp;type=small\">Preview (Small)</a></td>"."\n";
						echo "				<td><a href=\"./upload.php?tab=$tab&amp;action=upload&amp;gallery=$date&amp;type=medium\">Enlarge (Medium)</a></td>"."\n";
						echo "				<td><a href=\"./upload.php?tab=$tab&amp;action=upload&amp;gallery=$date&amp;type=large\">Download (Large)</a></td>"."\n";
						echo "			</tr>"."\n";
					}
					echo "		</table>"."\n";
				}
			} else {
				$gallery = $_GET["gallery"];
				$type = $_GET["type"];
				switch ($type){
					case "small": $path = "../img/album/$gallery"; break;
					case "medium": $path = "../img/album/$gallery/enlarge"; break;
					case "large": $path = "../img/album/$gallery/download"; break;
				}
			}
		} else {
			/******** normal mode *******/
			switch ($tab){
				case "news": $path = "../upload/news"; break;
				case "newsletter": $path = "../upload/newsletter/shipping"; break;
				case "publication": $path = "../upload/publication"; break;
				case "others": $path = "../upload/pdf"; break;
			}
		}
		
		// display upload form and upload list
		if (isset($path)){
			if ($tab != "gallery"){
				echo "		<h2>Upload New Files: ".Ucwords($tab)."</h2>"."\n";
				echo "		<form action=\"./upload.php?tab=$tab&amp;action=upload\" method=\"post\" enctype=\"multipart/form-data\">"."\n";
			} else {
				echo "		<h2>Upload New Files: ".Ucwords($tab)." ($gallery) ($type size)</h2>"."\n";
				echo "		<form action=\"./upload.php?tab=$tab&amp;action=upload&amp;gallery=$gallery&amp;type=$type\" method=\"post\" enctype=\"multipart/form-data\">"."\n";
			}
			echo "			<input name=\"upload[]\" id=\"upload\" type=\"file\" multiple />"."\n";
			echo "			<p>* Only English filename is accepted"."\n";
			echo "			<p align=\"center\"><input name=\"submit\" type=\"submit\" value=\"Upload\">"."\n";
			echo "		</form>"."\n";
			
			echo "		<h2>Current Files</h2>"."\n";
			$files = glob("$path/*"); // get all file names
			if (!empty($files)){
				echo "		<table width='100%' cellpadding='2' border='0'>"."\n";
				echo "			<tr>"."\n";
				echo "				<th>Del</th>"."\n";
				echo "				<th>File name</th>"."\n";
				echo "				<th>File URL</th>"."\n";
				echo "			</tr>"."\n";
				foreach ($files as $file){
					$file = str_replace($path."/", "", $file);
					// in gallery mode, the related folder may contains folder "download" and "enlarge" (just exclude these two folders)
					if (($file != "download") && ($file != "enlarge")){
						$url = str_replace("../", "", $path);
						$url = "http://www.imcc.polyu.edu.hk/".$url;
						echo "			<tr>"."\n";
						if ($tab != "gallery"){
							echo "				<td><a href=\"./upload.php?tab=$tab&amp;action=del&amp;filename=$file\" onclick=\"return confirm('Do you really want to delete the selected file?')\"><img src=\"./img/delete.png\" title=\"Delete\"></a></td>"."\n";
						} else {
							echo "				<td><a href=\"./upload.php?tab=$tab&amp;action=del&amp;filename=$file&amp;gallery=$gallery&amp;type=$type\" onclick=\"return confirm('Do you really want to delete the selected file?')\"><img src=\"./img/delete.png\" title=\"Delete\"></a></td>"."\n";
						}
						echo "				<td>$file</td>"."\n";
						echo "				<td><a href=\"$url/$file\" target=\"_blank\">$url/$file</a></td>"."\n";
						echo "			</tr>"."\n";
					}
				}
				echo "		</table>"."\n";
			}
		} // end display upload form and upload list
	}

?>
	</div>
<?php
} else {
	// ------------------------ if the form is submitted ---------------
	
	if ($action == "upload"){
		$noOfFiles = uploadFiles();
		if ($noOfFiles > 0){	?>
	<meta http-equiv=Refresh content="2; url=./upload.php?tab=<?php echo $tab?>" />
	<div class="main">
		<p><h1>Upload successfully</h1>
		<p><?php echo $noOfFiles?> file(s) have been uploaded. Redirect to the list...
	</div>
<?php
		} else {	// if there is any error	?>
	<meta http-equiv=Refresh content="2; url=./upload.php?tab=<?php echo $tab?>" />
	<div class="main">
		<p><h1 class="error">Error!</h1>
		<p>Database error. Please try again or contact the administrator.
	</div>
<?php
		}
	} 
	
	/**************** del mode ***********/
	if ($action == "del"){
		if (del()){	?>
	<meta http-equiv=Refresh content="2; url=./upload.php?tab=<?php echo $tab?>" />
	<div class="main">
		<p><h1>Delete successfully</h1>
		<p>The file has been deleted. Redirect to the list...
	</div>
<?php
		} else {	// if there is any error	?>
	<meta http-equiv=Refresh content="2; url=./upload.php?tab=<?php echo $tab?>" />
	<div class="main">
		<p><h1 class="error">Error!</h1>
		<p>Database error. Please try again or contact the administrator.
	</div>
<?php
		}
	} // end del mode 
} // end form is submitted
?>