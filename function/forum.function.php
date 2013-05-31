<?php
function getAllThreads($page) {
	$start = ($page - 1) * THREADS_PER_PAGE;
	return DB::getData("SELECT a.*,b.* FROM ahut_thread a,ahut_lesson b WHERE a.lid = b.lid ORDER BY lastreply_time DESC LIMIT $start,".THREADS_PER_PAGE);
}

function getTotalAllThreadsNum() {
	return DB::getFirstGrid("SELECT COUNT(*) FROM ahut_thread");
}

function getLidListHasNew($uxh) {
	$rows = DB::getData("SELECT distinct lid FROM ".LESSONDB." WHERE xh = '$uxh' AND hasnew = 1");
	$lids = array();
	foreach($rows as $row) {
		$lids[] = $row['lid'];
	}
	return $lids;
}
?>
