<?php
class Page {

	private $time_start;
	private $title = '课友网 - 安工大课程助手网页版';
	private $mod;
	private $hasLogin = false;
	private $scripts = array();
	
	public function __construct() {
		if(!isset( $_SESSION)) session_start();
		$this->time_start = microtime(true);
		$this->hasLogin = User::isLoggedIn();
	}

	public function setTitle($title) {
		$this->title = $title.' - 课友网 - 安工大课程助手网页版';
	}

	public function setMod($mod) {
		$this->mod = $mod;
	}
	
	public function linkScript($script) {
		array_push($this->scripts, $script);
	}
	
	public function checkLogin() {
		if(!User::isLoggedIn()) $this->showError('你必须登录才能查看此页面，请在右上角登录或注册。');
	}
	
	public function displayHeader() {
		header("Content-Type: text/html; charset=utf-8");
		echo <<<EOD
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8" />
<title>{$this->title}</title>
<link rel="stylesheet" type="text/css" href="static/css/common.css" media="all" />
<script type="text/javascript" src="static/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="static/js/jquery.cookie.js"></script>
<script type="text/javascript" src="static/js/jquery.scrollto.js"></script>
<script type="text/javascript" src="static/js/common.js"></script>

EOD;
		foreach($this->scripts as $script) {
			echo <<<EOD
<script type="text/javascript" src="static/js/$script.js"></script>
EOD;
		}
		
		echo '<script>$.ajaxSetup({ cache: false });</script>';
		
echo <<<EOD
</head>
<body>
<div id="header_banner">
	<div class="wrap">
		<div id="userbar" class="">
EOD;
		if(!$this->hasLogin) {
			echo <<<EOD
			学号：<input type="text" class="w80" id="login_xh" />
			密码：<input type="password" class="w80" id="login_password" />
			<input id="save_cookie" type="checkbox" />
			<span onclick="toggleSaveCookie()" class="clickable">记住我</span>
			<button class="button" onclick="login();">登录</button>
			<a class="button" href="register.php">注册</a>
EOD;
		}else{
			$uinfo = User::getUserInfo();
			echo <<<EOD
			<span class="welcome">欢迎<a target="_blank" href="user.php?uxh={$uinfo['uxh']}">{$uinfo['uname']}</a>同学!</span>
			<a href="message.php">消息</a>
			<span class="unreadCount"></span>
			<span class="pipe">|</span>
			<a href="profile.php">编辑资料</a><span class="pipe">|</span>
			<span class="clickable" onclick="loginOut();">退出</span>
EOD;
		}
		echo <<<EOD
		</div>
	</div>
</div>
<div class="wrap">
	<div id="header">
		<div class="logo"><a title="安工大课程助手网页版" href="index.php">课友网</a></div>
		<div id="navi">
			<ul>
EOD;
		echo "<li><a ";if($this->mod == 'timetable') echo 'class="selected" '; echo 'href="timetable.php">我的课表</a></li>';
		echo "<li><a ";if($this->mod == 'android') echo 'class="selected" '; echo 'href="android.php">Android版</a></li>';
		echo <<<EOD
			</ul>
		</div>
	</div>
	<div class="pmdiv" style="display:none;">
	给<b><span id="pm_uname"></span></b>发送短消息：<br />
	标题:<br />
	<input type="text" id="pm_title" style="width:160px;"/><br />
	内容:<br />
	<textarea id="pm_content" style="width:160px;height:80px;margin-bottom:5px;"></textarea><br />
	<input type="button" class="button" value="确认并发送" onclick="sendpm();" />
	<input type="button" class="button" value="取消" onclick="$('.pmdiv').fadeOut(500);" />
	</div>
	<div class="body_wrap">
EOD;
	}
	
	public function displayFooter() {

		if($this->hasLogin) {
			echo '<script>checkUnreadMessage();</script>';
		}
		
		$time_end = microtime(true);
		$exectime = $time_end - $this->time_start;
		$exectime = number_format($exectime, 6);
		echo <<<EOD
	</div>
	<div id="footer">
		<span class="fr">By Renzhn@AHUT :: Copyright 2013 :: Executed in $exectime seconds</span>
	</div>
</div>
</body>
</html>
EOD;
	}
	
	public function showError($msg) {
		$this->displayHeader();
		showMessage('访问出错', $msg);
		$this->displayFooter();
		exit;
	}
}