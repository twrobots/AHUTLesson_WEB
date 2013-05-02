<?php
require 'include.php';
if(!isset($_GET['page']) || !is_numeric($_GET['page']))exit;

$threads = getAllThreads($_GET['page']);
$metadata = array(
	'total' => getTotalAllThreadsNum(),
	'threadsPerPage' => THREADS_PER_PAGE
);
retdata($threads, $metadata);
?>