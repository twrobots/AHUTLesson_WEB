<?php
/*
$ret = array();
$ret['code'] = '0';
//$ret['data'] = 'msg';
$ret['data'] = array('data' => 'data', 'metadata' => 'test');
echo json_encode($ret);


//{"code":"0","data":"msg"}
//{"code":"0","data":{"data":"data","metadata":"test"}}
*/

/*
$content = '回复2楼: interesting';
var_dump(isReplyingToReply($content));

$content = '回复12楼: interesting';
var_dump(isReplyingToReply($content));

$content = '回复楼: interesting';
var_dump(isReplyingToReply($content));

$content = 'interesting';
var_dump(isReplyingToReply($content));

function isReplyingToReply($content) {
	if(strpos($content, '回复') != 0) return false;
	$floor_end = strpos($content, '楼');
	if(empty($floor_end)) return false;
	$floor_str = substr($content, 6, $floor_end - 6);
	if(!is_numeric($floor_str)) return false;
	return $floor_str;
}
*/

include "include.php";

/*
$uxh = '119074021';
var_dump(getLidListHasNew($uxh));

function getLidListHasNew($uxh) {
	$rows = DB::getData("SELECT distinct lid FROM ".LESSONDB." WHERE xh = '$uxh' AND hasnew = 1");
	$lids = array();
	foreach($rows as $row) {
		$lids[] = $row['lid'];
	}
	return $lids;
}
*/

echo version_compare('1.4.2', '1.5.6');

?>