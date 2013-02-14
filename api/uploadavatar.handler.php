<?php
require 'include.php';

$uxh = User::getUXH();
if($uxh == false) die('你还没有登录');

if ($_FILES["avatar_file"]["error"] > 0) {
	die("上传失败！错误号:" . $_FILES["avatar_file"]["error"]);
}

$fileType = strtolower(strrchr($_FILES['avatar_file']['name'],"."));
if (!in_array($fileType, array(".jpg", ".jpeg", ".gif", ".png"))) {
	die('目前仅支持格式为jpg、jpeg、gif、png的图片!');
}
if( $_FILES['avatar_file']['size'] > 2097152 ) {
	die('目图片不能超过2MB!');
}
$imgInfo = @getimagesize($_FILES['avatar_file']['tmp_name']);

if(!$imgInfo || !in_array($imgInfo[2], array(1,2,3))) {
	die('无法识别你上传的文件!');
}

$tmpAvatar = $_FILES['avatar_file']['tmp_name'];

$maxWidth = 120;
$maxHeight = 120;
if($maxWidth > $imgInfo[0] || $maxHeight > $imgInfo[1]) {
	$maxWidth = $imgInfo[0];
	$maxHeight = $imgInfo[1];
}else{
	if($imgInfo[0] < $imgInfo[1])
		$maxWidth = ($maxHeight / $imgInfo[1]) * $imgInfo[0];
	else
		$maxHeight = ($maxWidth / $imgInfo[0]) * $imgInfo[1];
}
if($maxWidth < 40) {
	$maxWidth = 40;
}
if($maxHeight < 40) {
	$maxHeight = 40;
}

$image_p = imagecreatetruecolor($maxWidth, $maxHeight);
switch($imgInfo[2]) {
	case 1:
		$image = imagecreatefromgif($tmpAvatar);
		break;
	case 2:
		$image = imagecreatefromjpeg($tmpAvatar);
		break;
	case 3:
		$image = imagecreatefrompng($tmpAvatar);
		break;
}
imagecopyresampled($image_p, $image, 0, 0, 0, 0, $maxWidth, $maxHeight, $imgInfo[0], $imgInfo[1]);

imagejpeg($image_p, '../upload/avatar/'.$uxh.'.jpg', 100);

/* sae
 ob_start();
$s = new SaeStorage();
imagejpeg($image_p);
$img = ob_get_contents();
$s->write('upload', 'avatar/'.$uxh.'.jpg' ,$img);
ob_end_clean();
*/

imagedestroy($image_p);
imagedestroy($image);


if($fileType != ".jpg" && file_exists($tmpAvatar)) {
	unlink($tmpAvatar);
}
echo '0';
?>