<?php
require '../include/config.inc.php';
$uxh = $_GET['uxh'];
$refresh = false;
if(isset($_GET['refresh']))$refresh = true;
if(!is_numeric($uxh))exit;

if(!defined('IN_SAE')) {
	$avatar = '../upload/avatar/'.$uxh.'.jpg';
	$noavatar = '../static/img/noavatar.jpg';
	if(!file_exists($avatar)) $avatar = $noavatar;
	if(!$refresh)header("Cache-Control: maxage=2592000");
	header('Content-Type: image/jpeg');
	header("Content-Length: " .(string)(filesize($avatar)) );
	@readfile($avatar);
}else{
	$noavatar = '../static/img/noavatar.jpg';
	$s = new SaeStorage();
	if(!$s->fileExists('upload', 'avatar/'.$uxh.'.jpg')) {
		@readfile($noavatar);
	}else{
		$img =  $s->read('upload', 'avatar/'.$uxh.'.jpg');
		if(!$refresh)header("Cache-Control: maxage=2592000");
		header('Content-Type: image/jpeg');
		header("Content-Length: " .(string)(strlen($img)) );
		echo $img;
	}
}
?>