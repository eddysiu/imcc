<script>
function displayAddLinkFields(){
	document.getElementById("addLinkDiv").style.display = "block";
	// adjust the height again
	$(".nav").height(function(index, height){return (height+200)});
	$(".main").height(function(index, height){return (height+200)});
}
</script>
<?php

// get the current action
if (isset($_GET["action"])){
	$action = $_GET["action"];
} else {
	$action = "";
}

// detect form is submitted or not
function formIsSubmitted(){
	$isSubmitted = false;
	if ((isset($_GET["action"]) && ($_GET["action"] == "del")) || isset($_POST["submit"])){
		$isSubmitted = true;
	}
	return $isSubmitted;
}

if (!formIsSubmitted()){
	// ------------------------ if the form is NOT submitted ---------------
?>
	<div class="main">
		<p><h1>Quick Links</h1>
		<p>&nbsp;
		<form action="./quicklink.php" method="post" name="quicklink">
			<p><a href="javascript: void(0)" onclick="javascript: displayAddLinkFields()" class="largeButton">Add New Links</a>
			<p>&nbsp;
			<div id="addLinkDiv" style="display: none;">
				<table cellpadding="2" border="0">
					<tr>
						<td>Link</td>
						<td><input type="text" name="newLink[]" size="50" /></td>
						<td>Image</td>
						<td><input type="text" name="newImg[]" size="50" /></td>
						<td>Order</td>
						<td><input type="text" name="newOrder[]" size="2" /></td>
					</tr>
					<tr>
						<td>Link</td>
						<td><input type="text" name="newLink[]" size="50" /></td>
						<td>Image</td>
						<td><input type="text" name="newImg[]" size="50" /></td>
						<td>Order</td>
						<td><input type="text" name="newOrder[]" size="2" /></td>
					</tr>
					<tr>
						<td>Link</td>
						<td><input type="text" name="newLink[]" size="50" /></td>
						<td>Image</td>
						<td><input type="text" name="newImg[]" size="50" /></td>
						<td>Order</td>
						<td><input type="text" name="newOrder[]" size="2" /></td>
					</tr>
				</table>
			</div>
			<p>&nbsp;
			<h2>Current Quick Links</h2>
			<table width="100%" cellpadding="2" border="0">
				<tr>
					<th>Del</th>
					<th>Link</th>
					<th>Image</th>
					<th>Order</th>
					<th>Shown?</th>
				</tr>
<?php
	$linkList = getLinkList();
	if ($linkList != ""){
		foreach ($linkList as $link){
			$id = $link["id"];
			$image = $link["image"];
			$url = $link["url"];
			$order = $link["order"];
			$shown = $link["shown"];
			echo "				<tr>"."\n";
			echo "					<td><a href=\"./quicklink.php?action=del&amp;id=$id\" onclick=\"return confirm('Do you really want to delete this link?')\"><img src=\"./img/delete.png\" title=\"Delete\"></a></td>"."\n";
			echo "					<td><input type=\"hidden\" name=\"id[]\" value=\"$id\" /><input type=\"text\" name=\"link[]\" size=\"50\" value=\"$url\"/></td>"."\n";
			echo "					<td><input type=\"text\" name=\"image[]\" size=\"50\" value=\"$image\"/></td>"."\n";
			echo "					<td><input type=\"text\" name=\"order[]\" size=\"2\" value=\"$order\"/></td>"."\n";
			echo "					<td>"."\n";
			if ($shown == "1"){
				echo "						<input type=\"checkbox\" name=\"shown[]\" checked=\"checked\" value=\"$id\">"."\n";
			} else {
				echo "						<input type=\"checkbox\" name=\"shown[]\" value=\"$id\">"."\n";
			}
			echo "					</td>"."\n";
			echo "				</tr>"."\n";
		}
	}
?>
			<tr>
				<td colspan="5" align="center"><p><input type="submit" name="submit" value="Update" /></td>
			</tr>
			</table>
		</form>
		<p>* Note that only 4 links in maximum can be shown in the main page.
	</div>
<?php
} else {
	// ------------------------ if the form is submitted ---------------
	if (manageQuicklinks()){	?>
	<meta http-equiv=Refresh content="2; url=./quicklink.php" />
	<div class="main">
		<p><h1>Update successfully</h1>
		<p>The quick links have been updated. Redirect to the previous page...
	</div>
<?php
	} else {	// if there is any error	?>
	<meta http-equiv=Refresh content="2; url=./quicklink.php" />
	<div class="main">
		<p><h1 class="error">Error!</h1>
		<p>Database error. Please try again or contact the administrator.
	</div>
<?php
	} // end error
} // end form is submitted
?>