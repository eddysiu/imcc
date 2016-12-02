<?php
$title = getContentTitle("");

// set text in different languages
$textEN = array(
	"address" => "Address",
	"enquiries" => "General Enquiries",
	"tel" => "Tel",
	"email" => "Email",
	"officeHour" => "Office Hours",
	"brochure" => "Brochure"
);

$textTW = array(
	"address" => "地址",
	"enquiries" => "查詢",
	"tel" => "電話",
	"email" => "電郵",
	"officeHour" => "辦公時間",
	"brochure" => "小冊子"
);

$textCN = array(
	"address" => "地址",
	"enquiries" => "查询",
	"tel" => "电话",
	"email" => "电邮",
	"officeHour" => "办公时间",
	"brochure" => "小册子"
);

?>
			<div class="mainContentLarge">
				<div class="mainContentTitle">
					<?php echo $title; ?>
				</div>
				
				<div class="map">
					<?php echo getMap() ?>
				</div>
				
				<p><u><b><?php echo displayTextInDiffLang("address"); ?></b></u>
				<p><?php echo getAddress() ?>

				<p><u><b><?php echo displayTextInDiffLang("enquiries"); ?></b></u>
				<table>
					<tbody>
						<tr>
							<td><?php echo displayTextInDiffLang("tel"); ?></td>
							<td><?php echo getTel() ?></td>
						</tr>
						<tr>
							<td><?php echo displayTextInDiffLang("email"); ?>&nbsp;&nbsp;&nbsp;</td>
							<td><a href="mailto:<?php echo getEmail() ?>"><?php echo getEmail() ?></a></td>
						</tr>
					</tbody>
				</table> 
				<p><u><b><?php echo displayTextInDiffLang("officeHour"); ?></b></u>
				<table>
					<tbody>
						<tr>
							<td><?php echo getWeekday() ?></td>
							<td><?php echo getWeekdayHour() ?></td>
						</tr>
						<tr>
							<td><?php echo getWeekend() ?></td>
							<td><?php echo getWeekendHour() ?></td>
						</tr>
					</tbody>
				</table>
				<p><u><b><?php echo displayTextInDiffLang("brochure"); ?></b></u>
				<p><?php echo getBrochure() ?>

<?php // close div in footer?>
