<script>
var counter = 0;

function moreFields() {
	$(".nav").height(function(index, height){return (height+380)});
	$(".main").height(function(index, height){return (height+380)});
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
		echo "					<th style=\"text-align: center; width: 12%\">Local</th>"."\n";
		echo "					<th style=\"text-align: center; width: 42%\">Name</th>"."\n";
		echo "					<th style=\"text-align: center; width: 50%\">URL</th>"."\n";
		echo "				</tr>"."\n";
	} else {
		echo "				<tr>"."\n";
		echo "					<th style=\"text-align: center; width: 10%\">Del</th>"."\n";
		echo "					<th style=\"text-align: center; width: 10%\">Local</th>"."\n";
		echo "					<th style=\"text-align: center; width: 40%\">Name</th>"."\n";
		echo "					<th style=\"text-align: center; width: 40%\">URL</th>"."\n";
		echo "				</tr>"."\n";
	}
}

// display the whole table (in all modes)
function displayLinkTable($list){
	$noOfLinks = count($list);
	$action = getCurrentAction();

	echo "			<table>"."\n";
	displayTableHeader();
	for ($i = 0; $i < $noOfLinks; $i++){
		
		echo "                         <input type=\"hidden\" name=\"id[]\"  value=\"".$list[$i]["id"]."\"/>";
		// if in edit mode, display textarea for editing
		if (($action != "add") && ($action != "del")){
			// replace <br/> to \n for display
			$list = convertToNewLine($list);
                       
			echo " 				<tr>"."\n";
                        
                        echo "                              <td class=\"local\" align=\"center\"><select name=\"local[]\">";
                        if ($list[$i]["local"]){
                            echo "                              <option value=\"1\" selected=\"selected\">local</option>";
                            echo "                              <option value=\"0\">non-local</option>";
                        }else{
                            echo "                              <option value=\"1\">local</option>";
                            echo "                              <option value=\"0\" selected=\"selected\">non-local</option>";
                        }
                        echo "                              </select></td>";
                        echo "                              <td class=\"name\" valign=\"top\"><textarea name=\"name[]\" cols=\"50\" type=\"text\" class=\"textbox textarea\">".$list[$i]["name"]."</textarea></td>"."\n";
			echo "                              <td class=\"url\" valign=\"top\"><textarea name=\"url[]\" cols=\"60\" type=\"text\" class=\"textbox textarea\">".$list[$i]["url"]."</textarea></td>"."\n";
			echo "				</tr>"."\n";
                        
                        
		} // end edit mode
			
		if ($action == "add"){
			// if in add mode, just display the table only (no editing) and also the add form
			echo "				<tr>"."\n";
                        if ($list[$i]["local"]){
                            echo "				<td class=\"local\" align=\"center\"><input type=\"checkbox\" disabled=\"disabled\"  checked=\"checked\" valign=\"top\"></td>"."\n";
                        }else{
                            echo "				<td class=\"local\" align=\"center\"><input type=\"checkbox\" disabled=\"disabled\"  valign=\"top\"></td>"."\n";
                        }
                        echo "					<td class=\"name\" valign=\"top\">".$list[$i]["name"]."</td>"."\n";
			echo "					<td class=\"url\" valign=\"top\">".$list[$i]["url"]."</td>"."\n";
			echo "				</tr>"."\n";
		} // end add mode
		
		if ($action == "del"){
		
			echo "				<tr>"."\n";
			echo "					<td class=\"del\"  align=\"center\"><input type=\"checkbox\" name=\"mainDel[]\" value=\"".$list[$i]["id"]."\" /></td>"."\n";
			if ($list[$i]["local"]){
                            echo "				<td class=\"local\" align=\"center\"><input type=\"checkbox\" disabled=\"disabled\"  checked=\"checked\" valign=\"top\"></td>"."\n";
                        }else{
                            echo "				<td class=\"local\" align=\"center\"><input type=\"checkbox\" disabled=\"disabled\"  valign=\"top\"></td>"."\n";
                        }
			echo "					<td class=\"name\" valign=\"top\">".$list[$i]["name"]."</td>"."\n";
			echo "					<td class=\"url\" valign=\"top\">".$list[$i]["url"]."</td>"."\n";
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
	$parentid = getCatIDByAbbr($tab);
	$url = "./".getCurrentFilename()."?tab=$tab&amp;action=";
        
        
	if (!formIsSubmitted()){
		// ------------------------ if the form is NOT submitted ---------------
?>
	<div class="main">
		<p><h1>Links: <?php echo $title?></h1>
		<p><a href="<?php echo $url."add" ?>" class="largeButton">Add New Links</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="<?php echo $url."edit" ?>" class="largeButton">Edit Links</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="<?php echo $url."del" ?>" class="largeButton">Delete Links</a>
		</p><p>&nbsp;
		
  		<form action="<?php $url.$action?>" method="post" name="link">                  
                 
		
		<input type="hidden" name="parentid" value="<?php echo $parentid ?>" />
		<input type="hidden" name="tab" value="<?php echo $tab ?>" />
                       
		<?php
                if($action == "add"){ 
                    echo "                      <div id=\"addform\">";
                    echo "			<table>"."\n";
                    displayTableHeader();
                    
                    for( $i=0; $i<5; $i++){
                        echo " 				<tr>"."\n";
                        echo "                              <td class=\"local\" align=\"center\"><select name=\"local[]\">";
                        echo "                              <option value=\"1\" selected=\"selected\">local</option>";
                        echo "                              <option value=\"0\">non-local</option>";
                        echo "                              </select></td>";
                        echo "                              <td class=\"name\" valign=\"top\"><textarea name=\"name[]\" cols=\"50\" type=\"text\" class=\"textbox textarea\"></textarea></td>"."\n";
			echo "                              <td class=\"url\" valign=\"top\"><textarea name=\"url[]\" cols=\"60\" type=\"text\" class=\"textbox textarea\"></textarea></td>"."\n";
			echo "				</tr>"."\n";
                    }
                    
                    echo "			</table>"."\n";
                    echo"</div>";
                    
                    echo"<span id=\"writeroot\"></span>";
                    
                    echo "  <p style=\"float: right; height: 50px;\">";
                    echo "  <a href=\"javascript: void(0)\" onclick=\"javascript:moreFields()\" class=\"largeButton\">Add more fields</a>";
                    echo "  </p>";
                    
                        
                    echo"   <p style=\"text-align: center\">";
                    echo"   <input type=\"submit\" name=\"".$action."\"value=\"Update\" class=\"button\" />";
                    echo"   </p>";
                }
		
		$linkList = getLinkList($parentid);
                
		if ($linkList != ""){ 
			displayLinkTable($linkList);
                        if($action != 'add'){
                        echo"   <p style=\"text-align: center\">";
                        echo"   <input type=\"submit\" name=\"".$action."\"value=\"Update\" class=\"button\" />";
                        echo"   </p>";
                        }
		} else {
			echo "		<p>There are no links.</p>"."\n";
		}
 
		?>   			 
		</form>
	</div>





<?php
	} else {
		// ------------------------ if the form is submitted ---------------
		
		/*********** add mode ***********/
		if ($action == "add"){
			if (addLink()){	?>
	<meta http-equiv=Refresh content="2; url=" />
	<div class="main">
		<p><h1>Add successfully</h1>
		<p>The links have been added. Redirect to the previous page...
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
                    if (editLink()){	?> 
	<meta http-equiv=Refresh content="2; url=" />
	<div class="main">
		<p><h1>Edit successfully</h1>
		<p>The links have been updated. Redirect to the previous page...
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
			if (delLink()){	?>
	<meta http-equiv=Refresh content="2; url=" />
	<div class="main">
		<p><h1>Delete successfully</h1>
		<p>The links have been deleted. Redirect to the previous page...
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
