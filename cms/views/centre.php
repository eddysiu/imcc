<script>
	$(document).ready(function(){
		$("#submit").click(function(){
			editorEN.post();
			editorTW.post();
			editorCN.post();
		});
	});
</script>
<?php
// get the current tab
$tab = "";

if (isset($_GET["tab"])){
	$tab = $_GET["tab"];
} else {
	$tab = "";
}

if ($tab == "public"){
			include_once("./views/publication.php");
}else{
		

if (isset($_POST["submit"])){
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
	if (isValidTab($tab)){
		// display the content
		$title = getContentTitle($tab);
		$parentid = getCatIDByAbbr($tab);
		if ($tab != "publication"){
			/************ normal mode ***********/
?>
	<div class="main">
		<p><h1>R&D Centre : <?php echo $title ?></h1>
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
<?php
		} else {
			/************** publication mode ***********/
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
}
?>
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