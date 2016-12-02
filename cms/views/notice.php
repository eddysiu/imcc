<script>
var counter = 0;

function moreFields() {
	counter++;
	var newFields = document.getElementById('addform').cloneNode(true);
	newFields.id = '';
	newFields.style.display = 'block';
	var newField = newFields.childNodes;
	for (var i=0;i<newField.length;i++) {
		var theName = newField[i].name
		if (theName)
			newField[i].name = theName + counter;
	}
	var insertHere = document.getElementById('writeroot');
	insertHere.parentNode.insertBefore(newFields,insertHere);
}

function validateHhMm(inputField) {
        var isValid = /^([0-1]?[0-9]|2[0-4]):([0-5][0-9])(:[0-5][0-9])?$/.test(inputField.value);

        if (isValid) {
            inputField.style.backgroundColor = '#bfa';
        } else {
            inputField.style.backgroundColor = '#fba';
        }

        return isValid;
    }                   
    
function validateYyyyMmdd(inputField) {
        var isValid = /^([12][90][0-9][0-9])-([0][0-9]|1[0-2])-([0-2]?[0-9]|3[0-1])$/.test(inputField.value);

        if (isValid) {
            inputField.style.backgroundColor = '#bfa';
        } else {
            inputField.style.backgroundColor = '#fba';
        }

        return isValid;
    }
</script>



<?php


// detect form is submitted or not
function formIsSubmitted(){
	$isSubmitted = false;
	if ((isset($_POST["add"])) || (isset($_POST["edit"])) || isset($_POST["del"])){
		$isSubmitted = true;
	}
	return $isSubmitted;
}

// display table header
function displayTableHeader(){
	$action = getCurrentAction();
	if ($action != "del"){
		// add mode and edit mode
		echo "				<tr>"."\n";
		echo "					<th style=\"text-align: center; width: 115px\">Start Date<br>(YYYY-MM-DD)</th>"."\n";
                echo "					<th style=\"text-align: center; width: 87px\">Start Time<br>(HH:MM:SS)</th>"."\n";
                echo "					<th style=\"text-align: center; width: 115px\">End Date <br> (YYYY-MM-DD)</th>"."\n";
                echo "					<th style=\"text-align: center; width: 87px\">End Time <br> (HH:MM:SS)</th>"."\n";
		echo "					<th style=\"text-align: center; width: 170px\">Title</th>"."\n";
		echo "					<th style=\"text-align: center; width: 380px\">Content</th>"."\n";
		echo "				</tr>"."\n";
	} else {
		echo "				<tr>"."\n";
		echo "					<th style=\"text-align: center; width: 40px\">Del</th>"."\n";
		echo "					<th style=\"text-align: center; width: 115px\">Start Date<br>(YYYY-MM-DD)</th>"."\n";
                echo "					<th style=\"text-align: center; width: 87px\">Start Time<br>(HH:MM:SS)</th>"."\n";
                echo "					<th style=\"text-align: center; width: 115px\">End Date <br> (YYYY-MM-DD)</th>"."\n";
                echo "					<th style=\"text-align: center; width: 87px\">End Time <br> (HH:MM:SS)</th>"."\n";
		echo "					<th style=\"text-align: center; width: 170px\">Title</th>"."\n";
		echo "					<th style=\"text-align: center; width: 340px\">Content</th>"."\n";
		echo "				</tr>"."\n";
	}
}

// display the whole table (in all modes)
function displayNoticeTable($list){
	$noOfNotices = count($list);
	$action = getCurrentAction();

	echo "			<table>"."\n";
	displayTableHeader();
	for ($i = 0; $i < $noOfNotices; $i++){
		
            $list[$i]["startdate"] = substr($list[$i]["starttime"],0,10);
            $list[$i]["starttime"] = substr($list[$i]["starttime"],11,9);
            $list[$i]["enddate"] = substr($list[$i]["endtime"],0,10);
            $list[$i]["endtime"] = substr($list[$i]["endtime"],11,9);
            $list[$i]["content"] = $list[$i]["content"];
            // $list = convertToNewLine($list);
            
		echo "                         <input type=\"hidden\" name=\"id[]\"  value=\"".$list[$i]["id"]."\"/>";
		// if in edit mode, display textarea for editing
		if (($action != "add") && ($action != "del")){
			// replace <br/> to \n for display
			
                       
			echo " 				<tr>"."\n";
                        echo "                              <td class=\"startdate\" valign=\"top\"><textarea name=\"startdate[]\" cols=\"12\" onchange=\"validateYyyyMmdd(this)\" type=\"text\" class=\"textbox textarea\">".$list[$i]["startdate"]."</textarea></td>"."\n";
                        echo "                              <td class=\"starttime\" valign=\"top\"><textarea name=\"starttime[]\" cols=\"8\"  onchange=\"validateHhMm(this)\"  type=\"text\" class=\"textbox textarea\">".$list[$i]["starttime"]."</textarea></td>"."\n";
                        echo "                              <td class=\"enddate\" valign=\"top\"><textarea name=\"enddate[]\" cols=\"12\" onchange=\"validateYyyyMmdd(this)\" type=\"text\" class=\"textbox textarea\">".$list[$i]["enddate"]."</textarea></td>"."\n";
                        echo "                              <td class=\"endtime\" valign=\"top\"><textarea name=\"endtime[]\" cols=\"8\" onchange=\"validateHhMm(this)\" type=\"text\" class=\"textbox textarea\">".$list[$i]["endtime"]."</textarea></td>"."\n";
                        echo "                              <td class=\"title\" valign=\"top\"><textarea name=\"title[]\" cols=\"20\" type=\"text\" class=\"textbox textarea\">".$list[$i]["title"]."</textarea></td>"."\n";
			echo "                              <td class=\"content\" valign=\"top\"><textarea name=\"content[]\" cols=\"50\" rows=\" 10\" type=\"text\" class=\"textbox textarea\">".$list[$i]["content"]."</textarea></td>"."\n";
			echo "				</tr>"."\n";
                        
                        
		} // end edit mode
			
		if ($action == "add"){
			// if in add mode, just display the table only (no editing) and also the add form
			echo "				<tr>"."\n";

                        echo "					<td class=\"startdate\" valign=\"top\">".$list[$i]["startdate"]."</td>"."\n";
			echo "					<td class=\"starttime\" valign=\"top\">".$list[$i]["starttime"]."</td>"."\n";
			echo "					<td class=\"enddate\" valign=\"top\">".$list[$i]["enddate"]."</td>"."\n";
                        echo "					<td class=\"endtime\" valign=\"top\">".$list[$i]["endtime"]."</td>"."\n";
                        echo "					<td class=\"title\" valign=\"top\">".$list[$i]["title"]."</td>"."\n";
			echo "					<td class=\"content\" valign=\"top\">".$list[$i]["content"]."</td>"."\n";
			echo "				</tr>"."\n";
		} // end add mode
		
		if ($action == "del"){
		
			echo "				<tr>"."\n";
			echo "					<td class=\"del\"  align=\"center\"><input type=\"checkbox\" name=\"mainDel[]\" value=\"".$list[$i]["id"]."\" /></td>"."\n";
			echo "					<td class=\"startdate\" valign=\"top\">".$list[$i]["startdate"]."</td>"."\n";
			echo "					<td class=\"starttime\" valign=\"top\">".$list[$i]["starttime"]."</td>"."\n";
			echo "					<td class=\"enddate\" valign=\"top\">".$list[$i]["enddate"]."</td>"."\n";
                        echo "					<td class=\"endtime\" valign=\"top\">".$list[$i]["endtime"]."</td>"."\n";
                        echo "					<td class=\"title\" valign=\"top\">".$list[$i]["title"]."</td>"."\n";
			echo "					<td class=\"content\" valign=\"top\">".$list[$i]["content"]."</td>"."\n";
			echo "				</tr>"."\n";
		} // end del mode
	} //end for loop
	echo "			</table>"."\n";
} // end displayEventTable






        if (isset($_GET["action"])){
            $action = getCurrentAction();
        }else{
            $action = "edit";
        }
	
	$url = "./".getCurrentFilename()."?action=";
        
        
	if (!formIsSubmitted()){
		// ------------------------ if the form is NOT submitted ---------------
?>
	<div class="main">
		<p><h1>Urgent Notice</h1>
		<p><a href="<?php echo $url."add" ?>" class="largeButton">Add New</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="<?php echo $url."edit" ?>" class="largeButton">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="<?php echo $url."del" ?>" class="largeButton">Delete</a>
		</p><p>&nbsp;
		
  		<form action="<?php $url.$action?>" method="post" name="notice">                  
                 

                       
		<?php
                if($action == "add"){ 
                    echo "                      <div id=\"addform\">";
                    echo "			<table>"."\n";
                    displayTableHeader();
                    
                    
                        echo " 				<tr>"."\n";
                        echo "                              <td class=\"startdate\" valign=\"top\"><textarea name=\"startdate[]\" cols=\"12\" onchange=\"validateYyyyMmdd(this)\" type=\"text\" class=\"textbox textarea\"></textarea></td>"."\n";
                        echo "                              <td class=\"starttime\" valign=\"top\"><textarea name=\"starttime[]\" cols=\"8\" onchange=\"validateHhMm(this)\" type=\"text\" class=\"textbox textarea\"></textarea></td>"."\n";
                        echo "                              <td class=\"enddate\" valign=\"top\"><textarea name=\"enddate[]\" cols=\"12\" onchange=\"validateYyyyMmdd(this)\" type=\"text\" class=\"textbox textarea\"></textarea></td>"."\n";
                        echo "                              <td class=\"endtime\" valign=\"top\"><textarea name=\"endtime[]\" cols=\"8\" onchange=\"validateHhMm(this)\" type=\"text\" class=\"textbox textarea\"></textarea></td>"."\n";
                        echo "                              <td class=\"name\" valign=\"top\"><textarea name=\"title[]\" cols=\"20\" type=\"text\" class=\"textbox textarea\"></textarea></td>"."\n";
			echo "                              <td class=\"url\" valign=\"top\"><textarea name=\"content[]\" id=\"textarea\" width=\"350px\" height=\"200px\" type=\"text\" class=\"textbox textarea\"></textarea></td>"."\n";
			echo "				</tr>"."\n";
                    
                    
                    echo "			</table>"."\n";
                    echo"</div>";
                    
                    echo"<span id=\"writeroot\"></span>";

                    echo"   <p style=\"text-align: center\">";
                    echo"   <input type=\"submit\" name=\"".$action."\"value=\"Submit\" class=\"button\" />";
                    echo"   </p>";
?>
<script>
	$(document).ready(function(){
		$("#submit").click(function(){
			editor.post();
		});
	});
	
	new TINY.editor.edit('editor',{
		id:'textarea',
		width:350,
		height:200,
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
		bodyid:'editor',
		footerclass:'tefooter',
		toggle:{text:'show source',activetext:'show wysiwyg',cssclass:'toggle'},
		resize:{cssclass:'resize'}
	});
</script>
<?php
                }
		
		$noticeList = getNoticeList();
                
		if ($noticeList != ""){ 
			displayNoticeTable($noticeList);
                        if($action != 'add'){
                            
                        echo"   <p style=\"text-align: center\">";
                        echo"   <input type=\"submit\" name=\"".$action."\"value=\"Submit\" class=\"button\" />";
                        echo"   </p>";
                        }
		} else {
			echo "		<p>There are no notices.</p>"."\n";
		}
 
		?>   			 
		</form>
	</div>





<?php
	} else {
		// ------------------------ if the form is submitted ---------------
		
		/*********** add mode ***********/
		if ($action == "add"){
			if (addNotice()){	?>
	<meta http-equiv=Refresh content="2; url=" />
	<div class="main">
		<p><h1>Add successfully</h1>
		<p>The notices have been added. Redirect to the previous page...
	</div>
<?php
			} else {	// if there is any error	?>
	<meta http-equiv=Refresh content="2; url=" />
	<div class="main">
		<p><h1 class="error">Error!</h1>
		<p>Database error. Please try again or contact the administrator.
	</div>
<?php
			}
		}
			
		/************* edit mode *********/
		if ($action == "edit"){
                    if (editNotice()){	?> 
	<meta http-equiv=Refresh content="2; url=" />
	<div class="main">
		<p><h1>Edit successfully</h1>
		<p>The notices have been updated. Redirect to the previous page...
	</div>
<?php		} else {	// if there is any error	?>
	<meta http-equiv=Refresh content="2; url=" />
	<div class="main">
		<p><h1 class="error">Error!</h1>
		<p>Database error. Please try again or contact the administrator.
	</div>
<?php
			}	// end error
		} // end edit part
		
		/**************** del mode ***********/
		if ($action == "del"){
			if (delNotice()){	?>
	<meta http-equiv=Refresh content="2; url=" />
	<div class="main">
		<p><h1>Delete successfully</h1>
		<p>The notices have been deleted. Redirect to the previous page...
	</div>
<?php		} else {	// if there is any error	?>
	<meta http-equiv=Refresh content="2; url=" />
	<div class="main">
		<p><h1 class="error">Error!</h1>
		<p>Database error. Please try again or contact the administrator.
	</div>
<?php
			} // end error
		} // end del part
	} // end form is submitted

?>
