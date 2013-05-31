<?php
function resultToLessons($result) {
	//将mysql查询结果转换为课程二维数组
	$lessons = array();
	while(($row = mysql_fetch_assoc($result)) == true) {
		if(!isset($lessons[$row['week']])) {
			$lessons[$row['week']] = array();
		}
		$lessons[$row['week']][$row['time']] = $row;
	}
	return $lessons;
}

function getLessonsByXH($xh) {
	$result = DB::query("SELECT * FROM ".LESSONDB." WHERE `xh` LIKE '$xh'");
	return resultToLessons($result);
}

function getLessonListByXH($xh) {
	return DB::getData("SELECT * FROM ".LESSONDB." WHERE `xh` LIKE '$xh'");
}

function getLessonInfo($lid) {
	return DB::getFirstRow("SELECT * FROM ahut_lesson WHERE lid = '$lid'");
}

function getLessonmatesByLid($lid, $page) {
	$start = ($page - 1) * LESSONMATES_PER_PAGE;
	$sql = "SELECT l.xh, p.xm, p.zy, p.bj, p.registered, u.has_avatar, u.signature
FROM ahut_lessonmate l, ahut_profile p, ahut_user u 
WHERE l.xh = p.xh AND l.xh = u.uxh AND lid = '$lid' 
AND registered = 1
UNION SELECT l.xh, p.xm, p.zy, p.bj, p.registered, 0, ''
FROM ahut_lessonmate l, ahut_profile p
WHERE l.xh = p.xh AND lid = '$lid' 
AND registered = 0
LIMIT $start,".LESSONMATES_PER_PAGE; 
	return DB::getData($sql);
}
?>