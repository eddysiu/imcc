<script>
var counter = 0;

function blankInput(value1, value2, value3, type, shown){
	// if all blanks, and all radio buttons do not be checked
	if ((value1 == "") && (value2 == "") && (value3 == "") && (type[0].checked == false) && (type[1].checked == false) && (shown[0].checked == false) && (shown[1].checked == false)){
		return true;
	} else {
		return false;
	}
}

function isValidDate(dateString) {
	var regEx = /^\d{4}-\d{2}-\d{2}$/;
	return dateString.match(regEx) != null;
}

function validateForm() {
	var errorMsg = "";
	var contentCounter = 0;
	var blankCounter = 0;
	
	for (i = 0; i < 5; i++){
		var contentTypeName = "contentType"+i+"[]";
		var shownName = "shown"+i+"[]";
		var editorName = "editor"+i;
		
		// get data from the form
		var startDate = document.getElementsByName("startDate[]");
		var endDate = document.getElementsByName("endDate[]");
		var title = document.getElementsByName("title[]");
		var contentType = document.getElementsByName(contentTypeName);
		var shown = document.getElementsByName(shownName);
		
		if (!blankInput(startDate[i].value, endDate[i].value, title[i].value, contentType, shown)){
			
			// if it is not a blank input
			var fieldIndex = i+1;
			
			if (startDate[i].value != ""){
				if (!isValidDate(startDate[i].value)){
					errorMsg += "- For the "+fieldIndex+"-input: The format of the start date is not correct\n";
				}
			} else {
				errorMsg += "- For the "+fieldIndex+"-input: Please fill in the start date\n";
			}
			
			if (endDate[i].value != ""){
				if (!isValidDate(endDate[i].value)){
					errorMsg += "- For the "+fieldIndex+"-input: The format of the end date is not correct\n";
				}
			} else {
				errorMsg += "- For the "+fieldIndex+"-input: Please fill in the end date\n";
			}
			
			if (title[i].value == ""){
				errorMsg += "- For the "+fieldIndex+"-input: Please fill in the title\n";
			}
			
			if ((contentType[0].checked == false) && (contentType[1].checked == false)){
				errorMsg += "- For the "+fieldIndex+"-input: Please select the type of content\n";
			} else {
				var content = document.getElementsByName("content[]");
				if (content[contentCounter].value == ""){
					errorMsg += "- For the "+fieldIndex+"-input: Please fill in the content of the news\n";
				}
				contentCounter++;
			}
			
			if ((shown[0].checked == false) && (shown[1].checked == false)){
				errorMsg += "- For the "+fieldIndex+"-input: Please select whether the new is shown in the main page or not\n";
			}
		} else {
			blankCounter++;
		}
	} // end for loop
	
	if (blankCounter == 5){
		errorMsg += "- Please input at least one set of fields\n";
	}
	
	if (errorMsg != ""){
		errorMsg = "Please check the following:\n\n" + errorMsg;
		alert(errorMsg);
		return false;
	} else {
		return true;
	}
}

function displayContentInputField(type, id){
	var contentDiv = "contentDiv"+id;
	if (type.value == "url"){
		// adjust the height again
		$(".nav").height(function(index, height){return (height+30)});
		$(".main").height(function(index, height){return (height+30)});
		var contentDiv = document.getElementById(contentDiv);
		contentDiv.innerHTML = '<input type="input" name="content[]" size="50" />';
	}
	
	if (type.value == "html"){
		// adjust the height again
		$(".nav").height(function(index, height){return (height+550)});
		$(".main").height(function(index, height){return (height+550)});
		
		var contentDiv = document.getElementById(contentDiv);
		var textareaID = "textarea"+id;
		var editorID = "editor"+id;
		contentDiv.innerHTML = '<textarea name="content[]" id="'+textareaID+'" width="600" height="450"></textarea>';
		
		new TINY.editor.edit(editorID,{
			id:textareaID,
			width:600,
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
			bodyid:editorID,
			footerclass:'tefooter',
			toggle:{text:'show source',activetext:'show wysiwyg',cssclass:'toggle'},
			resize:{cssclass:'resize'}
		});
	}
}

$(document).ready(function(){
	$("#submit").click(function(){
		// only post if editor are set
		if (typeof editor0 !== "undefined"){
			editor0.post();
		}
		
		if (typeof editor1 !== "undefined"){
			editor1.post();
		}
		
		if (typeof editor2 !== "undefined"){
			editor2.post();
		}
		
		if (typeof editor3 !== "undefined"){
			editor3.post();
		}
		
		if (typeof editor4 !== "undefined"){
			editor4.post();
		}
	});
});
</script>

<?php

// display add form (add mode)
function displayAddForm(){
	$tab = $_GET["tab"];
	$title = getContentTitle($tab);
	$actionURL = "./".getCurrentFilename()."?tab=$tab&amp;action=add";
	echo "		<form action=\"$actionURL\" method=\"post\" id=\"form\" name=\"news-events\" onsubmit=\"return validateForm()\">"."\n";
	echo displayAddFields($title);
	echo '			<p align="center"><input type="submit" name="submit" value="Submit" id="submit" />'."\n";
	echo "		</form>"."\n";
}

// display the fields in the add form (add mode)
function displayAddFields($type){
	for ($i = 0; $i < 5; $i++){
		$tableID = "table$i";
		$contentTypeName = "contentType$i".'[]';
		$shownName = "shown$i".'[]';
		$contentDivID = "contentDiv$i";
		$HTML = "";
		$HTML .= "			<table width=\"100%\" id=\"$tableID\">"."\n";
		$HTML .= "				<tr>"."\n";
		$HTML .= "					<td width=\"20%\">Type</td>"."\n";
		$HTML .= "					<td>$type</td>"."\n";
		$HTML .= "				</tr>"."\n";
		$HTML .= "				<tr>"."\n";
		$HTML .= "					<td>Start Date (YYYY-MM-DD)</td>"."\n";
		$HTML .= "					<td><input type=\"input\" name=\"startDate[]\" size=\"50\" /></td>"."\n";
		$HTML .= "				</tr>"."\n";
		$HTML .= "				<tr>"."\n";
		$HTML .= "					<td>End Date (YYYY-MM-DD)</td>"."\n";
		$HTML .= "					<td><input type=\"input\" name=\"endDate[]\" size=\"50\" /></td>"."\n";
		$HTML .= "				</tr>"."\n";
		$HTML .= "				<tr>"."\n";
		$HTML .= "					<td>Title</td>"."\n";
		$HTML .= "					<td><input type=\"input\" name=\"title[]\" size=\"50\" /></td>"."\n";
		$HTML .= "				</tr>"."\n";
		$HTML .= "				<tr>"."\n";
		$HTML .= "					<td>Source</td>"."\n";
		$HTML .= "					<td><input type=\"input\" name=\"source[]\" size=\"50\" /></td>"."\n";
		$HTML .= "				</tr>"."\n";
		$HTML .= "				<tr>"."\n";
		$HTML .= "					<td>Content</td>"."\n";
		$HTML .= "					<td>"."\n";
		$HTML .= "						<input type=\"radio\" name=\"$contentTypeName\" value=\"url\" onclick=\"javascript: displayContentInputField(this, $i)\" /> Link"."\n";
		$HTML .= "						<input type=\"radio\" name=\"$contentTypeName\" value=\"html\" onclick=\"javascript: displayContentInputField(this, $i)\" /> Article"."\n";
		$HTML .= "						<div id=\"$contentDivID\"></div>"."\n";
		$HTML .= "					</td>"."\n";
		$HTML .= "				</tr>"."\n";
		$HTML .= "				<tr>"."\n";
		$HTML .= "					<td>Show in main</td>"."\n";
		$HTML .= "					<td><input type=\"radio\" name=\"$shownName\" value=\"1\" /> Yes "."\n";
		$HTML .= "						<input type=\"radio\" name=\"$shownName\" value=\"0\" /> No "."\n";
		$HTML .= "					</td>"."\n";
		$HTML .= "				</tr>"."\n";
		$HTML .= "			</table>"."\n";
		$HTML .= "			<p>&nbsp;"."\n";
		echo $HTML;
	}
}


displayAddForm();
?>
