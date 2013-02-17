<?php
require 'include.php';
if(!isset($_GET['act'])) exit;
switch($_GET['act']) {
	case 'send':
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
	case 'getinbox':
		$uxh = User::getUXH();
		if(!$uxh) exit;
		if(!isset($_GET['page']) || !is_numeric($_GET['page']))exit;
		$page = $_GET['page'];
		echo json_encode(getUserInboxMessage($uxh, $page));
		break;
	case 'getoutbox':
		$uxh = User::getUXH();
		if(!$uxh) exit;
		if(!isset($_GET['page']) || !is_numeric($_GET['page']))exit;
		$page = $_GET['page'];
		echo json_encode(getUserOutboxMessage($uxh, $page));
		break;
	case 'delete':
		$uxh = User::getUXH();
		if(!$uxh) die('1|你还没有登录!');
		if(!isset($_GET['mid']) || !is_numeric($_GET['mid']))exit;
		echo deleteMessageByMid($_GET['mid'], $uxh);
		break;
	case 'countunread':
		$uxh = User::getUXH();
		if(!$uxh) die('0');
		echo unreadMessageCount($uxh);
		break;
	case 'markasread':
		$uxh = User::getUXH();
		if(!$uxh) die('1|你还没有登录!');
		if(!isset($_GET['mid']) || !is_numeric($_GET['mid']))exit;
		markAsRead($_GET['mid'], $uxh);
		break;
}
?>