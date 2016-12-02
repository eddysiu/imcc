			<script language="javascript" type="text/javascript">
			$(document).ready(function() {
				// $('div.disclaimer').hide();
				$('div.disclaimerTitle').click(function() {
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

function displayLinks($tab){
	$id = getSubCatIDByURL($tab);
	$localLinks = getLocalLinks($id);
	$nonLocalLinks = getNonLocalLinks($id);
	
	// only display Local (Title) and Non-Local (Title) if both contain links
	if (($localLinks == "") || ($nonLocalLinks == "")){
		$displayRegionTitle = false;
	} else {
		$displayRegionTitle = true;
	}
	
	// display local links
	if ($localLinks != ""){
		if ($displayRegionTitle){
			echo "				<p><u><b>Local</b></u>"."\n";
		}
		foreach ($localLinks as $link){
			$name = $link["name"];
			$url = $link["url"];
			echo "				<p>$name<br/>"."\n";
			echo "					<a href=\"$url\" target=\"_blank\">$url</a>"."\n";
		}
	}
	
	// display non-local links
	if ($nonLocalLinks != ""){
		if ($displayRegionTitle){
			echo "				<p>&nbsp;"."\n";
			echo "				<p><u><b>Non-local</b></u>"."\n";
		}
		foreach ($nonLocalLinks as $link){
			$name = $link["name"];
			$url = $link["url"];
			echo "				<p>$name<br/>"."\n";
			echo "					<a href=\"$url\" target=\"_blank\">$url</a>"."\n";
		}
	}
}

if (isValidTab($tab)){
	// get the title of the page
	$title = getContentTitle($tab);
?>
			<div class="mainContent">
				<div class="mainContentTitle">
					<?php echo $title."\n"; ?>
				</div>
				<div class="disclaimerTitle"><p>Disclaimer</div>
				<div class="disclaimer">
<?php	echo "					".getDisclaimer()."\n"; ?>
				</div>
				<p>&nbsp;</p>
<?php 	displayLinks($tab);
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