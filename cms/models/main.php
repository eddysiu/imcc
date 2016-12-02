<?php
function db_update($item, $value, $valueColumn){
	$value = addslashes($value);
	$result = 0;
	$query = "UPDATE imcc.config SET $valueColumn = \"$value\" WHERE item = \"$item\"";
	$result = exec_non_query($query);
	return $result;
}

?>