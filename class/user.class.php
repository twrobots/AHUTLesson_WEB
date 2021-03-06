<?php
class User {
	
	public static $uxh;
	public static $loggedIn = false;
	public static $uinfo = array();
	public static $loadedInfo = false;
	
	public static function login($uxh, $password) {
		if(self::verify($uxh, $password)) {
			$ck = self::genCookie($uxh, $password);
			retdata($ck);
		}else{
			reterror('登录失败，请检查学号或密码是否有误');
		}
	}
	
	public static function verify($uxh, $password) {
		$result = DB::getFirstGrid("SELECT password FROM ahut_user WHERE uxh='$uxh'"); 
		if($password == $result) {
			updateLastLoginTime($uxh);
			self::$uxh = $uxh;
			self::$loggedIn = true;
			return true;
		}
	}
	
	public static function genCookie($uxh, $password) {
		return base64_encode(serialize(array('uxh'=>$uxh,'password'=>$password)));
	}
	
	public static function isLoggedIn() {
		if(self::$loggedIn == true) return true;
		if(isset($_COOKIE['ck'])){
			$u = unserialize(base64_decode($_COOKIE['ck']));
			return self::verify($u['uxh'], $u['password']);
		}
		return false;
	}
	
	public static function getUXH() {
		if(self::$loggedIn) {
			return self::$uxh;
		}else if(self::isLoggedIn()) {
			return self::$uxh;
		}else return false;
	}
	
	public static function getUserInfo() {
		if(self::$loadedInfo) {
			return self::$uinfo;
		}else if(self::isLoggedIn()){
			self::$uinfo = getLoginUserInfoByXH(self::$uxh);
			self::$loadedInfo = true;
			return self::$uinfo;
		}else return false;
	}

	public static function isAdmin() {
		if(self::getUserInfo() != false && self::$uinfo['is_admin'] == 1) {
			return true;
		}
	}

	public static function setSignature($signature) {
		$uxh = User::getUXH();
		if($uxh == false) reterror('你还没有登录！');
		DB::query("UPDATE ahut_user SET signature='".$signature."' WHERE uxh='{$uxh}'");
	}
	
	public static function register($uxh, $password) {
		if(self::exists($uxh)) reterror('该学号已被注册，如有疑问请联系renzhen999@gmail.com');
		if(!isRealXH($uxh)) reterror('该学号不存在，如有疑问请联系renzhen999@gmail.com');
		$date = date('Y-m-d H:i:s');
		$uinfo = getProfileByXH($uxh);
		DB::query("INSERT INTO ahut_user (uxh, uname, bj, password, register_time, lastlogin_time) VALUES ('$uxh', '{$uinfo['xm']}', '{$uinfo['bj']}', '$password', '$date', '$date')");
		DB::query("UPDATE ahut_profile SET registered=1 WHERE xh='$uxh'");
		$ck = self::genCookie($uxh, $password);
		retdata($ck);
	}
	
	public static function exists($uxh) {
		if(mysql_num_rows(DB::query("SELECT uxh FROM ahut_user WHERE uxh = '$uxh'"))){
			return true;
		}
	}
}