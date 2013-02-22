<?php
require 'include.php';

if(!isset($_GET['lid']) || !is_numeric($_GET['lid'])) exit;
if(!isset($_GET['page']) || !is_numeric($_GET['page'])) exit;

$lessonmates = getLessonmatesByLid($_GET['lid'], $_GET['page']);
echo json_encode($lessonmates);
?>