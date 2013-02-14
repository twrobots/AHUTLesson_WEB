<?php
require 'include.php';

$xh = $_GET['xh'];
if(!isValidXH($xh))exit;

$lessons = getLessonsByXH($xh);
echo json_encode($lessons);
?>