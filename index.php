<?php
include 'timetable.php';
exit;
require 'include.php';

$page = new Page();
$page->setTitle('首页');
$page->setMod('index');
$page->displayHeader();

$page->displayFooter();

?>