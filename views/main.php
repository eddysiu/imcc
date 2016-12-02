<?php

// display year title
function displayYearTitle($year){
	echo '						<tr>'."\n";
	echo "							<td colspan=\"2\"><br/><u><b>$year</b></u></td>"."\n";
	echo '						</tr>'."\n";
}

$textEN = array(
	"quicklink" => "Quick Links");
$textTW = array(
	"quicklink" => "連結推介");
$textCN = array(
	"quicklink" => "连结推介");

// for displayNewsDate e.g. 01 --> Jan
function numericToEng($month){
	$text = "";
	if (isEN()){
		switch ($month){
			case "01": $text = "Jan"; break;
			case "02": $text = "Feb"; break;
			case "03": $text = "Mar"; break;
			case "04": $text = "Apr"; break;
			case "05": $text = "May"; break;
			case "06": $text = "Jun"; break;
			case "07": $text = "Jul"; break;
			case "08": $text = "Aug"; break;
			case "09": $text = "Sep"; break;
			case "10": $text = "Oct"; break;
			case "11": $text = "Nov"; break;
			case "12": $text = "Dec"; break;
		}
	} else {
		switch ($month){
			case "01": $text = "一月"; break;
			case "02": $text = "二月"; break;
			case "03": $text = "三月"; break;
			case "04": $text = "四月"; break;
			case "05": $text = "五月"; break;
			case "06": $text = "六月"; break;
			case "07": $text = "七月"; break;
			case "08": $text = "八月"; break;
			case "09": $text = "九月"; break;
			case "10": $text = "十月"; break;
			case "11": $text = "十一月"; break;
			case "12": $text = "十二月"; break;
		}
	}
	return $text;
}

// for display news date e.g. Jan 01-Feb 01
function displayNewsDate($sqlStartDate, $sqlEndDate){
	$displayDate = "";
	
	// process start date
	$startDate = explode("-", $sqlStartDate);	// 0: year, 1: month, 2: day
	$startYear = $startDate[0];
	$startMonth = $startDate[1];
	$startDay = $startDate[2];
	
	$endDate = explode("-", $sqlEndDate);	// 0: year, 1: month, 2: day
	$endYear = $endDate[0];
	$endMonth = $endDate[1];
	$endDay = $endDate[2];
	
	$displayDate = numericToEng($startMonth);	// format: e.g. Jan
	$displayDate .= " ".$startDay;					// format: e.g. Jan 01
	
	// case1: same year, same month, different day
	if (($startYear == $endYear) && ($startMonth == $endMonth) && ($startDay != $endDay)){
		$displayDate .= "-".$endDay;			// format: e.g. Jan 01-02
	}
	
	// case2: same year, different month, different day
	if (($startYear == $endYear) && ($startMonth != $endMonth)){
		$displayDate .= "-".numericToEng($endMonth);	// format: e.g. Jan 01-Feb
		$displayDate .= " ".$endDay;			// format: e.g. Jan 01-Feb 01
	}
	
	return $displayDate;
}

// display news
function displayNews($listOfNews){
	$currentYear = "";
	echo '					<table border="0" cellpadding="2" width="100%">'."\n";
	foreach ($listOfNews as $news){
		// process data
		$startDate = $news["start"];
		$endDate = $news["end"];
		$title = $news["title"];
		$source = $news["source"];
		$isExpand = $news["isExpand"];
		if ($isExpand){
			$id = $news["id"];
			$url = "./index_news.php";
			$content = "$url?id=$id";
		} else {
			$content = $news["content"];
		}
		
		// check display year title or not
		$startYear = substr($startDate, 0, 4);	// extract year
		if ($currentYear != $startYear){
			displayYearTitle($startYear);
			$currentYear = $startYear;	// update new current year
		}
		
		// display td
		echo "						<tr>"."\n";
		echo '							<td style="white-space: nowrap" valign="top" width="10%">'.displayNewsDate($startDate, $endDate)."</td>"."\n";
		echo '							<td valign="top" width="90%">'."\n";
		if ($isExpand){
			echo "								<a class=\"newsIframe\" href=\"$content\">$title</a>";
		} else {
			echo "								<a target=\"_blank\" href=\"$content\">$title</a>";
		}
		if ($source != ""){
			echo " <i>-$source</i>"."\n";
		} else {
			echo "\n";
		}
		echo '							</td>'."\n";
		echo "						</tr>"."\n";
	}
	echo '					</table>'."\n";
}

// display news content (if isExpand)
function displayNewsContent($id){
	echo '			<script type="text/javascript">'."\n";
	echo '				document.getElementById("index_pics").style.display = "none";'."\n";
	echo '				document.getElementById("content").setAttribute("style", "margin-top: 0px");'."\n";
	echo '			</script>'."\n";
	$content = getNewsContent($id);
	echo $content."\n";
}

// display quick links
function displayQuickLink(){
	$links = getQuickLinks();
	foreach ($links as $link){
		$url = $link["url"];
		$img = correctImgURL($link["img"]);
		echo "					<p><a target=\"_blank\" href=\"$url\"><img src=\"$img\"></a>"."\n";
	}
}

$title = getIndexNewsTitle();
$listOfNews = getNews();
?>
			<div class="mainContentNews">
				<div class="mainContentTitle">
					<?php echo $title."\n"; ?>
				</div>
				<div class="newsIndex">
<?php
if (isset($id)){
	displayNewsContent($id);
} else {
	if ($listOfNews != ""){	// if there is news
		displayNews($listOfNews);
	} else {
		echo "					<p>Not Found. Please try again or contact us."."\n";
	}
}
?>
				</div>
			</div>
			<div class="mainQuickLink">
				<div class="mainContentTitle">
					<?php echo displayTextInDiffLang("quicklink")."\n"; ?>
				</div>
				<div>
					<?php displayQuickLink(); ?>
				</div>
<?php

// mainQuickLink Div close tag in footer.php
?>