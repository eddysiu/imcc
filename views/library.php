<?php
// get the current tab
$tab = "";

if (isset($_GET["tab"])){
	$tab = $_GET["tab"];
} else {
	$tab = getDefaultTab();
}

$textEN = array(
	"intro" => "Items held by Maritime Library can be searched through this online catalogue. The subjects include maritime and commerce law, shipping and logistics management, supply chain management, economics, naval architecture and maritime history, etc.",
	"callNo" => "Call No.",
	"title" => "Title",
	"author" => "Author",
	"isbn" => "ISBN/ISSN",
	"subject" => "Subject",
	"search" => "Search",
	"publisher" => "Publisher",
	"year" => "Year",
	"edition" => "Edition",
	"noOfCopy" => "No of Copy",
	"re-search" => "Click to search again.",
	"record" => " record(s) found.",
	"tooManyRecords" => "More than 200 records found. Please enter more keywords.",
	"noRecord" => "No record found.");

$textTW = array(
	"intro" => "請輸入關鍵字。",
	"callNo" => "書號",
	"title" => "書名",
	"author" => "作者",
	"isbn" => "ISBN/ISSN",
	"subject" => "分類",
	"search" => "搜尋",
	"publisher" => "出版社",
	"year" => "年份",
	"edition" => "版本",
	"noOfCopy" => "副本數量",
	"re-search" => "按此再次搜尋。",
	"record" => "則搜尋結果。",
	"tooManyRecords" => "搜尋結果多於200則，請輸入更多關鍵字縮窄搜尋範圍。",
	"noRecord" => "查無記錄。");
	
$textCN = array(
	"intro" => "请输入关键字。",
	"callNo" => "书号",
	"title" => "书名",
	"author" => "作者",
	"isbn" => "ISBN/ISSN",
	"subject" => "分类",
	"search" => "搜寻",
	"publisher" => "出版社",
	"year" => "年份",
	"edition" => "版本",
	"noOfCopy" => "副本数量",
	"re-search" => "按此再次搜寻。",
	"record" => "则搜寻结果。",
	"tooManyRecords" => "搜寻结果多於200则，请输入更多关键字缩窄搜寻范围。",
	"noRecord" => "查无记录。");

function displaySearchResult(){
	$title = $_POST["title"];
	$author = $_POST["author"];
	$isbn = $_POST["isbn"];
	$subject = $_POST["subject"];
	$results = getSearchResult($title, $author, $isbn, $subject);
	if (!empty($results)){
		$noOfResults = count($results);
	} else {
		$noOfResults = 0;
	}
	
	if ($noOfResults == 0){
		echo "					<p>".displayTextInDiffLang("noRecord")."\n";
		echo "						<a href=\"javascript:history.go(-1)\">".displayTextInDiffLang("re-search")."</a>"."\n";
	}
	
	if ($noOfResults > 200){
		echo "					<p>".displayTextInDiffLang("tooManyRecords")."\n";
		echo "						<a href=\"javascript:history.go(-1)\">".displayTextInDiffLang("re-search")."</a>"."\n";
	}
	
	if (($noOfResults > 0) && ($noOfResults <= 200)) {
		echo "					<p>$noOfResults".displayTextInDiffLang("record")."\n";	// e.g. 1 record(s) found.
		echo "						<a href=\"javascript:history.go(-1)\">".displayTextInDiffLang("re-search")."</a>"."\n";
		echo "					<p>&nbsp;"."\n";
		echo '					<table width="100%" cellpadding="5" border="0">'."\n";
		echo "						<tr>"."\n";
		echo "							<td align=\"center\" width=\"10%\"><b>".displayTextInDiffLang("subject")."</b></td>"."\n";
		echo "							<td align=\"center\" width=\"5%\"><b>".displayTextInDiffLang("callNo")."</b></td>"."\n";
		echo "							<td align=\"center\" width=\"20%\"><b>".displayTextInDiffLang("title")."</b></td>"."\n";
		echo "							<td align=\"center\" width=\"15%\"><b>".displayTextInDiffLang("author")."</b></td>"."\n";
		echo "							<td align=\"center\" width=\"15%\"><b>".displayTextInDiffLang("publisher")."</b></td>"."\n";
		echo "							<td align=\"center\" width=\"5%\"><b>".displayTextInDiffLang("year")."</b></td>"."\n";
		echo "							<td align=\"center\" width=\"5%\"><b>".displayTextInDiffLang("edition")."</b></td>"."\n";
		echo "							<td align=\"center\" width=\"10%\"><b>ISBN</b></td>"."\n";
		echo "							<td align=\"center\" width=\"10%\"><b>ISSN</b></td>"."\n";
		echo "							<td align=\"center\" width=\"5%\"><b>".displayTextInDiffLang("noOfCopy")."</b></td>"."\n";
		echo "						</tr>"."\n";
		foreach ($results as $result){
			$callNo = $result["callNo"];
			$title = $result["title"];
			$author = $result["author"];
			$publisher = $result["publisher"];
			$year = $result["year"];
			$edition = $result["edition"];
			$ISBN = $result["ISBN"];
			$ISSN = $result["ISSN"];
			$noOfCopy = $result["noOfCopy"];
			$genreID = $result["genreID"];	// not subject code
			$subject = getBookSubject($genreID);
			echo "						<tr>"."\n";
			echo "							<td class=\"searchTableTd\">$subject</td>"."\n";
			echo "							<td class=\"searchTableTd\">$callNo</td>"."\n";
			echo "							<td class=\"searchTableTd\">$title</td>"."\n";
			echo "							<td class=\"searchTableTd\">$author</td>"."\n";
			echo "							<td class=\"searchTableTd\">$publisher</td>"."\n";
			echo "							<td class=\"searchTableTd\">$year</td>"."\n";
			echo "							<td class=\"searchTableTd\">$edition</td>"."\n";
			echo "							<td class=\"searchTableTd\">$ISBN</td>"."\n";
			echo "							<td class=\"searchTableTd\">$ISSN</td>"."\n";
			echo "							<td class=\"searchTableTd\">$noOfCopy</td>"."\n";
			echo "						</tr>"."\n";
		}
		echo "					</table>"."\n";
	} // end if there is/are record(s)
} // end of function
	
if (isValidTab($tab)){
	if ($tab != "search"){	// if not in search mode
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
		/************* search mode ************/
		$title = getContentTitle($tab);
		$filename = getCurrentFilename();
		$actionURL = "./$filename?tab=$tab&submit=true";
		if (!isset($_GET['submit'])){
			/****** search form *******/
		?>
			<div class="mainContent">
				<div class="mainContentTitle">
					<?php echo $title."\n"; ?>
				</div> 
				<?php echo "<p>".displayTextInDiffLang("intro")."\n"; ?>
				<p>&nbsp;
				<form name="catalogue" action="./<?php echo $actionURL;?>" method="post">
					<table width="60%" align="center" cellpadding="5" border="0">
						<tr>
							<td width="40%"><?php echo displayTextInDiffLang("title")?></td>
							<td width="60%"><input type="text" name="title" size="50" placeholder="separate different keywords with a comma" /></td>
						</tr>
						<tr>
							<td width="40%"><?php echo displayTextInDiffLang("author")?></td>
							<td width="60%"><input type="text" name="author" size="50"/></td>
						</tr>
						<tr>
							<td width="40%">ISBN/ISSN</td>
							<td width="60%"><input type="text" name="isbn" size="50" maxlength="15" /></td>
						</tr>
						<tr>
							<td width="40%"><?php echo displayTextInDiffLang("subject")?></td>
							<td width="60%">
								<select name="subject">
<?php
									$subjects = getAllSubjects();
									echo "									<option value=\"all\">All</option>"."\n";
									if ($subjects != ""){
										foreach ($subjects as $subject){
											$name = $subject["name"];
											$value = $subject["id"];
											echo "									<option value=\"$value\">$name</option>"."\n";
										} // end foreach
									} // end if	?>
								</select>
							</td>
						</tr>
						<tr>
							<td colspan="2" align="center"><input type="submit" name="submit" value="<?php echo displayTextInDiffLang("search")?>"/></td>
						</tr>
					</table>
				</form>
<?php
		} else {
		/****** search result ******/
			if (!hasError()){
				/**** display search result ******/	?>
			<script>
				document.getElementById("subMenu").style.display = "none";
			</script>
			<div class="mainContentLarge">
				<div class="mainContentTitle">
					<?php echo $title."\n"; ?>
				</div>
				<div class="catalogueSearch">
<?php			displaySearchResult();	?>
				</div>
<?php		} else {
				/****** error *****/	?>
			<div class="mainContentError">
				<div class="mainContentTitleError">
					Error!
				</div> 
				<p>Please input keyword(s) in any field.
<?php
			} // end search error part
		} // end displaying search result
	} // end search mode
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