<?php
require 'include.php';
if(!isset($_GET['act'])) exit;
switch($_GET['act']) {
	case 'login':
		$xh = $_POST['x'];
		if(!isValidXH($xh)) reterror('学号错误');
		$password = addslashes($_POST['p']);
		User::login($xh, $password);
		break;
	case 'register':
		$xh = $_POST['x'];
		if(!isValidXH($xh)) reterror('学号错误');
		$password = addslashes($_POST['p']);
		User::register($xh, $password);
		break;
	case 'setsignature':
		$signature = $_POST['s'];
		if(mb_strlen($signature) > 255) reterror('内容过长（大于255个字符）');
		User::setSignature($signature);
		retok();
		break;
	case 'getloginuserinfo':
		$uinfo = User::getUserInfo();
		if(!$uinfo) reterror('你还没有登录!');
		retdata($uinfo);
		break;
	case 'getuserinfo':
		$uxh = $_GET['uxh'];
		if(!isValidXH($uxh)) reterror('学号错误');
		retdata(getUserInfoByXH($uxh));
		break;
}
