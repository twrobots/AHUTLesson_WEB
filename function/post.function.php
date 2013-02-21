<?php
function newPost($content, $tid, $uxh, $from_client) {
	$date = date('Y-m-d H:i:s');
	$uinfo = User::getUserInfo();
	if($uinfo == false) return '1|获取用户信息出错';
	$tinfo = DB::getFirstRow("SELECT * FROM ahut_thread WHERE tid = '$tid'");
	if($tinfo == false) return '1|获取帖子信息出错';
	$floor = DB::getFirstGrid("SELECT COUNT(*) FROM ahut_post WHERE tid = '$tid'");
	$floor++; 
	DB::query("INSERT INTO ahut_post (tid, content, uxh, floor, post_time, from_client) VALUES ('$tid', '$content', '$uxh', '$floor', '$date', '$from_client')");	
	$pid = mysql_insert_id();
	DB::query("UPDATE ahut_thread SET lastreply_time='$date',lastreply_uxh='$uxh',lastreply_uname='{$uinfo['uname']}' WHERE tid=$tid");
	updateThreadReplyCount($tid);
	if($uxh != $tinfo['uxh']) {
		sendReplyNotice($tid, $pid, $tinfo['subject'], $uxh, $tinfo['uxh']);
	}
	return '0|'.$pid;
}
	
function getPosts($tid, $page) {
	$start = ($page - 1) * POSTS_PER_PAGE;
	return DB::getData("SELECT a.*,b.uname,b.has_avatar FROM ahut_post a,ahut_user b WHERE tid = '$tid' AND a.uxh = b.uxh ORDER BY a.post_time LIMIT $start,".POSTS_PER_PAGE);
}

function getPageByPid($tid, $pid) {
	$postsBeforeNum = DB::getFirstGrid("SELECT COUNT(*) FROM ahut_post WHERE post_time < (SELECT post_time FROM ahut_post WHERE pid = $pid) AND tid=$tid") ;
	return (int) ($postsBeforeNum / POSTS_PER_PAGE + 1);
}

function getTotalPostsNum($tid) {
	return DB::getFirstGrid("SELECT COUNT(*) FROM ahut_post WHERE tid = '$tid'");
} 

function getPostInfo($tid) {
	return DB::getFirstRow("SELECT * FROM ahut_post WHERE tid = '$tid'");
}

function deletePostByPid($pid) {
	if(DB::query("DELETE FROM ahut_post WHERE pid = '$pid'"))
		echo '0';
}
?>