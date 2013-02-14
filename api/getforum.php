<?php
require 'include.php';
if(!isset($_GET['page']) || !is_numeric($_GET['page']))exit;

$page = $_GET['page'];
$threads = getAllThreads($page);
$total = getTotalAllThreadsNum();
$return = array($total, $threads);
echo json_encode($return);
?>