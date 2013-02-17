<?php
require 'include.php';
if(!isset($_GET['act'])) exit;
switch($_GET['act']) {
	case 'login':
		$xh = $_POST['x'];
		if(!isValidXH($xh)) die('1|学号错误');
		$password = addslashes($_POST['p']);
		echo User::login($xh, $password);
		break;
	case 'register':
		$xh = $_POST['x'];
		if(!isValidXH($xh)) die('1|学号错误');
		$password = addslashes($_POST['p']);
		echo User::register($xh, $password);
		break;
	case 'setsignature':
		$signature = $_POST['s'];
		if(mb_strlen($signature) > 255) die('1|内容过长（大于255个字符）');
		echo User::setSignature($signature);
		break;
	case 'getuserinfo':
		$uinfo = User::getUserInfo();
		if(!$uinfo) die('1|你还没有登录!');
		echo json_encode($uinfo);
		break;
}
