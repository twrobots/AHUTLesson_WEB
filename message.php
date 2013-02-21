<?php
require 'include.php';

$page = new Page();
$page->setTitle('消息中心');
$page->linkScript('message');
$page->checkLogin();
$page->displayHeader();
?>
<script>
var inboxPage = 1;
var outboxPage = 1;
var messagesPerPage = <?php echo MESSAGES_PER_PAGE;?>;
loadInbox();
</script>
<div class="nav-tab">
	<ul>
		<li class="clickable selected" id="inboxbutton"><span onclick="loadInbox();">收件箱</span><span class="unreadMessageCount"></span></li>
		<li class="clickable" id="outboxbutton"><span onclick="loadOutbox();">发件箱</span></li>
	</ul>
</div>
<div id="messagelist">
</div>
<div id="pager">
</div>
<?php 
$page->displayFooter();
?>