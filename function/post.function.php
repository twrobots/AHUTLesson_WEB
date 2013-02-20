<?php
function newPost($content, $tid, $uxh) {
	$date = date('Y-m-d H:i:s');
	$uinfo = User::getUserInfo();
	if($uinfo == false) return '1|获取用户信息出错';
	$tinfo = DB::getFirstRow("SELECT * FROM ".DB_PREFIX."thread WHERE tid = '$tid'");
	if($tinfo == false) return '1|获取帖子信息出错';
	$floor = DB::getFirstGrid("SELECT COUNT(*) FROM ".DB_PREFIX."post WHERE tid = '$tid'");
	$floor++; 
	DB::query("INSERT INTO ".DB_PREFIX."post (tid, content, uxh, floor, post_time) VALUES ('$tid', '$content', '$uxh', '$floor', '$date')");	
	$pid = mysql_insert_id();
	DB::query("UPDATE ".DB_PREFIX."thread SET lastreply_time='$date',lastreply_uxh='$uxh',lastreply_uname='{$uinfo['uname']}' WHERE tid=$tid");
	updateThreadReplyCount($tid);
	if($uxh != $tinfo['uxh']) {
		sendPM('我回复了你的帖子"'.$tinfo['subject'].'"', '<a target="_blank" href="thread.php?tid='.$tid.'&pid='.$pid.'">快去看看吧>></a>', $uxh, $tinfo['uxh']);
	}
	return '0|'.$pid;
}
	
function getPosts($tid, $page) {
	$start = ($page - 1) * POSTS_PER_PAGE;
	return DB::getData("SELECT a.*,b.uname FROM ".DB_PREFIX."post a,".DB_PREFIX."user b WHERE tid = '$tid' AND a.uxh = b.uxh ORDER BY a.post_time LIMIT $start,".POSTS_PER_PAGE);
}

function getPageByPid($tid, $pid) {
	$postsBeforeNum = DB::getFirstGrid("SELECT COUNT(*) FROM ".DB_PREFIX."post WHERE post_time < (SELECT post_time FROM ".DB_PREFIX."post WHERE pid = $pid) AND tid=$tid") ;
	return (int) ($postsBeforeNum / POSTS_PER_PAGE + 1);
}

function getTotalPostsNum($tid) {
	return DB::getFirstGrid("SELECT COUNT(*) FROM ".DB_PREFIX."post WHERE tid = '$tid'");
} 

function getPostInfo($tid) {
	return DB::getFirstRow("SELECT * FROM ".DB_PREFIX."post WHERE tid = '$tid'");
}

function deletePostByPid($pid) {
	if(DB::query("DELETE FROM ".DB_PREFIX."post WHERE pid = '$pid'"))
		echo '0';
}
?>