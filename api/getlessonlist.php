<?php
require 'include.php';

$xh = $_GET['xh'];
if(!isValidXH($xh))exit;

$lessons = getLessonListByXH($xh);
echo json_encode($lessons);
?>