<?php
function getLessonsByXH($xh) {
	$result = DB::query("SELECT * FROM ".LESSON_TABLE." WHERE `xh` LIKE '$xh'");
	return resultToLessons($result);
}

function getLessonListByXH($xh) {
	return DB::getData("SELECT * FROM ".LESSON_TABLE." WHERE `xh` LIKE '$xh'");
}

//将mysql查询结果转换为课程二维数组
function resultToLessons($result) {
	$lessons = array();
	while($row = mysql_fetch_assoc($result)) {
		if(!isset($lessons[$row['week']])) {
			$lessons[$row['week']] = array();
		}
		$lessons[$row['week']][$row['time']] = $row;
	}
	return $lessons;
}

function getLessonInfo($lid) {
	return DB::getFirstRow("SELECT * FROM ahut_lesson WHERE lid = '$lid'");
}

function getLessonmatesByLid($lid) {
	return DB::getData("SELECT a.*, b.uname, b.zy, b.bj, b.registered FROM ahut_lessonmate a, ahut_profile b WHERE a.xh = b.uxh AND lid = '$lid'");
}
?>