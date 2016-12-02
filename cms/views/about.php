<script>
function displayAddNewAlbum(){
	document.getElementById("newAlbumTable").style.display = "block";
	// adjust the height again
	$(".nav").height(function(index, height){return (height+200)});
	$(".main").height(function(index, height){return (height+200)});
}

function isBlankInput(value1, value2, value3, value4){
	// if any one of the fields is filled, then NOT blank
	if ((value1 != "") || (value2 != "") || (value3 != "") || (value4 != "")){
		return false;
	} else {
		return true;
	}
}

function isValidDate(dateString) {
	var regEx = /^\d{4}-\d{2}-\d{2}$/;
	return dateString.match(regEx) != null;
}

// it looks stupid anyway I have no time to modify it
function hasNoSameDate(value1, value2, value3, value4, value5){
	var sameDate = false;
	if ((value1 == "") && (value2 == "") && (value3 == "") && (value4 == "") && (value5 == "")){
		// if just blank inputs, then true
		return true;
	} else {
		if (value1 != ""){
			switch (value1){
				case value2: return false;
				case value3: return false;
				case value4: return false;
				case value5: return false;
			}
		}
		if (value2 != ""){
			switch (value2){
				case value1: return false;
				case value3: return false;
				case value4: return false;
				case value5: return false;
			}
		}
		if (value3 != ""){
			switch (value3){
				case value1: return false;
				case value2: return false;
				case value4: return false;
				case value5: return false;
			}
		}
		if (value4 != ""){
			switch (value4){
				case value1: return false;
				case value2: return false;
				case value3: return false;
				case value5: return false;
			}
		}
		if (value5 != ""){
			switch (value5){
				case value1: return false;
				case value2: return false;
				case value3: return false;
				case value4: return false;
			}
		}
		return true;
	}
}

function validateForm() {
	var errorMsg = "";

	// for new albums
	var newAlbumCat = document.getElementsByName("newAlbumCat[]");
	var newAlbumDate = document.getElementsByName("newAlbumDate[]");
	var newAlbumName = document.getElementsByName("newAlbumName[]");
	var newAlbumOrgan = document.getElementsByName("newAlbumOrgan[]");

	if (!hasNoSameDate(newAlbumDate[0].value, newAlbumDate[1].value, newAlbumDate[2].value, newAlbumDate[3].value, newAlbumDate[4].value)){
		errorMsg += "- The dates of the new albums should NOT be the same\n";
	}
	
	for (i = 0; i < 5; i++){
		var fieldIndex = i+1;
		if (!isBlankInput(newAlbumCat[i].value, newAlbumDate[i].value, newAlbumName[i].value, newAlbumOrgan[i].value)){
			if (newAlbumCat[i].value == ""){
				errorMsg += "- For new albums ("+fieldIndex+"-input): Please select a category\n";
			}
			if (!isValidDate(newAlbumDate[i].value)){
				errorMsg += "- For new albums ("+fieldIndex+"-input): Please input a valid date (YYYY-mm-dd)\n";
			}
			if (newAlbumName[i].value == ""){
				errorMsg += "- For new albums ("+fieldIndex+"-input): Please input a title\n";
			}
		}
	}
	
	// for current albums
	var albumCat = document.getElementsByName("albumCat[]");
	var albumName = document.getElementsByName("albumName[]");
	
	for (i = 0; i < albumCat.length; i++){
		var fieldIndex = i+1;
		if (albumCat[i].value == ""){
			errorMsg += "- For current albums ("+fieldIndex+"-input): Please select a category\n";
		}
		
		if (albumName[i].value == ""){
			errorMsg += "- For current albums ("+fieldIndex+"-input): Please input a title\n";
		}
	}
	
	
	if (errorMsg != ""){
		errorMsg = "Please check the following:\n\n" + errorMsg;
		alert(errorMsg);
		return false;
	} else {
		return true;
	}
}

</script>
<?php
// get the current tab
$tab = "";

if (isset($_GET["tab"])){
	$tab = $_GET["tab"];
} else {
	$tab = "";
}

function displayAlbumCatList($currentAlbumParentID){
	$albumCatList = getListOfAlbumCat();
	echo '						<select name="albumCat[]">'."\n";
	foreach ($albumCatList as $album){
		$id = $album["id"];
		$name = $album["name"];
		if ($currentAlbumParentID == $id){
			echo "							<option value=\"$id\" selected=\"selected\">$name</option>"."\n";
		} else {
			echo "							<option value=\"$id\">$name</option>"."\n";
		}
	}
	echo "						</select>"."\n";
}

function displayNewAlbumFields(){
	$albumCatList = getListOfAlbumCat();
	echo '			<table width="100%" style="display: none;" id="newAlbumTable">'."\n";
	echo '				<tr>'."\n";
	echo '					<th>Catagory</th>'."\n";
	echo '					<th>Date</th>'."\n";
	echo '					<th>Name</th>'."\n";
	echo '					<th>Organizer</th>'."\n";
	echo '				</tr>'."\n";
	for ($i = 0; $i < 5; $i++){
		echo "				<tr>"."\n";
		echo "					<td>"."\n";
		echo '						<select name="newAlbumCat[]">'."\n";
		echo '							<option value="">---------------</option>'."\n";
		foreach ($albumCatList as $album){
			$id = $album["id"];
			$name = $album["name"];
			echo "							<option value=\"$id\">$name</option>"."\n";
		}
		echo "						</select>"."\n";
		echo '					</td>'."\n";
		echo '					<td><input type="text" name="newAlbumDate[]" size="30" /></td>'."\n";
		echo '					<td><input type="text" name="newAlbumName[]" size="30" /></td>'."\n";
		echo '					<td><input type="text" name="newAlbumOrgan[]" size="30" /></td>'."\n";
		echo '				</tr>'."\n";
	} // end for loop
	echo '			</table>'."\n";
}

if ((isset($_POST["submit"])) || (isset($_GET["action"]))){
	if ($tab != "gallery"){
		/*********** normal mode ********/
		// process data
		$tab = $_POST["tab"];	// for redirect only
		$parentid = $_POST["parentid"];
		$contentEN = $_POST["contentEN"];
		$contentTW = $_POST["contentTW"];
		$contentCN = $_POST["contentCN"];
		
		$result = updateDB($parentid, $contentEN, $contentTW, $contentCN);
		
		if ($result){	// if success	?>
	<meta http-equiv=Refresh content="2; url=about.php?tab=<?php echo $tab ?>" />
	<div class="main">
		<p><h1>Update successfully</h1>
		<p>The page has been updated. Redirect to the previous page...
	</div>
<?php
		} else {	// if fail	?>
	<meta http-equiv=Refresh content="5; url=about.php?tab=<?php echo $tab ?>">
	<div class="main">
		<p><h1 class="error">Error!</h1>
		<p>Database error. Please try again or contact the administrator.
	</div>
<?php
		}	// end if update
	} else {
		/************* gallery mode ************/
		if (isset($_GET["action"])){
			if ($_GET["action"] == "del"){
				/******** delete mode *****/
				if (delAlbum() >= 0){	// if success	?>
	<meta http-equiv=Refresh content="2; url=about.php?tab=<?php echo $tab ?>" />
	<div class="main">
		<p><h1>Delete successfully</h1>
		<p>The gallery has been deleted. Redirect to the previous page...
	</div>
<?php
				} else {	// if fail	?>
	<meta http-equiv=Refresh content="5; url=about.php?tab=<?php echo $tab ?>">
	<div class="main">
		<p><h1 class="error">Error!</h1>
		<p>Database error. Please try again or contact the administrator.
	</div>
<?php
				}
			}
		} else {
			if (updateAlbum()){	// if success	?>
	<meta http-equiv=Refresh content="2; url=about.php?tab=<?php echo $tab ?>" />
	<div class="main">
		<p><h1>Update successfully</h1>
		<p>The gallery has been updated. Redirect to the previous page...
	</div>
<?php
			} else {	// if fail	?>
	<meta http-equiv=Refresh content="5; url=about.php?tab=<?php echo $tab ?>">
	<div class="main">
		<p><h1 class="error">Error!</h1>
		<p>Database error. Please try again or contact the administrator.
	</div>
<?php
			}
		}
	} // end gallery mode
} else {
	if (isValidTab($tab)){
		// display the content
		$title = getContentTitle($tab);
		$parentid = getCatIDByAbbr($tab);
		if ($tab != "gallery"){
			/************ normal mode ***********/
?>
<script>
$(document).ready(function(){
	$("#submit").click(function(){
		editorEN.post();
		editorTW.post();
		editorCN.post();
	});
});
</script>
	<div class="main">
		<p><h1>About: <?php echo $title ?></h1>
		<form action="./about.php" method="post" name="about">
			<input type="hidden" name="parentid" value="<?php echo $parentid ?>" />
			<input type="hidden" name="tab" value="<?php echo $tab ?>" />
			<table border="0" cellpadding="3" width="100%">
				<tr>
					<td valign="top">English</td>
					<td><textarea name="contentEN" id="textareaEN" width="700" height="450"><?php echo getContentInOneLang($tab, "EN") ?></textarea></td>
				</tr>
				<tr>
					<td valign="top">Traditional Chinese</td>
					<td><textarea name="contentTW" id="textareaTW" width="700" height="450"><?php echo getContentInOneLang($tab, "TW") ?></textarea></td>
				</tr>
				<tr>
					<td valign="top">Simplified Chinese</td>
					<td><textarea name="contentCN" id="textareaCN" width="700" height="450"><?php echo getContentInOneLang($tab, "CN") ?></textarea></td>
				</tr>
				<tr>
					<td colspan="2" align="center">
						<input id="submit" name="submit" value="Update" type="submit" />
					</td>
				</tr>
			</table>
		</form>
	</div>

<script>
	new TINY.editor.edit('editorEN',{
		id:'textareaEN',
		width:700,
		height:450,
		cssclass:'te',
		controlclass:'tecontrol',
		rowclass:'teheader',
		dividerclass:'tedivider',
		controls:['bold','italic','underline','strikethrough','|','subscript','superscript','|',
				  'orderedlist','unorderedlist','|','outdent','indent','|','leftalign',
				  'centeralign','rightalign','blockjustify','|','unformat','|','undo','redo','n', '|',
				  'style', 'image', 'link','unlink','|','cut','copy','paste'],
		footer:true,
		fonts:['Verdana','Arial','Georgia','Trebuchet MS'],
		xhtml:true,
		cssfile:'./css/style_editor.css',
		bodyid:'editorEN',
		footerclass:'tefooter',
		toggle:{text:'show source',activetext:'show wysiwyg',cssclass:'toggle'},
		resize:{cssclass:'resize'}
	});
	
	new TINY.editor.edit('editorTW',{
		id:'textareaTW',
		width:700,
		height:450,
		cssclass:'te',
		controlclass:'tecontrol',
		rowclass:'teheader',
		dividerclass:'tedivider',
		controls:['bold','italic','underline','strikethrough','|','subscript','superscript','|',
				  'orderedlist','unorderedlist','|','outdent','indent','|','leftalign',
				  'centeralign','rightalign','blockjustify','|','unformat','|','undo','redo','n', '|',
				  'style', 'image', 'link','unlink','|','cut','copy','paste'],
		footer:true,
		fonts:['Verdana','Arial','Georgia','Trebuchet MS'],
		xhtml:true,
		cssfile:'./css/style_editor.css',
		bodyid:'editorTW',
		footerclass:'tefooter',
		toggle:{text:'show source',activetext:'show wysiwyg',cssclass:'toggle'},
		resize:{cssclass:'resize'}
	});
	
	new TINY.editor.edit('editorCN',{
		id:'textareaCN',
		width:700,
		height:450,
		cssclass:'te',
		controlclass:'tecontrol',
		rowclass:'teheader',
		dividerclass:'tedivider',
		controls:['bold','italic','underline','strikethrough','|','subscript','superscript','|',
				  'orderedlist','unorderedlist','|','outdent','indent','|','leftalign',
				  'centeralign','rightalign','blockjustify','|','unformat','|','undo','redo','n', '|',
				  'style', 'image', 'link','unlink','|','cut','copy','paste'],
		footer:true,
		fonts:['Verdana','Arial','Georgia','Trebuchet MS'],
		xhtml:true,
		cssfile:'./css/style_editor.css',
		bodyid:'editorCN',
		footerclass:'tefooter',
		toggle:{text:'show source',activetext:'show wysiwyg',cssclass:'toggle'},
		resize:{cssclass:'resize'}
	});
</script>
<?php
		} else {
			/************** gallery mode ***********/
			$albumCatList = getListOfAlbumCat();
?>
	<div class="main">
		<p><h1>About: Photo Gallery</h1>
		<form action="./about.php?tab=gallery" method="post" name="about" onsubmit="return validateForm()">
			<p><a href="javascript: void(0)" onclick="javascript: displayAddNewAlbum()" class="largeButton">Add New Albums</a>
			<p>&nbsp;
<?php		displayNewAlbumFields();	?>
			<p>&nbsp;
			<h2>Current Albums</h2>
			<table width="100%" cellpadding="2" border="0">
				<tr>
					<th>Del</th>
					<th>Category</th>
					<th>Date</th>
					<th>Name</th>
					<th>Organizer</th>
				</tr>
<?php
			$albums = getListOfAlbum();
			if ($albums != ""){
				foreach ($albums as $album){
					$id = $album["id"];
					$date = $album["date"];
					$name = $album["title"];
					$organ = $album["organ"];
					$parent = $album["parent"];
					echo "				<tr>"."\n";
					echo "					<td><a href=\"./about.php?tab=gallery&amp;action=del&amp;id=$id&amp;date=$date\" onclick=\"return confirm('Do you really want to delete this album?')\"><img src=\"./img/delete.png\" title=\"Delete\"></a></td>"."\n";
					echo "					<td>"."\n";
					displayAlbumCatList($parent);
					echo "					</td>"."\n";
					echo "					<td><input type=\"hidden\" name=\"albumID[]\" value=\"$id\" />"."\n";
					echo "						$date</td>"."\n";
					echo "					<td><input type=\"text\" size=\"30\" name=\"albumName[]\" value=\"$name\" /></td>"."\n";
					echo "					<td><input type=\"text\" size=\"30\" name=\"albumOrgan[]\" value=\"$organ\" /></td>"."\n";
					echo "				</tr>"."\n";
				}
			}
?>
			</table>
			<p align="center"><input type="submit" name="submit" value="Submit" />
		</form>
	</div>			
<?php
		}
	} else {
		// display error message	?>
	<div class="main">
		<h1>Error!</h1>
		<p>Page not found. Please contact the administrator. 
	</div>
<?php
	}
}
?>