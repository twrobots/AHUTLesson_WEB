<?php
function newThread($subject, $content, $lid, $uxh, $from_client) {
	$date = date('Y-m-d H:i:s');
	$uinfo = User::getUserInfo();
	if($uinfo == false) return '1|获取用户信息出错';
	DB::query("INSERT INTO ahut_thread (lid, subject, uxh, uname, post_time, lastreply_time, lastreply_uxh, lastreply_uname) VALUES ('$lid', '$subject', '$uxh', '{$uinfo['uname']}', '$date', '$date', '$uxh', '{$uinfo['uname']}')");
	$tid = mysql_insert_id();
	DB::query("INSERT INTO ahut_post (tid, content, uxh, floor, post_time, from_client) VALUES ('$tid', '$content', '$uxh', '1', '$date', '$from_client')");
	retdata($tid);
}

function addThreadViewCount($tid) {
	DB::query("UPDATE ahut_thread SET view=view+1 WHERE tid=$tid");
}

function updateThreadReplyCount($tid) {
	DB::query("UPDATE ahut_thread SET reply=(SELECT COUNT(*)-1 FROM ahut_post p WHERE p.tid = $tid) WHERE tid=$tid");
}

function getThreads($lid, $page) {
	$start = ($page - 1) * THREADS_PER_PAGE;
	return DB::getData("SELECT * FROM ahut_thread WHERE top = 1 UNION SELECT * FROM ahut_thread WHERE lid = '$lid' ORDER BY top DESC, lastreply_time DESC LIMIT $start,".THREADS_PER_PAGE);
}

function getTotalThreadsNum($lid) {
	return DB::getFirstGrid("SELECT COUNT(*) FROM ahut_thread WHERE lid = '$lid'");
}

function getThreadInfo($tid) {
	return DB::getFirstRow("SELECT * FROM ahut_thread WHERE tid = '$tid'");
}

function deleteThreadByTid($tid) {
	DB::query("DELETE FROM ahut_thread WHERE tid = '$tid'");
	DB::query("DELETE FROM ahut_post WHERE tid = '$tid'");
}

function setThreadTop($tid, $value) {
	if($value == 1) {
		DB::query("UPDATE ahut_thread SET top=1 WHERE tid=$tid");
	}else{
		DB::query("UPDATE ahut_thread SET top=0 WHERE tid=$tid");
	}
}

?>