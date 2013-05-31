<?php
function isReplyingToReply($content) {
	if(strpos($content, '回复') != 0) return false;
	$floor_end = strpos($content, '楼');
	if(empty($floor_end)) return false;
	$floor_str = substr($content, 6, $floor_end - 6);
	if(!is_numeric($floor_str)) return false;
	return $floor_str;
}

function getPostByFloor($tid, $floor) {
	return DB::getFirstRow("SELECT * FROM ahut_post WHERE tid = '$tid' AND floor = '$floor'");
}

function newPost($content, $tid, $uxh, $from_client) {
	$date = date('Y-m-d H:i:s');
	$uinfo = User::getUserInfo();
	if($uinfo == false) reterror('获取用户信息出错');
	$tinfo = DB::getFirstRow("SELECT * FROM ahut_thread WHERE tid = '$tid'");
	if($tinfo == false) reterror('获取帖子信息出错');
	$floor = DB::getFirstGrid("SELECT COUNT(*) FROM ahut_post WHERE tid = '$tid'");
	$floor++; 
	DB::query("INSERT INTO ahut_post (tid, content, uxh, floor, post_time, from_client) VALUES ('$tid', '$content', '$uxh', '$floor', '$date', '$from_client')");	
	$pid = mysql_insert_id();
	DB::query("UPDATE ahut_thread SET lastreply_time='$date',lastreply_uxh='$uxh',lastreply_uname='{$uinfo['uname']}' WHERE tid=$tid");
	updateThreadReplyCount($tid);
	$touxh = $tinfo['uxh'];
	if($uxh != $touxh) {
		sendReplyNotice($tid, $pid, $tinfo['subject'], $uxh, $touxh);
	}
	$replyfloor = isReplyingToReply($content);
	if($replyfloor !== false) {
		$postToReply = getPostByFloor($tid, $replyfloor);
		if($uxh != $postToReply['uxh']) {
			sendReplyNotice($tid, $pid, $tinfo['subject'], $uxh, $postToReply['uxh']);
		}
	}
	retdata($pid);
}
	
function getPosts($tid, $page) {
	$start = ($page - 1) * POSTS_PER_PAGE;
	return DB::getData("SELECT a.*,b.uname,b.has_avatar FROM ahut_post a,ahut_user b WHERE tid = '$tid' AND a.uxh = b.uxh ORDER BY a.post_time LIMIT $start,".POSTS_PER_PAGE);
}

function getPost($pid) {
	return DB::getFirstRow("SELECT a.*,b.uname,b.has_avatar FROM ahut_post a,ahut_user b WHERE pid = '$pid' AND a.uxh = b.uxh");
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
	DB::query("DELETE FROM ahut_post WHERE pid = '$pid'");
}
?>