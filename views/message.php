			<script language="javascript" type="text/javascript">
			$(document).ready(function() {
				$('div.newMsgForm').hide();
				$('div.newMsgBtn').click(function() {
					$(this).next().slideToggle('fast');
				});
				
				$('div.replyForm').hide();
				$('div.replyBtn').click(function() {
					$(this).next().slideToggle('fast');
				});
			});
			</script>
<?php
$title = getContentTitle("");

// set text in different languages
$textEN = array(
	"title" => "Message Board",
	"newMsg" => "Post New Message",
	"replyMsg" => "Reply this Message",
	"back" => "Back to list",
	"note1" => "Note1: * Required fields",
	"note2" => "Note2: Your personal information provided above (e.g. email) will be used for internal follow-up purpose only. Only your name will be displayed with the message.",
	"note3" => "Note3: All posts will be reviewed and approved by IMCC website’s administrator before displaying on the board.",
	"note4" => "Note4: IMCC makes no warranties, express or implied, as to the content of the messages in the message boards or the accuracy and reliability of any messages and other materials in the message boards. Nonetheless, IMCC reserves the right to prevent you from submitting Materials to message boards and to edit, restrict, or remove such messages for any reason at any time. IMCC has no responsibility for the content of the messages, no obligation to modify or remove any inappropriate messages, and no responsibility for the conduct of the user submitting any message. You agree that IMCC accepts no liability whatsoever if it determines to prevent your messages from being submitted or if it edits, restricts or removes your messages. You also agree to permit any other user of this site to access, view, store, or reproduce the material for that other user's personal use and not to restrict or inhibit the use of the site by any other person.",
	"success" => "Your post has been submitted successfully. It will be displayed after approval. Thank you.",
	"fail" => "Please fill in ALL required fields. <a href='javascript:history.go(-1)'>Click to go back.</a>",
	"submit" => "Submit"
);

$textTW = array(
	"title" => "留言版",
	"newMsg" => "留言",
	"replyMsg" => "回覆留言",
	"back" => "返回列表",
	"note1" => "Note1: * Required fields",
	"note2" => "Note2: Your personal information provided above (e.g. email) will be used for internal follow-up purpose only. Only your name will be displayed with the message.",
	"note3" => "Note3: All posts will be reviewed and approved by IMCC website’s administrator before displaying on the board.",
	"note4" => "Note4: IMCC makes no warranties, express or implied, as to the content of the messages in the message boards or the accuracy and reliability of any messages and other materials in the message boards. Nonetheless, IMCC reserves the right to prevent you from submitting Materials to message boards and to edit, restrict, or remove such messages for any reason at any time. IMCC has no responsibility for the content of the messages, no obligation to modify or remove any inappropriate messages, and no responsibility for the conduct of the user submitting any message. You agree that IMCC accepts no liability whatsoever if it determines to prevent your messages from being submitted or if it edits, restricts or removes your messages. You also agree to permit any other user of this site to access, view, store, or reproduce the material for that other user's personal use and not to restrict or inhibit the use of the site by any other person.",
	"success" => "已成功留言。留言將會在審核後刊登。",
	"fail" => "請填妥所有必要項目。<a href='javascript:history.go(-1)'>點此回到上一頁。</a>",
	"submit" => "送出"
);

$textCN = array(
	"title" => "留言版",
	"newMsg" => "留言",
	"replyMsg" => "回覆留言",
	"back" => "返回列表",
	"note1" => "Note1: * Required fields",
	"note2" => "Note2: Your personal information provided above (e.g. email) will be used for internal follow-up purpose only. Only your name will be displayed with the message.",
	"note3" => "Note3: All posts will be reviewed and approved by IMCC website’s administrator before displaying on the board.",
	"note4" => "Note4: IMCC makes no warranties, express or implied, as to the content of the messages in the message boards or the accuracy and reliability of any messages and other materials in the message boards. Nonetheless, IMCC reserves the right to prevent you from submitting Materials to message boards and to edit, restrict, or remove such messages for any reason at any time. IMCC has no responsibility for the content of the messages, no obligation to modify or remove any inappropriate messages, and no responsibility for the conduct of the user submitting any message. You agree that IMCC accepts no liability whatsoever if it determines to prevent your messages from being submitted or if it edits, restricts or removes your messages. You also agree to permit any other user of this site to access, view, store, or reproduce the material for that other user's personal use and not to restrict or inhibit the use of the site by any other person.",
	"success" => "已成功留言。留言将会在审核後刊登。",
	"fail" => "请填妥所有必要项目。<a href='javascript:history.go(-1)'>点此回到上一页。</a>",
	"submit" => "送出"
);

if (isset($_GET["id"])){
	$topicID = $_GET["id"];
}


function displayTopicList($topics){
	if (!empty($topics)){
		echo "					<p>&nbsp;"."\n";
		echo '					<table width="100%" cellpadding="5" border="0">'."\n";
		echo "						<tr>"."\n";
		echo "							<td align=\"center\" width=\"33%\"><b>Title</b></td>"."\n";
		echo "							<td align=\"center\" width=\"20%\"><b>Author</b></td>"."\n";
		echo "							<td align=\"center\" width=\"7%\"><b>Reply</b></td>"."\n";
		echo "							<td align=\"center\" width=\"20%\"><b>Post Date</b></td>"."\n";
		echo "							<td align=\"center\" width=\"20%\"><b>Last Reply</b></td>"."\n";
		echo "						</tr>"."\n";
		foreach ($topics as $topic){
			$id = $topic["id"];
			$name = $topic["name"];
			$email = $topic["email"];
			$title = $topic["title"];
			$msgdate = $topic["msgdate"];
			$lastreply = $topic["lastreply"];
			
			// process information needed to be displayed
			$filename = getCurrentFilename();
			$postURL = "$filename?id=$id";
			$author = getPostAuthor($name, $email);
			$noOfReply = getNoOfReply($id);
			echo "						<tr>"."\n";
			echo "							<td class=\"topicTableTd\"><a href=\"$postURL\">$title</a></td>"."\n";
			echo "							<td class=\"topicTableTd\" align=\"center\">$author</td>"."\n";
			echo "							<td class=\"topicTableTd\" align=\"center\">$noOfReply</td>"."\n";
			echo "							<td class=\"topicTableTd\" align=\"center\">$msgdate</td>"."\n";
			echo "							<td class=\"topicTableTd\" align=\"center\">$lastreply</td>"."\n";
			echo "						</tr>"."\n";
		}
		echo "					</table>"."\n";
	} else {
		echo "					<p align=\"center\">There are no topics yet. Let's share.";
	}
}

function displayNewPostForm(){
	$actionURL = getCurrentFilename()."?post=true";
	echo '					<div class="newMsgBtn">'."\n";
	echo '						'.displayTextInDiffLang("newMsg")."\n";
	echo '					</div>'."\n";
	echo '					<div class="newMsgForm">'."\n";
	echo '						<form name="newpost" action="'.$actionURL.'" method="post">'."\n";
	echo '							<table cellpadding="5" border="0">'."\n";
	echo '								<tr>'."\n";
	echo '									<td width="20%">* Name</td>'."\n";
	echo '									<td width="80%"><input type="text" name="name" size="65"/></td>'."\n";
	echo '								</tr>'."\n";
	echo '								<tr>'."\n";
	echo '									<td width="20%">Email</td>'."\n";
	echo '									<td width="80%"><input type="text" name="email" size="65"/></td>'."\n";
	echo '								</tr>'."\n";
	echo '								<tr>'."\n";
	echo '									<td width="20%">* Title</td>'."\n";
	echo '									<td width="80%"><input type="text" name="title" size="65" maxlength="512" /></td>'."\n";
	echo '								</tr>'."\n";
	echo '								<tr>'."\n";
	echo '									<td width="20%">* Content</td>'."\n";
	echo '									<td width="80%"><textarea name="content" rows="4" cols="60"></textarea></td>'."\n";
	echo '								</tr>'."\n";
	echo '								<tr>'."\n";
	echo '									<td colspan="2" align="center"><input type="submit" name="submit" value="'.displayTextInDiffLang("submit").'"/></td>'."\n";
	echo '								</tr>'."\n";
	echo '								<tr>'."\n";
	echo '									<td colspan="2"><span style="font-size: 10pt; font-style: italic;">'.displayTextInDiffLang("note1")."<br/><br/>"."\n";
	echo '									'.displayTextInDiffLang("note2").' <br/><br/>'."\n";
	echo '									'.displayTextInDiffLang("note3").' <br/><br/>'."\n";
	echo '									'.displayTextInDiffLang("note4").' </span></td>'."\n";
	echo '								</tr>'."\n";
	echo '							</table>'."\n";
	echo '						</form>'."\n";
	echo '					</div>'."\n";
}

function displayReplyForm($topicTitle){
	$actionURL = getCurrentFilename()."?reply=true";
	$replyTitle = "RE: $topicTitle";
	echo '					<div class="replyBtn">'."\n";
	echo '						'.displayTextInDiffLang("replyMsg")."\n";
	echo '					</div>'."\n";
	echo '					<div class="replyForm">'."\n";
	echo '						<form name="replymsfg" action="'.$actionURL.'" method="post">'."\n";
	echo '							<input type="hidden" name="parentid" value="'.$_GET["id"].'" />'."\n";
	echo '							<table cellpadding="5" border="0">'."\n";
	echo '								<tr>'."\n";
	echo '									<td width="20%">* Name</td>'."\n";
	echo '									<td width="80%"><input type="text" name="name" size="65"/></td>'."\n";
	echo '								</tr>'."\n";
	echo '								<tr>'."\n";
	echo '									<td width="20%">Email</td>'."\n";
	echo '									<td width="80%"><input type="text" name="email" size="65"/></td>'."\n";
	echo '								</tr>'."\n";
	echo '								<tr>'."\n";
	echo '									<td width="20%">* Title</td>'."\n";
	echo '									<td width="80%"><input type="text" name="title" size="65" maxlength="512" value="'.$replyTitle.'"/></td>'."\n";
	echo '								</tr>'."\n";
	echo '								<tr>'."\n";
	echo '									<td width="20%">* Content</td>'."\n";
	echo '									<td width="80%"><textarea name="content" rows="4" cols="60"></textarea></td>'."\n";
	echo '								</tr>'."\n";
	echo '								<tr>'."\n";
	echo '									<td colspan="2" align="center"><input type="submit" name="submit" value="'.displayTextInDiffLang("submit").'"/></td>'."\n";
	echo '								</tr>'."\n";
	echo '								<tr>'."\n";
	echo '									<td colspan="2"><span style="font-size: 10pt; font-style: italic;">'.displayTextInDiffLang("note1")."<br/><br/>"."\n";
	echo '									'.displayTextInDiffLang("note2").' <br/><br/>'."\n";
	echo '									'.displayTextInDiffLang("note3").' <br/><br/>'."\n";
	echo '									'.displayTextInDiffLang("note4").' </span></td>'."\n";
	echo '								</tr>'."\n";
	echo '							</table>'."\n";
	echo '						</form>'."\n";
	echo '					</div>'."\n";
}

function displayTopicContent($topicID){
	$topic = getTopicDetails($topicID);
	
	// process the data
	$title = $topic[0]["title"];
	$author = getPostAuthor($topic[0]["name"], $topic[0]["email"]);
	$msgdate = $topic[0]["msgdate"];
	$content = $topic[0]["content"];
	
	// back to list link
	$url = getCurrentFilename();
	echo '					<p style="float: right; padding-right: 10px;"><a href="'.$url.'">&lt;&lt; '.displayTextInDiffLang("back").'</a>'."\n";
	
	// reply form
	displayReplyForm($title);
	
	echo '					<div class="topPost">'."\n";
	echo '						<div class="author">'."\n";
	echo "							<p><b>$author</b>"."\n";
	echo "							<p>($msgdate)"."\n";
	echo '						</div>'."\n";
	echo '						<div class="msgcontent">'."\n";
	echo "							<p><b>$title</b>"."\n";
	echo "							<p>$content"."\n";
	echo '						</div>'."\n";
	echo '					</div>'."\n";
}

function displayTopicReply($topicID){
	$replies = getTopicReply($topicID);
	
	if (!empty($replies)){
		foreach ($replies as $reply){
			// process the data
			$title = $reply["title"];
			$author = getPostAuthor($reply["name"], $reply["email"]);
			$msgdate = $reply["msgdate"];
			$content = $reply["content"];
			
			echo '					<div class="replyPost">'."\n";
			echo '						<div class="replyAuthor">'."\n";
			echo "							<p><b>$author</b>"."\n";
			echo "							<p>($msgdate)"."\n";
			echo '						</div>'."\n";
			echo '						<div class="msgcontent">'."\n";
			echo "							<p><b>$title</b>"."\n";
			echo "							<p>$content"."\n";
			echo '						</div>'."\n";
			echo '					</div>'."\n";
		}
	}
}

if (isset($topicID)){
	/***************************** content mode *****************************/
	if (isValidTopic($topicID)){
		// show post content	?>
			<div class="mainContentLarge">
				<div class="mainContentTitle">
					<?php echo displayTextInDiffLang("title"); ?>
				</div>
				<div class="message">
<?php					displayTopicContent($topicID);
						displayTopicReply($topicID);	?>
				</div> <!-- end of message -->
<?php
	} else {
		// error message	?>
			<div class="mainContentLargeError">
				<div class="mainContentTitleError">
					Error!
				</div> 
				<p>Topic Not Found. Please try again or contact us.
<?php
	}
} else { /******* end content mode *******/
	if (isset($_GET["post"])){
		/***************************** new post mode *****************************/
		$name = htmlspecialchars($_POST["name"]);
		$email =  htmlspecialchars($_POST["email"]);
		$title =  htmlspecialchars($_POST["title"]);
		$content =  htmlspecialchars($_POST["content"]);
		if (isValidNewPost($name, $email, $title, $content)){
			// show post successfully message
			$addNewPost = insertNewPost($name, $email, $title, $content); ?>
			<meta http-equiv="refresh" content="5; URL='<?php echo getCurrentFilename(); ?>'">
			<div class="mainContentLarge">
				<div class="mainContentTitle">
					<?php echo displayTextInDiffLang("title") ?>
				</div> 
				<p><?php echo displayTextInDiffLang("success") ?>
<?php
			} else {
			// error message	?>
			<div class="mainContentLargeError">
				<div class="mainContentTitleError">
					Error!
				</div> 
				<p><?php echo displayTextInDiffLang("fail") ?>
<?php
		} /******** end new post mode ********/
	} else {
		if (isset($_GET["reply"])){
			/***************************** reply mode *****************************/
			$name = htmlspecialchars($_POST["name"]);
			$email =  htmlspecialchars($_POST["email"]);
			$title =  htmlspecialchars($_POST["title"]);
			$content =  htmlspecialchars($_POST["content"]);
			$parentid = $_POST["parentid"];
			if (isValidNewPost($name, $email, $title, $content)){
				// show reply successfully message
				$replyPost = replyPost($name, $email, $title, $content, $parentid); ?>
			<meta http-equiv="refresh" content="5; URL='<?php echo getCurrentFilename(); ?>'">
			<div class="mainContentLarge">
				<div class="mainContentTitle">
					<?php echo displayTextInDiffLang("title") ?>
				</div> 
				<p><?php echo displayTextInDiffLang("success") ?>
<?php
			} else {
				// error message	?>
			<div class="mainContentLargeError">
				<div class="mainContentTitleError">
					Error!
				</div> 
				<p><?php echo displayTextInDiffLang("fail") ?>
<?php
			}
		} else { /******* end reply mode *******/
			/***************************** topic list mode *****************************/	?>
			<div class="mainContentLarge">
				<div class="mainContentTitle">
					<?php echo displayTextInDiffLang("title"); ?>
				</div>
				<div class="message">
<?php			
				$topics = getTopics();
				$filename = getCurrentFilename();
				$actionURL = "./$filename?post=true";
				displayNewPostForm();
				displayTopicList($topics); ?>
				</div> <!-- end of message -->
<?php	} /***** end topic list mode *******/
	}
}
?>


<?php // close div in footer?>