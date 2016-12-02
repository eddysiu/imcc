<script>
	function validateForm() {
		var errorMsg = "";
		var inputs = document.getElementsByTagName('input');
		var textareas = document.getElementsByTagName('textarea');
		
		for(i = 0; i < inputs.length; ++i){
			if (inputs[i].value == ""){
				errorMsg = "- Please fill in all the fields.";
			}
		}
		
		for(i = 0; i < textareas.length; ++i){
			if (textareas[i].value == ""){
				errorMsg = "- Please fill in all the fields";
			}
		}
		
		if (errorMsg != ""){
			errorMsg = "Please check the following:\n\n" + errorMsg;
			alert(errorMsg);
			return false;
		} else {
			return true;
		}
	}
</script>
<?php
if (isset($_POST["submit"])){
	// process data
	$universityname = $_POST["universityname"];
	$title = $_POST["title"];
	$address = $_POST["address"];
	$map = $_POST["map"];
	$email = $_POST["email"];
	$tel = $_POST["tel"];
	$weekday = $_POST["weekday"];
	$weekday_officehour = $_POST["weekday_officehour"];
	$weekend = $_POST["weekend"];
	$brochure = $_POST["brochure"];
	$disclaimer = $_POST["disclaimer"];
	$lang_tw = $_POST["lang_tw"];
	$lang_cn = $_POST["lang_cn"];
	
	$result = updateDB($universityname, $title, $address, $email, $map, $tel, $weekday, $weekday_officehour, $weekend, $brochure, $disclaimer, $lang_tw, $lang_cn);
	
	if ($result){	// if success	?>
	<meta http-equiv=Refresh content="2; url=index.php" />
	<div class="main">
		<p><h1>Update successfully</h1>
		<p>The general setting has been updated. Redirect to the previous page...
	</div>
<?php
	} else {	// if fail	?>
	<meta http-equiv=Refresh content="5; url=index.php">
	<div class="main">
		<p><h1 class="error">Error!</h1>
		<p>Database error. Please try again or contact the administrator.
	</div>
<?php	
	}	// end if update
} else {
?>
	<div class="main">
		<p><h1>General Setting</h1>
		<form action="./index.php" method="post" name="main" onsubmit="return validateForm()">
			<table border="0" cellpadding="3" width="100%">
				<tr>
					<th>Item</th>
					<th>English</th>
					<th>Tranditional Chinese</th>
					<th>Simplified Chinese</th>
				</tr>
				<tr>
					<td>Name of University</td>
					<td><input name="universityname[]" value="<?php echo getConfigValueInOneLang("universityname", "EN") ?>" type="text" size="30"/></td>
					<td><input name="universityname[]" value="<?php echo getConfigValueInOneLang("universityname", "TW") ?>" type="text" size="30"/></td>
					<td><input name="universityname[]" value="<?php echo getConfigValueInOneLang("universityname", "CN") ?>" type="text" size="30"/></td>
				</tr>
				<tr>
					<td>Name of IMCC</td>
					<td><input name="title[]" value="<?php echo getConfigValueInOneLang("title", "EN") ?>" type="text" size="30"/></td>
					<td><input name="title[]" value="<?php echo getConfigValueInOneLang("title", "TW") ?>" type="text" size="30"/></td>
					<td><input name="title[]" value="<?php echo getConfigValueInOneLang("title", "CN") ?>" type="text" size="30"/></td>
				</tr>
				<tr>
					<td>Address</td>
					<td><textarea name="address[]" cols="28" rows="5"><?php echo getConfigValueInOneLang("address", "EN") ?></textarea></td>
					<td><textarea name="address[]" cols="28" rows="5"><?php echo getConfigValueInOneLang("address", "TW") ?></textarea></td>
					<td><textarea name="address[]" cols="28" rows="5"><?php echo getConfigValueInOneLang("address", "CN") ?></textarea></td>
				</tr>
				<tr>
					<td>Map</td>
					<td><textarea name="map[]" cols="28" rows="5"><?php echo getConfigValueInOneLang("googlemap", "EN") ?></textarea></td>
					<td><textarea name="map[]" cols="28" rows="5"><?php echo getConfigValueInOneLang("googlemap", "TW") ?></textarea></td>
					<td><textarea name="map[]" cols="28" rows="5"><?php echo getConfigValueInOneLang("googlemap", "CN") ?></textarea></td>
				</tr>
				<tr>
					<td>Email</td>
					<td><input name="email[]" value="<?php echo getConfigValueInOneLang("email", "EN") ?>" type="text" size="30"/></td>
					<td><input name="email[]" value="<?php echo getConfigValueInOneLang("email", "TW") ?>" type="text" size="30"/></td>
					<td><input name="email[]" value="<?php echo getConfigValueInOneLang("email", "CN") ?>" type="text" size="30"/></td>
				</tr>
				<tr>
					<td>Tel</td>
					<td><input name="tel[]" value="<?php echo getConfigValueInOneLang("tel", "EN") ?>" type="text" size="30"/></td>
					<td><input name="tel[]" value="<?php echo getConfigValueInOneLang("tel", "TW") ?>" type="text" size="30"/></td>
					<td><input name="tel[]" value="<?php echo getConfigValueInOneLang("tel", "CN") ?>" type="text" size="30"/></td>
				</tr>
				<tr>
					<td>Normal Day</td>
					<td><input name="weekday[]" value="<?php echo getConfigValueInOneLang("weekday", "EN") ?>" type="text" size="30"/></td>
					<td><input name="weekday[]" value="<?php echo getConfigValueInOneLang("weekday", "TW") ?>" type="text" size="30"/></td>
					<td><input name="weekday[]" value="<?php echo getConfigValueInOneLang("weekday", "CN") ?>" type="text" size="30"/></td>
				</tr>
				<tr>
					<td>Normal Day Office Hour</td>
					<td><input name="weekday_officehour[]" value="<?php echo getConfigValueInOneLang("weekday_officehour", "EN") ?>" type="text" size="30"/></td>
					<td><input name="weekday_officehour[]" value="<?php echo getConfigValueInOneLang("weekday_officehour", "TW") ?>" type="text" size="30"/></td>
					<td><input name="weekday_officehour[]" value="<?php echo getConfigValueInOneLang("weekday_officehour", "CN") ?>" type="text" size="30"/></td>
				</tr>
				<tr>
					<td>Holiday</td>
					<td><input name="weekend[]" value="<?php echo getConfigValueInOneLang("weekend", "EN") ?>" type="text" size="30"/></td>
					<td><input name="weekend[]" value="<?php echo getConfigValueInOneLang("weekend", "TW") ?>" type="text" size="30"/></td>
					<td><input name="weekend[]" value="<?php echo getConfigValueInOneLang("weekend", "CN") ?>" type="text" size="30"/></td>
				</tr>
				<tr>
					<td>Brochure (PDF)</td>
					<td><textarea name="brochure[]" cols="28" rows="5"><?php echo getConfigValueInOneLang("brochure", "EN") ?></textarea></td>
					<td><textarea name="brochure[]" cols="28" rows="5"><?php echo getConfigValueInOneLang("brochure", "TW") ?></textarea></td>
					<td><textarea name="brochure[]" cols="28" rows="5"><?php echo getConfigValueInOneLang("brochure", "CN") ?></textarea></td>
				</tr>
				<tr>
					<td>Disclaimer</td>
					<td><textarea name="disclaimer[]" cols="28" rows="5"><?php echo getConfigValueInOneLang("disclaimer", "EN") ?></textarea></td>
					<td><textarea name="disclaimer[]" cols="28" rows="5"><?php echo getConfigValueInOneLang("disclaimer", "TW") ?></textarea></td>
					<td><textarea name="disclaimer[]" cols="28" rows="5"><?php echo getConfigValueInOneLang("disclaimer", "CN") ?></textarea></td>
				</tr>
				<tr>
					<td>Tranditional Chinese Version</td>
					<td colspan="3"><input name="lang_tw" value="1" type="radio" size="30" <?php echo getlanguageEnable("langbar", "TW","1") ?>/> Enable <input name="lang_tw" value="0" type="radio" size="30" <?php echo getlanguageEnable("langbar", "TW","0") ?>/> Disable</td>
				</tr>
				<tr>
					<td>Simplified Chinese Version</td>
					<td colspan="3"><input name="lang_cn" value="1" type="radio" size="30" <?php echo getlanguageEnable("langbar", "CN","1") ?>/> Enable <input name="lang_cn" value="0" type="radio" size="30" <?php echo getlanguageEnable("langbar", "CN","0") ?>/> Disable</td>
				</tr>
				<tr>
					<td colspan="4" align="center">
						<input name="submit" value="Update" type="submit" />
					</td>
				</tr>
			</table>
		</form>
	</div>
<?php
}
?>