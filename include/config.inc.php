<?php
//define('IN_SAE', true);

if(!defined('IN_SAE')) {
	define('SERVER_URL', 'http://localhost/lesson/');
	define('DB_SERVER', '127.0.0.1');
	define('DB_PORT', 3306);
	define('DB_USERNAME', 'devoneni_admin');
	define('DB_PASSWORD', 'free2587698');
	define('DB_NAME', 'ahut');
}else{
	define('SERVER_URL', 'http://ahutlesson.sinaapp.com/');
	define('DB_SERVER', SAE_MYSQL_HOST_M);
	define('DB_PORT', SAE_MYSQL_PORT);
	define('DB_USERNAME', SAE_MYSQL_USER);
	define('DB_PASSWORD', SAE_MYSQL_PASS);
	define('DB_NAME', SAE_MYSQL_DB);
}
define('USE_MIN_JS', false);

date_default_timezone_set("Asia/Shanghai");

//page
define('THREADS_PER_PAGE', 50);
define('LESSONMATES_PER_PAGE', 50);
define('POSTS_PER_PAGE', 20);
define('MESSAGES_PER_PAGE', 15);
define('NOTICES_PER_PAGE', 15);

define('LESSONDB', 'lesson2013');
define('LESSONDB_VERSION', '20130528');
$currentTimetableSetting = array(
		'year' => 2013,
		'month' => 2,
		'day' => 27,
		'season' => 0 //0 summer, 1 winter
);
?>