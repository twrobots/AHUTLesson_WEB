<?php
require 'include.php';
if(!isset($_GET['act'])) exit;
switch($_GET['act']) {
	case 'getunreadcount':
		$uxh = $_GET['uxh'];
		if(!isValidXH($uxh)) reterror('Invalid Arguments');
		$unread_count = getUnreadCount($uxh);
		if($unread_count === false) reterror('Server Error');
		$ret = array();
		$ret['m'] = $unread_count['unread_message'];
		$ret['n'] = $unread_count['unread_notice'];
		$ret['l'] = getLidListHasNew($uxh);
		retdata($ret);
		break;
	//message
	case 'sendmessage':
		$from_uxh = User::getUXH();
		if(!$from_uxh) reterror('你还没有登录!');
		if(!isset($_POST['u']) || !isset($_POST['t']) || !isset($_POST['c']) || !isValidXH($_POST['u'])) reterror('Invalid Arguments');
		$to_uxh = $_POST['u'];
		$title = addslashes(htmlspecialchars($_POST['t']));
		$content = addslashes(htmlspecialchars($_POST['c']));
		if(empty($title)||empty($content)) reterror('标题或内容为空');
		if(mb_strlen($title) > 64) reterror('标题过长（大于64个字符）');
		if(mb_strlen($content) > 500) reterror('内容过长（大于500个字符）');
		sendPM($title, $content, $from_uxh, $to_uxh);
		retok();
		break;
	case 'getmessage':
		$uxh = User::getUXH();
		if(!$uxh) reterror('你还没有登录!');
		if(!isset($_GET['page']) || !is_numeric($_GET['page']))reterror('Invalid Arguments');
		$page = $_GET['page'];
		$data = getMessage($uxh, $page);
		$metadata = array(
			'messagesPerPage' => MESSAGES_PER_PAGE
		);
		markMessageAsRead($uxh);
		retdata($data, $metadata);
		break;
	case 'deletemessage':
		$uxh = User::getUXH();
		if(!$uxh) reterror('你还没有登录!');
		if(!isset($_GET['mid']) || !is_numeric($_GET['mid'])) reterror('Invalid Arguments');
		deleteMessageByMid($_GET['mid'], $uxh);
		retok();
		break;
	//notice
	case 'getnotice':
		$uxh = User::getUXH();
		if(!$uxh) reterror('你还没有登录!');
		if(!isset($_GET['page']) || !is_numeric($_GET['page'])) reterror('Invalid Arguments');
		$page = $_GET['page'];
		$data = getNotice($uxh, $page);
		$metadata = array(
			'noticesPerPage' => NOTICES_PER_PAGE
		);
		markNoticeAsRead($uxh);
		retdata($data, $metadata);
		break;
}
?>