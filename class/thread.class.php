<?php
class Thread {
	
	public static function newThread($subject, $content, $lid, $uxh) {
		$date = date('Y-m-d H:i:s');
		$uinfo = User::getUserInfo();
		if($uinfo == false) return '1|获取用户信息出错';
		DB::query("INSERT INTO ".DB_PREFIX."thread (lid, subject, uxh, uname, post_time, lastreply_time, lastreply_uxh, lastreply_uname) VALUES ('$lid', '$subject', '$uxh', '{$uinfo['uname']}', '$date', '$date', '$uxh', '{$uinfo['uname']}')");
		$tid = mysql_insert_id();
		DB::query("INSERT INTO ".DB_PREFIX."post (tid, content, uxh, floor, post_time) VALUES ('$tid', '$content', '$uxh', '1', '$date')");
		return '0|'.$tid;
	}

	public static function newPost($content, $tid, $uxh) {
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
		self::updateReplyCount($tid);
		if($uxh != $tinfo['uxh']) {
			sendPM('我回复了你的帖子"'.$tinfo['subject'].'"', '<a target="_blank" href="thread.php?tid='.$tid.'&pid='.$pid.'">快去看看吧>></a>', $uxh, $tinfo['uxh']);
		}
		return '0|'.$pid;
	}
	
	public static function addViewCount($tid) {
		DB::query("UPDATE ".DB_PREFIX."thread SET view=view+1 WHERE tid=$tid");
	}

	public static function updateReplyCount($tid) {
		DB::query("UPDATE ".DB_PREFIX."thread SET reply=(SELECT COUNT(*)-1 FROM ".DB_PREFIX."post p WHERE p.tid = $tid) WHERE tid=$tid");
	}
}