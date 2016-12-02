<script>
var counter = 0;

function displayAddVolumeFields(){
	document.getElementById("addVolumeDiv").style.display = "block";
	// adjust the height again
	$(".nav").height(function(index, height){return (height+200)});
	$(".main").height(function(index, height){return (height+200)});
}

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


</script>


<?php

if (! function_exists('array_column')) {
    function array_column(array $input, $columnKey, $indexKey = null) {
        $array = array();
        foreach ($input as $value) {
            if (is_null($indexKey)) {
                $array[] = $value[$columnKey];
            }
            else {
                $array[$value[$indexKey]] = $value[$columnKey];
            }
        }
        return $array;
   }
}
    
// get the current tab
$tab = "";

if (isset($_GET["tab"])){
	$tab = $_GET["tab"];
} else {
	$tab = "";
}

// get the current action
if (isset($_GET["action"])){
	$action = $_GET["action"];
	if (($action != "add") && ($action != "del") && ($action != "manage")){
		$action = "edit";	// default: edit mode
	}
} else {
	$action = "edit";	// default: edit mode
}


// display list of volumn
function displayVolList($tab){
    $url = "./".getCurrentFilename()."?tab=$tab&amp;id=";
    $volList = getNewsletterVol($tab);
    $noOfVol = count($volList);
    echo "			<table>"."\n";
    for ($i = 0; $i < $noOfVol; $i++){
       if ($i % 10 == 0){
           echo "               <tr>";
        }
        echo "                  <td style=\"text-align: center; width: 100px\"><a href=\"".$url.$volList[$i]["id"]." \">".$volList[$i]["name"]."</a></td>";
    }
     echo "			</table>"."\n";

     return $volList;
    
}


// detect form is submitted or not
function formIsSubmitted(){
	$isSubmitted = false;
	if ((isset($_POST["add"])) || (isset($_POST["edit"])) || isset($_POST["del"]) || isset($_POST["manage"]) || (isset($_GET["del"]))){
		// $_GET["del"] for manage volume: del
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
		echo "					<th style=\"text-align: center; width: 50%\">Name</th>"."\n";
		echo "					<th style=\"text-align: center; width: 50%\">URL</th>"."\n";
		echo "				</tr>"."\n";
	} else {
		echo "				<tr>"."\n";
		echo "					<th style=\"text-align: center; width: 10%\">Del</th>"."\n";
		echo "					<th style=\"text-align: center; width: 50%\">Name</th>"."\n";
		echo "					<th style=\"text-align: center; width: 50%\">URL</th>"."\n";
		echo "				</tr>"."\n";
	}
}

// display the whole table (in all modes)
function displayNewsletterTable($list){
	$noOfNewsletter = count($list);
	$action = getCurrentAction();

	echo "			<table>"."\n";
	displayTableHeader();
	for ($i = 0; $i < $noOfNewsletter; $i++){
		
		echo "                         <input type=\"hidden\" name=\"id[]\"  value=\"".$list[$i]["id"]."\"/>";
		// if in edit mode, display textarea for editing
		if (($action != "add") && ($action != "del")){
			// replace <br/> to \n for display
			$list = convertToNewLine($list);
                       
			echo " 				<tr>"."\n";
                        
                        echo "                              <td class=\"name\" valign=\"top\"><textarea name=\"name[]\" cols=\"60\" type=\"text\" class=\"textbox textarea\">".$list[$i]["name"]."</textarea></td>"."\n";
			echo "                              <td class=\"url\" valign=\"top\"><textarea name=\"url[]\" cols=\"60\" type=\"text\" class=\"textbox textarea\">".$list[$i]["url"]."</textarea></td>"."\n";
			echo "				</tr>"."\n";
                        
                        
		} // end edit mode
			
		if ($action == "add"){
			// if in add mode, just display the table only (no editing) and also the add form
			echo "				<tr>"."\n";
                        echo "					<td class=\"name\" valign=\"top\">".$list[$i]["name"]."</td>"."\n";
			echo "					<td class=\"url\" valign=\"top\">".$list[$i]["url"]."</td>"."\n";
			echo "				</tr>"."\n";
		} // end add mode
		
		if ($action == "del"){
		
			echo "				<tr>"."\n";
			echo "					<td class=\"del\"  align=\"center\"><input type=\"checkbox\" name=\"mainDel[]\" value=\"".$list[$i]["id"]."\" /></td>"."\n";
			echo "					<td class=\"name\" valign=\"top\">".$list[$i]["name"]."</td>"."\n";
			echo "					<td class=\"url\" valign=\"top\">".$list[$i]["url"]."</td>"."\n";
			echo "				</tr>"."\n";
		} // end del mode
	} //end for loop
	echo "			</table>"."\n";
} // end displayEventTable





if (isValidTab($tab)){
        //$action = getCurrentAction();
	$title = getContentTitle($tab);
	//$parentid = getCatIDByAbbr($tab);
	//$url = "./".getCurrentFilename()."?tab=$tab&amp;id=$parentid&amp;action=";
        
        
	if (!formIsSubmitted()){
		// ------------------------ if the form is NOT submitted ---------------
?>
	<div class="main">
		<p><h1>Newsletter: <?php echo $title?></h1>
               
                <?php
                $volList = displayVolList($tab);
		
		if (!isset($_GET["id"])){
                    $parentid = $volList[0]["id"];                   
                }else{
                    $parentid = $_GET["id"];
                }
                $url = "./".getCurrentFilename()."?tab=$tab&amp;id=$parentid&amp;action=";
                ?>
                       
		<p align="center">
		<a href="<?php echo $url."manage" ?>" class="largeButton">Manage Volume</a>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="<?php echo $url."add" ?>" class="largeButton">Add New</a>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="<?php echo $url."edit" ?>" class="largeButton">Edit</a>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<a href="<?php echo $url."del" ?>" class="largeButton">Delete</a>
		</p>
		 <?php
		 
		 if ($action != "manage"){
              
                $volName = $volList[array_search($parentid, array_column($volList, 'id'))]["name"]; 
                echo"   <h2>".$volName."</h2>";		
        ?>
		
                
  		<form action="<?php $url.$action?>" method="post" name="newsletter">
		
		<input type="hidden" name="parentid" value="<?php echo $parentid ?>" />
		<input type="hidden" name="tab" value="<?php echo $tab ?>" />
                       
		<?php
                if($action == "add"){ 
                    echo "                      <div id=\"addform\">";
                    echo "			<table>"."\n";
                    displayTableHeader();
                    
                    for( $i=0; $i<5; $i++){
                        echo " 				<tr>"."\n";
                        echo "                              <td class=\"name\" valign=\"top\"><textarea name=\"name[]\" cols=\"60\" type=\"text\" class=\"textbox textarea\"></textarea></td>"."\n";
			echo "                              <td class=\"url\" valign=\"top\"><textarea name=\"url[]\" cols=\"60\" type=\"text\" class=\"textbox textarea\"></textarea></td>"."\n";
			echo "				</tr>"."\n";
                    }
                    
                    echo "			</table>"."\n";
                    echo"</div>";
                    
                    echo"<span id=\"writeroot\"></span>";
                    
/*                     echo "  <p style=\"text-align: right\">";
                    echo "  <img src=\"./img/add.png\" title=\"Add\" onclick=\"javascript:moreFields()\"> Add more records</a>";
                    echo "  </p>"; */
                    
                        
                    echo"   <p style=\"text-align: center\">";
                    echo"   <input type=\"submit\" name=\"".$action."\"value=\"Update\" class=\"button\" />";
                    echo"   </p>";
                }

		$NewsletterList = getNewsletterList($parentid);
                
		if ($NewsletterList != ""){ 
			displayNewsletterTable($NewsletterList);
                        if($action != 'add'){
                        echo"   <p style=\"text-align: center\">";
                        echo"   <input type=\"submit\" name=\"".$action."\"value=\"Update\" class=\"button\" />";
                        echo"   </p>";
                        }
		} else {
			echo "		<p>There are no newsletters.</p>"."\n";
		}
 
		?>   			 
		</form>
	</div>



<?php
		 } else {
			 // ************ manage mode ***********
			 ?>
		<h2>Manage Volume</h2>
		<p>&nbsp;
		<form action="./newsletter.php?tab=shipping&action=manage" method="post" name="manage">
			<p><a href="javascript: void(0)" onclick="javascript: displayAddVolumeFields()" class="largeButton">Add New Volume</a>
			<p>&nbsp;
			<div id="addVolumeDiv" style="display: none;">
				<p>Name <input type="text" name="newVolume[]" size="50" />
				<p>Name <input type="text" name="newVolume[]" size="50" />
				<p>Name <input type="text" name="newVolume[]" size="50" />
				<p>Name <input type="text" name="newVolume[]" size="50" />
				<p>Name <input type="text" name="newVolume[]" size="50" />
				<p>Name <input type="text" name="newVolume[]" size="50" />
			</div>
			<p>&nbsp;
			<h2>Current Volume</h2>
			<table width="100%" cellpadding="2" border="0">
				<tr>
					<th>Del</th>
					<th>Name</th>
				</tr>
<?php
		$volumeList = getNewsletterVol($tab);
		foreach ($volumeList as $subject){
			$id = $subject["id"];
			$name = $subject["name"];
			echo "				<tr>"."\n";
			echo "					<td><a href=\"./newsletter.php?tab=shipping&amp;action=manage&amp;del=true&amp;id=$id\" onclick=\"return confirm('Do you really want to delete this volume?')\"><img src=\"./img/delete.png\" title=\"Delete\"></a></td>"."\n";
			echo "					<td><input type=\"hidden\" name=\"id[]\" value=\"$id\" /><input type=\"text\" name=\"volume[]\" size=\"50\" value=\"$name\"/></td>"."\n";
			echo "				</tr>"."\n";
		}
?>
			<tr>
				<td colspan="2" align="center"><p><input type="submit" name="manage" value="Submit" /></td>
			</tr>
			</table>
		</form>
	</div>
<?php
		} // end manage mode
	} else {
		// ------------------------ if the form is submitted ---------------
		
		/*********** add mode ***********/
		if ($action == "add"){
			if (addNewsletter()){	?>
	<meta http-equiv=Refresh content="2; url=./newsletter.php?tab=shipping" />
	<div class="main">
		<p><h1>Add successfully</h1>
		<p>The newsletter has been added. Redirect to the previous page...
	</div>
<?php
			} else {	// if there is any error	?>
	<meta http-equiv=Refresh content="2; url=./newsletter.php?tab=shipping" />
	<div class="main">
		<p><h1 class="error">Error!</h1>
		<p>Database error. Please try again or contact the administrator.
	</div>
<?php
			}
		}
                
		/************* edit mode *********/
		if ($action == "edit"){
                    if (editNewsletter()){	?> 
	<meta http-equiv=Refresh content="2; url=./newsletter.php?tab=shipping" />
	<div class="main">
		<p><h1>Edit successfully</h1>
		<p>The newsletter has been updated. Redirect to the previous page...
	</div>
<?php		} else {	// if there is any error	?>
	<meta http-equiv=Refresh content="2; url=./newsletter.php?tab=shipping" />
	<div class="main">
		<p><h1 class="error">Error!</h1>
		<p>Database error. Please try again or contact the administrator.
	</div>
<?php
			}	// end error
		} // end edit part
		
		/**************** del mode ***********/
		if ($action == "del"){
			if (delNewsletter()){	?>
	<meta http-equiv=Refresh content="2; url=./newsletter.php?tab=shipping" />
	<div class="main">
		<p><h1>Delete successfully</h1>
		<p>The newsletter has been deleted. Redirect to the previous page...
	</div>
<?php		} else {	// if there is any error	?>
	<meta http-equiv=Refresh content="2; url=./newsletter.php?tab=shipping" />
	<div class="main">
		<p><h1 class="error">Error!</h1>
		<p>Database error. Please try again or contact the administrator.
	</div>
<?php
			} // end error
		} // end del part
		
		/**************** manage mode ***********/
		if ($action == "manage"){
			if (manageVolume()){	?>
	<meta http-equiv=Refresh content="2; url=./newsletter.php?tab=shipping&amp;action=manage" />
	<div class="main">
		<p><h1>Update successfully</h1>
		<p>The volume has been updated. Redirect to the previous page...
	</div>
<?php		} else {	// if there is any error	?>
	<meta http-equiv=Refresh content="2; url=./newsletter.php?tab=shipping&amp;action=manage" />
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
