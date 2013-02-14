<?php
require 'include.php';

$page = new Page();
$page->setTitle('编辑个人资料');
$page->setMod('profile');
$page->checkLogin();
$page->linkScript('profile');
$page->linkScript('ajaxfileupload');
$page->displayHeader();
$uinfo = User::getUserInfo();
?>

<div class="navtitle">个人资料</div>
<div class="content_wrap">
		<label>个性签名: </label> <input class="w200" type="text" name="signature" id="signature" value="<?php echo $uinfo['signature'];?>" /> 
		<button class="button" onclick="setSignature();return false;">设置</button>
</div>
<div class="navtitle">上传头像</div>
<div class="content_wrap">
	<label>当前头像：</label><br />
	<img src="<?php echo SERVER_URL;?>api/getavatar.php?uxh=<?php echo $uinfo['uxh'];?>&refresh" />
	<form id="upload_avatar_form" method="post" enctype="multipart/form-data" action="api/uploadavatar.handler.php">
		<label>选择头像: </label><input type="file" id="avatar_file" name="avatar_file" accept="image/jpeg, image/x-png, image/gif" /> <br />
		<button class="button" type="submit" onclick="uploadAvatar();return false;">上传</button>
	</form>
</div>
<?php
$page->displayFooter();
?>