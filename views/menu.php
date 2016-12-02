<?php
	$subMenu = getLeftSubMenu();
	if ($subMenu != ""){	// if there is a sub menu, display it
?>

			<div class="subMenu" id="subMenu">
				<ul class="sub-nav">
<?php
		$currentPage = getCurrentFilename();
		foreach ($subMenu as $subItem){
?>
					<li><a href="./<?php echo $currentPage."?tab=".$subItem["abbr"]; ?>"><?php echo $subItem["name"]; ?></a></li>
<?php
		} // end foreach loop
?>
				</ul>
			</div>

<?php
	} // end of has sub menu
?>