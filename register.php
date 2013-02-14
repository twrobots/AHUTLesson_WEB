<?php
require 'include.php';

$page = new Page();
$page->setTitle('新用户注册');
$page->setMod('register');
$page->linkScript('register');
$page->displayHeader();
?>

<div class="navtitle">新用户注册</div>
<div class="content_wrap">
	<form id="register_form">
		<label>学号: </label> <input class="w80" type="text" name="xh" /> <br />
		<label>密码: </label> <input class="w80" type="password" name="password" /> <br />
		<label>确认: </label> <input class="w80" type="password" name="confirm_password" /> <br />
		<button class="button" id="submit_button" onclick="checkRegisterForm();return false;">提交</button>
	</form>
</div>
<?php 
$page->displayFooter();
?>