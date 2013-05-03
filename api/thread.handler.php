<?php
require 'include.php';
if(!isset($_GET['act'])) exit;
switch($_GET['act']) {
	case 'get':
		if(!isset($_GET['lid']) || !is_numeric($_GET['lid'])) reterror('Invalid Arguments');
		if(!isset($_GET['page']) || !is_numeric($_GET['page'])) reterror('Invalid Arguments');
		$lid = $_GET['lid'];
		$page = $_GET['page'];
		$threads = getThreads($lid, $page);
		$metadata = array(
			'total' => getTotalThreadsNum($lid),
			'threadsPerPage' => THREADS_PER_PAGE
		);
		$uxh = User::getUXH();
		if($uxh) {
			markLessonForumRead($uxh, $lid);
		}
		retdata($threads, $metadata);
		break;
	case 'new':
		if(!isset($_POST['s']) || !isset($_POST['c']) || !isset($_POST['l'])) reterror('Invalid Arguments');
		$subject = htmlspecialchars($_POST['s']);
		if(mb_strlen($subject) > 80) reterror('标题过长（大于80字符）');
		$content = htmlspecialchars($_POST['c']);
		if(mb_strlen($content) > 1024) reterror('内容过长（大于1024字符）');
		$lid = $_POST['l'];
		if(!is_numeric($lid)) reterror('Invalid Arguments');
		if(!User::isLoggedIn()) reterror('你还没有登录，请先登录帐号！');
		$from_client = 0;
		if(isset($_GET['from']) && $_GET['from'] == 'mobile') $from_client = 1;
		newThread($subject, $content, $lid, User::getUXH(), $from_client);
		break;
	case 'delete':
		$uinfo = User::getUserInfo();
		if(!$uinfo) reterror('你还没有登录，请先登录帐号！');
		if($uinfo['is_admin'] != 1) reterror('权限不足！');
		if(!isset($_GET['tid']) || !is_numeric($_GET['tid'])) reterror('Invalid Arguments');
		deleteThreadByTid($_GET['tid']);
		retok();
		break;
	case 'settop':
		$uinfo = User::getUserInfo();
		if(!$uinfo) reterror('你还没有登录，请先登录帐号！');
		if($uinfo['is_admin'] != 1) reterror('权限不足！');
		if(!isset($_GET['tid']) || !is_numeric($_GET['tid'])) reterror('Invalid Arguments');
		if(!isset($_GET['value']) || !is_numeric($_GET['value'])) reterror('Invalid Arguments');
		setThreadTop($_GET['tid'], $_GET['value']);
		retok();
		break;
}
?>