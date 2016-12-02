<?php
// set text in different languages
$textEN = array(
	"title" => "Site Map",
	"msgboard" => "Message Board"
);

$textTW = array(
	"title" => "網站索引",
	"msgboard" => "留言板"
);

$textCN = array(
	"title" => "网站索引",
	"msgboard" => "留言板"
);

?>
			<div class="mainContentLarge">
				<div class="mainContentTitle">
					<?php echo displayTextInDiffLang("title") ?>
				</div>
				<ul>
<?php
$mainCatList = getMainCatList();
foreach ($mainCatList as $mainCat){
	echo "					<li>"."\n";
	echo '						<a href="./'.$mainCat["abbr"].'.php" target="_blank">'.$mainCat["name"].'</a>'."\n";
	$subCatList = getSubCatList($mainCat["id"]);
	if ($subCatList != ""){
		echo '					<ul>'."\n";
		foreach ($subCatList as $subCat){
			echo '						<li><a href="./'.$mainCat["abbr"].'.php?tab='.$subCat["abbr"].'" target="_blank">'.$subCat["name"].'</a></li>'."\n";
		} // end sub cat foreach
		echo '					</ul>'."\n";
	} // end if
	echo "					</li>"."\n";
} // end main cat foreach
?>
					<li><a href="./message.php" target="_blank"><?php echo displayTextInDiffLang("msgboard")?></a></li>
				</ul>

<?php // close div in footer?>
