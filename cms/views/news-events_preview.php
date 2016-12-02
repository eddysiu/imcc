<!DOCTYPE>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo getTitle() ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="icon" type="image/ico" href="../img/favicon.ico"/>
	<link rel="stylesheet" type="text/css" href="../css/style_news.css" />
</head>

<body>
<?php
// get the current tab

if (isset($_GET["id"])){
	$id = $_GET["id"];
}

if (isset($id)){
	// display news content
	if (isExpandableNews($id)){
		$content = correctImgURLInText(getNewsContent($id));
		
		echo $content."\n";
	} else {
		echo "<p>Error! Please try again or contact us."."\n";
	}
} else {
	echo "<p>News not found. Please try again or contact us."."\n";
}
?>
</body>
</html>