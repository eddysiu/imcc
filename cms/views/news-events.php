<?php
// get the current tab
if (isset($_GET["tab"])){
	$tab = $_GET["tab"];
} else {
	$tab = "";
}

// get the current action
$action = getCurrentAction();

// detect form is submitted or not
function formIsSubmitted(){
	$action = getCurrentAction();
	$isSubmitted = false;
	if ((isset($_POST["submit"])) || (($action == "del") && (isset($_GET["id"])))){
		$isSubmitted = true;
	}
	return $isSubmitted;
}

// display news (normal mode)
function displayNews($tab, $listOfNews){
	$currentYear = "";
	echo '		<table border="0" cellpadding="2" width="100%">'."\n";
	echo '			<tr>'."\n";
	echo '				<th width="4%">Edit</th>'."\n";
	echo '				<th width="4%">Del</th>'."\n";
	echo '				<th width="7%">Start</th>'."\n";
	echo '				<th width="7%">End</th>'."\n";
	echo '				<th width="40%">Title and Content</th>'."\n";
	echo '				<th width="20%">Source</th>'."\n";
	echo '				<th width="7%">Article?</th>'."\n";
	echo '				<th width="7%">Main?</th>'."\n";
	echo '			</tr>'."\n";
	foreach ($listOfNews as $news){
		// process data
		$id = $news["id"];
		$startDate = $news["start"];
		$endDate = $news["end"];
		$title = $news["title"];
		$source = $news["source"];
		$isExpand = $news["isExpand"];
		$isShown = $news["isShown"];
		if ($isExpand){
			$content = "./news-events_preview.php?id=$id";
		} else {
			$content = correctPdfURL($news["content"]);
		}
		
		$editURL = "./".getCurrentFilename()."?tab=$tab&amp;action=edit&amp;id=$id";
		$delURL = "./".getCurrentFilename()."?tab=$tab&amp;action=del&amp;id=$id";
		
		// display td
		echo "			<tr>"."\n";
		echo '				<td valign="top"><a href="'.$editURL.'"><img src="./img/edit.png" title="Edit"></a>'."</td>"."\n";
		echo '				<td valign="top"><a href="'.$delURL.'" onclick="return confirm(\'Do you really want to delete the selected piece of news?\')"><img src="./img/delete.png" title="Delete"></a>'."</td>"."\n";
		echo '				<td valign="top">'.$startDate."</td>"."\n";
		echo '				<td valign="top">'.$endDate."</td>"."\n";
		echo '				<td valign="top">'."<a href='$content' target='_blank'>$title</a>"."</td>"."\n";
		echo '				<td valign="top">'.$source."</td>"."\n";
		if ($isExpand){
			echo '				<td valign="top" align="center">Yes'."</td>"."\n";
		} else {
			echo '				<td valign="top" align="center">'."</td>"."\n";
		}
		if ($isShown){
			echo '				<td valign="top" align="center">Yes'."</td>"."\n";
		} else {
			echo '				<td valign="top" align="center">'."</td>"."\n";
		}
		echo "			</tr>"."\n";
	}
	echo '		</table>'."\n";
}

if (isValidTab($tab)){
	// // $parentid = getCatIDByAbbr($tab);
	$addUrl = "./".getCurrentFilename()."?tab=$tab&amp;action=add";
	if (!formIsSubmitted()){
		// ------------------------ if the form is NOT submitted ---------------
		$title = getContentTitle($tab);
?>
	<div class="main">
		<p><h1>News & Events: <?php echo $title ?></h1>
		
<?php
		/******* normal mode ******/
		if (($action == "") || ($action == "del")){
			// note that del mode only when action = del AND id is set
			echo "		<p><a href=\"$addUrl\" class=\"largeButton\">Add New</a>"."\n";
			echo "		<p>&nbsp;"."\n";
			$listOfNews = getNews($tab);
			if ($listOfNews != ""){	// if there is news
				displayNews($tab, $listOfNews);
			} else {
				echo "		<p>News Not Found."."\n";
			} // end display news
		}
		
		/********** add mode *******/
		if ($action == "add"){
			include_once("./views/news-events_add.php");
		}
		
		/******** edit mode *******/
		if ($action == "edit"){
			include_once("./views/news-events_edit.php");
		}

?>
	</div>
<?php
	} else {
		// ------------------------ if the form is submitted ---------------
		
		$redirectURL = "./".getCurrentFilename()."?tab=$tab";
		
		/*********** add mode ***********/
		if ($action == "add"){
			if (addNews()){	?>
	<meta http-equiv=Refresh content="2; url=<?php echo $redirectURL ?>" />
	<div class="main">
		<p><h1>Add successfully</h1>
		<p>The news has been added. Redirect to the list...
	</div>
<?php
			} else {	// if there is any error	?>
	<meta http-equiv=Refresh content="2; url=<?php echo $redirectURL ?>" />
	<div class="main">
		<p><h1 class="error">Error!</h1>
		<p>Database error. Please try again or contact the administrator.
	</div>
<?php
			}
		}
			
		/************* edit mode *********/
		if ($action == "edit"){
			if (editNews() >= 0){	?>
	<meta http-equiv=Refresh content="2; url=<?php echo $redirectURL ?>" />
	<div class="main">
		<p><h1>Edit successfully</h1>
		<p>The news has been updated. Redirect to the list...
	</div>
<?php		} else {	// if there is any error	?>
	<meta http-equiv=Refresh content="2; url=<?php echo $redirectURL ?>" />
	<div class="main">
		<p><h1 class="error">Error!</h1>
		<p>Database error. Please try again or contact the administrator.
	</div>
<?php
			}	// end error
		} // end edit part
		
		/**************** del mode ***********/
		if ($action == "del"){
			if (delNews() >= 0){	?>
	<meta http-equiv=Refresh content="2; url=<?php echo $redirectURL ?>" />
	<div class="main">
		<p><h1>Delete successfully</h1>
		<p>The news has been deleted. Redirect to the list...
	</div>
<?php		} else {	// if there is any error	?>
	<meta http-equiv=Refresh content="2; url=<?php echo $redirectURL ?>" />
	<div class="main">
		<p><h1 class="error">Error!</h1>
		<p>Database error. Please try again or contact the administrator.
	</div>
<?php
			} // end error
		} // end del part
	} // end form is submitted
} else {
	// invalid tab
?>
	<div class="main">
		<p><h1 class="error">Error!</h1>
		<p>Page not found. Please <a href="javascript:history.go(-1)">go back</a> and try again.
	</div>
</div>
<?php
} // end all cases
?>
