<?php
function isValidXH($uxh) {
	return preg_match('/^[0-9]{9}$/',$uxh);
}

function isRealXH($uxh) {		
	if(mysql_num_rows(DB::query("SELECT * FROM ".DB_PREFIX."profile WHERE uxh = '$uxh'"))){
		return true;
	}
}

function getUserInfoByXH($uxh) { //must be registered uxh
	return DB::getFirstRow("SELECT a.*,b.* FROM ".DB_PREFIX."user a,".DB_PREFIX."profile b WHERE a.uxh = b.uxh AND a.uxh = '$uxh'");
}

function getProfileByXH($uxh) { //can be not-registerd uxh
	return DB::getFirstRow("SELECT * FROM ".DB_PREFIX."profile WHERE uxh = '$uxh'");
}

function sendPM($title, $content, $from_uxh, $to_uxh) {
	$date = date('Y-m-d H:i:s');
	if($from_uxh == $to_uxh) return false;
	return DB::query("INSERT INTO ".DB_PREFIX."message (`title`, `content`, `read`, `from_uxh`, `to_uxh`, `post_time`) VALUES ('$title', '$content', 0, '$from_uxh', '$to_uxh', '$date')");
}

function getUserInboxMessage($uxh, $page) {
	$start = ($page - 1) * MESSAGES_PER_PAGE;
	return DB::getData("SELECT m.*,u.uname FROM ".DB_PREFIX."message m,".DB_PREFIX."user u WHERE to_uxh = '$uxh' AND m.from_uxh = u.uxh ORDER BY post_time DESC LIMIT $start,".MESSAGES_PER_PAGE);
}

function getUserOutboxMessage($uxh, $page) {
	$start = ($page - 1) * MESSAGES_PER_PAGE;
	return DB::getData("SELECT m.*,u.uname FROM ".DB_PREFIX."message m,".DB_PREFIX."user u WHERE from_uxh = '$uxh' AND m.to_uxh = u.uxh ORDER BY post_time DESC LIMIT $start,".MESSAGES_PER_PAGE);	
}

function deleteMessageByMid($mid, $uxh) {
	if(DB::query("DELETE FROM ".DB_PREFIX."message WHERE to_uxh = '$uxh' AND mid = '$mid'"))
		echo '0';
}

function unreadMessageCount($uxh) {
	return DB::getFirstGrid("SELECT count(*) FROM ".DB_PREFIX."message WHERE to_uxh = '$uxh' AND `read` = 0");
}

function markAsRead($mid, $uxh) {
	DB::query("UPDATE ahut_message SET `read` = 1 WHERE to_uxh = '$uxh' AND mid = '$mid'");
}
?>