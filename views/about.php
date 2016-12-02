			<script language="javascript" type="text/javascript">
			$(document).ready(function() {
				$('div.albumList').hide();
				$('div.galleryList').click(function() {
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

$textEN = array(
	"back" => "Back to list",
	"albumFolderPath" => "./img/album/"
);

$textTW = array(
	"back" => "返回列表",
	"albumFolderPath" => "../img/album/"
);

$textCN = array(
	"back" => "返回列表",
	"albumFolderPath" => "../img/album/"
);


function displayAlbum($tab, $galleryList){
	if (isset($_GET["album"])){
		$album = $_GET["album"];
	}
	
	$title = getContentTitle($tab);
	
	if (!isset($album)){
		/********* display album list ***********/
		echo '			<div class="mainContent">'."\n";
		echo '				<div class="mainContentTitle">'."\n";
		echo "					$title"."\n";
		echo '				</div>'."\n";
		
		if ($galleryList != ""){
			foreach ($galleryList as $gallery){
				$galleryAbbr = $gallery["abbr"];
				$galleryName = $gallery["name"];
				echo '				<div class="galleryList"><p>'.$galleryName.'</div>'."\n";
				echo '				<div class="albumList">'."\n";
				$albumList = getAlbumList($galleryAbbr);
				if ($albumList != ""){
					foreach ($albumList as $album){
						$albumDate = $album["date"];
						$albumTitle = $album["title"];
						$albumOrganizer = $album["organizer"];
						$filename = getCurrentFilename();
						$url = "$filename?tab=$tab&album=$albumDate";
						echo "					<p><a href=\"$url\">$albumTitle</a>"."\n";
						if ($albumOrganizer != ""){
							echo "						<br/>&nbsp;&nbsp;&nbsp;<i>Organized by $albumOrganizer</i>"."\n";
						}
					} // end album forearch loop
				}
				echo '				</div>'."\n";
			} // end gallery forearch loop
		}
	} else {
		if (isValidAlbum($album)){
			/********* display album photo **********/	?>
			<script type="text/javascript">
				document.getElementById("subMenu").style.display = "none";
				document.getElementById("index_pics").style.display = "none";
				document.getElementById("content").setAttribute("style", "margin-top: 0px");
				
				jQuery(document).ready(function($) {
					// Initially set opacity on thumbs and add
					// additional styling for hover effect on thumbs
					var onMouseOutOpacity = 0.67;
					$('#thumbs ul.thumbs li').opacityrollover({
						mouseOutOpacity:   onMouseOutOpacity,
						mouseOverOpacity:  1.0,
						fadeSpeed:         'fast',
						exemptionSelector: '.selected'
					});
					
					// Initialize Advanced Galleriffic Gallery
					var gallery = $('#thumbs').galleriffic({
						delay:                     2500,
						numThumbs:                 15,
						preloadAhead:              10,
						enableTopPager:            true,
						enableBottomPager:         true,
						maxPagesToShow:            7,
						imageContainerSel:         '#slideshow',
						controlsContainerSel:      '#controls',
						captionContainerSel:       '#caption',
						loadingContainerSel:       '#loading',
						renderSSControls:          true,
						renderNavControls:         true,
						playLinkText:              'Play Slideshow',
						pauseLinkText:             'Pause Slideshow',
						prevLinkText:              '&lt; Previous',
						nextLinkText:              'Next &gt;',
						nextPageLinkText:          'Next &gt;',
						prevPageLinkText:          '&lt; Prev',
						enableHistory:             true,
						autoStart:                 false,
						syncTransitions:           true,
						defaultTransitionDuration: 900,
						onSlideChange:             function(prevIndex, nextIndex) {
							// 'this' refers to the gallery, which is an extension of $('#thumbs')
							this.find('ul.thumbs').children()
								.eq(prevIndex).fadeTo('fast', onMouseOutOpacity).end()
								.eq(nextIndex).fadeTo('fast', 1.0);
						},
						onPageTransitionOut:       function(callback) {
							this.fadeTo('fast', 0.0, callback);
						},
						onPageTransitionIn:        function() {
							this.fadeTo('fast', 1.0);
						}
					});
					
					
				});
			</script>
			
			<div class="mainContentLarge">
				<div class="mainContentTitle">
					<?php echo $title."\n" ?>
				</div>
				<p><a href="<?php echo getCurrentFilename()."?tab=$tab" ?>">&lt;&lt; <?php echo displayTextInDiffLang("back") ?></a>
<?php
			$albumDetails = getAlbumDetails($album);
			$albumCategory = getAlbumCategory($albumDetails[0]["parent"]);
			$albumTitle = $albumDetails[0]["title"];
			$albumOrganizer = $albumDetails[0]["organizer"];
			
			echo "				<p><b>$albumCategory: $album $albumTitle</b>"."\n";
			if ($albumOrganizer != ""){
				echo "				<br/>&nbsp;&nbsp;&nbsp;<i>Organized by $albumOrganizer</i>"."\n";
			}
?>
				<div id="gallery" class="albumContent">
					<div id="controls" class="controls"></div>
					<div class="slideshow-container">
						<div id="loading" class="loader"></div>
						<div id="slideshow" class="slideshow"></div>
					</div>
					<div id="caption" class="caption-container"></div>
				</div>
				<div id="thumbs" class="navigation">
					<ul class="thumbs noscript">
<?php
			$photoList = getPhoto($album);
 			foreach ($photoList as $photo){
				$smallSizeURL = $photo;
				$enlargeSizeURL = str_replace("/$album/", "/$album/enlarge/", $photo);
				$downloadSizeURL = str_replace("/$album/", "/$album/download/", $photo); 
?>
						<li>
							<a class="thumb" href="<?php echo $enlargeSizeURL ?>">
								<img src="<?php echo $smallSizeURL ?>" />
							</a>
							<div class="caption">
								<div class="download">
									<a href="<?php echo $downloadSizeURL ?>">Download Original</a>
								</div>
							</div>
						</li>
<?php
			} // end foreach loop	?>
					</ul>
				</div>
<?php
		} else {
			/********* error page *********/	?>
			<div class="mainContentError">
				<div class="mainContentTitleError">
					<?php echo $title."\n" ?>
				</div>
				<p>Page Not Found. Please try again or contact us.
<?php
		} // end album photo
	}
}



if (isValidTab($tab)){
	if ($tab != "gallery"){	// if not in gallery mode
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
		if ($tab == "intro"){
			$brochure = getBrochure();
			echo "				<p>$brochure"."\n";
		}
	} else {
		/********* gallery mode ***********/
		$galleryList = getGalleryList($tab);
		displayAlbum($tab, $galleryList);
	}
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