<?php
function isValidXH($uxh) {
	return preg_match('/^[0-9]{9}$/',$uxh);
}

function isRealXH($xh) {		
	if(mysql_num_rows(DB::query("SELECT * FROM ahut_profile WHERE xh = '$xh'"))){
		return true;
	}
}

function getLoginUserInfoByXH($uxh) { //must be registered uxh
	return DB::getFirstRow("SELECT u.*,p.* FROM ahut_user u,ahut_profile p WHERE u.uxh = p.xh AND u.uxh = '$uxh'");
}

function getUserInfoByXH($uxh) { //must be registered uxh
	return DB::getFirstRow("SELECT u.uxh, u.uname, u.register_time, u.lastlogin_time, u.is_admin, u.signature, u.has_avatar, p.* FROM ahut_user u,ahut_profile p WHERE u.uxh = p.xh AND u.uxh = '$uxh'");
}

function getProfileByXH($xh) { //can be not-registerd uxh
	return DB::getFirstRow("SELECT * FROM ahut_profile WHERE xh = '$xh'");
}

function setAvatarState($uxh) {
	DB::query("UPDATE ahut_user SET `has_avatar` = 1 WHERE uxh = '$uxh'");
}


//Message
function sendPM($title, $content, $from_uxh, $to_uxh) {
	$date = date('Y-m-d H:i:s');
	if($from_uxh == $to_uxh) return false;
	DB::query("INSERT INTO ahut_message (`title`, `content`, `read`, `from_uxh`, `to_uxh`, `post_time`) VALUES ('$title', '$content', 0, '$from_uxh', '$to_uxh', '$date')");
	updateUnreadMessageCount($to_uxh);
}

function updateUnreadMessageCount($uxh) {
	DB::query("UPDATE ahut_user SET unread_message = (SELECT count(*) FROM ahut_message WHERE to_uxh = '$uxh' AND `read` = 0) WHERE uxh = '$uxh'");
}

function getMessage($uxh, $page) {
	$start = ($page - 1) * MESSAGES_PER_PAGE;
	return DB::getData("SELECT m.*,u.uname,u.has_avatar FROM ahut_message m,ahut_user u WHERE to_uxh = '$uxh' AND m.from_uxh = u.uxh ORDER BY post_time DESC LIMIT $start,".MESSAGES_PER_PAGE);
}

function deleteMessageByMid($mid, $uxh) {
	DB::query("DELETE FROM ahut_message WHERE to_uxh = '$uxh' AND mid = '$mid'");
	updateUnreadMessageCount($uxh);
}

function markMessageAsRead($uxh) {
	DB::query("UPDATE ahut_message SET `read` = 1 WHERE to_uxh = '$uxh'");
	DB::query("UPDATE ahut_user SET unread_message = 0 WHERE uxh = '$uxh'");
}

//Notice
function sendReplyNotice($tid, $pid, $subject, $from_uxh, $to_uxh) {
	$date = date('Y-m-d H:i:s');
	DB::query("INSERT INTO ahut_notice (`tid`, `pid`, `subject`, `type`, `read`, `from_uxh`, `to_uxh`, `post_time`) VALUES ('$tid', '$pid', '$subject', 'reply', 0, '$from_uxh', '$to_uxh', '$date')");
	updateUnreadNoticeCount($to_uxh);
}

function updateUnreadNoticeCount($uxh) {
	DB::query("UPDATE ahut_user SET unread_notice = (SELECT count(*) FROM ahut_notice WHERE to_uxh = '$uxh' AND `read` = 0) WHERE uxh = '$uxh'");
}

function getNotice($uxh, $page) {
	$start = ($page - 1) * NOTICES_PER_PAGE;
	return DB::getData("SELECT n.*,u.uname,u.has_avatar FROM ahut_notice n,ahut_user u WHERE to_uxh = '$uxh' AND n.from_uxh = u.uxh ORDER BY post_time DESC LIMIT $start,".NOTICES_PER_PAGE);
}

function markNoticeAsRead($uxh) {
	DB::query("UPDATE ahut_notice SET `read` = 1 WHERE to_uxh = '$uxh'");
	DB::query("UPDATE ahut_user SET unread_notice = 0 WHERE uxh = '$uxh'");
}

//General
function getUnreadCount($uxh) {
	return DB::getFirstRow("SELECT unread_message, unread_notice FROM ahut_user WHERE uxh = '$uxh'");
}

?>