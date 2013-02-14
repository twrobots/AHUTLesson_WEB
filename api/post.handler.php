<?php
require 'include.php';
switch($_GET['act']) {
	case 'get':
		if(!isset($_GET['tid']) || !is_numeric($_GET['tid']))exit;
		if(!isset($_GET['page']) || !is_numeric($_GET['page']))exit;
		$tid = $_GET['tid'];
		$page = $_GET['page'];
		$posts = getPosts($tid, $page);
		$total = getTotalPostsNum($tid);
		$return = array($total, $posts);
		echo json_encode($return);
		break;
	case 'new':
		if(!isset($_POST['c']) || !isset($_POST['t'])) die('参数错误');
		$content = htmlspecialchars($_POST['c']);
		if(mb_strlen($content) > 1024) die('内容过长（大于1024个字符）');
		$tid = $_POST['t'];
		if(!is_numeric($tid)) die('参数错误');
		if(!User::isLoggedIn()) die('你还没有登录，请先登录帐号！');
		echo Thread::newPost($content, $tid, User::getUXH());
		break;
	case 'delete':
		$uinfo = User::getUserInfo();
		if(!$uinfo) die('你还没有登录，请先登录帐号！');
		if($uinfo['is_admin'] != 1) die('权限不足！');
		if(!isset($_GET['pid']) || !is_numeric($_GET['pid']))exit;
		echo deletePostByPid($_GET['pid']);
		break;
}
?>