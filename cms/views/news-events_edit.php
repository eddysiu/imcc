<script>

function isValidDate(dateString) {
	var regEx = /^\d{4}-\d{2}-\d{2}$/;
	return dateString.match(regEx) != null;
}

function validateForm() {
	var errorMsg = "";
	
	// get data from the form
	var startDate = document.getElementsByName("startDate");
	var endDate = document.getElementsByName("endDate");
	var title = document.getElementsByName("title");
	var contentType = document.getElementsByName("contentType");
	var shown = document.getElementsByName("shown");

	if (startDate[0].value != ""){
		if (!isValidDate(startDate[0].value)){
			errorMsg += "- The format of the start date is not correct\n";
		}
	} else {
		errorMsg += "- Please fill in the start date\n";
	}
	
	if (endDate[0].value != ""){
		if (!isValidDate(endDate[0].value)){
			errorMsg += "- The format of the end date is not correct\n";
		}
	} else {
		errorMsg += "- Please fill in the end date\n";
	}
			
	if (title[0].value == ""){
		errorMsg += "- Please fill in the title\n";
	}
	
	if ((contentType[0].checked == false) && (contentType[1].checked == false)){
		errorMsg += "- Please select the type of content\n";
	} else {
		if (contentType[0].checked == true){	// url
			var content = document.getElementsByName("contentURL");
		} else {	// html
			var content = document.getElementsByName("contentHTML");
		}
		
		if (content[0].value == ""){
			errorMsg += "- Please fill in the content of the news\n";
		}
	}
	
	if ((shown[0].checked == false) && (shown[1].checked == false)){
		errorMsg += "- For the "+fieldIndex+"-input: Please select whether the new is shown in the main page or not\n";
	}

	if (errorMsg != ""){
		errorMsg = "Please check the following:\n\n" + errorMsg;
		alert(errorMsg);
		return false;
	} else {
		return true;
	}
}

function displayContentInputField(type){
	var contentDiv = "contentDiv";
	if (type.value == "url"){
		document.getElementById("inputURL").style.display = "block";
	document.getElementsByClassName("te")[0].style.display = "none";
	}
	
	if (type.value == "html"){
		document.getElementById("inputURL").style.display = "none";
	document.getElementsByClassName("te")[0].style.display = "block";
	}
}

$(document).ready(function(){
	$("#submit").click(function(){
		editor.post();
	});
});
</script>

<?php
// display edit form (edit mode)
function displayEditForm(){
	$id = $_GET["id"];
	$tab = $_GET["tab"];
	$type = getContentTitle($tab);
	$details = getNewsDetails($id);
	
	// process the data
	$start = $details[0]["start"];
	$end = $details[0]["end"];
	$title = $details[0]["title"];
	$source = $details[0]["source"];
	$content = $details[0]["content"];
	$isExpand = $details[0]["isExpand"];
	$isShown = $details[0]["isShown"];
	
	if (!$isExpand){
		$content = htmlspecialchars($content);
	}
	
	$actionURL = "./".getCurrentFilename()."?tab=$tab&amp;action=edit&amp;id=$id";

	echo "		<form action=\"$actionURL\" method=\"post\" id=\"form\" name=\"news-events\" onsubmit=\"return validateForm()\">"."\n";
	echo "			<table width=\"100%\">"."\n";
	echo "				<tr>"."\n";
	echo "					<td width=\"20%\">Type</td>"."\n";
	echo "					<td>$type</td>"."\n";
	echo "				</tr>"."\n";
	echo "				<tr>"."\n";
	echo "					<td>Start Date (YYYY-MM-DD)</td>"."\n";
	echo "					<td><input type=\"input\" name=\"startDate\" size=\"50\" value=\"$start\"/></td>"."\n";
	echo "				</tr>"."\n";
	echo "				<tr>"."\n";
	echo "					<td>End Date (YYYY-MM-DD)</td>"."\n";
	echo "					<td><input type=\"input\" name=\"endDate\" size=\"50\" value=\"$end\" /></td>"."\n";
	echo "				</tr>"."\n";
	echo "				<tr>"."\n";
	echo "					<td>Title</td>"."\n";
	echo "					<td><input type=\"input\" name=\"title\" size=\"50\" value=\"$title\" /></td>"."\n";
	echo "				</tr>"."\n";
	echo "				<tr>"."\n";
	echo "					<td>Source</td>"."\n";
	echo "					<td><input type=\"input\" name=\"source\" size=\"50\" value=\"$source\" /></td>"."\n";
	echo "				</tr>"."\n";
	echo "				<tr>"."\n";
	echo "					<td valign='center'>Content</td>"."\n";
	echo "					<td>"."\n";
	if (!$isExpand){
		echo "						<input type=\"radio\" name=\"contentType\" value=\"url\" onclick=\"javascript: displayContentInputField(this)\" checked=\"checked\" /> Link";
		echo "						<input type=\"radio\" name=\"contentType\" value=\"html\" onclick=\"javascript: displayContentInputField(this)\" /> Article<br/>"."\n";
		echo "						<input type=\"input\" id=\"inputURL\" name=\"contentURL\" size=\"50\" value=\"$content\" />"."\n";
		echo "						<textarea name=\"contentHTML\" id=\"textarea\" width=\"600\" height=\"450\"></textarea>"."\n";
	} else {
		$content = htmlspecialchars($content);
		echo "						<input type=\"radio\" name=\"contentType\" value=\"url\" onclick=\"javascript: displayContentInputField(this)\" /> Link";
		echo "						<input type=\"radio\" name=\"contentType\" value=\"html\" onclick=\"javascript: displayContentInputField(this)\" checked=\"checked\" /> Article<br/>"."\n";
		echo "						<input type=\"input\" id=\"inputURL\" name=\"contentURL\" size=\"50\" />"."\n";
		echo "						<textarea name=\"contentHTML\" id=\"textarea\" width=\"600\" height=\"450\">$content</textarea>"."\n";
	}

	echo "					</td>"."\n";
	echo "				</tr>"."\n";
	echo "				<tr>"."\n";
	if (!$isShown){
		echo "					<td>Show in main</td>"."\n";
		echo "					<td><input type=\"radio\" name=\"shown\" value=\"1\" /> Yes ";
		echo "						<input type=\"radio\" name=\"shown\" value=\"0\" checked=\"checked\" /> No "."\n";
		echo "					</td>"."\n";
	} else {
		echo "					<td>Show in main</td>"."\n";
		echo "					<td><input type=\"radio\" name=\"shown\" value=\"1\" checked=\"checked\" /> Yes ";
		echo "						<input type=\"radio\" name=\"shown\" value=\"0\" /> No "."\n";
		echo "					</td>"."\n";
	}
	echo "				</tr>"."\n";
	echo "			</table>"."\n";
	echo '			<p align="center"><input type="submit" name="submit" value="Submit" id="submit" />';
	echo "		</form>"."\n";
}

displayEditForm();

?>

<script>
new TINY.editor.edit("editor",{
	id:"textarea",
	width:650,
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
	bodyid:"editor",
	footerclass:'tefooter',
	toggle:{text:'show source',activetext:'show wysiwyg',cssclass:'toggle'},
	resize:{cssclass:'resize'}
});

var typeButton = document.getElementsByName("contentType");

if (typeButton[0].checked == true){	// type = url
	document.getElementsByClassName("te")[0].style.display = "none";
}

if (typeButton[1].checked == true){ // type = html
	document.getElementById("inputURL").style.display = "none";
}

</script>
