<script>
function displayAddSubjectFields(){
	document.getElementById("addSubjectDiv").style.display = "block";
	// adjust the height again
	$(".nav").height(function(index, height){return (height+200)});
	$(".main").height(function(index, height){return (height+200)});
}

function isBlankInput(value1, value2, value3, value4, value5, value6, value7, value8, value9, value10){
	// if any one of the fields is filled, then NOT blank
	// I know its look stupid but I just have to finish the backend in time
	if ((value1 != "") || (value2 != "") || (value3 != "") || (value4 != "") || (value5 != "") || (value6 != "") || (value7 != "") || (value8 != "") || (value9 != "") || (value10 != "")){
		return false;
	} else {
		return true;
	}
}

function validateEditForm() {
	var errorMsg = "";

	// get data from the form
	var title = document.getElementsByName("title");
	
	if (title.value == ""){
		errorMsg += "- Please fill in the title field\n";
	}
	
	if (errorMsg != ""){
		errorMsg = "Please check the following:\n\n" + errorMsg;
		alert(errorMsg);
		return false;
	} else {
		return true;
	}
}

function validateForm() {
	var errorMsg = "";
	var blankCounter = 0;

	// get data from the form
	var callNo = document.getElementsByName("callNo[]");
	var subject = document.getElementsByName("subject[]");
	var title = document.getElementsByName("title[]");
	var author = document.getElementsByName("author[]");
	var publisher = document.getElementsByName("publisher[]");
	var year = document.getElementsByName("year[]");
	var edition = document.getElementsByName("edition[]");
	var ISBN = document.getElementsByName("ISBN[]");
	var ISSN = document.getElementsByName("ISSN[]");
	var noOfCopy = document.getElementsByName("noOfCopy[]");
	
	for (i = 0; i < title.length; i++){
		var fieldIndex = i+1;
		if (isBlankInput(subject[i].value, callNo[i].value, title[i].value, author[i].value, publisher[i].value, year[i].value, edition[i].value, ISBN[i].value, ISSN[i].value, noOfCopy[i].value)){
			blankCounter++;
		} else {
			if (title[i].value == ""){
				errorMsg += "- For the "+fieldIndex+"-input: Please fill in the title field\n";
			}
			
			if (subject[i].value == ""){
				errorMsg += "- For the "+fieldIndex+"-input: Please select a subject\n";
			}
		}
	}
		
	if (blankCounter == title.length){
		errorMsg += "- Please at least input one field\n";
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
// get the current action
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

// for edit mode
function displaySubjectList($id){
	$subjectList = getSubjectList();
	$currentSubject = getCurrentBookSubject($id);
	echo '			<select name="subject[]">'."\n";
			echo "					<option value=''></option>"."\n";
	foreach ($subjectList as $subject){
		$id = $subject["id"];
		$name = $subject["name"];
		if ($currentSubject != $id){
			echo "					<option value='$id'>$name</option>"."\n";
		} else {
			echo "					<option value='$id' selected='selected'>$name</option>"."\n";
		}
	}
	echo "			</select>"."\n";
}

// for normal mode
function displaySubjectURLList(){
	$subjectList = getSubjectList();
	echo '		<span style="float: right;">'."\n";
	echo '			<select name="subject" onchange="javascript:location.href=this.value;">'."\n";
	echo '				<option selected="select">---Please select a subject---</option>'."\n";
	foreach ($subjectList as $subject){
		$id = $subject["id"];
		$name = $subject["name"];
		$subjectURL = "./library_search.php?subject=$id";
		echo "					<option value='$subjectURL'>$name</option>"."\n";
	}
	echo "			</select>"."\n";
	echo "		</span>"."\n";
}

function displayAddForm(){
	for ($i=0; $i < 5; $i++){
		echo '			<table width="100%" cellpadding="2" border="0">'."\n";
		echo '				<tr>'."\n";
		echo '					<td width="15%">Subject</td>'."\n";
		echo '					<td>'."\n";
		displaySubjectList("");
		echo '					</td>'."\n";
		echo '				</tr>'."\n";
		echo '				<tr>'."\n";
		echo '					<td width="15%">Call No</td>'."\n";
		echo '					<td><input type="text" name="callNo[]" value="" size="50" /></td>'."\n";
		echo '				</tr>'."\n";
		echo '				<tr>'."\n";
		echo '					<td width="15%">Title</td>'."\n";
		echo '					<td><input type="text" name="title[]" size="50" /></td>'."\n";
		echo '				</tr>'."\n";
		echo '				<tr>'."\n";
		echo '					<td width="15%">Author</td>'."\n";
		echo '					<td><textarea name="author[]" rows="2" cols="45"></textarea></td>'."\n";
		echo '				</tr>'."\n";
		echo '				<tr>'."\n";
		echo '					<td width="15%">Publisher</td>'."\n";
		echo '					<td><textarea name="publisher[]" rows="2" cols="45"></textarea></td>'."\n";
		echo '				</tr>'."\n";
		echo '				<tr>'."\n";
		echo '					<td width="15%">Year</td>'."\n";
		echo '					<td><input type="text" name="year[]" size="50" /></td>'."\n";
		echo '				</tr>'."\n";
		echo '				<tr>'."\n";
		echo '					<td width="15%">Edition</td>'."\n";
		echo '					<td><input type="text" name="edition[]" value="" size="50" /></td>'."\n";
		echo '				</tr>'."\n";
		echo '				<tr>'."\n";
		echo '					<td width="15%">ISBN</td>'."\n";
		echo '					<td><input type="text" name="ISBN[]" value="" size="50" /></td>'."\n";
		echo '				</tr>'."\n";
		echo '				<tr>'."\n";
		echo '					<td width="15%">ISSN</td>'."\n";
		echo '					<td><input type="text" name="ISSN[]" value="" size="50" /></td>'."\n";
		echo '				</tr>'."\n";
		echo '				<tr>'."\n";
		echo '					<td width="15%">No. of Copy</td>'."\n";
		echo '					<td><input type="text" name="noOfCopy[]" value="" size="50" /></td>'."\n";
		echo '				</tr>'."\n";
		echo '			</table>'."\n";
		echo '		<p>&nbsp;'."\n";
	}
}

if (!formIsSubmitted()){
	// ------------------------ if the form is NOT submitted ---------------
?>
	<div class="main">
		<p><h1>Online Catalogue</h1>
<?php	displaySubjectURLList();	?>		
		<p><a href="./library_search.php?action=add" class="largeButton">Add New Books</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="./library_search.php?action=manage" class="largeButton">Manage Subjects</a> 
		<p>&nbsp;
		
<?php
	/******* normal mode ******/
	if (($action == "") && isset($_GET["subject"])){
		$subjectID = $_GET["subject"];
		$subject = getBookSubject($subjectID);
		$books = getBookList($subjectID);
?>
		<h2><?php echo $subject?></h2>
		<table width="100%" cellpadding="2" border="0">
				<tr>
					<th width="5%">Edit</th>
					<th width="5%">Del</th>
					<th width="5%">Call No.</th>
					<th width="20%">Title</th>
					<th width="10%">Author</th>
					<th width="20%">Publisher</th>
					<th width="5%">Year</th>
					<th width="7%">Edition</th>
					<th width="10%">ISBN</th>
					<th width="10%">ISSN</th>
					<th width="5%">Copy</th>
				</tr>
<?php	if ($books != ""){
			foreach ($books as $book){
				$id = $book["id"];
				$callNo = $book["callNo"];
				$title = $book["title"];
				$author = $book["author"];
				$publisher = $book["publisher"];
				$year = $book["year"];
				$edition = $book["edition"];
				$ISBN = $book["ISBN"];
				$ISSN = $book["ISSN"];
				$noOfCopy = $book["noOfCopy"];
				
				echo "				<tr>"."\n";
				echo "					<td valign=\"top\" align=\"center\"><a href=\"./library_search.php?action=edit&amp;id=$id\"><img src=\"./img/edit.png\" title=\"Edit\"></a></td>"."\n";
				echo "					<td valign=\"top\" align=\"center\"><a href=\"./library_search.php?action=del&amp;type=book&amp;id=$id\" onclick=\"return confirm('Do you really want to delete this book?')\"><img src=\"./img/delete.png\" title=\"Delete\"></a></td>"."\n";
				echo "					<td valign=\"top\">$callNo</td>"."\n";
				echo "					<td valign=\"top\">$title</td>"."\n";
				echo "					<td valign=\"top\">$author</td>"."\n";
				echo "					<td valign=\"top\">$publisher</td>"."\n";
				echo "					<td valign=\"top\">$year</td>"."\n";
				echo "					<td valign=\"top\">$edition</td>"."\n";
				echo "					<td valign=\"top\">$ISBN</td>"."\n";
				echo "					<td valign=\"top\">$ISSN</td>"."\n";
				echo "					<td valign=\"top\">$noOfCopy</td>"."\n";
				echo "				</tr>"."\n";
			}
?>
		</table>
		<p>&nbsp;	
<?php
		} else {	?>
				<tr>
					<td colspan="10" align="center">No books are under this subject or subject is not found.</td>
				</tr>
			</table>
		</form>
<?php	}
	}
	
	/********** add mode *******/
	if ($action == "add"){	?>
		<form action="./library_search.php?action=add" method="post" name="add" onsubmit="return validateForm()">
<?php	displayAddForm();	?>
			<p align="center"><input type="submit" name="submit" value="Submit" />
		</form>		
<?php
	} // end add mode

	
	/********* edit mode*********/
	if ($action == "edit"){
		$id = $_GET["id"];
		$details = getBookDetails($id);	?>
		<form action="./library_search.php?action=edit&amp;id=<?php echo $id?>" method="post" name="edit" onsubmit="return validateEditForm();">
			<table width="100%" cellpadding="2" border="0">
				<tr>
					<td width="15%">Subject</td>
					<td><?php displaySubjectList($id); ?></td>
				</tr>
				<tr>
					<td width="15%">Call No</td>
					<td><input type="text" name="callNo" value="<?php echo $details["callNo"]?>" size="50" /></td>
				</tr>
				<tr>
					<td width="15%">Title</td>
					<td><input type="text" name="title" value="<?php echo $details["title"]?>" size="50" /></td>
				</tr>
				<tr>
					<td width="15%">Author</td>
					<td><textarea name="author" rows="2" cols="45"><?php echo br2nl($details["author"])?></textarea></td>
				</tr>
				<tr>
					<td width="15%">Publisher</td>
					<td><textarea name="publisher" rows="2" cols="45"><?php echo br2nl($details["publisher"])?></textarea></td>
				</tr>
				<tr>
					<td width="15%">Year</td>
					<td><input type="text" name="year" value="<?php echo $details["year"]?>" size="50" /></td>
				</tr>
				<tr>
					<td width="15%">Edition</td>
					<td><input type="text" name="edition" value="<?php echo $details["edition"]?>" size="50" /></td>
				</tr>
				<tr>
					<td width="15%">ISBN</td>
					<td><input type="text" name="ISBN" value="<?php echo $details["ISBN"]?>" size="50" /></td>
				</tr>
				<tr>
					<td width="15%">ISSN</td>
					<td><input type="text" name="ISSN" value="<?php echo $details["ISSN"]?>" size="50" /></td>
				</tr>
				<tr>
					<td width="15%">No. of Copy</td>
					<td><input type="text" name="noOfCopy" value="<?php echo $details["noOfCopy"]?>" size="50" /></td>
				</tr>
				<tr>
					<td colspan="2" align="center"><p><input type="submit" name="submit" value="Submit" /></td>
				</tr>
			</table>
		</form>
<?php
	} // end edit mode
	
	/********** manage subject mode *******/
	if ($action == "manage"){	?>
		<h2>Manage Subjects</h2>
		<p>&nbsp;
		<form action="./library_search.php?action=manage" method="post" name="manage">
			<p><a href="javascript: void(0)" onclick="javascript: displayAddSubjectFields()" class="largeButton">Add New Subjects</a>
			<p>&nbsp;
			<div id="addSubjectDiv" style="display: none;">
				<p>Subject Code  <input type="text" name="newCode[]" size="10" />
					Name <input type="text" name="newSubject[]" size="50" />
				<p>Subject Code  <input type="text" name="newCode[]" size="10" />
					Name <input type="text" name="newSubject[]" size="50" />
				<p>Subject Code  <input type="text" name="newCode[]" size="10" />
					Name <input type="text" name="newSubject[]" size="50" />
				<p>Subject Code  <input type="text" name="newCode[]" size="10" />
					Name <input type="text" name="newSubject[]" size="50" />
				<p>Subject Code  <input type="text" name="newCode[]" size="10" />
					Name <input type="text" name="newSubject[]" size="50" />
			</div>
			<p>&nbsp;
			<h2>Current Subjects</h2>
			<table cellpadding="2" border="0">
				<tr>
					<th>Del</th>
					<th>Code</th>
					<th>Name</th>
				</tr>
<?php
		$subjectList = getSubjectList();
		foreach ($subjectList as $subject){
			$id = $subject["id"];
			$code = $subject["code"];
			$name = $subject["name"];
			echo "				<tr>"."\n";
			echo "					<td><a href=\"./library_search.php?action=del&amp;type=subject&amp;id=$id\" onclick=\"return confirm('Do you really want to delete this subject?\\nNote that ALL books under this subject WILL ALSO BE deleted.')\"><img src=\"./img/delete.png\" title=\"Delete\"></a></td>"."\n";
			echo "					<td><input type=\"hidden\" name=\"id[]\" value=\"$id\" /><input type=\"text\" name=\"code[]\" size=\"10\" value=\"$code\"/></td>"."\n";
			echo "					<td><input type=\"text\" name=\"subject[]\" size=\"50\" value=\"$name\"/></td>"."\n";
			echo "				</tr>"."\n";
		}
?>
			<tr>
				<td colspan="2" align="center"><p><input type="submit" name="submit" value="Submit" /></td>
			</tr>
			</table>
		</form>
<?php
	} // end manage mode

	
?>
	</div>
<?php
} else {
	// ------------------------ if the form is submitted ---------------
	
	$redirectURL = "./".getCurrentFilename();
	
	/*********** add mode ***********/
	if ($action == "add"){
		if (addBooks()){	?>
	<meta http-equiv=Refresh content="2; url=./library_search.php" />
	<div class="main">
		<p><h1>Add successfully</h1>
		<p>The books have been added. Redirect to the list...
	</div>
<?php
		} else {	// if there is any error	?>
	<meta http-equiv=Refresh content="2; url=./library_search.php" />
	<div class="main">
		<p><h1 class="error">Error!</h1>
		<p>Database error. Please try again or contact the administrator.
	</div>
<?php
		}
	} 
			
	/************* edit mode *********/
	if ($action == "edit"){
		if (editBook() >= 0){	?>
	<meta http-equiv=Refresh content="2; url=./library_search.php" />
	<div class="main">
		<p><h1>Edit successfully</h1>
		<p>The book has been updated. Redirect to the list...
	</div>
<?php		} else {	// if there is any error	?>
	<meta http-equiv=Refresh content="2; url=./library_search.php" />
	<div class="main">
		<p><h1 class="error">Error!</h1>
		<p>Database error. Please try again or contact the administrator.
	</div>
<?php
		}	// end error 
	} // end edit part
	
	/************** manage mode ************/
	if ($action == "manage"){
		if (updateSubjects()){	?>
	<meta http-equiv=Refresh content="2; url=./library_search.php?action=manage" />
	<div class="main">
		<p><h1>Update successfully</h1>
		<p>The subjects have been updated. Redirect to the list...
	</div>
<?php
		} else {	// if there is any error	?>
	<meta http-equiv=Refresh content="2; url=./library_search.php?action=manage" />
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
	<meta http-equiv=Refresh content="2; url=./library_search.php" />
	<div class="main">
		<p><h1>Delete successfully</h1>
		<p>The book/subject has been deleted. Redirect to the list...
	</div>
<?php
		} else {	// if there is any error	?>
	<meta http-equiv=Refresh content="2; url=./library_search.php" />
	<div class="main">
		<p><h1 class="error">Error!</h1>
		<p>Database error. Please try again or contact the administrator.
	</div>
<?php
		}
	} // end del mode 
} // end form is submitted
?>