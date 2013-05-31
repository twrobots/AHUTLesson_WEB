<?php
require 'include.php';

//version
$latestLessondbVer = LESSONDB_VERSION;

if(!isset($_GET['act'])) exit;
switch($_GET['act']) {
	case 'check':
		$ret = array();
		if(!isset($_GET['l']) || !isset($_GET['ty']) || !isset($_GET['tm']) || !isset($_GET['td']) || !isset($_GET['ts'])) reterror("Invalid Arguments");
		$lessondbVer = $_GET['l'];
		$timetableSetting = array(
				'year' => $_GET['ty'],
				'month' => $_GET['tm'],
				'day' => $_GET['td'],
				'season' => $_GET['ts']
		);
		
		if(version_compare($lessondbVer, $latestLessondbVer) < 0) {
			$ret['hasNewLessondbVer'] = true;
		}
		
		if($timetableSetting != $currentTimetableSetting) {
			$ret['hasNewTimetableSetting'] = true;
			$ret['newTimetableSetting'] = $currentTimetableSetting;
		}
		
		if(empty($ret))	$ret['upToDate'] = true;
		retdata($ret);
		break;
}
?>