<!DOCTYPE>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo getTitle() ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php

$textEN = array(
	"noticeTitle" => "Important Notice: ",
	"polyLogoURL" => "./img/logo_poly_200px.jpg",
	"imccLogoURL" => "./img/logo_imcc.jpg",
	"noticeLogoURL" => "./img/logo_imcc.jpg",
	"banner1URL" => "./img/top_banner1.jpg",
	"banner2URL" => "./img/top_banner2.jpg"
);

$textTW = array(
	"noticeTitle" => "Important Notice: ",
	"polyLogoURL" => "../img/logo_poly_200px.jpg",
	"imccLogoURL" => "../img/logo_imcc.jpg",
	"noticeLogoURL" => "../img/logo_imcc.jpg",
	"banner1URL" => "../img/top_banner1.jpg",
	"banner2URL" => "../img/top_banner2.jpg"
);

$textCN = array(
	"noticeTitle" => "Important Notice: ",
	"polyLogoURL" => "../img/logo_poly_200px.jpg",
	"imccLogoURL" => "../img/logo_imcc.jpg",
	"noticeLogoURL" => "../img/logo_imcc.jpg",
	"banner1URL" => "../img/top_banner1.jpg",
	"banner2URL" => "../img/top_banner2.jpg"
);

$now = date('Y-m-d H:i:s'); // for notice

if (isEN()){	?>
	<link rel="icon" type="image/ico" href="./img/favicon.ico"/>
	<link rel="stylesheet" type="text/css" href="./css/style.css" />
	<link rel="stylesheet" type="text/css" href="./css/style_colorbox.css" /> <!-- index news-->
	<link rel="stylesheet" type="text/css" href="./css/style_galleriffic.css" /> <!-- gallery-->
	<script type="text/javascript" src="./js/jquery-1.10.2.js"></script>
	<script type="text/javascript" src="./js/jquery.easing.1.3.js"></script>
	<script type="text/javascript" src="./js/jquery.cycle.lite.js"></script>
	<script type="text/javascript" src="./js/jquery.colorbox.js"></script> <!-- index news-->
	<script type="text/javascript" src="./js/jquery.galleriffic.js"></script> <!-- gallery -->
	<script type="text/javascript" src="./js/jquery.opacityrollover.js"></script> <!-- gallery -->
	<script src="./js/more-show.js" type="text/javascript"></script>
<?php
} else { ?>
	<link rel="icon" type="image/ico" href="../img/favicon.ico"/>
	<link rel="stylesheet" type="text/css" href="./css/style.css" />
	<link rel="stylesheet" type="text/css" href="../css/style_colorbox.css" /> <!-- index news-->
	<link rel="stylesheet" type="text/css" href="../css/style_galleriffic.css" /> <!-- gallery-->
	<script type="text/javascript" src="../js/jquery-1.10.2.js"></script>
	<script type="text/javascript" src="../js/jquery.easing.1.3.js"></script>
	<script type="text/javascript" src="../js/jquery.cycle.lite.js"></script>
	<script type="text/javascript" src="../js/jquery.colorbox.js"></script> <!-- index news-->
	<script type="text/javascript" src="../js/jquery.galleriffic.js"></script> <!-- gallery -->
	<script type="text/javascript" src="../js/jquery.opacityrollover.js"></script> <!-- gallery -->
	<script src="../js/more-show.js" type="text/javascript"></script>
<?php
} ?>
	<script type="text/javascript">
		$(document).ready(function () {
			
			$("a[href^='http']").each(function() {
				var value = $(this).attr('href');
				$(this).attr("target","_blank");
			});
			
			// for top menu
			$('.nav li').hover(
				function () {
					//show its submenu
					$('ul', this).stop().slideDown(100);
				},
				function () {
					//hide its submenu
					$('ul', this).stop().slideUp(100);            
				}
			);
			
			// for slider
			$('#index_pics').cycle({
				fx: 'fade',
				speed: 1000,
				timeout: 5000
			}); 

			// for index news
			$(".newsIframe").colorbox({iframe:true, width:"60%", height:"90%"});

<?php	if (hasNotice($now)){	?>
			// for notice 
			if (document.cookie.indexOf('noticeRead=true') == -1) {
				var endtime = 1000*<?php echo getNoticeEndSecond($now); ?>;
				var expires = new Date((new Date()).valueOf() + endtime);
				document.cookie = "noticeRead=true;expires=" + expires.toUTCString();
				$.colorbox({width:"700px", height:"300px", inline:true, href:"#notice"});
			}
<?php	} // end if hasNotice	?>
		});
	</script>
</head>

<?php
function displayMenu(){
	echo '		<div class="menu" id="mainMenu">'."\n";
	echo '			<ul class="nav">'."\n";
	$mainCatList = getMainCatList();
	$mainCssCounter = 1;
	foreach ($mainCatList as $mainCat){
		$mainCssClass = "menu0".$mainCssCounter;
		$subCatList = getSubCatList($mainCat["id"]);
		echo '				<li>'."\n";
		echo '					<a href="./'.$mainCat["abbr"].'.php" class="'.$mainCssClass.'"></a>'."\n";
		if ($subCatList != ""){
			// some hard code for css styling
			switch ($mainCssCounter){
				case 2: $ulStyle = "display: none; height: 168px; padding-top: 0px; margin-top: 0px; padding-bottom: 0px; margin-bottom: 0px;"; break;
				case 3: $ulStyle = "display: none; height: 112px; padding-top: 0px; margin-top: 0px; padding-bottom: 0px; margin-bottom: 0px;"; break;
				case 4: $ulStyle = "display: none; height: 84px; padding-top: 0px; margin-top: 0px; padding-bottom: 0px; margin-bottom: 0px;"; break;
				case 6: $ulStyle = "display: none; height: 28px; padding-top: 0px; margin-top: 0px; padding-bottom: 0px; margin-bottom: 0px;"; break;
				default: $ulStyle = "";
			}
			echo '					<ul style="'.$ulStyle.'">'."\n";
			foreach ($subCatList as $subCat){
				echo '						<li><a href="./'.$mainCat["abbr"].'.php?tab='.$subCat["abbr"].'">'.$subCat["name"].'</a></li>'."\n";
			}
			echo '					</ul>'."\n";
		}
		echo '				</li>'."\n";
		$mainCssCounter++;
	}
	echo '			</ul>'."\n";
	echo '		</div>'."\n";
}

function displayLangBar(){
	// set the lang bar (default: ENG)
	$bar = getLangBar();
	
	if ($bar != ""){
	echo '		<div class="lang_bar">'."\n";
	echo '			'.$bar."\n";
	echo '		</div>'."\n";		
	}
}

function displayNoticeDiv($now){
	if (hasNotice($now)){
		$noticeDetails = getNoticeDetails($now);
		$title = $noticeDetails[0]["title"];
		$content = $noticeDetails[0]["content"];
		echo '	<div style="display: none;">'."\n";
		echo '		<div id="notice">'."\n";
		echo '			<img src="'.displayTextInDiffLang("noticeLogoURL").'" title="IMC - Frank Tsao Maritime Library and Research &amp; Development Centre" />'."\n";
		echo '			<p class="noticeTitle">'.displayTextInDiffLang("noticeTitle").$title."\n";
		echo '			<p class="noticeContent">'.$content."\n";
		echo '		</div>'."\n";
		echo '	</div>'."\n";
	}
}
?>

<body>
<?php	displayNoticeDiv($now)."\n"	?>
	<div class="container">
<?php	displayLangBar(); ?>
		<div class="header">
			<a href="http://www.polyu.edu.hk" target="_blank"><img src="<?php echo displayTextInDiffLang("polyLogoURL"); ?>" title="<?php echo getUniversityName() ?>" class="logo_poly_200px" /></a>
			<a href="http://www.imcc.polyu.edu.hk/" target="_blank"><img src="<?php echo displayTextInDiffLang("imccLogoURL"); ?>" title="<?php echo getTitleForBanner() ?>" class="logo_imcc" /></a>
		</div>
		
		<div class="hr"></div>
		
<?php	displayMenu(); ?>

<?php 	if (showBannerSlide()){	?>
		<div class="index_pics" id="index_pics">
			<img src="<?php echo displayTextInDiffLang("banner1URL"); ?>" title="<?php echo getTitleForBanner() ?>" />
			<img src="<?php echo displayTextInDiffLang("banner2URL"); ?>" title="<?php echo getTitleForBanner() ?>" />
		</div>
<?php	}	?>

		<div class="content" id="content">
