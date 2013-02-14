<?php
function getAllThreads($page) {
	$start = ($page - 1) * THREADS_PER_PAGE;
	return DB::getData("SELECT a.*,b.* FROM ".DB_PREFIX."thread a,".DB_PREFIX."lesson b WHERE a.lid = b.lid ORDER BY lastreply_time DESC LIMIT $start,".THREADS_PER_PAGE);
}

function getTotalAllThreadsNum() {
	return DB::getFirstGrid("SELECT COUNT(*) FROM ".DB_PREFIX."thread");
}

?>
