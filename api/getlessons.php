<?php
require 'include.php';

$xh = $_GET['xh'];
if(!isValidXH($xh))exit;

$lessons = getLessonsByXH($xh);
$uinfo = getProfileByXH($xh);
$metadata = array(
	'xm' => $uinfo['xm'],
	'build' => LESSONDB_VERSION
);
retdata($lessons, $metadata);
?>