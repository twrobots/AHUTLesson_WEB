<?php
require 'include.php';

$page = new Page();
if(!isset($_GET['lid']) || !is_numeric($_GET['lid'])) $page->showError('参数错误');
$lid = $_GET['lid'];
$viewpage = 1;
if(isset($_GET['page'])) {
	if(is_numeric($_GET['page'])) {
		$viewpage = $_GET['page'];
	}
}
$linfo = getLessonInfo($lid);
if(empty($linfo))$page->showError('未找到此课程ID:'.$lid);
$page->setTitle($linfo['lessonname'].'('.$linfo['teachername'].')'.' - 课程讨论');
$page->setMod('forum');
$page->linkScript('lesson');
$page->displayHeader();
?>
<script>
var totalThreads = 1;
var threadsPerPage = <?php echo THREADS_PER_PAGE;?>;
var totalPages = 1;
var currentPage = 1;
var showLessonmate = false;
var lessonmates = null;
var lessonmatePage = 0;
var lessonmatesPerPage= <?php echo LESSONMATES_PER_PAGE;?>;
<?php
echo "var lid = '$lid';";
echo "loadPage($viewpage);";
$uinfo = User::getUserInfo();
echo ($uinfo != false && $uinfo['is_admin'] == 1) ? "var is_admin = true;" : "var is_admin = false;";
?>
</script>
<div class="toolbar">
	<span class="button" onclick="refreshForum()">刷新帖子</span>
	<span class="button" onclick="showOrHideLessonmate()">显示/隐藏课友</span>
</div>
<div class="navtitle">
<?php 	
echo <<<EOD
<span id="lesson_name"><a href="lesson.php?lid={$lid}">{$linfo['lessonname']}({$linfo['teachername']})</a></span>
EOD;
?>
</div>
<div class="lesson_wrap">
	<div class="fl">
		<div class="lesson_content">
			<div class="threadlisthead bdb">
				<div class="number">点击</div><div class="number">回复</div><div class="title">标题</div><div class="author">作者</div><div class="lastreply">最后回复</div><div class="clear"></div>
			</div>
			<div id="threadlist">
			</div>
			<div class="threadpager">
				<span id="pager"></span>
				<span id="threadsnum"></span>
			</div>
		</div>
		<div class="newpost_wrap bd">
			<div class="block_title">发表新帖</div>
			<div class="block_content">
				<div id="newthread">
					<table>
						<tr>
							<td>标题: </td><td><input class="title" type="text" id="newthread_subject" /></td>
						</tr>
						<tr>
							<td valign="top">内容: </td><td><textarea cols="70" rows="10"  id="newthread_content" ></textarea></td>
						</tr>
						<tr>
							<td></td><td><button title="提示：按Ctrl+Enter也可以发表" class="button" id="submit_button" onclick="newThread();return false;">发表</button></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div id="lessonmate_block" class="lessonmate bdt fr" style="display:none;">
		<div class="block_title">课友列表</div>
		<div id="lessonmatelist">
		</div>
		<div id="lessonmatePager" style="padding:15px 0px;">
		</div>
	</div>
	<div class="clear"></div>
</div>

<script>
$('#newthread_content').keydown(function (e) {
	if (e.keyCode === 10 || e.keyCode == 13 && e.ctrlKey) {
		newThread();
	}
});
</script>
<?php
$page->displayFooter();
?>