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

function validateInteger(inputField) {
        var isValid = /^\d+$/.test(inputField.value);

        if (isValid) {
            inputField.style.backgroundColor = '#bfa';
        } else {
            inputField.style.backgroundColor = '#fba';
        }

        return isValid;
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
		echo "					<th style=\"text-align: center; width: 10%\">Type</th>"."\n";
		echo "					<th style=\"text-align: center; width: 70%\">Content</th>"."\n";
		echo "					<th style=\"text-align: center; width: 10%\">Display Order</th>"."\n";
		echo "				</tr>"."\n";
	} else {
		echo "				<tr>"."\n";
		echo "					<th style=\"text-align: center; width: 10%\">Del</th>"."\n";
		echo "					<th style=\"text-align: center; width: 10%\">Type</th>"."\n";
		echo "					<th style=\"text-align: center; width: 60%\">Content</th>"."\n";
		echo "					<th style=\"text-align: center; width: 10%\">Display Order</th>"."\n";
		echo "				</tr>"."\n";
	}
}

// display the whole table (in all modes)
function displayPubTable($list){
	$noOfPubs = count($list);
	$action = getCurrentAction();

	echo "			<table>"."\n";
	displayTableHeader();
	for ($i = 0; $i < $noOfPubs; $i++){
		$list[$i]["value"] = htmlspecialchars($list[$i]["value"]);
		echo "                         <input type=\"hidden\" name=\"id[]\"  value=\"".$list[$i]["id"]."\"/>";
		// if in edit mode, display textarea for editing
		if (($action != "add") && ($action != "del")){
			// replace <br/> to \n for display
			$list = convertToNewLine($list);
                       
			echo " 				<tr>"."\n";
                        
                        echo "                              <td class=\"type\" align=\"center\"><select name=\"type[]\">";
                        if ($list[$i]["type"] == "research"){
                            echo "                              <option value=\"research\" selected=\"selected\">Research</option>";
                            echo "                              <option value=\"paper\">Paper</option>";
                        }else{
                            echo "                              <option value=\"research\">Research</option>";
                            echo "                              <option value=\"paper\" selected=\"selected\">Paper</option>";
                        }
                        echo "                              </select></td>";
                        echo "                              <td class=\"value\" valign=\"top\"><textarea name=\"value[]\" cols=\"100\" type=\"text\" class=\"textbox textarea\">".$list[$i]["value"]."</textarea></td>"."\n";
			echo "                              <td class=\"order\" valign=\"top\"><textarea name=\"displayorder[]\" cols=\"10\"  onchange=\"validateInteger(this)\" type=\"text\" class=\"textbox textarea\">".$list[$i]["displayorder"]."</textarea></td>"."\n";
			echo "				</tr>"."\n";
                        
                        
		} // end edit mode
			
		if ($action == "add"){
			// if in add mode, just display the table only (no editing) and also the add form
			echo "				<tr>"."\n";
			echo "					<td class=\"type\" valign=\"top\">".$list[$i]["type"]."</td>"."\n";
                        echo "					<td class=\"value\" valign=\"top\">".$list[$i]["value"]."</td>"."\n";
			echo "					<td class=\"displayorder\" align =\"center\" valign=\"top\">".$list[$i]["displayorder"]."</td>"."\n";
			echo "				</tr>"."\n";
		} // end add mode
		
		if ($action == "del"){
		
			echo "				<tr>"."\n";
			echo "					<td class=\"del\"  align=\"center\"><input type=\"checkbox\" name=\"mainDel[]\" value=\"".$list[$i]["id"]."\" /></td>"."\n";
			echo "					<td class=\"type\" valign=\"top\">".$list[$i]["type"]."</td>"."\n";
                        echo "					<td class=\"value\" valign=\"top\">".$list[$i]["value"]."</td>"."\n";
			echo "					<td class=\"displayorder\" align =\"center\" valign=\"top\">".$list[$i]["displayorder"]."</td>"."\n";
			echo "				</tr>"."\n";
		} // end del mode
	} //end for loop
	echo "			</table>"."\n";
} // end displayEventTable

if (isValidTab($tab)){
        if (isset($_GET["action"])){
            $action = getCurrentAction();
        }else{
            $action = "edit";
        }
        
	$title = getContentTitle($tab);
	//$parentid = getCatIDByAbbr($tab);
	$url = "./".getCurrentFilename()."?tab=$tab&amp;action=";
        
        
	if (!formIsSubmitted()){
		// ------------------------ if the form is NOT submitted ---------------
?>
	<div class="main">
		<p><h1>R&D Centre: <?php echo $title?></h1>
		<p><a href="<?php echo $url."add" ?>" class="largeButton">Add New</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="<?php echo $url."edit" ?>" class="largeButton">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="<?php echo $url."del" ?>" class="largeButton">Delete</a>
		</p><p>&nbsp;
		
  		<form action="<?php $url.$action?>" method="post" name="pub">                  
                 
		
		
		<input type="hidden" name="tab" value="<?php echo $tab ?>" />
                       
		<?php
                if($action == "add"){ 
                    echo "                      <div id=\"addform\">";
                    echo "			<table>"."\n";
                    displayTableHeader();
                    
                    for( $i=0; $i<5; $i++){
                        echo " 				<tr>"."\n";
                        echo "                              <td class=\"type\" align=\"center\"><select name=\"type[]\">";
                        echo "                              <option value=\"research\" selected=\"selected\">Research</option>";
                        echo "                              <option value=\"paper\">Paper</option>";
                        echo "                              </select></td>";
                        echo "                              <td class=\"value\" valign=\"top\"><textarea name=\"value[]\" cols=\"100\" type=\"text\" class=\"textbox textarea\"></textarea></td>"."\n";
			echo "                              <td class=\"displayorder\" valign=\"top\"><textarea name=\"displayorder[]\" cols=\"10\" type=\"text\" class=\"textbox textarea\"></textarea></td>"."\n";
			echo "				</tr>"."\n";
                    }
                    
                    echo "			</table>"."\n";
                    echo"</div>";
                    
                    echo"<span id=\"writeroot\"></span>";
                    
                    echo "  <p style=\"text-align: right\">";
                    echo "  <img src=\"./img/add.png\" title=\"Add\" onclick=\"javascript:moreFields()\"> Add more records</a>";
                    echo "  </p>";
                    
                        
                    echo"   <p style=\"text-align: center\">";
                    echo"   <input type=\"submit\" name=\"".$action."\"value=\"Update\" class=\"button\" />";
                    echo"   </p>";
                }
		
		$pubList = getPubList();
                
		if ($pubList != ""){ 
			displayPubTable($pubList);
                        if($action != 'add'){
                        echo"   <p style=\"text-align: center\">";
                        echo"   <input type=\"submit\" name=\"".$action."\"value=\"Update\" class=\"button\" />";
                        echo"   </p>";
                        }
		} else {
			echo "		<p>There are no pubs.</p>"."\n";
		}
 
		?>   			 
		</form>
	</div>





<?php
	} else {
		// ------------------------ if the form is submitted ---------------
		
		/*********** add mode ***********/
		if ($action == "add"){
			if (addPub()){	?>
	<meta http-equiv=Refresh content="2; url=" />
	<div class="main">
		<p><h1>Add successfully</h1>
		<p>The publication has been added. Redirect to the previous page...
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
                    if (editPub()){	?> 
	<meta http-equiv=Refresh content="2; url=" />
	<div class="main">
		<p><h1>Edit successfully</h1>
		<p>The publication has been updated. Redirect to the previous page...
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
			if (delPub()){	?>
	<meta http-equiv=Refresh content="2; url=" />
	<div class="main">
		<p><h1>Delete successfully</h1>
		<p>The publication has been deleted. Redirect to the previous page...
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
