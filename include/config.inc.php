<?php
define('SERVER_URL', 'http://localhost/lesson/');
//define('SERVER_URL', 'http://ahutlesson.sinaapp.com/');

//db
define('DB_SERVER', '127.0.0.1');
define('DB_PORT', 3306);
define('DB_USERNAME', 'devoneni_admin');
define('DB_PASSWORD', 'free2587698');
define('DB_NAME', 'ahut');
define('DB_PREFIX', 'ahut_');

/* SAE
define('DB_SERVER', SAE_MYSQL_HOST_M);
define('DB_PORT', SAE_MYSQL_PORT);
define('DB_USERNAME', SAE_MYSQL_USER);
define('DB_PASSWORD', SAE_MYSQL_PASS);
define('DB_NAME', SAE_MYSQL_DB);
define('DB_PREFIX', 'ahut_');
*/

//table
define('LESSON_TABLE', 'lesson2013');

//forum
date_default_timezone_set("Asia/Shanghai"); 
define('THREADS_PER_PAGE', 50);
define('POSTS_PER_PAGE', 20);
define('MESSAGES_PER_PAGE', 10);
?>