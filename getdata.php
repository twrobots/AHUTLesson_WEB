<?php
require_once('include/config.inc.php');
require_once("function/profile.function.php");
require_once("class/db.class.php");
require_once("class/lesson.class.php");

$xh = $_GET['xh'];
if(!isValidXH($xh))exit;

$lessons = Lesson::getLessonListByXH($xh);
echo json_encode($lessons);
?>