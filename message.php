<?php
require 'include.php';

$page = new Page();
$page->setTitle('消息中心');
$page->linkScript('message');
$page->checkLogin();
$page->displayHeader();
?>
<script>
var messagePage = 1;
var messagesPerPage = <?php echo MESSAGES_PER_PAGE;?>;
loadMessage();
</script>
<div class="nav-tab">
	<ul>
		<li class="clickable selected" id="inboxbutton"><span onclick="loadMessage();">我的消息</span><span class="unreadMessageCount"></span></li>
	</ul>
</div>
<div id="messagelist">
</div>
<div id="pager">
</div>
<?php 
$page->displayFooter();
?>