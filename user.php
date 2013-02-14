<?php
require 'include.php';

$feeds_per_page = 20;
$viewpage = 1;
if(isset($_GET['page']) && is_numeric($_GET['page'])) $viewpage = $_GET['page'];

$page = new Page();

if(!isset($_GET['uxh']) || !is_numeric($_GET['uxh'])) $page->showError('参数错误');
$uxh = $_GET['uxh'];

$uinfo = getUserInfoByXH($uxh);
if(!$uinfo) $page->showError('该用户未找到');
$page->setTitle($uinfo['uname'].'的个人主页');
$page->displayHeader();
?>
<script type="text/javascript">
</script>
<div class="userinfo fl bd">
	<div class="block_title">个人资料</div>
	<div class="block_content">
<?php 
echo '<img src="'.SERVER_URL.'api/getavatar.php?uxh='.$uxh.'">';
echo <<<EOD
		<div class="uname">{$uinfo['uname']}</div>
		<div class="signature" title="个性签名">{$uinfo['signature']}</div>
		<div class="action">
			<button class="button" onclick="showPmdiv('$uxh', '{$uinfo['uname']}')">发消息</button><br />
			<a target="_blank" class="button" href="timetable.php?uxh=$uxh">查看TA的课表</a>
		</div>
		<div class="detail bdt">班级:{$uinfo['bj']}<br />专业:{$uinfo['zy']}<br />学院:{$uinfo['xy']}<br />所在级:{$uinfo['rx']}</div>
		<div class="logintime">注册时间:{$uinfo['register_time']}<br />最后登录:{$uinfo['lastlogin_time']}</div>
EOD;
?>
	</div>
</div>
<div class="useractivity fr bd">
	<div class="block_title">最新动态</div>
	<div class="block_content">
		<ul class="userfeed">
<?php
$start = ($viewpage - 1) * $feeds_per_page;
$userfeeds = DB::getData("SELECT p.*, t.lid, t.subject ,l.* FROM ".DB_PREFIX."post p,".DB_PREFIX."thread t,".DB_PREFIX."lesson l WHERE p.tid = t.tid AND t.lid = l.lid AND p.uxh = '$uxh' ORDER BY p.post_time DESC LIMIT $start,$feeds_per_page");
foreach($userfeeds as $userfeed) {
	echo <<<EOD
	<li><div class="lessonname fr"><a target="_blank" href="lesson.php?lid={$userfeed['lid']}">{$userfeed['lessonname']} - {$userfeed['teachername']}</a></div>在<a target="_blank" href="thread.php?tid={$userfeed['tid']}">{$userfeed['subject']}</a>中发言：<br /><a target="_blank" href="thread.php?tid={$userfeed['tid']}&pid={$userfeed['pid']}"><div class="quote">{$userfeed['content']}</div></a><div class="time">{$userfeed['post_time']}</div></li>
EOD;
}
	if(empty($userfeeds)) {
		echo '<li>没有更多动态可以显示</li>';
	}else if(count($userfeeds) == $feeds_per_page){
		$nextpage = $viewpage + 1;
		echo <<<EOD
			<li><a href="user.php?uxh=$uxh&page={$nextpage}">下一页</a></li>
EOD;
	}
?>
		</ul>
	</div>
</div>
<div class="clear"></div>
<?php 
$page->displayFooter();
?>