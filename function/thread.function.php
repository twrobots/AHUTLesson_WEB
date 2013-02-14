<?php
function getThreads($lid, $page) {
	$start = ($page - 1) * THREADS_PER_PAGE;
	return DB::getData("SELECT * FROM ".DB_PREFIX."thread WHERE lid = '$lid' ORDER BY lastreply_time DESC LIMIT $start,".THREADS_PER_PAGE);
}

function getTotalThreadsNum($lid) {
	return DB::getFirstGrid("SELECT COUNT(*) FROM ".DB_PREFIX."thread WHERE lid = '$lid'");
}

function getThreadInfo($tid) {
	return DB::getFirstRow("SELECT * FROM ".DB_PREFIX."thread WHERE tid = '$tid'");
}

function deleteThreadByTid($tid) {
	DB::query("DELETE FROM ".DB_PREFIX."thread WHERE tid = '$tid'");
	DB::query("DELETE FROM ".DB_PREFIX."post WHERE tid = '$tid'");
	echo '0';
}

?>