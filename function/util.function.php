<?php
function retok() {
	$ret = array();
	$ret['code'] = '0';
	echo json_encode($ret);
	exit;
}

function retdata($data, $metadata = array()) {
	$ret = array();
	$ret['code'] = '0';
	$ret['data'] = $data;
	if(!empty($metadata)) {
		$ret['metadata'] = $metadata;
	}
	echo json_encode($ret);
	exit;
}

function reterror($msg) {
	$ret = array();
	$ret['code'] = '1';
	$ret['msg'] = $msg;
	echo json_encode($ret);
	exit;
}

//$datetime = date('Y-m-d H:i:s') ;
function datetimeToTime($datetime) {
	$timestamp = strtotime($datetime);
	return date('H:i', $timestamp);
}
?>