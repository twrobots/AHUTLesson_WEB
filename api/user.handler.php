<?php
require 'include.php';
if(!isset($_GET['act'])) exit;
switch($_GET['act']) {
	case 'setsignature':
		$signature = $_POST['s'];
		if(mb_strlen($signature) > 255) die('内容过长（大于255个字符）');
		echo User::setSignature($signature);
		break;
	case 'getuserinfo':
		$uinfo = User::getUserInfo();
		if(!$uinfo) die('你还没有登录!');
		echo json_encode($uinfo);
		break;
}
