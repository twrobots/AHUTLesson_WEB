<?php
//$datetime = date('Y-m-d H:i:s') ;
function datetimeToTime($datetime) {
	$timestamp = strtotime($datetime);
	return date('H:i', $timestamp);
}

?>