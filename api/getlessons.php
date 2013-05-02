<?php
require 'include.php';

$xh = $_GET['xh'];
if(!isValidXH($xh))exit;

$lessons = getLessonsByXH($xh);
$uinfo = getProfileByXH($xh);
$metadata = array(
	'xm' => $uinfo['xm'],
	'build' => LESSON_TABLE_BUILD
);
retdata($lessons, $metadata);
?>