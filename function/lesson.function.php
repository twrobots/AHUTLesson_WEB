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

function getLessonmatesByLid($lid, $page) {
	$start = ($page - 1) * LESSONMATES_PER_PAGE;
	$sql = "SELECT l.*, p.xm, p.zy, p.bj, p.registered, u.has_avatar
FROM ahut_lessonmate l, ahut_profile p, ahut_user u 
WHERE l.xh = p.xh AND l.xh = u.uxh AND lid = '$lid' 
AND registered = 1
UNION SELECT l.*, p.xm, p.zy, p.bj, p.registered, 0
FROM ahut_lessonmate l, ahut_profile p
WHERE l.xh = p.xh AND lid = '$lid' 
AND registered = 0
LIMIT $start,".LESSONMATES_PER_PAGE; 
	return DB::getData($sql);
}
?>