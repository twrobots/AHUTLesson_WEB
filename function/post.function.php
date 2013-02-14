<?php
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