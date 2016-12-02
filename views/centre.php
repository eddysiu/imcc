<?php
// get the current tab
$tab = "";

if (isset($_GET["tab"])){
	$tab = $_GET["tab"];
} else {
	$tab = getDefaultTab();
}

// set text
$textEN = array(
	"researchTitle" => "List of research outputs",
	"paperTitle" => "Policy Papers"
);
$textTW = array(
	"researchTitle" => "研究結果",
	"paperTitle" => "政策論文"
);
$textCN = array(
	"researchTitle" => "研究结果",
	"paperTitle" => "政策论文"
);

// display lists in publication mode
function displayPulications($researchList, $paperList){
	if ($researchList != ""){
		echo "				<p><b>".displayTextInDiffLang("researchTitle")."</b>"."\n";
		echo "				<ol>"."\n";
		foreach ($researchList as $item){
			echo "					<li>".$item["item"]."<br/><br/></li>"."\n";
		}
		echo "				</ol>"."\n";
	}
	
	if ($paperList != ""){
		echo "				<p><b>".displayTextInDiffLang("paperTitle")."</b>"."\n";
		echo "				<ol>"."\n";
		foreach ($paperList as $item){
			echo "					<li>".$item["item"]."<br/><br/></li>"."\n";
		}
		echo "				</ol>"."\n";
	}
}

if (isValidTab($tab)){
	if ($tab != "public"){	// if not in publication mode
		// get the title and content of the page
		$title = getContentTitle($tab);
		$content = getContent($tab);
		$content = correctImgURLInText($content);
?>
			<div class="mainContent">
				<div class="mainContentTitle">
					<?php echo $title."\n"; ?>
				</div> 
				<?php echo $content."\n"; ?>

<?php
	} else {
		/********* publication mode **********/
		$title = getContentTitle($tab);
		$researchList = getResearchList();
		$paperList = getPaperList();
?>
			<div class="mainContent">
				<div class="mainContentTitle">
					<?php echo $title."\n"; ?>
				</div> 
				<?php displayPulications($researchList, $paperList); ?>
<?php
	}	// end publication mode
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