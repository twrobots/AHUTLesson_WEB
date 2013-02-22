<?php
require 'include.php';
if(!isset($_GET['act'])) exit;
switch($_GET['act']) {
	case 'getunreadcount':
		$uxh = $_GET['uxh'];
		if(!isValidXH($uxh)) exit;
		$unread_count = getUnreadCount($uxh);
		if($unread_count == false) exit;
		$ret = array($unread_count['unread_message'], $unread_count['unread_notice']);
		echo json_encode($ret);
		break;
	
	//message
	case 'sendmessage':
		$from_uxh = User::getUXH();
		if(!$from_uxh) die('1|你还没有登录!');
		if(!isset($_POST['u']) || !isset($_POST['t']) || !isset($_POST['c']) || !isValidXH($_POST['u'])) die('1|参数错误');
		$to_uxh = $_POST['u'];
		$title = addslashes(htmlspecialchars($_POST['t']));
		$content = addslashes(htmlspecialchars($_POST['c']));
		if(empty($title)||empty($content)) die('1|标题或内容为空');
		if(mb_strlen($title) > 64) die('1|标题过长（大于64个字符）');
		if(mb_strlen($content) > 500) die('1|内容过长（大于500个字符）');
		sendPM($title, $content, $from_uxh, $to_uxh);
		break;
	case 'getmessage':
		$uxh = User::getUXH();
		if(!$uxh) exit;
		if(!isset($_GET['page']) || !is_numeric($_GET['page']))exit;
		$page = $_GET['page'];
		echo json_encode(getMessage($uxh, $page));
		markMessageAsRead($uxh);
		break;
	case 'deletemessage':
		$uxh = User::getUXH();
		if(!$uxh) die('1|你还没有登录!');
		if(!isset($_GET['mid']) || !is_numeric($_GET['mid']))exit;
		deleteMessageByMid($_GET['mid'], $uxh);
		break;
	//notice
	case 'getnotice':
		$uxh = User::getUXH();
		if(!$uxh) exit;
		if(!isset($_GET['page']) || !is_numeric($_GET['page']))exit;
		$page = $_GET['page'];
		echo json_encode(getNotice($uxh, $page));
		markNoticeAsRead($uxh);
		break;
}
?>