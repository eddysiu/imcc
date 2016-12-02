			<script language="javascript" type="text/javascript">
			$(document).ready(function() {
				$('div.newsletterIssue').hide();
				$('div.newsletterVol').click(function() {
					$(this).next().slideToggle('fast');
				});
			});
			</script>
<?php
// get the current tab
$tab = "";

if (isset($_GET["tab"])){
	$tab = $_GET["tab"];
} else {
	$tab = getDefaultTab();
}

// display the HTML
function displayNewsletter($tab){
	// get the content of the page
	$volumes = getNewsletterVol($tab);
	foreach ($volumes as $vol){
		echo '					<div class="newsletterVol"><p>'.$vol["name"].'</div>'."\n";
		echo '					<div class="newsletterIssue">'."\n";
		echo '						<p>'."\n";
		$id = $vol["id"];
		$issues = getNewsletterIssue($id);
		$brCount = 0;	// for break lines
		foreach ($issues as $issue){
			$issueName = $issue["name"];
			$issueURL = $issue["url"];
			$issueURL = correctPdfURL($issueURL);
			echo "							<a href=\"$issueURL\" target=\"_blank\">$issueName</a>"."\n";
			$brCount++;
			if ($brCount%8 == 0){
				echo "							<br/>"."\n";
			}
		} // end foreach issue
		echo '					</div>'."\n";
	} // end foreach volume
}


if (isValidTab($tab)){
	// get the title of the page
	$title = getContentTitle($tab);
?>
			<div class="mainContent">
				<div class="mainContentTitle">
					<?php echo $title."\n"; ?>
				</div>
				<div class="newsletter">
<?php 	displayNewsletter($tab); ?>
				</div> <!--newsletter-->
<?php

} else {	// show errors if it is an invalid tab
?>
			<div class="mainContentError">
				<div class="mainContentTitleError">
					404 Error!
				</div> 
				<p>Page Not Found. Please try again or contact us.
<?php
}
// mainContent Div close tag in footer.php
?>