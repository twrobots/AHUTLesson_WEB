<?php
require 'include.php';

$page = new Page();
$page->setTitle('提醒');
$page->linkScript('notice');
$page->checkLogin();
$page->displayHeader();
?>
<script>
var noticePage = 1;
var noticesPerPage = <?php echo NOTICES_PER_PAGE;?>;
loadNotice();
</script>
<div class="nav-tab">
	<ul>
		<li class="clickable selected" id="replybutton"><span onclick="loadNotice();">我的提醒</span><span class="unreadNoticeCount"></span></li>
	</ul>
</div>
<div id="noticelist">
</div>
<div id="pager">
</div>
<?php 
$page->displayFooter();
?>