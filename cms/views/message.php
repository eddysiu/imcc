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
	if ((isset($_POST["submit"])) || (($action == "del") || ($action == "reapprove") || ($action == "unapprove")) && (isset($_GET["id"]))){
		$isSubmitted = true;
	}
	return $isSubmitted;
}

$addUrl = "./".getCurrentFilename()."?action=add";

if (!formIsSubmitted()){
	// ------------------------ if the form is NOT submitted ---------------
	$waitForApproval = getNoOfWaitingPost();
?>
	<div class="main">
		<p><h1>Message Board</h1>
		<p><a href="./message.php?action=waiting" class="largeButton">Wait for Approval (<?php echo $waitForApproval ?>)</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="./message.php?action=approved" class="largeButton">Approved Posts</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="./message.php?action=unapproved" class="largeButton">Unapproved Posts</a>
		<p>&nbsp;
		
<?php
	/******* normal (waiting) mode ******/
	if (($action == "") || ($action == "waiting")){	?>
		<h2>Posts in Waiting List</h2>
		<form action="./message.php?action=waiting" method="post" name="waiting">
			<table width="100%" cellpadding="2" border="0">
				<tr>
					<th width="3%">Edit</th>
					<th width="10%">Name</th>
					<th width="10%">Email</th>
					<th width="18%">Title</th>
					<th width="43%">Content</th>
					<th width="11%">Post Datetime</th>
					<th width="3%">App?</th>
				</tr>
<?php	$waitingList = getWaitingList();
		if ($waitingList != ""){
			foreach ($waitingList as $post){
				$id = $post["id"];
				$name = $post["name"];
				$email = $post["email"];
				$title = $post["title"];
				$content = $post["content"];
				$date = $post["msgdate"];
				$parentid = $post["parentid"];
				
				if ($parentid != "0"){
					$parentPost = "../message.php?id=$parentid";
				}
				echo "				<tr>"."\n";
				echo "					<input type=\"hidden\" name=\"id[]\" value=\"$id\" />"."\n";
				echo "					<input type=\"hidden\" name=\"parentid[]\" value=\"$parentid\" />"."\n";
				echo "					<input type=\"hidden\" name=\"msgdate[]\" value=\"$date\" />"."\n";
				echo "					<td valign=\"top\" align=\"center\"><a href=\"./message.php?action=edit&amp;id=$id\"><img src=\"./img/edit.png\" title=\"Edit\"></a></td>"."\n";
				echo "					<td valign=\"top\">$name</td>"."\n";
				echo "					<td valign=\"top\"><a href=\"mailto:$email\">$email</a></td>"."\n";
				if ($parentid != "0"){
					echo "					<td valign=\"top\"><a href=\"$parentPost\" target=\"_blank\">$title</a></td>"."\n";
				} else {
					echo  "					<td valign=\"top\">$title</td>"."\n";
				}
				echo "					<td valign=\"top\">$content</td>"."\n";
				echo "					<td valign=\"top\">$date</td>"."\n";
				echo "					<td valign=\"top\" align=\"center\"><input type=\"checkbox\" name=\"approvedID[]\" value=\"$id\"/></td>"."\n";
				echo "				</tr>"."\n";
			}
?>
			</table>
			<p align="center"><input type="submit" name="submit" value="Submit">
			<p>&nbsp;
		</form>
	
<?php
		} else {	?>
				<tr>
					<td colspan="7" align="center">There is no post waiting for approval.</td>
				</tr>
			</table>
		</form>
<?php	}
	}
	
	/********** approved mode *******/
	if ($action == "approved"){	?>
		<h2>Approved Posts</h2>
		<table width="100%" cellpadding="2" border="0">
			<tr>
				<th width="3%">Edit</th>
				<th width="3%">Unapp</th>
				<th width="10%">Name</th>
				<th width="10%">Email</th>
				<th width="18%">Title</th>
				<th width="45%">Content</th>
				<th width="11%">Post Datetime</th>
			</tr>
<?php	$approvedList = getApprovedList();
		if ($approvedList != ""){
			foreach ($approvedList as $post){
				$id = $post["id"];
				$name = $post["name"];
				$email = $post["email"];
				$title = $post["title"];
				$content = $post["content"];
				$date = $post["msgdate"];
				$parentid = $post["parentid"];
				
				if ($parentid != "0"){
					$parentPost = "../message.php?id=$parentid";
				}
				echo "			<tr>"."\n";
				echo "				<td valign=\"top\" align=\"center\"><a href=\"./message.php?action=edit&amp;id=$id\"><img src=\"./img/edit.png\" title=\"Edit\"></a></td>"."\n";
				echo "				<td valign=\"top\" align=\"center\"><a href=\"./message.php?action=unapprove&amp;id=$id\" onclick=\"return confirm('Do you want to unapprove this post?')\"><img src=\"./img/delete.png\" title=\"Unapprove\"></a></td>"."\n";
				echo "				<td valign=\"top\">$name</td>"."\n";
				echo "				<td valign=\"top\"><a href=\"mailto:$email\">$email</a></td>"."\n";
				if ($parentid != "0"){
					echo "				<td valign=\"top\"><a href=\"$parentPost\" target=\"_blank\">$title</a></td>"."\n";
				} else {
					echo  "				<td valign=\"top\">$title</td>"."\n";
				}
				echo "				<td valign=\"top\">$content</td>"."\n";
				echo "				<td valign=\"top\">$date</td>"."\n";
				echo "			</tr>"."\n";
			}
?>
		</table>
		<p>&nbsp;
<?php
		} else {	?>
			<tr>
				<td colspan="7" align="center">There is no post approved.</td>
			</tr>
		</table>
<?php
		}
	} // end approved mode
	
	/******** unapproved mode *******/
	if ($action == "unapproved"){	?>
		<h2>Unapproved Posts</h2>
		<table width="100%" cellpadding="2" border="0">
			<tr>
				<th width="3%">Edit</th>
				<th width="3%">App</th>
				<th width="3%">Del</th>
				<th width="10%">Name</th>
				<th width="10%">Email</th>
				<th width="18%">Title</th>
				<th width="42%">Content</th>
				<th width="11%">Post Datetime</th>
			</tr>
<?php	$unapprovedList = getUnapprovedList();
		if ($unapprovedList != ""){
			foreach ($unapprovedList as $post){
				$id = $post["id"];
				$name = $post["name"];
				$email = $post["email"];
				$title = $post["title"];
				$content = $post["content"];
				$date = $post["msgdate"];
				$parentid = $post["parentid"];
				
				if ($parentid != "0"){
					$parentPost = "../message.php?id=$parentid";
				}
				echo "			<tr>"."\n";
				echo "				<td valign=\"top\" align=\"center\"><a href=\"./message.php?action=edit&amp;id=$id\"><img src=\"./img/edit.png\" title=\"Edit\"></a></td>"."\n";
				echo "				<td valign=\"top\" align=\"center\"><a href=\"./message.php?action=reapprove&amp;id=$id\"><img src=\"./img/add.png\" title=\"Approve\"></a></td>"."\n";
				echo "				<td valign=\"top\" align=\"center\"><a href=\"./message.php?action=del&amp;id=$id\" onclick=\"return confirm('Do you want to permanently delete this post?\\nNote that if it is the top post, ALL replies WILL ALSO be deleted.')\"><img src=\"./img/delete.png\" title=\"Delete\"></a></td>"."\n";
				echo "				<td valign=\"top\">$name</td>"."\n";
				echo "				<td valign=\"top\"><a href=\"mailto:$email\">$email</a></td>"."\n";
				if ($parentid != "0"){
					echo "				<td valign=\"top\"><a href=\"$parentPost\" target=\"_blank\">$title</a></td>"."\n";
				} else {
					echo  "				<td valign=\"top\">$title</td>"."\n";
				}
				echo "				<td valign=\"top\">$content</td>"."\n";
				echo "				<td valign=\"top\">$date</td>"."\n";
				echo "			</tr>"."\n";
			}
?>
		</table>
		<p>&nbsp;
<?php
		} else {	?>
			<tr>
				<td colspan="8" align="center">There is no post unapproved.</td>
			</tr>
		</table>
<?php
		}
	} // end unapprove mode
	
	/********* edit mode*********/
	if ($action == "edit"){
		$id = $_GET["id"];
		$details = getPostDetails($id);	?>
		<form action="./message.php?action=edit&amp;id=<?php echo $id?>" method="post" name="edit">
			<table width="100%" cellpadding="2" border="0">
				<tr>
					<td width="15%">Post Datetime</td>
					<td><?php echo $details["msgdate"] ?></td>
				</tr>
				<tr>
					<td width="15%">Name</td>
					<td><input type="text" name="name" value="<?php echo $details["name"]?>" size="50" /></td>
				</tr>
				<tr>
					<td width="15%">Email</td>
					<td><input type="text" name="email" value="<?php echo $details["email"]?>" size="50" /></td>
				</tr>
				<tr>
					<td width="15%">Title</td>
					<td><input type="text" name="title" value="<?php echo $details["title"]?>" size="50" /></td>
				</tr>
				<tr>
					<td width="15%">Content</td>
					<td><textarea name="content" rows="15" cols="70"><?php echo br2nl($details["content"])?></textarea></td>
				</tr>
				<tr>
					<td colspan="2" align="center"><p><input type="submit" name="submit" value="Submit" /></td>
				</tr>
			</table>
		</form>		
<?php
	} // end edit mode
?>
	</div>
<?php
} else {
	// ------------------------ if the form is submitted ---------------
	
	$redirectURL = "./".getCurrentFilename();
	
	/*********** waiting post ***********/
	if ($action == "waiting"){
		if (approvePost()){	?>
	<meta http-equiv=Refresh content="2; url=./message.php" />
	<div class="main">
		<p><h1>Update successfully</h1>
		<p>The posts have been approved/unapproved. Redirect to the list...
	</div>
<?php
		} else {	// if there is any error	?>
	<meta http-equiv=Refresh content="2; url=<?php echo $redirectURL ?>" />
	<div class="main">
		<p><h1 class="error">Error!</h1>
		<p>Database error. Please try again or contact the administrator.
	</div>
<?php
		}
	}
			
	/************* edit mode *********/
	if ($action == "edit"){
		if (editPost() >= 0){	?>
	<meta http-equiv=Refresh content="2; url=./message.php" />
	<div class="main">
		<p><h1>Edit successfully</h1>
		<p>The post has been updated. Redirect to the list...
	</div>
<?php		} else {	// if there is any error	?>
	<meta http-equiv=Refresh content="2; url=./message.php" />
	<div class="main">
		<p><h1 class="error">Error!</h1>
		<p>Database error. Please try again or contact the administrator.
	</div>
<?php
		}	// end error
	} // end edit part
	
	/************** app->unapp mode ************/
	if ($action == "unapprove"){
		if (unapprovePost() >= 0){	?>
	<meta http-equiv=Refresh content="2; url=./message.php?action=approved" />
	<div class="main">
		<p><h1>Update successfully</h1>
		<p>The posts have been unapproved. Redirect to the list...
	</div>
<?php
		} else {	// if there is any error	?>
	<meta http-equiv=Refresh content="2; url=./message.php?action=approved" />
	<div class="main">
		<p><h1 class="error">Error!</h1>
		<p>Database error. Please try again or contact the administrator.
	</div>
<?php
		}
	}
	
	/************** unapp->app mode ************/
	if ($action == "reapprove"){
		if (reapprovePost() >= 0){	?>
	<meta http-equiv=Refresh content="2; url=./message.php?action=unapproved" />
	<div class="main">
		<p><h1>Update successfully</h1>
		<p>The posts have been re-approved. Redirect to the list...
	</div>
<?php
		} else {	// if there is any error	?>
	<meta http-equiv=Refresh content="2; url=./message.php?action=unapproved" />
	<div class="main">
		<p><h1 class="error">Error!</h1>
		<p>Database error. Please try again or contact the administrator.
	</div>
<?php
		}
	}
	
	/**************** del mode ***********/
	if ($action == "del"){
		if (delPost()){	?>
	<meta http-equiv=Refresh content="2; url=./message.php?action=unapproved" />
	<div class="main">
		<p><h1>Delete successfully</h1>
		<p>The posts have been deleted. Redirect to the list...
	</div>
<?php
		} else {	// if there is any error	?>
	<meta http-equiv=Refresh content="2; url=./message.php?action=unapproved" />
	<div class="main">
		<p><h1 class="error">Error!</h1>
		<p>Database error. Please try again or contact the administrator.
	</div>
<?php
		}
	} // end del mode
} // end form is submitted
?>