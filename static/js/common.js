var SERVER_URL = "http://localhost/lesson/";

function toggleSaveCookie() {
	var checkbox = $('#save_cookie');
	checkbox.attr("checked", !checkbox.attr("checked"));
}

function login() {
	var xh = $('#login_xh').val();
	var password = $('#login_password').val();
	var rem = $('#save_cookie').attr("checked");
	$.post('api/user.handler.php?act=login', { x: xh, p: password })
	.done(function(result) {
		if(result.lastIndexOf('0', 0) == 0) { //begin with 0
			if(rem) {
				$.cookie('ck', result.substr(2), { expires: 30 });
			}else{
				$.cookie('ck', result.substr(2));
			}
			window.location.href='index.php';
		}else{
			alert(result);
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
var unreadCount = 0;

function checkUnreadMessage() {
	$.get('api/pm.handler.php?act=checkunread', function(ret) {
		unreadCount = ret;
		refreshUnreadCount();
	});
}

function refreshUnreadCount() {
	if(origin_title == '') {
		origin_title = document.title;
	}
	if(unreadCount != 0) {
		$('.unreadCount').html('<a title="' + unreadCount + '条未读消息" href="message.php">(' + unreadCount + ')</a>');
		document.title = '【' + unreadCount + '条未读消息】' + origin_title;
	}else{
		document.title = origin_title;
		$('.unreadCount').html('');
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
	$.post("api/pm.handler.php?act=send", { u: xh, t: title, c: content })
	.done(function(result) {
		$('#pm_title').val('');
		$('#pm_content').val('');
		$('.pmdiv').fadeOut(500);
	});
}