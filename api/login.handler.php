<?php
require 'include.php';

$xh = $_POST['x'];
if(!isValidXH($xh)) die('学号错误');
$password = addslashes($_POST['p']);

echo User::login($xh, $password);
?>