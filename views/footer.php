<?php
$textEN = array(
	"twitterURL" => "./img/footer/icon_twitter.gif",
	"fbURL" => "./img/footer/icon_fb.gif",
	"sinaURL" => "./img/footer/icon_sina.gif",
	"youtubeURL" => "./img/footer/icon_youtube.gif",
	"instagramURL" => "./img/footer/icon_instagram.gif",
	"fbLogo" => "./img/logo_fb.png",
	"fbTitle" => "Faculty of Business",
	"lmsLogo" => "./img/logo_lms.png",
	"lmsTitle" => "Department of Logistics & Maritime Studies",
	"sitemap" => "Site Map",
	"contact" => "Contact Us",
	"privacy" => "Privacy Statement",
	"copyright" => "Copyright",
	"copyrightStmt" => "Copyright &copy; ".date('Y')." IMC-Frank Tsao Maritime Library and Research & Development Centre.<br/>The Hong Kong Polytechnic University. All Rights Reserved."
);

$textTW = array(
	"twitterURL" => "../img/footer/icon_twitter.gif",
	"fbURL" => "../img/footer/icon_fb.gif",
	"sinaURL" => "../img/footer/icon_sina.gif",
	"youtubeURL" => "../img/footer/icon_youtube.gif",
	"instagramURL" => "../img/footer/icon_instagram.gif",
	"fbLogo" => "../img/logo_fb.png",
	"fbTitle" => "工商管理學院",
	"lmsLogo" => "../img/logo_lms.png",
	"lmsTitle" => "物流及航運學系",
	"sitemap" => "網站索引",
	"contact" => "聯絡我們",
	"privacy" => "私隱聲明",
	"copyright" => "版權與知識產權",
	"copyrightStmt" => "版權所有 &copy; ".date('Y')." 萬邦曹文錦海事圖書館暨研究及發展中心。<br/>香港理工大學。保留一切權利。"
);

$textCN = array(
	"twitterURL" => "../img/footer/icon_twitter.gif",
	"fbURL" => "../img/footer/icon_fb.gif",
	"sinaURL" => "../img/footer/icon_sina.gif",
	"youtubeURL" => "../img/footer/icon_youtube.gif",
	"instagramURL" => "../img/footer/icon_instagram.gif",
	"fbLogo" => "../img/logo_fb.png",
	"fbTitle" => "工商管理学系",
	"lmsLogo" => "../img/logo_lms.png",
	"lmsTitle" => "物流及航运学系",
	"sitemap" => "网站索引",
	"contact" => "联络我们",
	"privacy" => "私隐声明",
	"copyright" => "版权与知识产权",
	"copyrightStmt" => "版权所有 &copy; ".date('Y')." 万邦曹文锦海事图书馆暨研究及发展中心。<br/>香港理工大学。保留一切权利。"
);

?>
			</div> <!--mainContent div-->
		
			<p>&nbsp;
		
			<div class="hr">
			</div>
	
			<div class="footer">
				<div class="faculty_logo">
					<a href="http://www.fb.polyu.edu.hk/" target="_blank"><img src="<?php echo displayTextInDiffLang("fbLogo") ?>" title="<?php echo displayTextInDiffLang("fbTitle") ?>"/></a>
					<a href="http://www.lms.polyu.edu.hk/" target="_blank"><img src="<?php echo displayTextInDiffLang("lmsLogo") ?>" title="<?php echo displayTextInDiffLang("lmsTitle") ?>"/></a>
				</div>
				<div class="connect_polyu">
					<a href="http://twitter.com/HongKongPolyU" target="_blank"><img src="<?php echo displayTextInDiffLang("twitterURL") ?>" title="Twitter"></a>
					<a href="http://www.facebook.com/HongKongPolyU" target="_blank"><img src="<?php echo displayTextInDiffLang("fbURL") ?>" title="Facebook"></a>
					<a href="http://e.weibo.com/hongkongpolyu" target="_blank"><img src="<?php echo displayTextInDiffLang("sinaURL") ?>" title="Sina"></a>
					<a href="http://www.youtube.com/HongKongPolyU" target="_blank"><img src="<?php echo displayTextInDiffLang("youtubeURL") ?>" title="YouTube"></a>
					<a href="http://instagram.com/hongkongpolyu#" target="_blank"><img src="<?php echo displayTextInDiffLang("instagramURL") ?>" title="Instagram"></a>
				</div>
				<div class="link">
					<a href="./sitemap.php"><?php echo displayTextInDiffLang("sitemap") ?></a> |
					<a href="./contact.php"><?php echo displayTextInDiffLang("contact") ?></a> |
					<a href="./privacy.php"><?php echo displayTextInDiffLang("privacy") ?></a> |
					<a href="./copyright.php"><?php echo displayTextInDiffLang("copyright") ?></a>
				</div> <!-- link div -->
				<p><?php echo displayTextInDiffLang("copyrightStmt") ?>
			</div> <!-- footer -->
		</div> <!-- content -->
	</div> <!-- container -->
</body>
</html>
