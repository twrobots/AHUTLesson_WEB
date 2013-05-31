<?php
require 'include.php';
if(!isset($_GET['act'])) exit;
switch($_GET['act']) {
	case 'get':
		if(!isset($_GET['tid']) || !is_numeric($_GET['tid'])) reterror('Invalid Arguments');
		if(!isset($_GET['page']) || !is_numeric($_GET['page'])) reterror('Invalid Arguments');
		$tid = $_GET['tid'];
		$page = $_GET['page'];
		if(isset($_GET['pid']) && is_numeric($_GET['pid'])) {
			$pid = $_GET['pid'];
			$page = getPageByPid($pid);
		}
		addThreadViewCount($tid);
		$posts = getPosts($tid, $page);
		$metadata = array(
			'total' => getTotalPostsNum($tid),
			'currentPage' => $page,
			'postsPerPage' => POSTS_PER_PAGE
		);
		retdata($posts, $metadata);
		break;
	case 'getbypid':
		if(!isset($_GET['pid']) || !is_numeric($_GET['pid'])) reterror('Invalid Arguments');
		$pid = $_GET['pid'];
		retdata(getPost($pid));
		break;
	case 'new':
		if(!isset($_POST['c']) || !isset($_POST['t'])) reterror('Invalid Arguments');
		$content = htmlspecialchars($_POST['c']);
		if(mb_strlen($content) > 1024) reterror('内容过长（大于1024个字符）');
		$tid = $_POST['t'];
		if(!is_numeric($tid)) reterror('Invalid Arguments');
		if(!User::isLoggedIn()) reterror('你还没有登录，请先登录帐号！');
		$from_client = 0;
		if(isset($_GET['from']) && $_GET['from'] == 'mobile') $from_client = 1;
		newPost($content, $tid, User::getUXH(), $from_client);
		retok();
		break;
	case 'delete':
		$uinfo = User::getUserInfo();
		if(!$uinfo) reterror('你还没有登录，请先登录帐号！');
		if($uinfo['is_admin'] != 1) reterror('权限不足！');
		if(!isset($_GET['pid']) || !is_numeric($_GET['pid'])) reterror('Invalid Arguments');
		deletePostByPid($_GET['pid']);
		retok();
		break;
}
?>