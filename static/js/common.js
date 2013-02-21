var IN_SAE = false;
var SERVER_URL = (IN_SAE) ? "http://ahutlesson.sinaapp.com" : "http://localhost/lesson/";

function getAvatarURL(uxh, hasAvatar) {
	if(!hasAvatar) {
		return "static/img/noavatar.jpg";
	}else if(IN_SAE) {
		return "http://ahutlesson-upload.stor.sinaapp.com/avatar/" + uxh + ".jpg";
	}else{
		return "http://localhost/lesson/upload/avatar/" + uxh + ".jpg";
	}
}

function toggleSaveCookie() {
	var checkbox = $('#save_cookie');
	checkbox.attr("checked", !checkbox.attr("checked"));
}

function login() {
	var xh = $('#login_xh').val();
	var password = $('#login_password').val();
	var rem = $('#save_cookie').attr("checked");
	$.post('api/user.handler.php?act=login', { x: xh, p: password })
	.done(function(ret) {
		if(ret.lastIndexOf('0', 0) == 0) {
			if(rem) {
				$.cookie('ck', ret.substr(2), { expires: 30 });
			}else{
				$.cookie('ck', ret.substr(2));
			}
			window.location.reload();
		}else if(ret.lastIndexOf('1', 0) == 0) {
			alert(ret.substr(2));
		}
	});
}

function loginOut() {
	$.removeCookie('ck');
	window.location.reload();
}

function atToday(date) {
	var now = new Date();
	return (date.getFullYear() == now.getFullYear() && date.getMonth() == now.getMonth() && date.getDate() == now.getDate());
}

function atThisYear(date) {
	var now = new Date();
	return date.getFullYear() == now.getFullYear();
}

function strtotime(strings) {
    var _ = strings.split(' ');
    var ymd = _[0];
    var hms = _[1];

    var str = ymd.split('-');
    var fix = hms.split(':');

    var year  = str[0] - 0; 
    var month = str[1] - 0 - 1; 
    var day   = str[2] - 0; 
    var hour   = fix[0] - 0; 
    var minute = fix[1] - 0; 
    var second = fix[2] - 0;

    return new Date(year, month, day, hour, minute, second);
}

var origin_title = '';
var logged_uxh = '';
var unreadMessageCount = 0;
var unreadNoticeCount = 0;

function isInt(n) {
   return n % 1 == 0;
}

function checkUnreadMessage() {
	$.getJSON('api/notice.handler.php?act=getunreadcount&uxh=' + logged_uxh, function(ret) {
		unreadMessageCount = ret[0];
		unreadNoticeCount = ret[1];
		refreshUnreadCount();
	});
}

function refreshUnreadCount() {
	if(origin_title == '') {
		origin_title = document.title;
	}

	var newtitle = '';
	
	if(unreadMessageCount != 0) {
		$('.unreadMessageCount').html('<a title="' + unreadMessageCount + '条新消息" href="message.php">(' + unreadMessageCount + ')</a>');
		newtitle += unreadMessageCount + '条新消息';
	}else{
		$('.unreadMessageCount').html('');
	}
	if(unreadNoticeCount != 0) {
		if(newtitle != '') newtitle += '，';
		newtitle += unreadNoticeCount + '条新提醒';
		$('.unreadNoticeCount').html('<a title="' + unreadNoticeCount + '条新提醒" href="notice.php">(' + unreadNoticeCount + ')</a>');
	}else{
		$('.unreadNoticeCount').html('');
	}
	
	if(newtitle != '') {
		document.title = '【' + newtitle + '】' + origin_title;
	}else{
		document.title = origin_title;
	}
}

var sendpm_uxh = '';

function showPmdiv(uxh, uname) {
	sendpm_uxh = uxh;
	$('#pm_uname').html(uname);
	$('.pmdiv').fadeIn(500);
}

function sendpm() {
	var xh = sendpm_uxh;
	var title = $('#pm_title').val();
	var content = $('#pm_content').val();
	if(title.length == '' || content.length == '') {
		alert('标题或内容为空！');
		return;
	}
	$.post("api/notice.handler.php?act=sendmessage", { u: xh, t: title, c: content })
	.done(function(result) {
		$('#pm_title').val('');
		$('#pm_content').val('');
		$('.pmdiv').fadeOut(500);
	});
}