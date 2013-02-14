<?php
require 'include.php';
$signature = $_POST['s'];
if(mb_strlen($signature) > 255) die('内容过长（大于255个字符）');
echo User::setSignature($signature);
?>