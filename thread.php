<?php
require 'include.php';

$page = new Page();
if(!isset($_GET['tid']) || !is_numeric($_GET['tid'])) $page->showError('参数错误');
$tid = $_GET['tid'];
$viewpage = 1;
if(isset($_GET['page'])) {
	if(is_numeric($_GET['page'])) {
		$viewpage = $_GET['page'];
	}
}
if(isset($_GET['pid'])) {
	if(is_numeric($_GET['pid'])) {
		$pid = $_GET['pid'];
	}
}
if(!empty($pid)){ 
	$viewpage = getPageByPid($tid, $pid);
}
$tinfo = getThreadInfo($tid);
if(empty($tinfo)) $page->showError('你要找的帖子不存在或者已被删除');
$lid = $tinfo['lid'];
$linfo = getLessonInfo($lid);
$page->setTitle($tinfo['subject'].' - '.$linfo['lessonname'].'('.$linfo['teachername'].')'.' - 课程讨论');
$page->setMod('forum');
$page->linkScript('thread');
$page->displayHeader();
?>
<script>
var totalPosts = 1;
var postsPerPage = <?php echo POSTS_PER_PAGE;?>;
var totalPages = 1;
var currentPage = 1;
<?php
$uinfo = User::getUserInfo();
echo ($uinfo != false && $uinfo['is_admin'] == 1) ? "var is_admin = true;" : "var is_admin = false;";
echo <<<EOD
var lid = '$lid';
var tid = '$tid';
EOD;
if(empty($pid)){
	echo "loadPage($viewpage);";	
}else{
	echo "loadPage($viewpage, $pid);";
}
?>
</script>
<div class="toolbar">
	<span class="button" onclick="refreshThread()">刷新</span>
</div>
<div class="navtitle">
	<div id="forum_title">
<?php 	
echo <<<EOD
<span id="forum_name"><a href="lesson.php?lid={$lid}">{$linfo['lessonname']}({$linfo['teachername']})</a></span>
EOD;
?>
	</div>
</div>
<div class="thread_wrap">
	<div class="threadtitle">
		<span><?php echo $tinfo['subject'];?></span>
	</div>
	<div id="postlist">

	</div>
	<div class="postpager">
		<span id="pager"></span>
		<span id="postsnum"></span>
	</div>
</div>

<div class="newpost_wrap bd">
	<div class="block_title">发表回复</div>
	<div class="block_content">
		<div id="newpost">
			<table>
				<tr>
					<td valign="top">内容: </td><td><textarea cols="70" rows="6"  id="newpost_content" ></textarea></td>
				</tr>
				<tr>
					<td></td><td><button title="提示：按Ctrl+Enter也可以发表" class="button" id="submit_button" onclick="newPost();">发表</button></td>
				</tr>
			</table>
				
		</div>
	</div>
</div>
<script>
$('#newpost_content').keydown(function (e) {
	if (e.keyCode === 10 || e.keyCode == 13 && e.ctrlKey) {
		newPost();
	}
});
</script>
<?php
$page->displayFooter();
?>