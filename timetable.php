<?php
require 'include.php';

$page = new Page();

$uxh = User::getUXH();
$page->setTitle('我的课表');

if(isset($_GET['uxh']) && isValidXH($_GET['uxh'])) {
	$uxh = $_GET['uxh'];
	$page->setTitle('课表浏览');
}


$page->setMod('timetable');
$page->checkLogin();
$page->linkScript('timetable');
$page->displayHeader();
?>
<script>
var xh = '<?php echo $uxh;?>';
var xm = '';
loadTimetable();
</script>
<div class="toolbar">
	<div id="input_xh">
		输入学号查询课表：
		<input class="w80" type="text" name="xh" id="xh" value="<?php echo $uxh;?>"/>
		<span class="button" onclick="refreshTimetable()">查询</span>
	</div>
</div>
<div class="navtitle">
	<span id="timetable_name">我的课表</span>
</div>
<div class="clear"></div>
<div id="loading_timetable">
	正在载入课程...
</div>
<table>
	<tbody id="timetable">
	</tbody>
</table>
<?php
$page->displayFooter();
?>