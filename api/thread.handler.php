<?php
require 'include.php';
if(!isset($_GET['act'])) exit;
switch($_GET['act']) {
	case 'get':
		if(!isset($_GET['lid']) || !is_numeric($_GET['lid']))exit;
		if(!isset($_GET['page']) || !is_numeric($_GET['page']))exit;
		$lid = $_GET['lid'];
		$page = $_GET['page'];
		$threads = getThreads($lid, $page);
		$total = getTotalThreadsNum($lid);
		$return = array($threads, $total);
		echo json_encode($return);
		break;
	case 'new':
		if(!isset($_POST['s']) || !isset($_POST['c']) || !isset($_POST['l'])) die('1|参数错误');
		$subject = htmlspecialchars($_POST['s']);
		if(mb_strlen($subject) > 80) die('1|标题过长（大于80字符）');
		$content = htmlspecialchars($_POST['c']);
		if(mb_strlen($content) > 1024) die('1|内容过长（大于1024字符）');
		$lid = $_POST['l'];
		if(!is_numeric($lid)) die('1|参数错误');
		if(!User::isLoggedIn()) die('1|你还没有登录，请先登录帐号！');
		$from_client = 0;
		if(isset($_GET['from']) && $_GET['from'] == 'mobile') $from_client = 1;
		echo newThread($subject, $content, $lid, User::getUXH(), $from_client);
		break;
	case 'delete':
		$uinfo = User::getUserInfo();
		if(!$uinfo) die('1|你还没有登录，请先登录帐号！');
		if($uinfo['is_admin'] != 1) die('1|权限不足！');
		if(!isset($_GET['tid']) || !is_numeric($_GET['tid']))exit;
		echo  deleteThreadByTid($_GET['tid']);
		break;
	case 'settop':
		$uinfo = User::getUserInfo();
		if(!$uinfo) die('1|你还没有登录，请先登录帐号！');
		if($uinfo['is_admin'] != 1) die('1|权限不足！');
		if(!isset($_GET['tid']) || !is_numeric($_GET['tid']))exit;
		if(!isset($_GET['value']) || !is_numeric($_GET['value']))exit;
		setThreadTop($_GET['tid'], $_GET['value']);
		break;
}
?>