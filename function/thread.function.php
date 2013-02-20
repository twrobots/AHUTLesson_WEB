<?php
function newThread($subject, $content, $lid, $uxh) {
	$date = date('Y-m-d H:i:s');
	$uinfo = User::getUserInfo();
	if($uinfo == false) return '1|获取用户信息出错';
	DB::query("INSERT INTO ".DB_PREFIX."thread (lid, subject, uxh, uname, post_time, lastreply_time, lastreply_uxh, lastreply_uname) VALUES ('$lid', '$subject', '$uxh', '{$uinfo['uname']}', '$date', '$date', '$uxh', '{$uinfo['uname']}')");
	$tid = mysql_insert_id();
	DB::query("INSERT INTO ".DB_PREFIX."post (tid, content, uxh, floor, post_time) VALUES ('$tid', '$content', '$uxh', '1', '$date')");
	return '0|'.$tid;
}

function addThreadViewCount($tid) {
	DB::query("UPDATE ".DB_PREFIX."thread SET view=view+1 WHERE tid=$tid");
}

function updateThreadReplyCount($tid) {
	DB::query("UPDATE ".DB_PREFIX."thread SET reply=(SELECT COUNT(*)-1 FROM ".DB_PREFIX."post p WHERE p.tid = $tid) WHERE tid=$tid");
}

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