<?php
require 'include.php';

if(!isset($_GET['lid']) || !is_numeric($_GET['lid']))exit;
$lid = $_GET['lid'];

$lessonmates = getLessonmatesByLid($lid);
echo json_encode($lessonmates);
?>