<?php
require 'include.php';

$page = new Page();
$page->setTitle('课程论坛');
$viewpage = 1;
if(isset($_GET['page'])) {
	if(is_numeric($_GET['page'])) {
		$viewpage = $_GET['page'];
	}
}
$page->setMod('forum');
$page->linkScript('forum');
$page->displayHeader();
?>
<script>
var totalThreads = 1;
var threadsPerPage = <?php echo THREADS_PER_PAGE;?>;
var totalPages = 1;
var currentPage = 1;
<?php
$uinfo = User::getUserInfo();
echo ($uinfo != false && $uinfo['is_admin'] == 1) ? "var is_admin = true;" : "var is_admin = false;";
echo "loadPage($viewpage);";
?>
</script>
<div class="toolbar">
	<span class="button" onclick="refreshForum()">刷新</span>
</div>
<div class="navtitle">课程论坛</div>
<div class="forum_wrap">
	<div class="forum_content">
		<div class="threadlisthead">
			<div class="lesson">所在课程</div><div class="number">点击</div><div class="number">回复</div><div class="title">标题</div><div class="author">作者</div><div class="lastreply">最后回复</div><div class="clear"></div>
		</div>
		<div id="threadlist">
		</div>
		<div class="threadpager">
			<span id="pager"></span>
			<span id="threadsnum"></span>
		</div>
	</div>
</div>

<?php 
$page->displayFooter();
?>